<?php

namespace App\Http\Controllers\Branch\SystemUsers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Role_privilege;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\MediaTrait;
use App\Mail\MailToAdminAfterUserCreation;
use App\Mail\MailToUserAfterUserCreation;
use DB;
use App\Models\User;
use Throwable;

class BranchSystemUserController extends Controller
{
    use MediaTrait;

    public function index()
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();
        if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'users_view')) {
            return view('Branch.System-users.system-user');
        } else {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }
    }

    public function create(Request $request)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();
        if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'users_add')) {
            $loggedUser = Auth::guard('branch')->user();
            $branchId = $loggedUser->id;
            $all_roles = Role_privilege::where('created_by', $branchId)->where('id', '!=', '1')->where('status', 'active')->orderBy('id', 'DESC')->get();
            return view('Branch.System-users.add-system-user', compact('all_roles'));
        } else {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }
    }

    public function store(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'mobile_no' => 'numeric',
        ]);

        $loggedUser = Auth::guard('branch')->user();
        $branchId = $loggedUser->id;
        $role_id = $loggedUser->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();

        return DB::transaction(function () use ($request, $id, $branchId, $RolesPrivileges) {
            $ipAddress = $request->ip();

            if (!empty($id)) {
                // UPDATE logic
                if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'users_edit')) {
                    $user = User::where('id', $id)->where('created_by', $branchId)->first();
                    if (!$user) {
                        return redirect()->back()->with('error', 'User not found or access denied!');
                    }

                    if (User::where('status', '!=', 'delete')->where('id', '!=', $id)->where('email', $request->email)->exists()) {
                        return redirect()->back()->with('error', 'Sorry, This Email Has Already Been Taken!');
                    }

                    $userInput = [
                        'name' => $request->name,
                        'email' => $request->email,
                        'role_id' => $request->role,
                        'mobile' => $request->mobile_no,
                        'address' => $request->address,
                        'modified_by' => $branchId,
                        'modified_ip_address' => $ipAddress,
                    ];

                    $user->update($userInput);

                    return redirect('branch/system-user')->with('success', 'User List Updated Successfully!');
                } else {
                    return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
                }
            } else {
                // CREATE logic
                $request->validate([
                    'password' => 'required|min:8',
                ]);

                if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'users_add')) {
                    // Check email uniqueness in User table globally
                    if (User::where('status', '!=', 'delete')->where('email', $request->email)->exists()) {
                        return redirect()->back()->with('error', 'Sorry, This Email Has Already Been Taken!');
                    }

                    // Prepare data for User model
                    $userInput = [
                        'type' => 'branch',
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'mobile' => $request->mobile_no,
                        'address' => $request->address,
                        'status' => 'active',
                        'role_id' => $request->role,
                        'created_by' => $branchId,
                        'created_ip_address' => $ipAddress,
                    ];

                    // Create User record first
                    $user = User::create($userInput);

                    $role_name = Role_privilege::where('status', 'active')->where('id', $request->role)->first();
                    $mailData = [
                        'name' => $request->name,
                        'email' => $request->email,
                        'phone' => $request->mobile_no,
                        'password' => $request->password,
                        'role' => $role_name ? $role_name->role_name : '',
                    ];

                    try {
                        // \Mail::to('deepakmegreat@gmail.com')->send(new MailToAdminAfterUserCreation($mailData));
                        // \Mail::to($request->email)->send(new MailToUserAfterUserCreation($mailData));
                    } catch (Throwable $e) {
                        return redirect('branch/system-user')->with('warning', 'User Created But Mail Sending Issue');
                    }

                    return redirect('branch/system-user')->with('success', 'User List Added Successfully!');
                } else {
                    return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
                }
            }
        });
    }

    public function data_table(Request $request)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();

        if (empty($RolesPrivileges) || !str_contains($RolesPrivileges->privileges, 'users_view')) {
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

        $loggedUser = Auth::guard('branch')->user();
        $branchId =  $loggedUser->id;
        $currentUserId = $loggedUser->id; // Exclude self

        $system_users = User::where('users.status', '!=', 'delete')
            ->where('users.id', '!=', $currentUserId)
            ->where('users.created_by', $branchId)
            ->where('role_privileges.status', '!=', 'delete')
            ->join('role_privileges', 'role_privileges.id', '=', 'users.role_id')
            ->orderBy('users.id', 'DESC')
            ->select('users.id', 'users.name as user_name', 'users.email', 'users.mobile as mobile_no', 'users.role_id', 'users.status', 'role_privileges.role_name')
            ->get();

        if ($request->ajax()) {
            return DataTables::of($system_users)
                ->addIndexColumn()
                ->addColumn('user_name', function ($row) {
                    return !empty($row->user_name) ? $row->user_name : '';
                })
                ->addColumn('email', function ($row) {
                    return !empty($row->email) ? $row->email : '';
                })
                ->addColumn('role', function ($row) {
                    return !empty($row->role_name) ? $row->role_name : '';
                })
                ->addColumn('mobile_no', function ($row) {
                    return !empty($row->mobile_no) ? $row->mobile_no : '';
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '';
                    $role_id = Auth::guard('branch')->user()->role_id;
                    $RolesPrivileges = Role_privilege::where('status', 'active')->where('id', $role_id)->select('privileges')->first();

                    // Edit button
                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'users_edit')) {
                        $actionBtn .= '<a href="' . url('branch/system-user/edit/' . $row->id) . '" 
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
                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'users_delete')) {
                        $actionBtn .= '<a href="javascript:void(0)" 
                                        data-id="' . $row->id . '" 
                                        data-table="users" 
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
                ->addColumn('status', function ($row) {
                    $role_id = Auth::guard('branch')->user()->role_id;
                    $RolesPrivileges = Role_privilege::where('status', 'active')->where('id', $role_id)->select('privileges')->first();

                    $isChecked = $row->status == 'active' ? 'checked' : '';

                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'users_status_change')) {
                        return '<input type="checkbox" class="change-status" data-id="' . $row->id . '" data-table="users" data-flash="Status Changed Successfully!" ' . $isChecked . '>';
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
        $role_id = Auth::guard('branch')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();

        if (empty($RolesPrivileges) || !str_contains($RolesPrivileges->privileges, 'users_edit')) {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }

        $loggedUser = Auth::guard('branch')->user();
        $branchId = $loggedUser->id;
        $all_roles = Role_privilege::where('status', 'active')->where('created_by', $branchId)->orderBy('id', 'DESC')->get();
        $system_user = User::where('id', $id)->where('created_by', $branchId)->first();

        // dd($system_user);

        if (!$system_user) {
            return redirect('branch/system-user')->with('error', 'User not found!');
        }

        return view('Branch.System-users.add-system-user', compact('all_roles', 'system_user'));
    }

    public function check_user_exist(Request $request)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)->where('status', 'active')->select('privileges')->first();

        if (empty($RolesPrivileges) || !str_contains($RolesPrivileges->privileges, 'users_view')) {
            return response("false", 403); // Deny with false to avoid exposure
        }

        if (!empty($request->user_id)) {
            if (User::where('id', '!=', $request->user_id)
                ->where('status', '!=', 'delete')
                ->where('email', $request->email)
                ->exists()) {
                return "true";
            } else {
                return "false";
            }
        } else {
            if (User::where('status', '!=', 'delete')
                ->where('email', $request->email)
                ->exists()) {
                return "true";
            } else {
                return "false";
            }
        }
    }
}