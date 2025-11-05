<?php

namespace App\Http\Controllers\Admin\SystemUsers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Master_admin;
use App\Models\Master\Role_privilege;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\MediaTrait;
use App\Mail\MailToAdminAfterUserCreation;
use App\Mail\MailToUserAfterUserCreation;
use Storage;
use Crypt;
use Session;
use App\Models\User;
use Throwable;

class SystemUserController extends Controller
{
    use MediaTrait;
    public function index(){
        $role_id = Auth::guard('master_admins')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();
        if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'user_view')){
            return view('Admin.System-users.system-user');
        }else {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }
    }

    public function create(Request $request){
        $role_id = Auth::guard('master_admins')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();
        if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'user_add')){
            $all_roles = Role_privilege::where('id', '!=', '1')->where('status', 'active')->orderBy('id', 'DESC')->get();
            return view('Admin.System-users.add-system-user', compact('all_roles'));
        }else {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }
        
    }

    // public function store(Request $request){
    //     $id = $request->id;
    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required|email',
    //         'role' => 'required',
    //         'mobile_no.' => 'numeric',
    //         'user_profile_image_path' => 'max:2048'
    //     ]);
        
    //     $input['user_type'] = "system";
    //     $input['user_name'] = $request->name;
    //     $input['email'] = $request->email;
    //     $input['role_id'] = $request->role;
    //     $input['mobile_no'] = $request->mobile_no;
    //     $input['address'] = $request->address;
        
    //     $role_id = Auth::guard('master_admins')->user()->role_id;
    //     $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();
    //     if (!empty($id)) {
    //         if (!empty($RolesPrivileges) && str_contains($RolesPrivileges, 'user_edit')) {
    //             if ($request->has('user_profile_image_path')) {
    //                 $input['user_profile_image_path'] = $this->verifyAndUpload($request, 'user_profile_image_path', 'images/profile_images');
    //                 $original_name = $request->file('user_profile_image_path')->getClientOriginalName();
    //                 $input['user_profile_image_name'] = $original_name;
    //             }
    //             if(Master_admin::where('status','!=','delete')->where('id', '!=', $id)->where('email', $request->email)->exists()){
    //                 return redirect()->back()->with('error', 'Sorry, This Email Has Already Been Taken !');
    //             }
    //             $input['modified_by'] = auth()->guard('master_admins')->user()->id;
    //             $input['modified_ip_address'] = $request->ip();
    //             Master_admin::find($id)->update($input);
    //             return redirect('admin/system-user')->with('success', 'User List Updated Successfully!');
    //         } else {
    //             return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
    //         }
    //     } else {
    //         $request->validate([
    //             'password' => 'required|min:8',
    //         ]);
    //         if (!empty($RolesPrivileges) && str_contains($RolesPrivileges, 'user_add')) {
    //             if ($request->has('image_path')) {
    //                 $input['user_profile_image_path'] = $this->verifyAndUpload($request, 'image_path', 'images/profile_images');
    //                 $original_name = $request->file('image_path')->getClientOriginalName();
    //                 $input['user_profile_image_name'] = $original_name;
    //             }
    //             if(Master_admin::where('status','!=','delete')->where('email', $request->email)->exists()){
    //                 return redirect()->back()->with('error', 'Sorry, This Email Has Already Been Taken !');
    //             }
    //             $input['password'] = Hash::make($request->password);
    //             $input['created_by'] = auth()->guard('master_admins')->user()->id;
    //             $input['created_ip_address'] = $request->ip();
    //             Master_admin::create($input);
    //             $role_name = Role_privilege::where('status', 'active')->where('id', $request->role)->orderBy('id', 'DESC')->first();
    //             $mailData = [
    //                 'name' => $input['user_name'],
    //                 'email' => $input['email'],
    //                 'phone' => $input['mobile_no'],
    //                 'password' => $request->password,
    //                 'role' => $role_name->role_name,
    //             ];
    //             try{
    //                 // \Mail::to('deepakmegreat@gmail.com')->send(new MailToAdminAfterUserCreation($mailData));
    //                 // \Mail::to($input['email'])->send(new MailToUserAfterUserCreation($mailData));
    //             }catch (Throwable $e) {
    //                 return redirect()->back()->with('warning', 'User Created But Mail Sending Issue');
    //             }
    //             return redirect('admin/system-user')->with('success', 'User List Added Successfully!');
    //         } else {
    //             return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
    //         }
    //     }
    // }

    public function store(Request $request){
        $id = $request->id;
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'mobile_no' => 'numeric',
            'user_profile_image_path' => 'nullable|image|max:2048', // Made explicitly optional with nullable and image validation
            'image_path' => 'nullable|image|max:2048', // For consistency in create, if using different field
        ]);
        
        $input['user_type'] = "system";
        $input['user_name'] = $request->name;
        $input['email'] = $request->email;
        $input['role_id'] = $request->role;
        $input['mobile_no'] = $request->mobile_no;
        $input['address'] = $request->address;
        
        $role_id = Auth::guard('master_admins')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();
        if (!empty($id)) {
            if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'user_edit')) {
                // Handle profile image update only if provided
                if ($request->hasFile('user_profile_image_path')) {
                    $files = ['user_profile_image_path' => $request->file('user_profile_image_path')];
                    $result = $this->uploadFiles($files, 'images/profile_images');
                    $input['user_profile_image_path'] = $result['user_profile_image_path'];
                    $input['user_profile_image_name'] = $result['user_profile_image_name'];
                }
                if(Master_admin::where('status','!=','delete')->where('id', '!=', $id)->where('email', $request->email)->exists()){
                    return redirect()->back()->with('error', 'Sorry, This Email Has Already Been Taken !');
                }
                $input['modified_by'] = auth()->guard('master_admins')->user()->id;
                $input['modified_ip_address'] = $request->ip();
                
                // Update User model as well
                $masterAdmin = Master_admin::find($id);
                if ($masterAdmin && $masterAdmin->user_id) {
                    $userInput = [
                        'name' => $request->name,
                        'email' => $request->email,
                        'role_id' => $request->role,
                        'mobile' => $request->mobile_no,
                        'address' => $request->address,
                        'modified_by' => auth()->guard('master_admins')->user()->id,
                        'modified_ip_address' => $request->ip(),
                    ];
                    // Update profile image in User if needed, but assuming User model doesn't have image fields
                    User::where('id', $masterAdmin->user_id)->update($userInput);
                }
                
                Master_admin::find($id)->update($input);
                return redirect('admin/system-user')->with('success', 'User List Updated Successfully!');
            } else {
                return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
            }
        } else {
            $request->validate([
                'password' => 'required|min:8',
            ]);
            if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'user_add')) {
                // Check email uniqueness in User table as well
                if(User::where('status','!=','delete')->where('email', $request->email)->exists()){
                    return redirect()->back()->with('error', 'Sorry, This Email Has Already Been Taken !');
                }
                
                // Prepare data for User model
                $userInput = [
                    'type' => 'admin',
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'mobile' => $request->mobile_no,
                    'address' => $request->address,
                    'status' => 'active',
                    'role_id' => $request->role,
                    'created_by' => auth()->guard('master_admins')->user()->id,
                    'created_ip_address' => $request->ip(),
                ];
                
                // Create User record first
                $user = User::create($userInput);
                $userId = $user->id;
                
                // Now prepare input for Master_admin with user_id
                $input['password'] = Hash::make($request->password); // Assuming Master_admin also needs password
                $input['created_by'] = auth()->guard('master_admins')->user()->id;
                $input['created_ip_address'] = $request->ip();
                $input['user_id'] = $userId; // Link to User id
                
                // Handle profile image create only if provided (using 'image_path' as in original, but made optional)
                if ($request->hasFile('image_path')) {
                    $files = ['user_profile_image_path' => $request->file('image_path')];
                    $result = $this->uploadFiles($files, 'images/profile_images');
                    $input['user_profile_image_path'] = $result['user_profile_image_path'];
                    $input['user_profile_image_name'] = $result['user_profile_image_name'];
                }
                
                if(Master_admin::where('status','!=','delete')->where('email', $request->email)->exists()){
                    return redirect()->back()->with('error', 'Sorry, This Email Has Already Been Taken !');
                }
                
                Master_admin::create($input);
                $role_name = Role_privilege::where('status', 'active')->where('id', $request->role)->orderBy('id', 'DESC')->first();
                $mailData = [
                    'name' => $input['user_name'],
                    'email' => $input['email'],
                    'phone' => $input['mobile_no'],
                    'password' => $request->password,
                    'role' => $role_name->role_name,
                ];
                try{
                    // \Mail::to('deepakmegreat@gmail.com')->send(new MailToAdminAfterUserCreation($mailData));
                    // \Mail::to($input['email'])->send(new MailToUserAfterUserCreation($mailData));
                }catch (Throwable $e) {
                    return redirect()->back()->with('warning', 'User Created But Mail Sending Issue');
                }
                return redirect('admin/system-user')->with('success', 'User List Added Successfully!');
            } else {
                return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
            }
        }
    }

    

    public function data_table(Request $request){
        $system_user = Master_admin::where('master_admins.status', '!=', 'delete')->where('master_admins.id', '!=', Auth::guard('master_admins')->user()->id)->where('role_privileges.status', '!=', 'delete')->join('role_privileges', 'role_privileges.id', '=' , 'master_admins.role_id')->orderBy('id','DESC')->select('master_admins.id', 'master_admins.user_name', 'master_admins.email', 'master_admins.mobile_no', 'master_admins.role_id', 'master_admins.status', 'role_privileges.role_name')->orderBy('master_admins.id', 'DESC')->get();
        if ($request->ajax()) {
            return DataTables::of($system_user)
                ->addIndexColumn()
                ->addColumn('user_name', function ($row) {
                    return !empty($row->user_name) ? $row->user_name : '' ;
                })
                ->addColumn('email', function ($row) {
                    return !empty($row->email) ? $row->email : '' ;
                })
                ->addColumn('role', function ($row) {
                    return !empty($row->role_name) ? $row->role_name : '' ;
                })
                ->addColumn('mobile_no', function ($row) {
                    return !empty($row->mobile_no) ? $row->mobile_no : '' ;
                })


                // ->addColumn('action', function ($row) {
                //     $actionBtn = '';
                //     $role_id = Auth::guard('master_admins')->user()->role_id;
                //     $RolesPrivileges = Role_privilege::where('status', 'active')->where('id', $role_id)->select('privileges')->first();
                //     if (!empty($RolesPrivileges) && str_contains($RolesPrivileges, 'user_edit')) {
                //         $actionBtn .= '<a href="' . url('admin/system-user/edit/' .$row->id) . '"> <button type="button" data-id="' . $row->id . '" class="btn btn-warning btn-xs Edit_button" title="Edit"><i class="mdi mdi-pencil"></i></button></a>';
                //     } else {
                //         $actionBtn .= '<a href="javascript:;"> <button type="button" data-id="' . $row->id . '" class="btn btn-warning btn-xs Edit_button" title="Edit" disabled><i class="mdi mdi-pencil"></i></button></a>';
                //     }
                //     if (str_contains($RolesPrivileges, 'user_delete')) {
                //         $actionBtn .=  ' <a href="javascript:void;" data-id="' . $row->id . '" data-table="master_admins" data-flash="User Deleted Successfully!" class="btn btn-danger delete btn-xs" title="Delete"><i class="mdi mdi-trash-can"></i></a>';
                //     } else {
                //         $actionBtn .= '<a href="javascript:void;" class="btn btn-danger btn-xs" title="Disabled" disabled><i class="mdi mdi-trash-can"></i></a>';
                //     }
                //     return $actionBtn;
                // })


                ->addColumn('action', function ($row) {
                    $actionBtn = '';
                    $role_id = Auth::guard('master_admins')->user()->role_id;
                    $RolesPrivileges = Role_privilege::where('status', 'active')->where('id', $role_id)->select('privileges')->first();

                    // Edit button
                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'user_edit')) {
                        $actionBtn .= '<a href="' . url('admin/system-user/edit/' . $row->id) . '" 
                                        class="btn btn-icon btn-warning me-1" 
                                        title="Edit User" 
                                        data-bs-toggle="tooltip" 
                                        style="background:#fff; color:#f6b51d; border:1px solid #f6b51d;">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>';
                    } else {
                        $actionBtn .= '<a href="javascript:;" 
                                        class="btn btn-icon btn-warning me-1" 
                                        title="Edit Disabled" 
                                        data-bs-toggle="tooltip" 
                                        style="background:#fff; color:#f6b51d; border:1px solid #f6b51d;" disabled>
                                        <i class="mdi mdi-pencil"></i>
                                    </a>';
                    }

                    // Delete button
                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'user_delete')) {
                        $actionBtn .= '<a href="javascript:void(0)" 
                                        data-id="' . $row->id . '" 
                                        data-table="master_admins" 
                                        data-flash="User Deleted Successfully!" 
                                        class="btn btn-icon btn-danger delete me-1" 
                                        title="Delete User" 
                                        data-bs-toggle="tooltip" 
                                        style="background:#fff; color:#cc235e; border:1px solid #cc235e;">
                                        <i class="mdi mdi-trash-can"></i>
                                    </a>';
                    } else {
                        $actionBtn .= '<a href="javascript:;" 
                                        class="btn btn-icon btn-danger me-1" 
                                        title="Delete Disabled" 
                                        data-bs-toggle="tooltip" 
                                        style="background:#fff; color:#cc235e; border:1px solid #cc235e;" disabled>
                                        <i class="mdi mdi-trash-can"></i>
                                    </a>';
                    }

                    return $actionBtn;
                })


                // ->addColumn('status', function ($row) {
                //     $role_id = Auth::guard('master_admins')->user()->role_id;
                //     $RolesPrivileges = Role_privilege::where('status', 'active')->where('id', $role_id)->select('privileges')->first();
                //     if (!empty($RolesPrivileges) && str_contains($RolesPrivileges, 'user_status_change')) {
                //         if ($row->status == 'active') {
                //             $statusActiveBtn = '<a href="javascript:void(0)"  data-id="' . $row->id . '" data-table="master_admins" data-flash="Status Changed Successfully!"  class="change-status"  ><i class="fa fa-toggle-on tgle-on  status_button" aria-hidden="true" title=""></i></a>';
                //             return $statusActiveBtn;
                //         } else {
                //             $statusBlockBtn = '<a href="javascript:void(0)"  data-id="' . $row->id . '" data-table="master_admins" data-flash="Status Changed Successfully!" class="change-status" ><i class="fa fa-toggle-off tgle-off  status_button" aria-hidden="true" title=""></></a>';
                //             return $statusBlockBtn;
                //         }
                //     } else {
                //         if ($row->status == 'active') {
                //             $statusActiveBtn = '<a href="javascript:;" disabled  ><i class="fa fa-toggle-on tgle-on  status_button" aria-hidden="true" title="Active"></i></a>';
                //             return $statusActiveBtn;
                //         } else {
                //             $statusBlockBtn = '<a href="javascript:;" disabled ><i class="fa fa-toggle-off tgle-off  status_button" aria-hidden="true" title="Inactive"></></a>';
                //             return $statusBlockBtn;
                //         }
                //     }
                // })

                ->addColumn('status', function ($row) {
                    $role_id = Auth::guard('master_admins')->user()->role_id;
                    $RolesPrivileges = Role_privilege::where('status', 'active')->where('id', $role_id)->select('privileges')->first();

                    $isChecked = $row->status == 'active' ? 'checked' : '';

                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'user_status_change')) {
                        return '<input type="checkbox" class="change-status" data-id="' . $row->id . '" data-table="master_admins" data-flash="Status Changed Successfully!" ' . $isChecked . '>';
                    } else {
                        // Disabled checkbox for users without permission
                        return '<input type="checkbox" disabled ' . $isChecked . '>';
                    }
                })


                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function edit($id){
        try {
            $all_roles = Role_privilege::where('status', 'active')->orderBy('id', 'DESC')->get();
            $system_user = Master_admin::find($id);
            return view('Admin.System-users.add-system-user', compact('all_roles', 'system_user'));
        } 
        catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect('admin/system-user')->with('error', 'Access Denied !');
        }
    }

    public function check_user_exist(Request $request){
        if(!empty($request->user_id)){
            if(Master_admin::where('id', '!=', $request->user_id)->where('status', '!=', 'delete')->where('email', $request->email)->exists()){
                return "true";
            } else {
                return "false";
            }
        } else {
            if(Master_admin::where('status','!=','delete')->where('email', $request->email)->exists()){
                return "true";
            } else {
                return "false";
            }
        } 
    }
}