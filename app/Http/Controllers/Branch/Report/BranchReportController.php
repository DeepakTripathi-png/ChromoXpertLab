<?php

namespace App\Http\Controllers\Branch\Report;

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
use App\Models\Branch;
use Barryvdh\DomPDF\Facade\Pdf;

class BranchReportController extends Controller
{
    protected $branchId;
    protected $branchUserId;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::guard('branch')->check()) {
                abort(403, 'Unauthorized access');
            }

            $user = Auth::guard('branch')->user();
            if ($user->role_id == 7) {
                $this->branchId = $user->branch->id;
                $this->branchUserId = $user->id;
            } else {
                $branch = Branch::where('user_id', $user->created_by)->first();
                if (!$branch) {
                    abort(403, 'Invalid branch access');
                }
                $this->branchId = $branch->id;
                $this->branchUserId = $user->created_by;
            }

            return $next($request);
        });
    }

    public function index(){
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (!empty($rolesPrivileges) && str_contains($rolesPrivileges->privileges, 'reports_view')){
             return view('Branch.Reports.index'); 
        }else {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }
    }

    public function getGenerateReport($id)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'reports_edit')){
             return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }

        // Get branch-specific test results
        $testResult = TestResults::where('test_result_code', $id)
            ->whereHas('appointment', function($query) {
                $query->where('lab_id', $this->branchId);
            })
            ->firstOrFail();

        $testIdArray = TestResults::where('test_result_code', $id)
            ->whereHas('appointment', function($query) {
                $query->where('lab_id', $this->branchId);
            })
            ->pluck('test_id')
            ->toArray();

        $appointmentId = TestResults::where('test_result_code', $id)
            ->whereHas('appointment', function($query) {
                $query->where('lab_id', $this->branchId);
            })
            ->value('appointment_id');

        $tests = Test::whereIn('id', $testIdArray)->with('parameters.options')->get();
        
        $appointment = Appointment::with('pet.petparent')
            ->where('id', $appointmentId)
            ->where('lab_id', $this->branchId)
            ->firstOrFail();

        $report = TestResults::with(['test.parameters.options', 'components'])
            ->where('test_result_code', $id)
            ->whereHas('appointment', function($query) {
                $query->where('lab_id', $this->branchId);
            })
            ->get();

        return view('Branch.Reports.report-generate', compact('report', 'tests', 'appointment', 'id'));
    }

    public function viewReport($id){
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'reports_view')){
             return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }

        // Get branch-specific test results
        $testResult = TestResults::where('test_result_code', $id)
            ->whereHas('appointment', function($query) {
                $query->where('lab_id', $this->branchId);
            })
            ->firstOrFail();

        $testIdArray = TestResults::where('test_result_code', $id)
            ->whereHas('appointment', function($query) {
                $query->where('lab_id', $this->branchId);
            })
            ->pluck('test_id')
            ->toArray();

        $appointmentId = TestResults::where('test_result_code', $id)
            ->whereHas('appointment', function($query) {
                $query->where('lab_id', $this->branchId);
            })
            ->value('appointment_id');

        $tests = Test::whereIn('id', $testIdArray)->with('parameters')->get();

        $appointment = Appointment::with('pet.petparent')
            ->where('id', $appointmentId)
            ->where('lab_id', $this->branchId)
            ->firstOrFail();

        $report = TestResults::with(['test.parameters', 'components'])
            ->where('test_result_code', $id)
            ->whereHas('appointment', function($query) {
                $query->where('lab_id', $this->branchId);
            })
            ->get();

        return view('Branch.Reports.report-view', compact('report', 'tests', 'appointment', 'id'));
    }

    public function data_table(Request $request)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'reports_view')){
            if ($request->ajax()) {
                return response()->json([
                    'draw' => (int) $request->input('draw'),
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => [],
                    'error' => 'Sorry, You Have No Permission For This Request!'
                ]);
            }
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }

        $reports = TestResults::with([
                'appointment.pet.petparent',
                'test',
                'assignedDoctor'
            ])
            ->select('test_results.*') 
            ->join('appointments', 'test_results.appointment_id', '=', 'appointments.id') 
            ->where('appointments.lab_id', $this->branchId) // Branch-specific filter
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


                // ->addColumn('status', function ($row) {
                //     return !empty($row->status) ? ucfirst($row->status) : '-';
                // })


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
                // ->addColumn('signed', function ($row) {
                //     return !empty($row->signed_by_id) ? 'Yes' : 'No';
                // })

                ->addColumn('assigned_doctor', function ($row) {
                    return $row->assigned_doctor ?? 'Not Assigned';
                })


                ->addColumn('action', function ($row) {
                    $actionBtn = '';
                    $id = $row->test_result_code; 


                      // Assign Doctor button
                    if($row->status != 'completed' && $row->status != 'approved') {
                        $actionBtn .= '<button type="button" 
                                                class="btn btn-icon btn-secondary assign-doctor-btn me-1"
                                                title="Assign Doctor" 
                                                data-id="' . $id . '"
                                                style="background:#fff; color:#6f42c1; border:1px solid #6f42c1;">
                                                <i class="mdi mdi-account-plus"></i>
                                            </button>';
                    }                    
                    

                    // View button
                    $actionBtn .= '<a href="' . url('branch/reports/view/' . $id) . '" 
                                class="btn btn-icon btn-info me-1" 
                                title="View Report" 
                                data-bs-toggle="tooltip" 
                                style="background:#fff; color:#6267ae; border:1px solid #6267ae;">
                                <i class="mdi mdi-eye"></i>
                            </a>';

                    if($row->status != 'completed' && $row->status != 'approved') {
                   
                    // Edit button
                    $actionBtn .= '<a href="' . url('branch/generate-reports/' . $id) . '" 
                                    class="btn btn-icon btn-warning me-1" 
                                    title="Edit Report" 
                                    data-bs-toggle="tooltip" 
                                    style="background:#fff; color:#f6b51d; border:1px solid #f6b51d;">
                                    <i class="mdi mdi-pencil"></i>
                                </a>';
                    }            

                    // Sign Report button
                        // $actionBtn .= '<a href="' . url('branch/test-report/sign/' . $id) . '" 
                        //                 class="btn btn-icon btn-success me-1" 
                        //                 title="Sign Report" 
                        //                 style="background:#fff; color:#28a745; border:1px solid #28a745;">
                        //                 <i class="mdi mdi-signature-text"></i>
                        //             </a>';

                        

                    // Print Barcode button
                    $actionBtn .= '<a href="' . url('branch/test-report/barcode/' . $id) . '" 
                                    class="btn btn-icon btn-primary" 
                                    title="Print Barcode" 
                                    style="background:#fff; color:#000; border:1px solid #000;" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#barcodeModal">
                                    <i class="mdi mdi-barcode"></i>
                                </a>';

                    return $actionBtn;
                })



                ->rawColumns(['action', 'tests','status'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'reports_edit')){
             return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }

        // First validate the appointment belongs to this branch
        $appointment = Appointment::where('id', $request->appointment_id)
            ->where('lab_id', $this->branchId)
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

        // Find or create the TestResults record with branch validation
        $testResult = TestResults::where('test_id', $validated['test_id'])
            ->where('appointment_id', $validated['appointment_id'])
            ->where('test_result_code', $validated['test_result_code'])
            ->whereHas('appointment', function($query) {
                $query->where('lab_id', $this->branchId);
            })
            ->first();

        if (!$testResult) {
            $testResult = TestResults::create([
                'test_id' => $validated['test_id'],
                'appointment_id' => $validated['appointment_id'],
                'test_result_code' => $validated['test_result_code'],
                'status' => 'pending',
                'done' => 'no',
                'created_by' => $this->branchUserId,
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
            'modified_by' => $this->branchUserId,
            'modified_ip_address' => $request->ip(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Test results updated successfully.');
    }

    public function reportPdf(Request $request)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'reports_view')){
             return response()->json([
                'error' => 'Sorry, You Have No Permission For This Request!'
            ], 403);
        }

        $request->validate([
            'selected_test_results' => 'required|array',
            'selected_test_results.*' => 'exists:test_results,id',
        ]);

        $testResultIds = $request->input('selected_test_results', []);
        $reportsData = [];

        foreach ($testResultIds as $testResultId) {
            // Verify test result belongs to branch
            $testResult = TestResults::with(['components'])
                ->where('id', $testResultId)
                ->whereHas('appointment', function($query) {
                    $query->where('lab_id', $this->branchId);
                })
                ->first();

            if (!$testResult) {
                continue;
            }

            $test = Test::where('id', $testResult->test_id)
                ->with(['parameters'])
                ->first();

            $appointment = Appointment::with(['pet.petParent', 'branch', 'refereeDoctor'])
                ->where('id', $testResult->appointment_id)
                ->where('lab_id', $this->branchId)
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
                'error' => 'No valid test results found for your branch.'
            ], 404);
        }

        // Load the Blade view and generate PDF
        $pdf = Pdf::loadView('Branch.Reports.report_pdf', [
            'reports' => $reportsData,
            'branch' => Auth::guard('branch')->user()->branch, // Pass branch info to view
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
                    'filename' => 'test_results_report_' . $this->branchId . '_' . now()->format('YmdHis') . '.pdf',
                ]
            ]
        ]);
    }

    // public function assignDoctor(Request $request, $code)
    // {
    //     $request->validate([
    //         'doctor_id' => 'required|exists:internal_doctors,id',
    //     ]);

    //     // Get all reports with same test_result_code
    //     $reports = TestResults::where('test_result_code', $code)->get();

    //     if ($reports->isEmpty()) {
    //         return response()->json(['message' => 'Report not found.'], 404);
    //     }

    //     foreach ($reports as $report) {
    //         $report->assigned_to_doctor_id = $request->doctor_id; // ✅ Correct column name
    //         $report->assigned_by = Auth::id();
    //         $report->assigned_at = now();
    //         $report->save();
    //     }

    //     return response()->json(['message' => 'Doctor assigned successfully!']);
    // }

    public function assignDoctor(Request $request, $code)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
            ->where('status', 'active')
            ->select('privileges')
            ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'reports_edit')) {
            return response()->json(['message' => 'Sorry, You Have No Permission For This Request!'], 403);
        }

        $request->validate([
            'doctor_id' => 'required|exists:internal_doctors,id',
        ]);

        // Get all reports with same test_result_code, filtered by branch
        $reports = TestResults::where('test_result_code', $code)
            ->whereHas('appointment', function($query) {
                $query->where('lab_id', $this->branchId);
            })
            ->get();

        if ($reports->isEmpty()) {
            return response()->json(['message' => 'Report not found.'], 404);
        }

        foreach ($reports as $report) {
            $report->assigned_to_doctor_id = $request->doctor_id;
            $report->assigned_by = Auth::guard('branch')->id();  // Fixed: Use 'branch' guard
            $report->assigned_at = now();
            $report->save();
        }

        return response()->json(['message' => 'Doctor assigned successfully!']);
    }

    

}