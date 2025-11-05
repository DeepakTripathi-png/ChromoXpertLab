<?php

namespace App\Http\Controllers\Doctor\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\TestParameters;
use App\Models\ParameterOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use App\Models\InternalDoctor;
use App\Models\Department;
use App\Models\TestResults;
use App\Models\Appointment;
use App\Models\TestResultComponent;
use App\Models\Branch;
use Barryvdh\DomPDF\Facade\Pdf;

class DoctorReportController extends Controller
{
    protected $doctorId;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::guard('doctor')->check()) {
                abort(403, 'Unauthorized access');
            }

            $doctorUser = Auth::guard('doctor')->user();
            $doctor = InternalDoctor::where('user_id', $doctorUser->id)->first();
            if (!$doctor) {
                abort(403, 'Invalid doctor access');
            }
            $this->doctorId = $doctor->id;

            return $next($request);
        });
    }

    public function index(){
        return view('Doctor.Reports.index'); 
    }

    public function getGenerateReport($id)
    {
        // Get doctor-specific test results (assigned to this doctor)
        $testResult = TestResults::where('test_result_code', $id)
            ->where('assigned_to_doctor_id', $this->doctorId)
            ->whereHas('appointment', function($query) {
                $query->whereHas('branch'); // Assuming appointments have branch relation, but no branch filter for doctors
            })
            ->firstOrFail();

        $testIdArray = TestResults::where('test_result_code', $id)
            ->where('assigned_to_doctor_id', $this->doctorId)
            ->whereHas('appointment', function($query) {
                $query->whereHas('branch');
            })
            ->pluck('test_id')
            ->toArray();

        $appointmentId = TestResults::where('test_result_code', $id)
            ->where('assigned_to_doctor_id', $this->doctorId)
            ->whereHas('appointment', function($query) {
                $query->whereHas('branch');
            })
            ->value('appointment_id');

        $tests = Test::whereIn('id', $testIdArray)->with('parameters.options')->get();
        
        $appointment = Appointment::with('pet.petparent')
            ->where('id', $appointmentId)
            ->firstOrFail();

        $report = TestResults::with(['test.parameters.options', 'components'])
            ->where('test_result_code', $id)
            ->where('assigned_to_doctor_id', $this->doctorId)
            ->whereHas('appointment', function($query) {
                $query->whereHas('branch');
            })
            ->get();

        return view('Doctor.Reports.report-generate', compact('report', 'tests', 'appointment', 'id'));
    }

    public function viewReport($id){

          

        // Get doctor-specific test results (assigned to this doctor)
        $testResult = TestResults::where('test_result_code', $id)
            ->where('assigned_to_doctor_id', $this->doctorId)
            ->whereHas('appointment', function($query) {
                $query->whereHas('branch');
            })
            ->firstOrFail();

        $testIdArray = TestResults::where('test_result_code', $id)
            ->where('assigned_to_doctor_id', $this->doctorId)
            ->whereHas('appointment', function($query) {
                $query->whereHas('branch');
            })
            ->pluck('test_id')
            ->toArray();

        $appointmentId = TestResults::where('test_result_code', $id)
            ->where('assigned_to_doctor_id', $this->doctorId)
            ->whereHas('appointment', function($query) {
                $query->whereHas('branch');
            })
            ->value('appointment_id');

        $tests = Test::whereIn('id', $testIdArray)->with('parameters')->get();

        $appointment = Appointment::with('pet.petparent')
            ->where('id', $appointmentId)
            ->firstOrFail();

        $report = TestResults::with(['test.parameters', 'components'])
            ->where('test_result_code', $id)
            ->where('assigned_to_doctor_id', $this->doctorId)
            ->whereHas('appointment', function($query) {
                $query->whereHas('branch');
            })
            ->get();

        $report_status = $testResult->doctor_approval_status;

        $signed_by_id = $testResult->signed_by_id;


        return view('Doctor.Reports.report-view', compact('report', 'tests', 'appointment', 'id','report_status','signed_by_id'));
    }

    public function data_table(Request $request)
    {
        $doctorUser = Auth::guard('doctor')->user();
        $doctor = InternalDoctor::where('user_id',$doctorUser->id)->first();

        $reports = TestResults::with([
                'appointment.pet.petparent',
                'test',
                'assignedDoctor'
            ])
            ->select('test_results.*') 
            ->join('appointments', 'test_results.appointment_id', '=', 'appointments.id') 
            ->where('test_results.assigned_to_doctor_id', $doctor->id)
            ->orderBy('test_results.created_at', 'DESC') // Sort by created_at DESC to get latest first
            ->get()
            ->groupBy('test_result_code')
            ->map(function($group) {
                $first = $group->first(); // Since the collection is already sorted by created_at DESC, first() will be the latest
                $tests = $group->pluck('test')->filter()->values();

                return (object)[
                    'test_result_code' => $first->test_result_code,
                    'appointment'      => $first->appointment,
                    'tests'            => $tests,
                    'status'           => $first->status,
                    'created_at'       => $first->created_at,
                    'assigned_doctor'  => $first->assignedDoctor ? $first->assignedDoctor->doctor_name : 'Not Assigned',
                ];
            })
            ->values();

        if ($request->ajax()) {
            return DataTables::of($reports)
                ->addIndexColumn()
                ->addColumn('test_result_code', function ($row) {
                    return $row->test_result_code ?? '';
                })
                ->addColumn('pet_code', function ($row) {
                    return $row->appointment->pet->pet_code ?? '';
                })
                ->addColumn('pet_name', function ($row) {
                    return $row->appointment->pet->name ?? '';
                })
                ->addColumn('pet_parent', function ($row) {
                    return $row->appointment->pet->petparent->name ?? '';
                })
                ->addColumn('pet_parent_mobile', function ($row) {
                    return $row->appointment->pet->petparent->mobile ?? '';
                })
                ->addColumn('tests', function ($row) {
                    $tests = $row->tests->map(function($test) {
                        return '<li>' . ($test->name ?? '') . '</li>';
                    })->implode('');

                    return '<ul style="padding-left: 20px; margin:0;">' . $tests . '</ul>';
                })
                ->addColumn('appointment_datetime', function ($row) {
                    if (!empty($row->appointment->appointment_date) && !empty($row->appointment->appointment_time)) {
                        $datetime = $row->appointment->appointment_date . ' ' . $row->appointment->appointment_time;
                        return \Carbon\Carbon::parse($datetime)->format('d M Y h:i A');
                    }
                    return '';
                })
                ->addColumn('created_date', function ($row) {
                    return !empty($row->created_at) ? \Carbon\Carbon::parse($row->created_at)->format('d M Y h:i A') : '';
                })


                ->addColumn('status', function ($row) {
                    $status = strtolower(trim($row->status)); // Normalize

                    switch ($status) {
                        case 'completed':
                            $class = 'badge bg-success'; // green
                            break;
                        case 'pending':
                            $class = 'badge bg-warning text-dark'; // yellow
                            break;
                        case 'approved':
                            $class = 'badge bg-primary'; // blue
                            break;
                        case 'rejected':
                            $class = 'badge bg-danger'; // red
                            break;
                        default:
                            $class = 'badge bg-light text-dark'; // default light gray
                            break;
                    }

                    return '<span class="' . $class . '">' . ucfirst($row->status ?? '-') . '</span>';
                })


                // ->addColumn('done', function ($row) {
                //     return $row->done ?? '-';
                // })
                ->addColumn('signed', function ($row) {
                    return !empty($row->signed_by_id) ? 'Yes' : 'No';
                })

                // ->addColumn('assigned_doctor', function ($row) {
                //     return $row->assigned_doctor ?? 'Not Assigned';
                // })

                ->addColumn('action', function ($row) {
                    $actionBtn = '';
                    $id = $row->test_result_code; 

                    // View button
                    $actionBtn .= '<a href="' . url('doctor/reports/view/' . $id) . '" 
                                class="btn btn-icon btn-info me-1" 
                                title="View Report" 
                                data-bs-toggle="tooltip" 
                                style="background:#fff; color:#6267ae; border:1px solid #6267ae;">
                                <i class="mdi mdi-eye"></i>
                            </a>';

                    // Edit button (for assigned reports)
                    $actionBtn .= '<a href="' . url('doctor/generate-reports/' . $id) . '" 
                                    class="btn btn-icon btn-warning me-1" 
                                    title="Edit Report" 
                                    data-bs-toggle="tooltip" 
                                    style="background:#fff; color:#f6b51d; border:1px solid #f6b51d;">
                                    <i class="mdi mdi-pencil"></i>
                                </a>';

                    // Approve/Reject buttons (assuming approve sets status to 'approved', reject to 'rejected')
                    // $actionBtn .= '<button type="button" 
                    //                         class="btn btn-icon btn-success me-1 approve-btn"
                    //                         title="Approve Report" 
                    //                         data-id="' . $id . '"
                    //                         style="background:#fff; color:#28a745; border:1px solid #28a745;">
                    //                         <i class="mdi mdi-check"></i>
                    //                     </button>';

                    // $actionBtn .= '<button type="button" 
                    //                         class="btn btn-icon btn-danger me-1 reject-btn"
                    //                         title="Reject Report" 
                    //                         data-id="' . $id . '"
                    //                         style="background:#fff; color:#dc3545; border:1px solid #dc3545;">
                    //                         <i class="mdi mdi-close"></i>
                    //                     </button>';

                    // Sign Report button
                    // $actionBtn .= '<a href="' . url('doctor/test-report/sign/' . $id) . '" 
                    //                 class="btn btn-icon btn-primary" 
                    //                 title="Sign Report" 
                    //                 style="background:#fff; color:#007bff; border:1px solid #007bff;">
                    //                 <i class="mdi mdi-signature-text"></i>
                    //             </a>';

                    return $actionBtn;
                })
                ->rawColumns(['action', 'tests','status'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        // First validate the appointment exists
        $appointment = Appointment::where('id', $request->appointment_id)
            ->firstOrFail();

        // Validate the incoming request
        $validated = $request->validate([
            'test_id' => 'required|exists:tests,id',
            'appointment_id' => 'required|exists:appointments,id',
            'test_result_code' => 'required|string',
            'results' => 'required|array',
            'results.*' => 'array',
            'results.*.*' => 'nullable|string',
            'status' => 'required|array',
            'status.*' => 'array',
            'status.*.*' => 'nullable|in:normal,abnormal',
            'comments' => 'required|array',
            'comments.*' => 'nullable|string',
        ]);

        // Find or create the TestResults record with doctor assignment validation
        $testResult = TestResults::where('test_id', $validated['test_id'])
            ->where('appointment_id', $validated['appointment_id'])
            ->where('test_result_code', $validated['test_result_code'])
            ->where('assigned_to_doctor_id', $this->doctorId)
            ->first();

        if (!$testResult) {
            $testResult = TestResults::create([
                'test_id' => $validated['test_id'],
                'appointment_id' => $validated['appointment_id'],
                'test_result_code' => $validated['test_result_code'],
                'status' => 'pending',
                'done' => 'no',
                'assigned_to_doctor_id' => $this->doctorId,
                'created_by' => Auth::guard('doctor')->id(),
                'created_ip_address' => $request->ip(),
            ]);
        }

        // Prepare result data for TestResults
        $resultData = [];
        foreach ($validated['results'][$validated['test_id']] as $paramId => $resultValue) {
            $status = $validated['status'][$validated['test_id']][$paramId] ?? null;
            if ($resultValue || $status) {
                $resultData[$paramId] = [
                    'result' => $resultValue,
                    'status' => $status,
                ];

                // Store or update individual test result component
                TestResultComponent::updateOrCreate(
                    [
                        'test_result_id' => $testResult->id,
                        'component_id' => $paramId,
                    ],
                    [
                        'result' => $resultValue,
                        'result_status' => $status,
                    ]
                );
            }
        }

        // Update TestResults with aggregated data
        $testResult->update([
            'comment' => $validated['comments'][$validated['test_id']] ?? null,
            'status' => 'completed',
            'done' => 'yes',
            'modified_by' => Auth::guard('doctor')->id(),
            'modified_ip_address' => $request->ip(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Test results updated successfully.');
    }

    public function reportPdf(Request $request)
    {
        $request->validate([
            'selected_test_results' => 'required|array',
            'selected_test_results.*' => 'exists:test_results,id',
        ]);

        $testResultIds = $request->input('selected_test_results', []);
        $reportsData = [];

        foreach ($testResultIds as $testResultId) {
            // Verify test result belongs to doctor
            $testResult = TestResults::with(['components'])
                ->where('id', $testResultId)
                ->where('assigned_to_doctor_id', $this->doctorId)
                ->first();

            if (!$testResult) {
                continue;
            }

            $test = Test::where('id', $testResult->test_id)
                ->with(['parameters'])
                ->first();

            $appointment = Appointment::with(['pet.petParent', 'branch', 'refereeDoctor'])
                ->where('id', $testResult->appointment_id)
                ->first();

            if ($appointment) {
                $reportsData[] = [
                    'testResult' => $testResult,
                    'test' => $test,
                    'appointment' => $appointment,
                ];
            }
        }

        if (empty($reportsData)) {
            return response()->json([
                'error' => 'No valid test results found for you.'
            ], 404);
        }

        // Load the Blade view and generate PDF
        $pdf = Pdf::loadView('Doctor.Reports.report_pdf', [
            'reports' => $reportsData,
            'doctor' => InternalDoctor::where('id', $this->doctorId)->with('user')->first(), // Pass doctor info to view
        ])
        ->setPaper('a4')
        ->setOption('margin-top', '0.5cm')
        ->setOption('margin-bottom', '0.5cm')
        ->setOption('margin-left', '0.5cm')
        ->setOption('margin-right', '0.5cm');

        // Get the PDF content as base64
        $pdfContent = base64_encode($pdf->output());

        // Return JSON response
        return response()->json([
            'reports' => [
                [
                    'content' => $pdfContent,
                    'filename' => 'test_results_report_' . $this->doctorId . '_' . now()->format('YmdHis') . '.pdf',
                ]
            ]
        ]);
    }

    public function assignDoctor(Request $request, $code)
    {
        // Doctors cannot assign to themselves; this method is removed for doctor controller
        return response()->json(['message' => 'Action not permitted for doctors.'], 403);
    }

    // Updated method for approving reports
    public function approveReport($code)
    {
         

       $reports = TestResults::where('test_result_code', $code)
        ->where('assigned_to_doctor_id', $this->doctorId)
        ->whereIn('doctor_approval_status', ['pending', 'rejected'])
        ->get();


        if ($reports->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Report not found, not assigned to you, or already processed.'], 404);
        }

        foreach ($reports as $report) {
            $report->doctor_approval_status = 'approved';
            $report->doctor_approved_at = now();
            $report->save();
        }

        return response()->json(['success' => true, 'message' => 'Report approved successfully!']);
    }

    // Updated method for rejecting reports
    public function rejectReport(Request $request, $code)
    {
        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $reports = TestResults::where('test_result_code', $code)
            ->where('assigned_to_doctor_id', $this->doctorId)
            ->where('doctor_approval_status', 'pending') // Only reject pending ones
            ->get();

        if ($reports->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Report not found, not assigned to you, or already processed.'], 404);
        }

        foreach ($reports as $report) {
            $report->doctor_approval_status = 'rejected';
            $report->doctor_rejection_comment = $request->reason;
            $report->doctor_approved_at = null; // Reset if previously approved (though shouldn't happen)
            $report->save();
        }

        return response()->json(['success' => true, 'message' => 'Report rejected successfully!']);
    }

    // Method for signing reports (for approved reports)
    public function signReport($code)
    {
        $reports = TestResults::where('test_result_code', $code)
            ->where('assigned_to_doctor_id', $this->doctorId)
            ->where('doctor_approval_status', 'approved')
            ->get();

        if ($reports->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Report not found, not assigned to you, or not approved.'], 404);
        }

        foreach ($reports as $report) {
            $report->signed_by_id = Auth::guard('doctor')->id();
            $report->signed_date = now();
            $report->save();
        }

        return response()->json(['success' => true, 'message' => 'Report signed successfully!']);
    }

    // Method for reopening rejected reports (sets back to pending)
    public function reopenReport($code)
    {
          
        $reports = TestResults::where('test_result_code', $code)
            ->where('assigned_to_doctor_id', $this->doctorId)
            ->where('doctor_approval_status', 'rejected')
            ->get();

        if ($reports->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Report not found, not assigned to you, or not rejected.'], 404);
        }

        foreach ($reports as $report) {
            $report->doctor_approval_status = 'pending';
            $report->doctor_rejection_comment = null; // Clear rejection comment if reopening
            $report->doctor_approved_at = null;
            $report->save();
        }

        return response()->json(['success' => true, 'message' => 'Report reopened successfully!']);
    }






}