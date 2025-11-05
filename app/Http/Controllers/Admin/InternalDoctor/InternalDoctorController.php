<?php

namespace App\Http\Controllers\Admin\InternalDoctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InternalDoctor;
use App\Models\Master\Master_admin;
use App\Models\Master\Role_privilege;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use App\Models\User;

class InternalDoctorController extends Controller
{

    public function index(){
        return view('Admin.Doctor.internal-doctor'); 
    }

    public function add(){
        return view('Admin.Doctor.add-internal-doctor'); 
    }


    // public function store(Request $request)
    // {
    //     $role_id = Auth::guard('master_admins')->user()->role_id;
    //     $RolesPrivileges = Role_privilege::where('id', $role_id)
    //         ->where('status', 'active')
    //         ->select('privileges')
    //         ->first();

    //     $masterAdminId = null;
    //     if (!empty($request->id)) {
    //         $internalDoctor = InternalDoctor::find($request->id);
    //         if ($internalDoctor) {
    //             $masterAdmin = Master_admin::where('email', $internalDoctor->email)->first();
    //             $masterAdminId = $masterAdmin ? $masterAdmin->id : null;
    //         }
    //     }

    //     $request->validate([
    //         'doctor_name' => 'required|string|max:255',
    //         'gender' => 'required|in:Male,Female,Other',
    //         'email' => 'required|email|max:255|unique:internal_doctors,email,' . ($request->id ?? 'NULL') . ',id|unique:master_admins,email,' . ($masterAdminId ?? 'NULL') . ',id',
    //         'mobile' => 'required|string|regex:/^\+91[0-9]{10}$/',
    //         'address' => 'nullable|string|max:255',
    //         'doctor_image_path' => 'nullable|image|max:2048',
    //         'doctor_sign_path' => 'nullable|image|max:2048',
    //     ]);

    //     $internalDoctorInput = [
    //         'doctor_name' => $request->doctor_name,
    //         'gender' => $request->gender,
    //         'email' => $request->email,
    //         'mobile' => $request->mobile,
    //         'address' => $request->address,

    //     ];

    //     // Handle image uploads
    //     if ($request->hasFile('doctor_image_path')) {
    //         $file = $request->file('doctor_image_path');
    //         $internalDoctorInput['doctor_image_name'] = $file->getClientOriginalName();
    //         $internalDoctorInput['doctor_image_path'] = $file->store('images/internal_doctors', 'public');
    //     } elseif (!empty($request->id)) {
    //         $internalDoctorInput['doctor_image_name'] = $internalDoctor->doctor_image_name ?? null;
    //         $internalDoctorInput['doctor_image_path'] = $internalDoctor->doctor_image_path ?? null;
    //     }

    //     if ($request->hasFile('doctor_sign_path')) {
    //         $file = $request->file('doctor_sign_path');
    //         $internalDoctorInput['doctor_sign_name'] = $file->getClientOriginalName();
    //         $internalDoctorInput['doctor_sign_path'] = $file->store('images/internal_doctors/signatures', 'public');
    //     } elseif (!empty($request->id)) {
    //         $internalDoctorInput['doctor_sign_name'] = $internalDoctor->doctor_sign_name ?? null;
    //         $internalDoctorInput['doctor_sign_path'] = $internalDoctor->doctor_sign_path ?? null;
    //     }

    //     $lastFourDigits = substr($request->mobile, -4);
    //     $passwordRaw = strtolower(str_replace(' ', '', $request->doctor_name)) . '@' . $lastFourDigits;
    //     $passwordHashed = Hash::make($passwordRaw);

    //     $masterAdminInput = [
    //         'user_type' => 'internal_doctor',
    //         'user_name' => $request->doctor_name,
    //         'email' => $request->email,
    //         'mobile_no' => $request->mobile,
    //         'password' => $passwordHashed,
    //         'address' => $request->address,
    //         'role_id' =>4
    //     ];

    //     if (isset($internalDoctorInput['doctor_image_path'])) {
    //         $masterAdminInput['user_profile_image_path'] = $internalDoctorInput['doctor_image_path'];
    //     }

