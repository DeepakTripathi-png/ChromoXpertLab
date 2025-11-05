<?php

namespace App\Http\Controllers\Admin\Testcase;

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
use App\Models\TestProfiles;
class TestcaseController extends Controller
{
    public function index()
    {

        return view('Admin.Testcases.index'); 
    }

    public function add()
    {
        $departments = Department::where('status', 'active')->get();
        return view('Admin.Testcases.testcase-add',compact('departments')); 
    }


    public function edit($id)
    {
        $test = Test::with(['parameters.options'])
            ->where('status', '!=', 'delete')
            ->findOrFail($id);

        $departments = Department::where('status', 'active')->get();    

        return view('Admin.Testcases.testcase-add', compact('test', 'departments'));
    }

    public function view($id)
    {
        $test = Test::with(['parameters.options', 'department'])
             ->where('status', '!=', 'delete')
             ->find($id);
       
       
        if (!$test) {
            return redirect()->route('admin.testcases')->with('error', 'Test case not found.');
        }

        return view('Admin.Testcases.textcase-view', compact('test'));
    }

 




    public function store(Request $request)
    {

        $role_id = Auth::guard('master_admins')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)
            ->where('status', 'active')
            ->select('privileges')
            ->first();

        $validated = $request->validate([
            'id' => 'nullable|exists:tests,id',
            'name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:100',
            'department' => 'required|exists:departments,id',
            'sample_type' => 'nullable|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'gst' => 'nullable|numeric|min:0',
            'total_price' => 'nullable|numeric|min:0',
            'precautions' => 'nullable|string',
            'parameters' => 'required|array',
            'parameters.*.row_type' => 'required|in:component,title',
            'parameters.*.id' => 'nullable|exists:test_parameters,id',
            'parameters.*.name' => 'required_if:parameters.*.row_type,component|string|nullable|max:255',
            'parameters.*.title' => 'required_if:parameters.*.row_type,title|string|nullable|max:255',
            'parameters.*.unit' => 'nullable|string|max:255',
            'parameters.*.result_type' => 'required_if:parameters.*.row_type,component|in:text,select',
            'parameters.*.reference_range' => 'nullable|string',
            'parameters.*.options' => 'nullable|array',
            'parameters.*.options.*' => 'nullable|string|max:255',
            'parameters.*.option_ids' => 'nullable|array',
            'parameters.*.option_ids.*' => 'nullable|exists:parameter_options,id',
            'test_for' => 'nullable'
        ]);

        $userIp = $request->ip();
        $userId = Auth::id();

