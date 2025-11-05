<?php

namespace App\Http\Controllers\Branch\Sample;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SampleCollection;
use App\Models\Appointment;
use App\Models\Branch;
use App\Models\Master\Role_privilege;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BranchSampleController extends Controller
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

    public function index(Request $request)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
            ->where('status', 'active')
            ->select('privileges')
            ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'sample_view')) {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }

        return view('Branch.Samples.index');
    }

    public function create()
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
            ->where('status', 'active')
            ->select('privileges')
            ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'sample_add')) {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }

        $appointments = Appointment::with('pet.petParent')  
            ->where('status', 'active')
            ->where('lab_id', $this->branchId)
            ->orderBy('created_at', 'DESC')
            ->get();

        $allBranches = Branch::where('status', 'active')->orderBy('branch_name')->get();    

        $branches = Branch::where('status', 'active')->where('type','branch')->orderBy('branch_name')->get();

        $currentBranch = Branch::find($this->branchId);

        return view('Branch.Samples.create', compact('appointments', 'branches','allBranches', 'currentBranch'));
    }

    public function store(Request $request)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
            ->where('status', 'active')
            ->select('privileges')
            ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'sample_add')) {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }

        $rules = [
            'appointment_id' => 'required|exists:appointments,id|unique:sample_collections,appointment_id',
            'sample_type' => 'required|in:Blood,Urine,Stool,Saliva,Tissue',
            'collection_source_id' => 'required|exists:branches,id',
            'destination_lab_id' => 'required|exists:branches,id',
            'status' => 'nullable|in:Pending,Collected,In Transit,Received,Processing,Analyzed,Reported,Completed,Cancelled,Rejected',
            'collection_date' => 'required|date|after_or_equal:today',
            'collection_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string|max:1000',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        return DB::transaction(function () use ($request) {
            $currentUserId = $this->branchUserId;
            $currentIp = $request->ip();

            $sampleInput = [
                'appointment_id' => $request->appointment_id,
                'sample_type' => $request->sample_type,
                'collection_source_id' => $this->branchId, 
                'destination_lab_id' => $request->destination_lab_id,
                'status' => $request->status ?? 'Pending', 
                'collection_date' => $request->collection_date,
                'collection_time' => $request->collection_time,
                'notes' => $request->notes,
                'created_by' => $currentUserId,
                'created_ip_address' => $currentIp,
            ];

            $sample = SampleCollection::create($sampleInput);

            // Generate and update sample code
            $sample->sample_code = 'SC' . str_pad($sample->id, 3, '0', STR_PAD_LEFT);
            $sample->save();

            return redirect()->route('branch.sample.index')->with('success', 'Sample collection added successfully!');
        });
    }

    public function edit($id)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
            ->where('status', 'active')
            ->select('privileges')
            ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'sample_edit')) {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }

        $sample = SampleCollection::with(['appointment', 'collectionSource', 'destinationLab'])
            ->where('id', $id)
            ->where('collection_source_id', $this->branchId)
            ->where('status', '!=', 'Deleted')
            ->firstOrFail();

        $appointments = Appointment::with('pet.petParent')  
            ->where('status', 'active')
            ->where('lab_id', $this->branchId)
            ->orderBy('created_at', 'DESC')
            ->get();

        $allBranches = Branch::where('status', 'active')->orderBy('branch_name')->get();    

        $branches = Branch::where('status', 'active')
            ->where('type', 'branch')
            ->orderBy('branch_name')
            ->get();

        $currentBranch = Branch::find($this->branchId);

        return view('Branch.Samples.create', compact('sample', 'appointments', 'branches', 'allBranches', 'currentBranch'));
    }

    public function update(Request $request, $id)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
            ->where('status', 'active')
            ->select('privileges')
            ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'sample_edit')) {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }

        $sample = SampleCollection::where('id', $id)
            ->where('collection_source_id', $this->branchId)
            ->where('status', '!=', 'Deleted')
            ->firstOrFail();

        $rules = [
            'appointment_id' => 'required|exists:appointments,id|unique:sample_collections,appointment_id,' . $id,
            'sample_type' => 'required|in:Blood,Urine,Stool,Saliva,Tissue',
            'collection_source_id' => 'required|exists:branches,id',
            'destination_lab_id' => 'required|exists:branches,id',
            'status' => 'nullable|in:Pending,Collected,In Transit,Received,Processing,Analyzed,Reported,Completed,Cancelled,Rejected',
            'collection_date' => 'required|date',
            'collection_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string|max:1000',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        return DB::transaction(function () use ($request, $id, $sample) { 
            $currentUserId = $this->branchUserId;
            $currentIp = $request->ip();

            $sampleInput = [
                'appointment_id' => $request->appointment_id,
                'sample_type' => $request->sample_type,
                'collection_source_id' => $this->branchId, // Keep as current branch
                'destination_lab_id' => $request->destination_lab_id,
                'status' => $request->status ?? $sample->status,
                'collection_date' => $request->collection_date,
                'collection_time' => $request->collection_time,
                'notes' => $request->notes,
                'modified_by' => $currentUserId,
                'modified_ip_address' => $currentIp,
            ];

            SampleCollection::where('id', $id)->update($sampleInput);

            return redirect()->route('branch.sample.index')->with('success', 'Sample collection updated successfully!');
        });
    }

    public function view($id)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
            ->where('status', 'active')
            ->select('privileges')
            ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'sample_view')) {
            abort(403, 'Unauthorized');
        }

        $sample = SampleCollection::with(['appointment', 'collectionSource', 'destinationLab'])
            ->where('id', $id)
            ->where('collection_source_id', $this->branchId)
            ->where('status', '!=', 'Deleted')
            ->firstOrFail();

        return view('Branch.Samples.view', compact('sample'));
    }

    public function delete($id)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
            ->where('status', 'active')
            ->select('privileges')
            ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'sample_delete')) {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }

        $sample = SampleCollection::where('id', $id)
            ->where('collection_source_id', $this->branchId)
            ->where('status', '!=', 'Deleted')
            ->firstOrFail();
        $sample->status = 'Deleted';
        $sample->save();

        return redirect()->route('branch.sample.index')->with('success', 'Sample collection deleted successfully!');
    }

    // public function data_table(Request $request)
    // {
    //     $role_id = Auth::guard('branch')->user()->role_id;
    //     $rolesPrivileges = Role_privilege::where('id', $role_id)
    //         ->where('status','active')
    //         ->select('privileges')
    //         ->first();

    //     // 🔐 Permission check
    //     if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'sample_view')) {
    //         if ($request->ajax()) {
    //             return response()->json([
    //                 'draw' => (int) $request->input('draw'),
    //                 'recordsTotal' => 0,
    //                 'recordsFiltered' => 0,
    //                 'data' => [],
    //                 'error' => 'Sorry, You Have No Permission For This Request!'
    //             ]);
    //         }
    //         return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
    //     }

    //     // Fetch samples with relations (branch-specific)
    //     $samples = SampleCollection::with(['appointment', 'collectionSource', 'destinationLab'])
    //         ->where('collection_source_id', $this->branchId)
    //         ->where('status', '!=', 'delete')
    //         ->orderBy('created_at', 'DESC')
    //         ->get();

    //     // DataTables response
    //     if ($request->ajax()) {
    //         return DataTables::of($samples)
    //             ->addIndexColumn()

    //             // Sample Code
    //             ->addColumn('sample_code', function ($row) {
    //                 return $row->sample_code ?? '';
    //             })

    //             // Appointment Code
    //             ->addColumn('appointment_code', function ($row) {
    //                 return $row->appointment->appointment_code ?? 'N/A';
    //             })

    //             // Patient Name
    //             ->addColumn('patient_name', function ($row) {
    //                 if (!empty($row->appointment->patient_name)) {
    //                     return $row->appointment->patient_name;
    //                 } elseif (!empty($row->appointment->pet->petParent->name)) {
    //                     return $row->appointment->pet->petParent->name;
    //                 }
    //                 return 'N/A';
    //             })

    //             // Sample Type
    //             ->addColumn('sample_type', function ($row) {
    //                 return $row->sample_type ?? '';
    //             })

    //             // Collection Source
    //             ->addColumn('collection_source', function ($row) {
    //                 if (!empty($row->collectionSource)) {
    //                     return $row->collectionSource->branch_name . ' (' . $row->collectionSource->branch_code . ')';
    //                 }
    //                 return 'N/A';
    //             })

    //             // Destination Lab
    //             ->addColumn('destination_lab', function ($row) {
    //                 if (!empty($row->destinationLab)) {
    //                     return $row->destinationLab->branch_name . ' (' . $row->destinationLab->branch_code . ')';
    //                 }
    //                 return 'N/A';
    //             })

    //             // Status Badge
    //             ->addColumn('status', function ($row) {
    //                 $badgeClass = $row->status_badge ?? 'secondary';
    //                 return '<span class="badge bg-' . $badgeClass . '">' . e($row->status) . '</span>';
    //             })

    //             // Collection DateTime (Fixed)
    //             ->addColumn('collection_datetime', function ($row) {
    //                 $datetime = null;

    //                 if (!empty($row->collection_date) && !empty($row->collection_time)) {
    //                     $datePart = trim($row->collection_date);
    //                     $timePart = trim($row->collection_time);

    //                     // Check if date already contains time
    //                     if (preg_match('/\d{2}:\d{2}:\d{2}/', $datePart)) {
    //                         $datetime = $datePart;
    //                     }
    //                     // Check if time is actually a full datetime
    //                     elseif (preg_match('/\d{4}-\d{2}-\d{2}/', $timePart)) {
    //                         $datetime = $timePart;
    //                     }
    //                     // Combine date + time safely
    //                     else {
    //                         $datetime = $datePart . ' ' . $timePart;
    //                     }

    //                     try {
    //                         return \Carbon\Carbon::parse($datetime)->format('d M Y h:i A');
    //                     } catch (\Exception $e) {
    //                         return 'Invalid Date';
    //                     }
    //                 }

    //                 return 'N/A';
    //             })

    //             // Action Buttons
    //             ->addColumn('action', function ($row) {
    //                 $actionBtn = '';

    //                 // View button
    //                 $actionBtn .= '<a href="' . route('branch.sample.view', $row->id) . '" 
    //                             class="btn btn-icon btn-info me-1" 
    //                             title="View Sample"
    //                             data-bs-toggle="tooltip"
    //                             style="background:#fff; color:#6267ae; border:1px solid #6267ae;">
    //                             <i class="mdi mdi-eye"></i>
    //                         </a>';

    //                 // Edit button
    //                 $actionBtn .= '<a href="' . route('branch.sample.edit', $row->id) . '" 
    //                             class="btn btn-icon btn-warning me-1" 
    //                             title="Edit Sample"
    //                             data-bs-toggle="tooltip"
    //                             style="background:#fff; color:#f6b51d; border:1px solid #f6b51d;">
    //                             <i class="mdi mdi-pencil"></i>
    //                         </a>';

    //                 // Delete button
    //                 $actionBtn .= '<a href="javascript:void(0)" 
    //                                 data-id="' . $row->id . '" 
    //                                 data-table="sample_collections" 
    //                                 data-flash="Sample Deleted Successfully!" 
    //                                 class="btn btn-icon btn-danger delete me-1" 
    //                                 title="Delete Sample" 
    //                                 data-bs-toggle="tooltip" 
    //                                 style="background:#fff; color:#cc235e; border:1px solid #cc235e;">
    //                                 <i class="mdi mdi-trash-can"></i>
    //                             </a>';  

    //                 return $actionBtn;
    //             })

    //             ->rawColumns(['status', 'action'])
    //             ->make(true);
    //     }
    // }

    public function data_table(Request $request)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
            ->where('status','active')
            ->select('privileges')
            ->first();

        // 🔐 Permission check
        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'sample_view')) {
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

        // Fetch samples with relations (branch-specific)
        $samples = SampleCollection::with(['appointment', 'collectionSource', 'destinationLab'])
            ->where('collection_source_id', $this->branchId)
            ->where('status', '!=', 'delete')
            ->orderBy('created_at', 'DESC')
            ->get();

        // DataTables response
        if ($request->ajax()) {
            return DataTables::of($samples)
                ->addIndexColumn()

                // Sample Code
                ->addColumn('sample_code', function ($row) {
                    return $row->sample_code ?? '';
                })

                // Appointment Code
                ->addColumn('appointment_code', function ($row) {
                    return $row->appointment->appointment_code ?? 'N/A';
                })

                // Patient Name
                ->addColumn('patient_name', function ($row) {
                    if (!empty($row->appointment->patient_name)) {
                        return $row->appointment->patient_name;
                    } elseif (!empty($row->appointment->pet->petParent->name)) {
                        return $row->appointment->pet->petParent->name;
                    }
                    return 'N/A';
                })

                // Sample Type
                ->addColumn('sample_type', function ($row) {
                    return $row->sample_type ?? '';
                })

                // Collection Source
                ->addColumn('collection_source', function ($row) {
                    if (!empty($row->collectionSource)) {
                        return $row->collectionSource->branch_name . ' (' . $row->collectionSource->branch_code . ')';
                    }
                    return 'N/A';
                })

                // Destination Lab (Show 'Self' if same as collection source)
                ->addColumn('destination_lab', function ($row) {
                    if (!empty($row->destinationLab)) {
                        if ($row->destination_lab_id == $row->collection_source_id) {
                            return 'Self (Internal Processing)';
                        }
                        return $row->destinationLab->branch_name . ' (' . $row->destinationLab->branch_code . ')';
                    }
                    return 'N/A';
                })

                // Status Badge
                ->addColumn('status', function ($row) {
                    $badgeClass = $row->status_badge ?? 'secondary';
                    return '<span class="badge bg-' . $badgeClass . '">' . e($row->status) . '</span>';
                })

                // Collection DateTime (Fixed)
                ->addColumn('collection_datetime', function ($row) {
                    $datetime = null;

                    if (!empty($row->collection_date) && !empty($row->collection_time)) {
                        $datePart = trim($row->collection_date);
                        $timePart = trim($row->collection_time);

                        // Check if date already contains time
                        if (preg_match('/\d{2}:\d{2}:\d{2}/', $datePart)) {
                            $datetime = $datePart;
                        }
                        // Check if time is actually a full datetime
                        elseif (preg_match('/\d{4}-\d{2}-\d{2}/', $timePart)) {
                            $datetime = $timePart;
                        }
                        // Combine date + time safely
                        else {
                            $datetime = $datePart . ' ' . $timePart;
                        }

                        try {
                            return \Carbon\Carbon::parse($datetime)->format('d M Y h:i A');
                        } catch (\Exception $e) {
                            return 'Invalid Date';
                        }
                    }

                    return 'N/A';
                })

                // Action Buttons
                ->addColumn('action', function ($row) {
                    $actionBtn = '';

                    // View button
                    $actionBtn .= '<a href="' . route('branch.sample.view', $row->id) . '" 
                                class="btn btn-icon btn-info me-1" 
                                title="View Sample"
                                data-bs-toggle="tooltip"
                                style="background:#fff; color:#6267ae; border:1px solid #6267ae;">
                                <i class="mdi mdi-eye"></i>
                            </a>';

                    // Edit button
                    $actionBtn .= '<a href="' . route('branch.sample.edit', $row->id) . '" 
                                class="btn btn-icon btn-warning me-1" 
                                title="Edit Sample"
                                data-bs-toggle="tooltip"
                                style="background:#fff; color:#f6b51d; border:1px solid #f6b51d;">
                                <i class="mdi mdi-pencil"></i>
                            </a>';

                    // Delete button
                    $actionBtn .= '<a href="javascript:void(0)" 
                                    data-id="' . $row->id . '" 
                                    data-table="sample_collections" 
                                    data-flash="Sample Deleted Successfully!" 
                                    class="btn btn-icon btn-danger delete me-1" 
                                    title="Delete Sample" 
                                    data-bs-toggle="tooltip" 
                                    style="background:#fff; color:#cc235e; border:1px solid #cc235e;">
                                    <i class="mdi mdi-trash-can"></i>
                                </a>';  

                    return $actionBtn;
                })

                ->rawColumns(['status', 'action'])
                ->make(true);
        }
    }
    

    public function getAppointment($id)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
            ->where('status', 'active')
            ->select('privileges')
            ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'sample_view')) {
            abort(403, 'Unauthorized');
        }

        $appointment = Appointment::with(['pet.petParent'])  
            ->where('id', $id)
            ->where('lab_id', $this->branchId)
            ->where('status', 'active')
            ->firstOrFail();

        return response()->json([
            'id' => $appointment->id,
            'appointment_code' => $appointment->appointment_code,
            'patient_name' => $appointment->patient_name ?? $appointment->pet->petParent->name ?? 'N/A',
            'patient_phone' => $appointment->patient_phone ?? $appointment->pet->petParent->mobile ?? 'N/A',
            // Add more fields as needed
        ]);
    }
}