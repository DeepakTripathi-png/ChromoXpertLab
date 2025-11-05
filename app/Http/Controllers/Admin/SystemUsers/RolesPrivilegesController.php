<?php

namespace App\Http\Controllers\Admin\SystemUsers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Role_privilege;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\MediaTrait;
use Storage;
use Crypt;
use Arr;
use Str;
use DB;
use Session;

class RolesPrivilegesController extends Controller
{
    public function index(){
        $role_id = Auth::guard('master_admins')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();
        if (!empty($RolesPrivileges) && str_contains($RolesPrivileges, 'role_privileges_view')){
            return view('Admin.System-users.roles-privileges');
        }else {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }
    }

    public function create(){
        $role_id = Auth::guard('master_admins')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();
        if (!empty($RolesPrivileges) && str_contains($RolesPrivileges, 'role_privileges_add')){
            return view('Admin.System-users.add-roles-privileges');
        }else {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }
    }

    public function store(Request $request){
        $id = $request->id;
        $request->validate([
            'role_name' => 'required|string',
            'privileges' => 'required',
        ]);
        $role_id = Auth::guard('master_admins')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();
        if (!empty($id)) {
            if (!empty($RolesPrivileges) && str_contains($RolesPrivileges, 'role_privileges_edit')) {
                if(Role_privilege::where('status','!=','delete')->where('id', '!=', $id)->where('role_name', $request->role_name)->exists()){
                    return redirect()->back()->with('error', 'Sorry, This Role Has Already Been Taken !');
                }
                $input['modified_by'] = auth()->guard('master_admins')->user()->id;
                $input['modified_ip_address'] = $request->ip();
                $input['role_name'] = $request->role_name;
                $input['privileges'] = implode(',', $request->privileges);
                Role_privilege::find($id)->update($input);
                return redirect('admin/roles-privileges')->with('success', 'Roles Updated Successfully!');
            } else {
                return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
            }
        } else {
            if (!empty($RolesPrivileges) && str_contains($RolesPrivileges, 'role_privileges_add')) {
                if(Role_privilege::where('status','!=','delete')->where('role_name', $request->role_name)->exists()){
                    return redirect()->back()->with('error', 'Sorry, This Role Has Already Been Taken !');
                }
                $input['created_by'] = auth()->guard('master_admins')->user()->id;
                $input['created_ip_address'] = $request->ip();
                $input['role_name'] = $request->role_name;
                $input['privileges'] = implode(',', $request->privileges);
                Role_privilege::create($input);
                return redirect('admin/roles-privileges')->with('success', 'Roles Added Successfully!');
            } else {
                return redirect()->back()->with('error', 'Access Denied!!');
            }
        }
    }