    //     return DB::transaction(function () use ($request, $RolesPrivileges, $internalDoctorInput, $masterAdminInput, $masterAdminId) {
    //         if (!empty($request->id)) {
    //             // UPDATE logic
    //             if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'internal_doctors_edit')) {
    //                 $internalDoctorInput['modified_by'] = Auth::guard('master_admins')->user()->id;
    //                 $internalDoctorInput['modified_ip_address'] = $request->ip();
    //                 $masterAdminInput['modified_by'] = Auth::guard('master_admins')->user()->id;
    //                 $masterAdminInput['modified_ip_address'] = $request->ip();

    //                 InternalDoctor::where('id', $request->id)->update($internalDoctorInput);

    //                 if ($masterAdminId) {
    //                     Master_admin::where('id', $masterAdminId)->update($masterAdminInput);
    //                 } else {
    //                     Master_admin::where('email', $request->old_email)->update($masterAdminInput);
    //                 }

    //                 return redirect('admin/internal-doctors')->with('success', 'Internal Doctor updated successfully!');
    //             } else {
    //                 return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
    //             }
    //         } else {
    //             // CREATE logic
    //             if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'internal_doctors_add')) {
    //                 $internalDoctorInput['created_by'] = Auth::guard('master_admins')->user()->id;
    //                 $internalDoctorInput['created_ip_address'] = $request->ip();
    //                 $masterAdminInput['created_by'] = Auth::guard('master_admins')->user()->id;
    //                 $masterAdminInput['created_ip_address'] = $request->ip();

    //                 // Create InternalDoctor
    //                 $internalDoctor = InternalDoctor::create($internalDoctorInput);

    //                 // Generate code using ID
    //                 $internalDoctor->code = 'ID' . str_pad($internalDoctor->id, 4, '0', STR_PAD_LEFT);
    //                 $internalDoctor->save();

    //                 // Create Master_admin
    //                 Master_admin::create($masterAdminInput);

    //                 return redirect('admin/internal-doctors')->with('success', 'Internal Doctor added successfully!');
    //             } else {
    //                 return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
    //             }
    //         }
    //     });
    // }


    public function store(Request $request)
    {
        $role_id = Auth::guard('master_admins')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)
            ->where('status', 'active')
            ->select('privileges')
            ->first();

        $internalDoctorId = $request->id;
        $userId = null;
        $emailTaken = false;
        if (!empty($internalDoctorId)) {
            $internalDoctor = InternalDoctor::find($internalDoctorId);
            if ($internalDoctor && $internalDoctor->user_id) {
                $userId = $internalDoctor->user_id;
                if (User::where('status', '!=', 'delete')->where('email', $request->email)->where('id', '!=', $userId)->exists()) {
                    $emailTaken = true;
                }
            }
        } else {
            if (User::where('status', '!=', 'delete')->where('email', $request->email)->exists()) {
                $emailTaken = true;
            }
        }
        if ($emailTaken) {
            return redirect()->back()->with('error', 'Sorry, This Email Has Already Been Taken !');
        }

        $request->validate([
            'doctor_name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'email' => 'required|email|max:255|unique:internal_doctors,email,' . ($internalDoctorId ?? 'NULL') . ',id',
            'mobile' => 'required|string|regex:/^(\+91)?[0-9]{10}$/',
            'address' => 'nullable|string|max:255',
            'doctor_image_path' => 'nullable|image|max:2048',
            'doctor_sign_path' => 'nullable|image|max:2048',
        ]);

        $internalDoctorInput = [
            'doctor_name' => $request->doctor_name,
            'gender' => $request->gender,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
        ];