        try {
            DB::transaction(function () use ($request, $RolesPrivileges, $userId, $userIp) {
                $testInput = [
                    'name' => $request->name,
                    'short_name' => $request->short_name ?? null,
                    'department_id' => $request->department,
                    'sample_type' => $request->sample_type ?? null,
                    'base_price' => $request->base_price,
                    'total_price' => $request->total_price,
                    'gst'  => $request->gst,
                    'precautions' => $request->precautions ?? null,
                    'test_for' => $request->test_for ??null,
                    'status' => 'active',
                ];

            

                if (!empty($request->id)) {
                    // Update mode
                    if (!str_contains($RolesPrivileges->privileges, 'test_edit')) {
                        throw new \Exception('Sorry, You Have No Permission For This Request!');
                    }

                    $testInput['modified_ip_address'] = $userIp;
                    $testInput['modified_by'] = $userId;

                    $test = Test::findOrFail($request->id);
                    $test->update($testInput);
                } else {
                    // Add mode
                    if (!str_contains($RolesPrivileges->privileges, 'test_add')) {
                        throw new \Exception('Sorry, You Have No Permission For This Request!');
                    }

                    $testInput['created_ip_address'] = $userIp;
                    $testInput['created_by'] = $userId;
                    $testInput['modified_ip_address'] = $userIp;
                    $testInput['modified_by'] = $userId;

                    $test = Test::create($testInput);
                    $test->test_code = 'TC' . str_pad($test->id, 3, '0', STR_PAD_LEFT);
                    $test->save();
                }

                // Handle parameters
                $existingParameterIds = $test->parameters()->pluck('id')->toArray();
                $submittedParameterIds = array_filter(array_column($request->parameters, 'id') ?? []);

                // Delete parameters that are not in the submitted list
                TestParameters::where('test_id', $test->id)
                    ->whereNotIn('id', $submittedParameterIds)
                    ->delete();

                foreach ($request->parameters as $index => $param) {
                    $status = isset($param['status']) && $param['status'] == '1' ? 'active' : 'inactive';

                    $parameterInput = [
                        'test_id' => $test->id,
                        'row_type' => $param['row_type'],
                        'name' => $param['row_type'] === 'component' ? ($param['name'] ?? null) : null,
                        'title' => $param['row_type'] === 'title' ? ($param['title'] ?? null) : null,
                        'unit' => $param['unit'] ?? null,
                        'result_type' => $param['row_type'] === 'component' ? ($param['result_type'] ?? 'text') : 'text',
                        'reference_range' => $param['reference_range'] ?? null,
                        'sort_order' => $index,
                        'created_ip_address' => $userIp,
                        'modified_ip_address' => $userIp,
                        'created_by' => $userId,
                        'modified_by' => $userId,
                        'status' => $status,
                    ];

                    if (!empty($param['id'])) {
                        // Update existing parameter
                        TestParameters::where('id', $param['id'])->update($parameterInput);
                        $parameter = TestParameters::find($param['id']);
                    } else {
                        
                        $parameter = TestParameters::create($parameterInput);
                    }

                    if ($param['row_type'] === 'component' && $param['result_type'] === 'select' && !empty($param['options'])) {
                       
                        $existingOptionIds = $parameter->options()->pluck('id')->toArray();
                        $submittedOptionIds = array_filter($param['option_ids'] ?? []);

                        
                        ParameterOptions::where('parameter_id', $parameter->id)
                            ->whereNotIn('id', $submittedOptionIds)
                            ->delete();

                        foreach ($param['options'] as $optionIndex => $optionValue) {
                            if (!empty(trim($optionValue))) {
                                $optionInput = [
                                    'parameter_id' => $parameter->id,
                                    'option_value' => trim($optionValue),
                                    'sort_order' => $optionIndex,
                                    'created_ip_address' => $userIp,
                                    'modified_ip_address' => $userIp,
                                    'created_by' => $userId,
                                    'modified_by' => $userId,
                                    'status' => 'active',
                                ];

                                if (!empty($param['option_ids'][$optionIndex])) {
                                    ParameterOptions::where('id', $param['option_ids'][$optionIndex])
                                        ->update($optionInput);
                                } else {
                                    ParameterOptions::create($optionInput);
                                }
                            }
                        }
                    } else {
                        ParameterOptions::where('parameter_id', $parameter->id)->delete();
                    }
                }

                return true;
            });


            return redirect()->route('admin.testcases')
                ->with('success', !empty($request->id) ? 'Test updated successfully.' : 'Test created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Test creation/update failed: ' . $e->getMessage(), [
                'request' => $request->all(),
                'exception' => $e,
            ]);
            return back()->withInput()->with('error', 'Error processing test: ' . $e->getMessage());
        }
    }



    public function data_table(Request $request)
    {
        $tests = Test::with(['parameters', 'department'])
            ->where('status', '!=', 'delete')
            ->orderBy('id', 'DESC')
            ->get();

        if ($request->ajax()) {
            return DataTables::of($tests)
                ->addIndexColumn()

                ->addColumn('test_code', function ($row) {
                    return !empty($row->test_code) ? $row->test_code : '';
                })

                ->addColumn('name', function ($row) {
                    return !empty($row->name) ? $row->name : '';
                })
                ->addColumn('short_name', function ($row) {
                    return !empty($row->short_name) ? $row->short_name : '';
                })

                ->addColumn('department_name', function ($row) {
                    return !empty($row->department->department_name) ? $row->department->department_name : '';
                })

                ->addColumn('sample_type', function ($row) {
                    return !empty($row->sample_type) ? $row->sample_type : '';
                })

                ->addColumn('base_price', function ($row) {
                    return !empty($row->base_price) ? number_format($row->base_price, 2) : '0.00';
                })

                ->addColumn('gst', function ($row) {
                    return !empty($row->gst) ? number_format($row->gst, 2) : '0.00';
                })

                ->addColumn('total_price', function ($row) {
                    return !empty($row->total_price) ? number_format($row->total_price, 2) : '0.00';
                })

                ->addColumn('parameters_count', function ($row) {
                    return $row->parameters->count();
                })

                ->addColumn('status', function ($row) {
                    $role_id = Auth::guard('master_admins')->user()->role_id;
                    $RolesPrivileges = Role_privilege::where('status', 'active')->where('id', $role_id)->select('privileges')->first();

                    $isChecked = $row->status == 'active' ? 'checked' : '';

                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'test_status_change')) {
                        return '<input type="checkbox" class="change-status" data-id="' . $row->id . '" data-table="tests" data-flash="Status Changed Successfully!" ' . $isChecked . '>';
                    } else {
                        return '<input type="checkbox" disabled ' . $isChecked . '>';
                    }
                })
                
                ->addColumn('action', function ($row) {
                    $actionBtn = '';
                    $role_id = Auth::guard('master_admins')->user()->role_id;
                    $RolesPrivileges = Role_privilege::where('status', 'active')->where('id', $role_id)->select('privileges')->first();

                   
                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'test_view')) {
                        $actionBtn .= '<a href="' . url('admin/test-case/view/' . $row->id) . '" 
                                    class="btn btn-icon btn-info me-1" 
                                    title="View Test" 
                                    data-bs-toggle="tooltip" 
                                    style="background:#fff; color:#6267ae; border:1px solid #6267ae;">
                                    <i class="mdi mdi-eye"></i>
                                </a>';
                    }

                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'test_edit')) {
                        $actionBtn .= '<a href="' . url('admin/test-case/edit/' . $row->id) . '" 
                                        class="btn btn-icon btn-warning me-1" 
                                        title="Edit Test" 
                                        data-bs-toggle="tooltip" 
                                        style="background:#fff; color:#f6b51d; border:1px solid #f6b51d;">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>';
                    }

                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'test_delete')) {
                        $actionBtn .= '<a href="javascript:void(0)" 
                                    data-id="' . $row->id . '" 
                                    data-table="tests" 
                                    data-flash="Test Deleted Successfully!" 
                                    class="btn btn-icon btn-danger delete me-1" 
                                    title="Delete Test" 
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







public function search(Request $request)
{
    $query = $request->input('q');
    
    // Search for tests
    $tests = Test::where('status', 'active')
        ->where(function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
              ->orWhere('test_code', 'LIKE', "%{$query}%")
              ->orWhere('short_name', 'LIKE', "%{$query}%");
        })
        ->select('id', 'name', 'test_code', 'total_price', DB::raw("'test' as type"))
        ->take(5)
        ->get();


        // dd($tests);

    // Search for profiles
    $profiles = TestProfiles::where('status', 'active')
        ->where(function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
              ->orWhere('profile_code', 'LIKE', "%{$query}%");
        })
        ->select(
            'id', 
            'name', 
            'profile_code as test_code', 
            'profile_price as total_price', 
            DB::raw('(SELECT COUNT(*) FROM test_profile_tests WHERE test_profile_id = test_profiles.id) as tests_count'), 
            DB::raw("'profile' as type")
        )
        ->take(5)
        ->get();

    // Merge results
    $results = $tests->merge($profiles)->take(10);

    return response()->json($results);
}


public function getProfileTests($profileId)
{
    $profile = TestProfiles::findOrFail($profileId);
    $tests = $profile->tests()
        ->select('tests.id', 'tests.name', 'tests.test_code', 'tests.total_price')
        ->get()
        ->makeHidden(['pivot']);

    return response()->json($tests);
}


}