<?php

namespace App\Http\Controllers\Branch\SystemUsers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Role_privilege;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;

class BranchRolesPrivilegesController extends Controller
{
    public function index()
    {
        $branchUserId = Auth::guard('branch')->user()->id;
        $role_id = Auth::guard('branch')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();
        if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'role_privileges_view')) {
            return view('Branch.System-users.roles-privileges');
        } else {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }
    }

    public function create()
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();
        if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'role_privileges_add')) {
            return view('Branch.System-users.add-roles-privileges');
        } else {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }
    }

    public function store(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'role_name' => 'required|string',
            'privileges' => 'required',
        ]);

        $branchUserId = Auth::guard('branch')->user()->id;
        $role_id = Auth::guard('branch')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();

        return DB::transaction(function () use ($request, $id, $branchUserId, $RolesPrivileges) {
            $ipAddress = $request->ip();

            if (!empty($id)) {
                // UPDATE logic
                if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'role_privileges_edit')) {
                    $role = Role_privilege::where('id', $id)->where('created_by', $branchUserId)->first();
                    if (!$role) {
                        return redirect()->back()->with('error', 'Role not found or access denied!');
                    }

                    if (Role_privilege::where('status', '!=', 'delete')->where('id', '!=', $id)->where('role_name', $request->role_name)->exists()) {
                        return redirect()->back()->with('error', 'Sorry, This Role Has Already Been Taken!');
                    }

                    $input = [
                        'modified_by' => $branchUserId,
                        'modified_ip_address' => $ipAddress,
                        'role_name' => $request->role_name,
                        'privileges' => implode(',', $request->privileges),
                    ];

                    $role->update($input);

                    return redirect('branch/roles-privileges')->with('success', 'Roles Updated Successfully!');
                } else {
                    return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
                }
            } else {
                // CREATE logic
                if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'role_privileges_add')) {
                    if (Role_privilege::where('status', '!=', 'delete')->where('role_name', $request->role_name)->exists()) {
                        return redirect()->back()->with('error', 'Sorry, This Role Has Already Been Taken!');
                    }

                    $input = [
                        'created_by' => $branchUserId,
                        'created_ip_address' => $ipAddress,
                        'role_name' => $request->role_name,
                        'privileges' => implode(',', $request->privileges),
                        'status' => 'active',
                    ];

                    Role_privilege::create($input);

                    return redirect('branch/roles-privileges')->with('success', 'Roles Added Successfully!');
                } else {
                    return redirect()->back()->with('error', 'Access Denied!!');
                }
            }
        });
    }

    public function data_table(Request $request)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();

        if (empty($RolesPrivileges) || !str_contains($RolesPrivileges->privileges, 'role_privileges_view')) {
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

        $branchUserId = Auth::guard('branch')->user()->id;
        
        $roles_privileges = Role_privilege::where('created_by', $branchUserId)
            ->where('status', '!=', 'delete')
            ->orderBy('id', 'DESC')
            ->select('id', 'role_name', 'privileges', 'status')
            ->get();

        if ($request->ajax()) {
            return DataTables::of($roles_privileges)
                ->addIndexColumn()
                ->addColumn('role_name', function ($row) {
                    return !empty($row->role_name) ? $row->role_name : '';
                })
                ->addColumn('privileges', function ($row) {
                    return !empty($row->privileges) ? "<div class='scrollable-cell'>" . implode(', ', explode(',', $row->privileges)) . "</div>" : '';
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '';
                    $role_id = Auth::guard('branch')->user()->role_id;
                    $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();

                    // Edit button
                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'role_privileges_edit')) {
                        $actionBtn .= '<a href="' . url('branch/roles-privileges/edit/' . $row->id) . '" 
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
                    $role_id = Auth::guard('branch')->user()->role_id;
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

    public function edit($id)
    {
        $branchUserId = Auth::guard('branch')->user()->id;
        $role_id = Auth::guard('branch')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();

        if (empty($RolesPrivileges) || !str_contains($RolesPrivileges->privileges, 'role_privileges_edit')) {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }

        $role_privileges = Role_privilege::where('id', $id)
            ->where('created_by', $branchUserId)
            ->first();

        if (!$role_privileges) {
            return redirect('branch/roles-privileges')->with('error', 'Role Privilege not found!');
        }

        return view('Branch.System-users.add-roles-privileges', compact('role_privileges'));
    }

    public function check_role_exist(Request $request)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();

        if (empty($RolesPrivileges) || !str_contains($RolesPrivileges->privileges, 'role_privileges_view')) {
            return response("false", 403); // Deny with false to avoid exposure
        }

        if (!empty($request->role_id)) {
            if (Role_privilege::where('id', '!=', $request->role_id)->where('status', '!=', 'delete')->where('role_name', $request->role_name)->exists()) {
                return "true";
            } else {
                return "false";
            }
        } else {
            if (Role_privilege::where('status', '!=', 'delete')->where('role_name', $request->role_name)->exists()) {
                return "true";
            } else {
                return "false";
            }
        }
    }
}