        // Handle image uploads
        if ($request->hasFile('doctor_image_path')) {
            $file = $request->file('doctor_image_path');
            $internalDoctorInput['doctor_image_name'] = $file->getClientOriginalName();
            $internalDoctorInput['doctor_image_path'] = $file->store('images/internal_doctors', 'public');
        } elseif (!empty($internalDoctorId)) {
            $internalDoctor = InternalDoctor::find($internalDoctorId);
            $internalDoctorInput['doctor_image_name'] = $internalDoctor->doctor_image_name ?? null;
            $internalDoctorInput['doctor_image_path'] = $internalDoctor->doctor_image_path ?? null;
        }

        if ($request->hasFile('doctor_sign_path')) {
            $file = $request->file('doctor_sign_path');
            $internalDoctorInput['doctor_sign_name'] = $file->getClientOriginalName();
            $internalDoctorInput['doctor_sign_path'] = $file->store('images/internal_doctors/signatures', 'public');
        } elseif (!empty($internalDoctorId)) {
            $internalDoctorInput['doctor_sign_name'] = $internalDoctor->doctor_sign_name ?? null;
            $internalDoctorInput['doctor_sign_path'] = $internalDoctor->doctor_sign_path ?? null;
        }

        $currentUserId = Auth::guard('master_admins')->user()->id;
        $currentIp = $request->ip();

