<?php

namespace App\Http\Controllers\Admin\Departments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Master_admin;
use App\Models\Master\Role_privilege;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\Department;

class DepartmentController extends Controller
{
    /**
     * Display department list view.
     */
    public function index()
    {
        return view('Admin.Departments.index');
    }

    /**
     * Show add department form.
     */
    public function add()
    {
        $department = null;
        return view('Admin.Departments.add_department', compact('department'));
    }

    /**
     * Show edit department form.
     */
    public function edit($id)
    {
        $department = Department::find($id);
        if (!$department) {
            return redirect('admin/departments')->with('error', 'Department not found!');
        }

        return view('Admin.Departments.index', compact('department'));
    }

    /**
     * Store or update department record.
     */
    public function store(Request $request)
    {
        $role_id = Auth::guard('master_admins')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)
            ->where('status', 'active')
            ->select('privileges')
            ->first();

        // ✅ Validate only fields that exist in the form
        $request->validate([
            'department_name' => 'required|string|max:255|unique:departments,department_name,' . ($request->id ?? 'NULL') . ',id',
            'description' => 'nullable|string',
        ]);

        $departmentInput = [
            'department_name' => $request->department_name,
            'description' => $request->description,
            'status' => 'active',
        ];

        return DB::transaction(function () use ($request, $RolesPrivileges, $departmentInput) {
            if (!empty($request->id)) {
                // ✅ Update existing department
                if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'departments_edit')) {
                    $departmentInput['modified_by'] = Auth::guard('master_admins')->user()->id;
                    $departmentInput['modified_ip_address'] = $request->ip();

                    Department::where('id', $request->id)->update($departmentInput);

                    return redirect('admin/departments')->with('success', 'Department updated successfully!');
                } else {
                    return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
                }
            } else {
                // ✅ Add new department
                if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'departments_add')) {
                    $departmentInput['created_by'] = Auth::guard('master_admins')->user()->id;
                    $departmentInput['created_ip_address'] = $request->ip();

                    $department = Department::create($departmentInput);

                    // Generate unique department code
                    $department->code = 'DEPT' . str_pad($department->id, 3, '0', STR_PAD_LEFT);
                    $department->save();

                    return redirect('admin/departments')->with('success', 'Department added successfully!');
                } else {
                    return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
                }
            }
        });
    }

    /**
     * DataTable for departments list.
     */
    public function data_table(Request $request)
    {
        $departments = Department::where('status', '!=', 'delete')
            ->orderBy('id', 'DESC')
            ->select('id', 'code', 'department_name', 'description', 'status')
            ->get();

        if ($request->ajax()) {
            return DataTables::of($departments)
                ->addIndexColumn()
                ->addColumn('code', fn($row) => $row->code ?? '')
                ->addColumn('department_name', fn($row) => $row->department_name ?? '')
                ->addColumn('description', fn($row) => $row->description ?? '')
                ->addColumn('status', function ($row) {
                    $role_id = Auth::guard('master_admins')->user()->role_id;
                    $RolesPrivileges = Role_privilege::where('status', 'active')->where('id', $role_id)->select('privileges')->first();
                    $isChecked = $row->status == 'active' ? 'checked' : '';

                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'departments_status_change')) {
                        return '<input type="checkbox" class="change-status" data-id="' . $row->id . '" data-table="departments" data-flash="Status Changed Successfully!" ' . $isChecked . '>';
                    } else {
                        return '<input type="checkbox" disabled ' . $isChecked . '>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '';
                    $role_id = Auth::guard('master_admins')->user()->role_id;
                    $RolesPrivileges = Role_privilege::where('status', 'active')->where('id', $role_id)->select('privileges')->first();

             

                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'departments_edit')) {
                        $actionBtn .= '<a href="' . url('admin/departments/edit/' . $row->id) . '" 
                            class="btn btn-icon btn-warning me-1" title="Edit Department" 
                            style="background:#fff; color:#f6b51d; border:1px solid #f6b51d;">
                            <i class="mdi mdi-pencil"></i>
                        </a>';
                    }

                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'departments_delete')) {
                        $actionBtn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" 
                            data-table="departments" data-flash="Department Deleted Successfully!" 
                            class="btn btn-icon btn-danger delete me-1" title="Delete Department" 
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



    /**
     * Soft delete department.
     */
    public function delete($id)
    {
        $role_id = Auth::guard('master_admins')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('status', 'active')->where('id', $role_id)->select('privileges')->first();

        if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'departments_delete')) {
            Department::where('id', $id)->update(['status' => 'delete']);
            return redirect('admin/departments')->with('success', 'Department deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }
    }
}
