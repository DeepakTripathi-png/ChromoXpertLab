<?php

namespace App\Http\Controllers\Admin\RefereeDoctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RefereeDoctor;
use App\Models\Master\Master_admin;
use App\Models\Master\Role_privilege;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
class RefereeDoctorController extends Controller
{
    
    public function index()
    {
        return view('Admin.Doctor.referee-doctor');
    }

    public function add(){
        return view('Admin.Doctor.add-referee-doctor');
    }


    public function store(Request $request)
    {
        $role_id = Auth::guard('master_admins')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)
            ->where('status', 'active')
            ->select('privileges')
            ->first();

        $masterAdminId = null;
        if (!empty($request->id)) {
            $refereeDoctor = RefereeDoctor::find($request->id);
            if ($refereeDoctor) {
                $masterAdmin = Master_admin::where('email', $refereeDoctor->email)->first();
                $masterAdminId = $masterAdmin ? $masterAdmin->id : null;
            }
        }

        $request->validate([
            'doctor_name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'email' => 'required|email|max:255|unique:referee_doctors,email,' . ($request->id ?? 'NULL') . ',id',
            'mobile' => 'required|string|regex:/^(\+91)?[0-9]{10}$/',
            'commission_percent' => 'required|numeric|min:0|max:100',
            'address' => 'nullable|string|max:255',
        ]);

        $refereeDoctorInput = [
            'doctor_name' => $request->doctor_name,
            'gender' => $request->gender,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'commission_percent' => $request->commission_percent,
            'address' => $request->address,
            'status' => 'active',
        ];

        $lastFourDigits = substr($request->mobile, -4);
        $passwordRaw = strtolower(str_replace(' ', '', $request->doctor_name)) . '@' . $lastFourDigits;
        $passwordHashed = Hash::make($passwordRaw);

  

        return DB::transaction(function () use ($request, $RolesPrivileges, $refereeDoctorInput, $masterAdminId) {
            if (!empty($request->id)) {
                // UPDATE logic
                if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'referee_doctors_edit')) {
                    $refereeDoctorInput['modified_by'] = Auth::guard('master_admins')->user()->id;
                    $refereeDoctorInput['modified_ip_address'] = $request->ip();


                    RefereeDoctor::where('id', $request->id)->update($refereeDoctorInput);

               
                    return redirect('admin/referee-doctors')->with('success', 'Referee Doctor updated successfully!');
                } else {
                    return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
                }
            } else {
                // CREATE logic
               
                if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'referee_doctors_add')) {
                    $refereeDoctorInput['created_by'] = Auth::guard('master_admins')->user()->id;
                    $refereeDoctorInput['created_ip_address'] = $request->ip();

                  

                    // Create RefereeDoctor
                    $refereeDoctor = RefereeDoctor::create($refereeDoctorInput);

                    // Generate code using ID
                    $refereeDoctor->code = 'RD' . str_pad($refereeDoctor->id, 4, '0', STR_PAD_LEFT); // RD0001
                    $refereeDoctor->save();

                 

                    return redirect('admin/referee-doctors')->with('success', 'Referee Doctor added successfully!');
                } else {
                    return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
                }
            }
        });
    }

    public function data_table(Request $request)
    {
        $refereeDoctors = RefereeDoctor::where('status', '!=', 'delete')
            ->orderBy('id', 'DESC')
            ->select('id', 'code', 'doctor_name', 'gender', 'email', 'mobile', 'commission_percent', 'status')
            ->get();

        if ($request->ajax()) {
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
                ->addColumn('commission_percent', function ($row) {
                    return !empty($row->commission_percent) ? $row->commission_percent . '%' : '';
                })

                    ->addColumn('action', function ($row) {
                        $actionBtn = '';
                        $role_id = Auth::guard('master_admins')->user()->role_id;
                        $RolesPrivileges = Role_privilege::where('status', 'active')->where('id', $role_id)->select('privileges')->first();


              


                    // Edit button
                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'referee_doctors_edit')) {
                        $actionBtn .= '<a href="' . url('admin/referee-doctor/edit/' . $row->id) . '" 
                                        class="btn btn-icon btn-warning me-1" 
                                        title="Edit Internal Doctor" 
                                        data-bs-toggle="tooltip" 
                                        style="background:#fff; color:#f6b51d; border:1px solid #f6b51d;">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>';
                    } 

                    // Delete button
                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'referee_doctors_delete')) {
                        $actionBtn .= '<a href="javascript:void(0)" 
                                        data-id="' . $row->id . '" 
                                        data-table="referee_doctors" 
                                        data-flash="Referee doctor deleted  Successfully!" 
                                        class="btn btn-icon btn-danger delete me-1" 
                                        title="Delete referee doctor" 
                                        data-bs-toggle="tooltip" 
                                        style="background:#fff; color:#cc235e; border:1px solid #cc235e;">
                                        <i class="mdi mdi-trash-can"></i>
                                    </a>';
                    } 
                    return $actionBtn;
                })

            
                ->addColumn('status', function ($row) {
                    $role_id = Auth::guard('master_admins')->user()->role_id;
                    $RolesPrivileges = Role_privilege::where('status', 'active')->where('id', $role_id)->select('privileges')->first();

                    $isChecked = $row->status == 'active' ? 'checked' : '';

                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'referee_doctors_status_change')) {
                        return '<input type="checkbox" class="change-status" data-id="' . $row->id . '" data-table="referee_doctors" data-flash="Status Changed Successfully!" ' . $isChecked . '>';
                    } else {
                        // Disabled checkbox for users without permission
                        return '<input type="checkbox" disabled ' . $isChecked . '>';
                    }
                })

                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function edit($id)
    {
        $refereedoctor = RefereeDoctor::find($id);

     

        if (!$refereedoctor) {
            return redirect('admin/referee-doctor')->with('error', 'Referee Doctor not found!');
        }

        return view('Admin.Doctor.add-referee-doctor', compact('refereedoctor'));
    }



    public function storeAjax(Request $request)
    {
        $role_id = Auth::guard('master_admins')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)
            ->where('status', 'active')
            ->select('privileges')
            ->first();

        if (!$RolesPrivileges || !str_contains($RolesPrivileges->privileges, 'referee_doctors_add')) {
            return response()->json([
                'success' => false,
                'errors' => ['permission' => 'Sorry, You Have No Permission For This Request!']
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'doctor_name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'email' => 'required|email|max:255|unique:referee_doctors,email',
            'mobile' => 'required|string|regex:/^\+91[0-9]{10}$/|unique:referee_doctors,mobile',
            'address' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        return DB::transaction(function () use ($request) {
            $refereeDoctorInput = [
                'doctor_name' => $request->doctor_name,
                'gender' => $request->gender,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'commission_percent' => $request->commission_percent??0,
                'address' => $request->address,
                'status' => 'active',
                'created_by' => Auth::guard('master_admins')->user()->id,
                'created_ip_address' => $request->ip(),
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