        return DB::transaction(function () use ($request, $RolesPrivileges, $internalDoctorInput, $internalDoctorId, $userId, $currentUserId, $currentIp) {
            if (!empty($internalDoctorId)) {
                // UPDATE logic
                if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'internal_doctors_edit')) {
                    // Update User model if user_id exists
                    if ($userId) {
                        User::where('id', $userId)->update([
                            'name' => $request->doctor_name,
                            'email' => $request->email,
                            'mobile' => $request->mobile,
                            'address' => $request->address,
                            'role_id' => 4,
                            'modified_by' => $currentUserId,
                            'modified_ip_address' => $currentIp,
                        ]);
                    }

                    $internalDoctorInput['modified_by'] = $currentUserId;
                    $internalDoctorInput['modified_ip_address'] = $currentIp;

                    InternalDoctor::where('id', $internalDoctorId)->update($internalDoctorInput);

                    return redirect('admin/internal-doctors')->with('success', 'Internal Doctor updated successfully!');
                } else {
                    return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
                }
            } else {
                // CREATE logic
                if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'internal_doctors_add')) {
                    // $lastFourDigits = substr($request->mobile, -4);
                    // $passwordRaw = strtolower(str_replace(' ', '', $request->doctor_name)) . '@' . $lastFourDigits;
                    $passwordRaw = 12345678;
                    $passwordHashed = Hash::make($passwordRaw);

                    // Prepare data for User model
                    $userInput = [
                        'type' => 'doctor',
                        'name' => $request->doctor_name,
                        'email' => $request->email,
                        'password' => $passwordHashed,
                        'mobile' => $request->mobile,
                        'address' => $request->address,
                        'status' => 'active',
                        'role_id' => null,
                        'created_by' => $currentUserId,
                        'created_ip_address' => $currentIp,
                    ];

                    // Create User record first
                    $user = User::create($userInput);
                    $newUserId = $user->id;

                    // Now set user_id in internalDoctorInput
                    $internalDoctorInput['user_id'] = $newUserId;
                    $internalDoctorInput['created_by'] = $currentUserId;
                    $internalDoctorInput['created_ip_address'] = $currentIp;

                    // Create InternalDoctor
                    $internalDoctor = InternalDoctor::create($internalDoctorInput);

                    // Generate code using ID
                    $internalDoctor->code = 'ID' . str_pad($internalDoctor->id, 4, '0', STR_PAD_LEFT);
                    $internalDoctor->save();

                    return redirect('admin/internal-doctors')->with('success', 'Internal Doctor added successfully!');
                } else {
                    return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
                }
            }
        });
    }


    public function data_table(Request $request)
    {
        $internalDoctors = InternalDoctor::where('status', '!=', 'delete')
            ->orderBy('id', 'DESC')
            ->select('id', 'code', 'doctor_name', 'gender', 'email', 'mobile', 'address', 'status')
            ->get();

        if ($request->ajax()) {
            return DataTables::of($internalDoctors)
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
                ->addColumn('address', function ($row) {
                    return !empty($row->address) ? $row->address : '';
                })


                
                ->addColumn('status', function ($row) {
                    $role_id = Auth::guard('master_admins')->user()->role_id;
                    $RolesPrivileges = Role_privilege::where('status', 'active')->where('id', $role_id)->select('privileges')->first();

                    $isChecked = $row->status == 'active' ? 'checked' : '';

                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'internal_doctors_status_change')) {
                        return '<input type="checkbox" class="change-status" data-id="' . $row->id . '" data-table="internal_doctors" data-flash="Status Changed Successfully!" ' . $isChecked . '>';
                    } else {
                        // Disabled checkbox for users without permission
                        return '<input type="checkbox" disabled ' . $isChecked . '>';
                    }
                })


                
                ->addColumn('action', function ($row) {
                    $actionBtn = '';
                    $role_id = Auth::guard('master_admins')->user()->role_id;
                    $RolesPrivileges = Role_privilege::where('status', 'active')->where('id', $role_id)->select('privileges')->first();


                // View button
                if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'internal_doctors_view')) {
                    $actionBtn .= '<a href="' . url('admin/internal-doctor/view/' . $row->id) . '" 
                                class="btn btn-icon btn-info me-1" 
                                title="View Internal Doctor" 
                                data-bs-toggle="tooltip" 
                                style="background:#fff; color:#6267ae; border:1px solid #6267ae;">
                                <i class="mdi mdi-eye"></i>
                            </a>';
                } 



                // Edit button
                if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'internal_doctors_edit')) {
                    $actionBtn .= '<a href="' . url('admin/internal-doctor/edit/' . $row->id) . '" 
                                    class="btn btn-icon btn-warning me-1" 
                                    title="Edit Internal Doctor" 
                                    data-bs-toggle="tooltip" 
                                    style="background:#fff; color:#f6b51d; border:1px solid #f6b51d;">
                                    <i class="mdi mdi-pencil"></i>
                                </a>';
                } 

                // Delete button
                if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'internal_doctors_delete')) {
                    $actionBtn .= '<a href="javascript:void(0)" 
                                    data-id="' . $row->id . '" 
                                    data-table="internal_doctors" 
                                    data-flash="Internal doctor deleted  Successfully!" 
                                    class="btn btn-icon btn-danger delete me-1" 
                                    title="Delete internal doctor" 
                                    data-bs-toggle="tooltip" 
                                    style="background:#fff; color:#cc235e; border:1px solid #cc235e;">
                                    <i class="mdi mdi-trash-can"></i>
                                </a>';
                } 
                return $actionBtn;
            })





                ->rawColumns(['status', 'action'])
                ->make(true);
        }
    }


    public function edit($id)
    {
        $internalDoctor = InternalDoctor::find($id);

        if (!$internalDoctor) {
            return redirect('admin/internal-doctor')->with('error', 'Internal Doctor not found!');
        }

        return view('Admin.Doctor.add-internal-doctor', compact('internalDoctor'));
    }

    public function view($id)
    {
        $internalDoctor = InternalDoctor::find($id);

        if (!$internalDoctor) {
            return redirect('admin/internal-doctor')->with('error', 'Internal Doctor not found!');
        }

        return view('Admin.Doctor.view-internal-doctor', compact('internalDoctor'));
    }

    public function delete($id)
    {
        $role_id = Auth::guard('master_admins')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('status', 'active')->where('id', $role_id)->select('privileges')->first();

        if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'internal_doctors_delete')) {
            InternalDoctor::where('id', $id)->update(['status' => 'delete']);
            return redirect('admin/internal-doctor')->with('success', 'Internal Doctor deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }
    }

    protected function uploadFiles(array $files, string $path)
    {
        $uploaded = [];
        foreach ($files as $key => $file) {
            if ($file->isValid()) {
                $uploaded[$key] = $file->store($path, 'public');
                $uploaded[$key . '_name'] = $file->getClientOriginalName();
            }
        }
        return $uploaded;
    }




    
}
