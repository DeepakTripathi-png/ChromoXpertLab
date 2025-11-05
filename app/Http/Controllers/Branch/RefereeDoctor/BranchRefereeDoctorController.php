<?php

namespace App\Http\Controllers\Branch\RefereeDoctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RefereeDoctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\Master\Role_privilege;
use App\Models\Branch;

class BranchRefereeDoctorController extends Controller
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

    public function index()
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (!empty($rolesPrivileges) && str_contains($rolesPrivileges->privileges, 'referee_doctors_view')){
             return view('Branch.Doctor.referee-doctor'); 
        }else {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }
    }

    public function add(){
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (!empty($rolesPrivileges) && str_contains($rolesPrivileges->privileges, 'referee_doctors_add')){
             return view('Branch.Doctor.add-referee-doctor'); 
        }else {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }
    }

    public function store(Request $request)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (empty($rolesPrivileges) || (!str_contains($rolesPrivileges->privileges, 'referee_doctors_add') && !str_contains($rolesPrivileges->privileges, 'referee_doctors_edit'))){
             return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }

        // Normalize phone (remove '+91' if exists)
        $normalizedPhone = preg_replace('/^\+91/', '', $request->mobile);

        // Custom validation logic
        $request->validate([
            'doctor_name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'email' => 'required|email|max:255|unique:referee_doctors,email,' . ($request->id ?? 'NULL') . ',id',
            'mobile' => [
                'required',
                'string',
                'max:255',
                'min:4',
                function ($attribute, $value, $fail) use ($request, $normalizedPhone) {
                    $existingRefereeDoctor = RefereeDoctor::where(function ($q) use ($normalizedPhone) {
                        $q->where('mobile', $normalizedPhone)
                            ->orWhere('mobile', '+91' . $normalizedPhone);
                    });

                    if ($request->id) {
                        $existingRefereeDoctor->where('id', '!=', $request->id);
                    }

                    $existingRefereeDoctor = $existingRefereeDoctor->first();

                    if ($existingRefereeDoctor) {
                        $fail('This mobile number is already in use.');
                    }
                },
            ],
            'commission_percent' => 'nullable|numeric|min:0|max:100',
            'address' => 'nullable|string|max:255',
        ]);

        //    dd($request->all());

        $refereeDoctorInput = [
            'doctor_name' => $request->doctor_name,
            'gender' => $request->gender,
            'email' => $request->email,
            'mobile' => $normalizedPhone,  // Store normalized version
            'commission_percent' => $request->commission_percent,
            'address' => $request->address,
            'status' => 'active',
        ];

        return DB::transaction(function () use ($request, $refereeDoctorInput) {
            $ipAddress = $request->ip();

            if (!empty($request->id)) {
                // UPDATE logic
                $refereeDoctorInput['modified_by'] = $this->branchUserId;
                $refereeDoctorInput['modified_ip_address'] = $ipAddress;

                RefereeDoctor::where('id', $request->id)->update($refereeDoctorInput);

                return redirect('branch/referee-doctors')->with('success', 'Referee Doctor updated successfully!');
            } else {
                // CREATE logic
                $refereeDoctorInput['created_by'] = $this->branchUserId;
                $refereeDoctorInput['created_ip_address'] = $ipAddress;

                // Create RefereeDoctor
                $refereeDoctor = RefereeDoctor::create($refereeDoctorInput);

                // Generate code using ID
                $refereeDoctor->code = 'RD' . str_pad($refereeDoctor->id, 4, '0', STR_PAD_LEFT);
                $refereeDoctor->save();

                return redirect('branch/referee-doctors')->with('success', 'Referee Doctor added successfully!');
            }
        });
    }

    public function data_table(Request $request)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'referee_doctors_view')){
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
        
        $refereeDoctors = RefereeDoctor::where('status', '!=', 'delete')
            ->orderBy('id', 'DESC')
            ->select('id', 'code', 'doctor_name', 'gender', 'email', 'mobile', 'commission_percent', 'status', 'created_by')
            ->get();

        if ($request->ajax()) {
            // Capture the property as a local variable for use in closures
            $branchUserId = $this->branchUserId;

            return DataTables::of($refereeDoctors)
                ->addIndexColumn()
                ->addColumn('code', function ($row) {
                    return !empty($row->code) ? $row->code : '';
                })
                ->addColumn('doctor_name', function ($row) {
                    return !empty($row->doctor_name) ? $row->doctor_name : '';
                })
                ->addColumn('gender', function ($row) {
                    return !empty($row->gender) ? $row->gender : '';
                })
                ->addColumn('email', function ($row) {
                    return !empty($row->email) ? $row->email : '';
                })
                ->addColumn('mobile', function ($row) {
                    return !empty($row->mobile) ? $row->mobile : '';
                })
                // ->addColumn('commission_percent', function ($row) {
                //     return !empty($row->commission_percent) ? $row->commission_percent . '%' : '';
                // })
                ->addColumn('action', function ($row) use ($branchUserId) {
                    $actionBtn = '';

                    if ($row->created_by == $branchUserId) {
                        // Edit button
                        $actionBtn .= '<a href="' . url('branch/referee-doctor/edit/' . $row->id) . '" 
                                        class="btn btn-icon btn-warning me-1" 
                                        title="Edit Referee Doctor" 
                                        data-bs-toggle="tooltip" 
                                        style="background:#fff; color:#f6b51d; border:1px solid #f6b51d;">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>';

                        // Delete button
                        $actionBtn .= '<a href="javascript:void(0)" 
                                        data-id="' . $row->id . '" 
                                        data-table="referee_doctors" 
                                        data-flash="Referee Doctor Deleted Successfully!" 
                                        class="btn btn-icon btn-danger delete me-1" 
                                        title="Delete Referee Doctor" 
                                        data-bs-toggle="tooltip" 
                                        style="background:#fff; color:#cc235e; border:1px solid #cc235e;">
                                        <i class="mdi mdi-trash-can"></i>
                                    </a>';
                    }
                    return $actionBtn;
                })
                ->addColumn('status', function ($row) use ($branchUserId) {
                    $isChecked = $row->status == 'active' ? 'checked' : '';

                    if ($row->created_by == $branchUserId) {
                        return '<input type="checkbox" class="change-status" data-id="' . $row->id . '" data-table="referee_doctors" data-flash="Status Changed Successfully!" ' . $isChecked . '>';
                    } else {
                        // Disabled checkbox for non-owned records
                        return '<input type="checkbox" disabled ' . $isChecked . '>';
                    }
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function edit($id)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'referee_doctors_edit')){
             return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }

        $refereedoctor = RefereeDoctor::where('id', $id)->where('created_by', $this->branchUserId)->first();

        if (!$refereedoctor) {
            return redirect('branch/referee-doctors')->with('error', 'Referee Doctor not found!');
        }

        return view('Branch.Doctor.add-referee-doctor', compact('refereedoctor'));
    }

    public function storeAjax(Request $request)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'referee_doctors_add')){
             return response()->json([
                'success' => false,
                'message' => 'Sorry, You Have No Permission For This Request!'
            ], 403);
        }

        // Normalize phone (remove '+91' if exists)
        $normalizedPhone = preg_replace('/^\+91/', '', $request->mobile);

        // Custom validation logic
        $validator = Validator::make($request->all(), [
            'doctor_name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'email' => 'required|email|max:255|unique:referee_doctors,email',
            'mobile' => [
                'required',
                'string',
                'max:255',
                'min:4',
                function ($attribute, $value, $fail) use ($normalizedPhone) {
                    $existingRefereeDoctor = RefereeDoctor::where(function ($q) use ($normalizedPhone) {
                        $q->where('mobile', $normalizedPhone)
                            ->orWhere('mobile', '+91' . $normalizedPhone);
                    })->first();

                    if ($existingRefereeDoctor) {
                        $fail('This mobile number is already in use.');
                    }
                },
            ],
            'commission_percent' => 'nullable|numeric|min:0|max:100',
            'address' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        return DB::transaction(function () use ($request, $normalizedPhone) {
            $ipAddress = $request->ip();

            $refereeDoctorInput = [
                'doctor_name' => $request->doctor_name,
                'gender' => $request->gender,
                'email' => $request->email,
                'mobile' => $normalizedPhone,  // Store normalized version
                'commission_percent' => $request->commission_percent,
                'address' => $request->address,
                'status' => 'active',
                'created_by' => $this->branchUserId,
                'created_ip_address' => $ipAddress,
            ];

            // Create RefereeDoctor
            $refereeDoctor = RefereeDoctor::create($refereeDoctorInput);

            // Generate code using ID
            $refereeDoctor->code = 'RD' . str_pad($refereeDoctor->id, 4, '0', STR_PAD_LEFT); // e.g., RD0001
            $refereeDoctor->save();

            return response()->json([
                'success' => true,
                'message' => 'Referee Doctor added successfully!',
                'doctor' => [
                    'id' => $refereeDoctor->id,
                    'doctor_name' => $refereeDoctor->doctor_name,
                    'code' => $refereeDoctor->code,
                ]
            ], 201);
        });
    }
}