    public function data_table(Request $request){
        $roles_previleges = Role_privilege::where('status', '!=', 'delete')->orderBy('id','DESC')->where('created_by',Auth::guard('master_admins')->user()->id)->select('id', 'role_name', 'privileges', 'status')->get();
        if ($request->ajax()) {
            return DataTables::of($roles_previleges)
                ->addIndexColumn()
                ->addColumn('role_name', function ($row) {
                    return !empty($row->role_name) ? $row->role_name : '' ;
                })
                ->addColumn('privileges', function ($row) {
                    return !empty($row->privileges) ? "<div class='scrollable-cell'>".implode(', ', explode(',',$row->privileges))."</div>" : '' ;
                })

                // ->addColumn('action', function ($row) {
                //     $actionBtn = '';
                //     $role_id = Auth::guard('master_admins')->user()->role_id;
                //     $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();

                //     if (!empty($RolesPrivileges) && str_contains($RolesPrivileges, 'role_privileges_edit')) {
                //         $actionBtn .= '<a href="' . url('admin/roles-privileges/edit/' . $row->id ) . '"> <button type="button" data-id="' . $row->id . '" class="btn btn-warning btn-xs Edit_button" title="Edit"><i class="mdi mdi-pencil"></i></button></a>';
                //     } else {
                //         $actionBtn .= '<a href="javascript:void;"> <button type="button" data-id="' . $row->id . '" class="btn btn-warning btn-xs Edit_button" title="Edit" disabled><i class="mdi mdi-pencil"></i></button></a>';
                //     }


                //     if (!empty($RolesPrivileges) && str_contains($RolesPrivileges, 'role_privileges_delete') && $row->id != 1 && $row->id != 2 && $row->id != 3) {
                //         $actionBtn .=  ' <a href="javascript:void;" data-id="' . $row->id . '" data-table="role_privileges" data-flash="Roles And Privileges Deleted Successfully!" class="btn btn-danger delete btn-xs" title="Delete"><i class="mdi mdi-trash-can"></i></a>';
                //     } else {
                //         $actionBtn .= '<a href="javascript:void;" class="btn btn-danger btn-xs" title="Disabled" style="cursor:not-allowed;" disabled><i class="mdi mdi-trash-can"></i></a>';
                //     }
                //     return $actionBtn;
                // })
                // ->addColumn('status', function ($row) {
                //     $role_id = Auth::guard('master_admins')->user()->role_id;
                //     $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();

                //     if (!empty($RolesPrivileges) && str_contains($RolesPrivileges, 'role_privileges_status_change')) {
                //         if ($row->status == 'active') {
                //             $statusActiveBtn = '<a href="javascript:void(0)"  data-id="' . $row->id . '" data-table="role_privileges" data-flash="Status Changed Successfully!"  class="change-status"  ><i class="fa fa-toggle-on tgle-on  status_button" aria-hidden="true" title=""></i></a>';
                //             return $statusActiveBtn;
                //         } else {
                //             $statusBlockBtn = '<a href="javascript:void(0)"  data-id="' . $row->id . '" data-table="role_privileges" data-flash="Status Changed Successfully!" class="change-status" ><i class="fa fa-toggle-off tgle-off  status_button" aria-hidden="true" title=""></></a>';
                //             return $statusBlockBtn;
                //         }
                //     } else {
                //         if ($row->status == 'active') {
                //             $statusActiveBtn = '<a href="javascript:;" disabled ><i class="fa fa-toggle-on tgle-on  status_button" aria-hidden="true" title="Active"></i></a>';
                //             return $statusActiveBtn;
                //         } else {
                //             $statusBlockBtn = '<a href="javascript:;" disabled ><i class="fa fa-toggle-off tgle-off  status_button" aria-hidden="true" title="Inactive"></></a>';
                //             return $statusBlockBtn;
                //         }
                //     }
                // })


                ->addColumn('action', function ($row) {
                    $actionBtn = '';
                    $role_id = Auth::guard('master_admins')->user()->role_id;
                    $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();

                    // Edit button
                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'role_privileges_edit')) {
                        $actionBtn .= '<a href="' . url('admin/roles-privileges/edit/' . $row->id) . '" 
                                        class="btn btn-icon btn-warning me-1" 
                                        title="Edit Role Privilege" 
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
                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'role_privileges_delete') && $row->id != 1 && $row->id != 2 && $row->id != 3) {
                        $actionBtn .= '<a href="javascript:void(0)" 
                                        data-id="' . $row->id . '" 
                                        data-table="role_privileges" 
                                        data-flash="Roles And Privileges Deleted Successfully!" 
                                        class="btn btn-icon btn-danger delete me-1" 
                                        title="Delete Role Privilege" 
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
                ->addColumn('status', function ($row) {
                    $role_id = Auth::guard('master_admins')->user()->role_id;
                    $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();

                    $isChecked = $row->status == 'active' ? 'checked' : '';

                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'role_privileges_status_change')) {
                        return '<input type="checkbox" class="change-status" data-id="' . $row->id . '" data-table="role_privileges" data-flash="Status Changed Successfully!" ' . $isChecked . '>';
                    } else {
                        // Disabled checkbox for users without permission
                        return '<input type="checkbox" disabled ' . $isChecked . '>';
                    }
                })


                ->rawColumns(['action', 'status', 'privileges'])
                ->make(true);
        }
    }

    public function edit($id){
        try {
            $role_privileges = Role_privilege::find($id);
            return view('Admin.System-users.add-roles-privileges', compact('role_privileges'));
        } 
        catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect('admin/roles-privileges')->with('error', 'Access Denied !');
        }
    }

    public function check_role_exist(Request $request){
        if(!empty($request->role_id)){
            if(Role_privilege::where('id', '!=', $request->role_id)->where('status', '!=', 'delete')->where('role_name', $request->role_name)->exists()){
                return "true";
            } else {
                return "false";
            }
        } else {
            if(Role_privilege::where('status', '!=', 'delete')->where('role_name', $request->role_name)->exists()){
                return "true";
            } else {
                return "false";
            }
        } 
    }
}
