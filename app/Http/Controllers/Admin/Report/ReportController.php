<?php

namespace App\Http\Controllers\Admin\Report;

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
use App\Models\Master\Role_privilege;
use App\Models\Department;
use App\Models\TestResults;
use App\Models\Appointment;
use App\Models\TestResultComponent;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(){
        return view('Admin.Reports.index'); 
    }

    public function getGenerateReport($id)
    {
        $testIdArray = TestResults::where('test_result_code', $id)->pluck('test_id')->toArray();
        $appointmentId = TestResults::where('test_result_code', $id)->value('appointment_id');
        $tests = Test::whereIn('id', $testIdArray)->with('parameters.options')->get();
        $appointment = Appointment::with('pet.petparent')->where('id', $appointmentId)->first();
        $report = TestResults::with(['test.parameters.options', 'components'])->where('test_result_code', $id)->get();

        return view('Admin.Reports.report-generate', compact('report', 'tests', 'appointment', 'id'));
    }

    public function viewReport($id){
        
        $testIdArray = TestResults::where('test_result_code', $id)->pluck('test_id')->toArray();
        $appointmentId = TestResults::where('test_result_code', $id)->value('appointment_id');

        $tests = Test::whereIn('id', $testIdArray)->with('parameters')->get();

        $appointment = Appointment::with('pet.petparent')->where('id', $appointmentId)->first();
        $report = TestResults::with(['test.parameters', 'components'])->where('test_result_code', $id)->get();

        return view('Admin.Reports.report-view',compact('report', 'tests', 'appointment','id'));
    }





   
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'test_id' => 'required|exists:tests,id',
            'appointment_id' => 'required|exists:appointments,id',
            'test_result_code' => 'required|string',
            'results' => 'required|array',
            'results.*' => 'array',
            'results.*.*' => 'nullable|string', // Allow nullable string for result values
            'status' => 'required|array',
            'status.*' => 'array',
            'status.*.*' => 'nullable|in:normal,abnormal', // Restrict status to valid values
            'comments' => 'required|array',
            'comments.*' => 'nullable|string', // Allow nullable comments
        ]);

        // Find or create the TestResults record
        $testResult = TestResults::firstOrCreate(
            [
                'test_id' => $validated['test_id'],
                'appointment_id' => $validated['appointment_id'],
                'test_result_code' => $validated['test_result_code'],
            ],
            [
                'status' => 'pending',
                'done' => 'no',
                'created_by' => Auth::id(),
                'created_ip_address' => $request->ip(),
            ]
        );

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
            'status' => 'pending',
            'done' => 'yes',
            'modified_by' => Auth::id(),
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
            $testResult = TestResults::with(['components'])
                ->where('id', $testResultId)
                ->first();

            if (!$testResult) {
                continue;
            }

            $test = Test::where('id', $testResult->test_id)
                ->with(['parameters' => function($query) {
                    $query->orderBy('sort_order');
                }])
                ->first();

            $appointment = Appointment::with(['pet.petParent', 'branch', 'refereeDoctor'])
                ->where('id', $testResult->appointment_id)
                ->first();

            // Date formatting like in the image
            $collectionDate = \Carbon\Carbon::parse($testResult->sample_collected_at ?? $testResult->created_at);
            $registrationDate = \Carbon\Carbon::parse($testResult->created_at);
            $reportingDate = \Carbon\Carbon::parse($testResult->updated_at);

            $reportsData[] = [
                'testResult' => $testResult,
                'test' => $test,
                'appointment' => $appointment,
                'formattedDates' => [
                    'collection' => $collectionDate->format('d/m/y, h:i a'),
                    'registration' => $registrationDate->format('d/m/y, h:i a'),
                    'reporting' => $reportingDate->format('d/m/y, h:i a'),
                ]
            ];
        }
        

        $pdf = Pdf::loadView('Admin.Reports.report_pdf', [
            'reports' => $reportsData,
        ])
        ->setPaper('a4')
        ->setOption('margin-top', '0.7in')
        ->setOption('margin-bottom', '0.7in')
        ->setOption('margin-left', '0.55in')
        ->setOption('margin-right', '0.55in')
        ->setOption('enable-local-file-access', true);

        $pdfContent = base64_encode($pdf->output());

        return response()->json([
            'reports' => [
                [
                    'content' => $pdfContent,
                    'filename' => 'test_results_report_' . now()->format('YmdHis') . '.pdf',
                ]
            ]
        ]);
    }


    public function data_table(Request $request)
    {
        $reports = TestResults::with([
                'appointment.pet.petparent',
                'test',
                'assignedDoctor'  // Eager load assigned doctor
            ])
            ->select('test_results.*') 
            ->join('appointments', 'test_results.appointment_id', '=', 'appointments.id') 
            ->orderBy('test_results.created_at', 'DESC') 
            ->get()
            ->groupBy('test_result_code')
            ->map(function($group) {
                $first = $group->first();
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




                ->rawColumns(['status'])

                // ->addColumn('done', function ($row) {
                //     return $row->done ?? '-';
                // })
                // ->addColumn('signed', function ($row) {
                //     return !empty($row->signed_by_id) ? 'Yes' : 'No';
                // })
                
                ->addColumn('assigned_doctor', function ($row) {
                    return $row->assigned_doctor ?? 'Not Assigned';
                })



                ->addColumn('action', function ($row) {
                    $actionBtn = '';
                    $role_id = Auth::guard('master_admins')->user()->role_id;
                    $RolesPrivileges = Role_privilege::where('status', 'active')
                        ->where('id', $role_id)
                        ->select('privileges')
                        ->first();

                    $id = $row->test_result_code; // use test_result_code as identifier


                    // Assign Doctor button
                    // if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'reports_view')) {
                    //     $actionBtn .= '<button type="button" 
                    //                         class="btn btn-icon btn-secondary assign-doctor-btn me-1"
                    //                         title="Assign Doctor" 
                    //                         data-id="' . $row->test_result_code . '"
                    //                         style="background:#fff; color:#6f42c1; border:1px solid #6f42c1;">
                    //                         <i class="mdi mdi-account-plus"></i>
                    //                     </button>';
                    // }


                    // View button
                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'reports_view')) {
                        $actionBtn .= '<a href="' . url('admin/reports/view/' . $id) . '" 
                                    class="btn btn-icon btn-info me-1" 
                                    title="View Branch" 
                                    data-bs-toggle="tooltip" 
                                    style="background:#fff; color:#6267ae; border:1px solid #6267ae;">
                                    <i class="mdi mdi-eye"></i>
                                </a>';
                    }


                        // Approve Report button
                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'reports_view')) {
                        $actionBtn .= '<button type="button"
                                            class="btn btn-icon btn-success me-1 approve-btn"
                                            title="Approve Report"
                                            data-bs-toggle="tooltip"
                                            data-id="' . $id . '"
                                            style="background:#fff; color:#198754; border:1px solid #198754;">
                                            <i class="mdi mdi-check-circle-outline"></i>
                                        </button>';
                    }

                    // Reject Report button
                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'reports_view')) {
                        $actionBtn .= '<button type="button"
                                            class="btn btn-icon btn-danger me-1 reject-btn"
                                            title="Reject Report"
                                            data-bs-toggle="tooltip"
                                            data-id="' . $id . '"
                                            style="background:#fff; color:#dc3545; border:1px solid #dc3545;">
                                            <i class="mdi mdi-close-circle-outline"></i>
                                        </button>';
                    }


                    // Edit button
                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'reports_view')) {
                        $actionBtn .= '<a href="' . url('admin/generate-reports/' . $id) . '" 
                                        class="btn btn-icon btn-warning me-1" 
                                        title="Edit Pet Parent" 
                                        data-bs-toggle="tooltip" 
                                        style="background:#fff; color:#f6b51d; border:1px solid #f6b51d;">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>';
                    }

                    // Sign Report button
                        if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'reports_view')) {
                            $actionBtn .= '<button type="button"
                                                class="btn btn-icon btn-success me-1 sign-btn"
                                                title="Sign Report"
                                                data-bs-toggle="tooltip"
                                                data-id="' . $id . '"
                                                style="background:#fff; color:#28a745; border:1px solid #28a745;">
                                                <i class="mdi mdi-signature-text"></i>
                                            </button>';
                        }


        

                    // Print Barcode button
                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'reports_view')) {
                    $actionBtn .= '<button type="button" 
                            class="btn btn-icon btn-primary print-barcode-btn me-1" 
                            title="Print Barcode" 
                            data-bs-toggle="tooltip"
                            data-appointment-id="' . $row->appointment->id . '"
                            style="background:#fff; color:#000; border:1px solid #000;">
                            <i class="mdi mdi-barcode"></i>
                        </button>';

                    }


                    return $actionBtn;
                })


                
                ->rawColumns(['action', 'tests','status'])
                ->make(true);
        }
    }


    public function assignDoctor(Request $request, $code)
    {
        $request->validate([
            'doctor_id' => 'required|exists:internal_doctors,id',
        ]);

        // Get all reports with same test_result_code
        $reports = TestResults::where('test_result_code', $code)->get();

        if ($reports->isEmpty()) {
            return response()->json(['message' => 'Report not found.'], 404);
        }

        foreach ($reports as $report) {
            $report->assigned_to_doctor_id = $request->doctor_id; // ✅ Correct column name
            $report->assigned_by = Auth::id();
            $report->assigned_at = now();
            $report->save();
        }

        return response()->json(['message' => 'Doctor assigned successfully!']);
    }


   // ✅ Approve Report
