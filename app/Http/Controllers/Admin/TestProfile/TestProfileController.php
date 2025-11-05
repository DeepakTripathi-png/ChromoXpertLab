<?php

namespace App\Http\Controllers\Admin\TestProfile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\TestProfiles;
use App\Models\TestProfileTest;
use App\Models\Master\Master_admin;
use App\Models\Master\Role_privilege;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class TestProfileController extends Controller
{
    public function index()
    {
        return view('Admin.Testprofile.index'); 
    }


    public function store(Request $request)
    {

        // dd($request->all());

        $request->validate([
            'profile_code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'profile_price' => 'required|numeric|min:0',
            'tests' => 'required|array|min:1', 
            'tests.*' => 'exists:tests,id',   
        ]);

        // Check if updating or creating
        if (!empty($request->id)) {
            // 🔹 Update case
            $testProfile = TestProfiles::findOrFail($request->id);
            $testProfile->name = $request->input('name');
            $testProfile->profile_code = $request->input('profile_code');
            $testProfile->profile_description = $request->input('profile_description');
            $testProfile->profile_price = $request->input('profile_price');
            $testProfile->modified_ip_address = $request->ip();
            $testProfile->modified_by = auth()->id(); 
            $message = 'Test Profile updated successfully!';
        } else {
            // 🔹 Create case
            $testProfile = new TestProfiles();
            $testProfile->name = $request->input('name');
            $testProfile->profile_code = $request->input('profile_code');
            $testProfile->profile_description = $request->input('profile_description');
            $testProfile->profile_price = $request->input('profile_price');
            $testProfile->created_ip_address = $request->ip();
            $testProfile->created_by = auth()->id(); 
            $testProfile->status = 'active';
            $message = 'Test Profile created successfully!';
        }

        if ($testProfile->save()) {
            // Remove old tests if updating
            if (!empty($request->id)) {
                TestProfileTest::where('test_profile_id', $testProfile->id)->delete();
            }

            // Add new tests
            if (!empty($request->input('tests'))) {
                foreach ($request->input('tests') as $testId) {
                    TestProfileTest::create([
                        'test_profile_id' => $testProfile->id,
                        'test_id' => $testId,
                    ]);
                }
            }

            return redirect()->route('testprofile.index')->with('success', $message);
        }

        return redirect()->back()->with('error', 'Something went wrong!');
    }



    public function edit($id)
    {
        
        $testProfile = TestProfiles::with('tests')->findOrFail($id);
        $tests = Test::where('status', 'active')->get();
        $selectedTests = TestProfileTest::where('test_profile_id', $id)
                                        ->pluck('test_id')
                                        ->toArray();

        return view('Admin.Testprofile.index', compact('testProfile', 'tests', 'selectedTests'));
    }

    


    public function data_table(Request $request)
    {
        if ($request->ajax()) {
            $testProfiles = TestProfiles::with('tests')
                ->where('status', '!=', 'delete')
                ->orderBy('id', 'DESC')
                ->select('id', 'profile_code','name','profile_description','profile_price', 'status')
                ->get();

            return DataTables::of($testProfiles)
                ->addIndexColumn()

                 ->addColumn('code', function ($row) {
                    return !empty($row->profile_code) ? $row->profile_code : '';
                })

                ->addColumn('name', function ($row) {
                    return !empty($row->name) ? $row->name : '';
                })

                ->addColumn('description', function ($row) {
                    return !empty($row->profile_description) ? $row->profile_description: '';
                })

                ->addColumn('profile_price', function ($row) {
                    return !empty($row->profile_price) ? number_format($row->profile_price, 2) : '0.00';
                })
                ->addColumn('tests', function ($row) {
                    if ($row->tests->isEmpty()) {
                        return 'N/A';
                    }
                    $testsList = '<ul style="padding-left: 20px;">';
                    foreach ($row->tests as $test) {
                        $testsList .= '<li>' . htmlspecialchars($test->name) . '</li>';
                    }
                    $testsList .= '</ul>';
                    return $testsList;
                })
                ->addColumn('status', function ($row) {
                    $role_id = Auth::guard('master_admins')->user()->role_id;
                    $RolesPrivileges = Role_privilege::where('status', 'active')->where('id', $role_id)->select('privileges')->first();

                    $isChecked = $row->status == 'active' ? 'checked' : '';

                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'test_status_change')) {
                        return '<input type="checkbox" class="change-status" data-id="' . $row->id . '" data-table="test_profiles" data-flash="Status Changed Successfully!" ' . $isChecked . '>';
                    } else {
                        return '<input type="checkbox" disabled ' . $isChecked . '>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '';
                    $role_id = Auth::guard('master_admins')->user()->role_id;
                    $RolesPrivileges = Role_privilege::where('status', 'active')->where('id', $role_id)->select('privileges')->first();

      

                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'test_edit')) {
                        $actionBtn .= '<a href="' . url('admin/testprofile/edit/' . $row->id) . '" 
                                    class="btn btn-icon btn-warning me-1" 
                                    title="Edit Test Profile" 
                                    data-bs-toggle="tooltip" 
                                    style="background:#fff; color:#f6b51d; border:1px solid #f6b51d;">
                                    <i class="mdi mdi-pencil"></i>
                                </a>';
                    }

                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'test_delete')) {
                        $actionBtn .= '<a href="javascript:void(0)" 
                                    data-id="' . $row->id . '" 
                                    data-table="test_profiles" 
                                    data-flash="Test Profile Deleted Successfully!" 
                                    class="btn btn-icon btn-danger delete me-1" 
                                    title="Delete Test Profile" 
                                    data-bs-toggle="tooltip" 
                                    style="background:#fff; color:#cc235e; border:1px solid #cc235e;">
                                    <i class="mdi mdi-trash-can"></i>
                                </a>';
                    }

                    return $actionBtn;
                })
                ->rawColumns(['tests', 'status', 'action'])
                ->make(true);
        }
    }



}