public function approveReport($code)
{
    $reports = TestResults::where('test_result_code', $code)
        ->whereIn('status', ['pending', 'rejected'])
        ->get();

    if ($reports->isEmpty()) {
        return response()->json(['success' => false, 'message' => 'Report not found or already processed.'], 404);
    }

    foreach ($reports as $report) {
        $report->admin_approved = 1;
        $report->admin_approved_by = Auth::guard('master_admins')->id();
        $report->admin_approved_at = now();
        $report->status = 'approved';
        $report->rejection_reason = null; // clear if previously rejected
        $report->save();
    }

    return response()->json(['success' => true, 'message' => 'Report approved successfully!']);
}

// ❌ Reject Report (with reason)
public function rejectReport(Request $request, $code)
{
    $request->validate([
        'reason' => 'required|string|max:1000',
    ]);

    $reports = TestResults::where('test_result_code', $code)
        ->whereIn('status', ['pending', 'approved'])
        ->get();

    if ($reports->isEmpty()) {
        return response()->json(['success' => false, 'message' => 'Report not found or cannot be rejected.'], 404);
    }

    foreach ($reports as $report) {
        $report->admin_approved = 0;
        $report->admin_rejected_by = Auth::guard('master_admins')->id();
        $report->admin_rejected_at = now();
        $report->rejection_reason = $request->reason; // ✅ save reason
        $report->status = 'rejected';
        $report->save();
    }

    return response()->json(['success' => true, 'message' => 'Report rejected successfully!']);
}

// ✍️ Sign Report (only approved ones)
public function signReport($code)
{
    $reports = TestResults::where('test_result_code', $code)
        ->where('status', 'approved')
        ->where('admin_approved', 1)
        ->get();

    if ($reports->isEmpty()) {
        return response()->json(['success' => false, 'message' => 'Report not found or not eligible for signing.'], 404);
    }

    $adminId = Auth::guard('master_admins')->id();

    foreach ($reports as $report) {
        $report->signed_by_id = $adminId;
        $report->signed_date = now();
        $report->status = 'completed';
        $report->save();
    }

    return response()->json(['success' => true, 'message' => 'Report signed and completed successfully!']);
}

// 🔁 Optional - Reopen Rejected Report
public function reopenReport($code)
{
    $reports = TestResults::where('test_result_code', $code)
        ->where('status', 'rejected')
        ->get();

    if ($reports->isEmpty()) {
        return response()->json(['success' => false, 'message' => 'Report not found or not rejected.'], 404);
    }

    foreach ($reports as $report) {
        $report->status = 'pending';
        $report->rejection_reason = null;
        $report->save();
    }

    return response()->json(['success' => true, 'message' => 'Report moved back to pending successfully!']);
}




}