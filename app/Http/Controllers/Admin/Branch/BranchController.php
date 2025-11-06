<?php

namespace App\Http\Controllers\Admin\Branch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Master_admin;
use App\Models\Master\Role_privilege;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use App\Models\Branch;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\User;


class BranchController extends Controller
{

    public function index(){
        return view('Admin.Branches.index'); 
    }

    public function add(){
        $branch = null;
        $countries = Country::get();
        $states = collect(); 
        $cities = collect(); 
        $labincharge = Master_admin::where('status', 'active')->where('role_id', 2)->get();

        return view('Admin.Branches.add-branches',compact('labincharge','branch','countries','states','cities')); 
    }





    // public function store(Request $request)
    // {
    //     $role_id = Auth::guard('master_admins')->user()->role_id;
    //     $RolesPrivileges = Role_privilege::where('id', $role_id)
    //         ->where('status', 'active')
    //         ->select('privileges')
    //         ->first();

    //     // Normalize mobile number
    //     $mobile = $request->mobile;
    //     if (!str_starts_with($mobile, '+91') && preg_match('/^[0-9]{10}$/', $mobile)) {
    //         $mobile = '+91' . $mobile; // Prepend +91 if it's a 10-digit number
    //         $request->merge(['mobile' => $mobile]);
    //     }

    //     $request->validate([
    //         'branch_name' => 'required|string|max:255',
    //         'email' => 'required|email|max:255|unique:branches,email,' . ($request->id ?? 'NULL') . ',id',
    //         'mobile' => 'required|string|regex:/^\+91[0-9]{10}$/',
    //         'address' => 'required|string|max:255',
    //         'country_id' => 'required|exists:countries,country_id',
    //         'state_id' => 'required|exists:states,state_id',
    //         'city_id' => 'required|exists:cities,city_id',
    //         'pincode' => 'required|string|max:10',
    //         'lab_incharge' => 'required|exists:master_admins,id',
    //         'branch_logo_path' => 'nullable|image|max:2048',
    //     ]);

    //     $branchInput = [
    //         'branch_name' => $request->branch_name,
    //         'email' => $request->email,
    //         'mobile' => $request->mobile, // Use normalized mobile
    //         'address' => $request->address,
    //         'country_id' => $request->country_id,
    //         'state_id' => $request->state_id,
    //         'city_id' => $request->city_id,
    //         'pincode' => $request->pincode,
    //         'lab_incharge' => $request->lab_incharge,
    //         'status' => 'active',
    //     ];

    //     if ($request->hasFile('branch_logo_path')) {
    //         $file = $request->file('branch_logo_path');
    //         $branchInput['branch_logo_name'] = $file->getClientOriginalName();
    //         $branchInput['branch_logo_path'] = $file->store('images/branches', 'public');
    //     } elseif (!empty($request->id)) {
    //         $branch = Branch::find($request->id);
    //         $branchInput['branch_logo_name'] = $branch->branch_logo_name ?? null;
    //         $branchInput['branch_logo_path'] = $branch->branch_logo_path ?? null;
    //     }

    //     return DB::transaction(function () use ($request, $RolesPrivileges, $branchInput) {
    //         if (!empty($request->id)) {
    //             if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'branch_edit')) {
    //                 $branchInput['modified_by'] = Auth::guard('master_admins')->user()->id;
    //                 $branchInput['modified_ip_address'] = $request->ip();

    //                 Branch::where('id', $request->id)->update($branchInput);

    //                 return redirect('admin/branches')->with('success', 'Branch updated successfully!');
    //             } else {
    //                 return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
    //             }
    //         } else {
    //             if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'branch_add')) {
    //                 $branchInput['created_by'] = Auth::guard('master_admins')->user()->id;
    //                 $branchInput['created_ip_address'] = $request->ip();

    //                 $branch = Branch::create($branchInput);

    //                 $branch->branch_code = 'BR' . str_pad($branch->id, 3, '0', STR_PAD_LEFT);
    //                 $branch->save();

    //                 return redirect('admin/branches')->with('success', 'Branch added successfully!');
    //             } else {
    //                 return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
    //             }
    //         }
    //     });
    // }

    // public function store(Request $request)
    // {
    //     $role_id = Auth::guard('master_admins')->user()->role_id;
    //     $RolesPrivileges = Role_privilege::where('id', $role_id)
    //         ->where('status', 'active')
    //         ->select('privileges')
    //         ->first();

    //     // Normalize mobile number
    //     $mobile = $request->mobile;
    //     if (!str_starts_with($mobile, '+91') && preg_match('/^[0-9]{10}$/', $mobile)) {
    //         $mobile = '+91' . $mobile; // Prepend +91 if it's a 10-digit number
    //         $request->merge(['mobile' => $mobile]);
    //     }

    //     $request->validate([
    //         'branch_name' => 'required|string|max:255',
    //         'email' => 'required|email|max:255|unique:branches,email,' . ($request->id ?? 'NULL') . ',id',
    //         'mobile' => 'required|string|regex:/^\+91[0-9]{10}$/',
    //         'address' => 'required|string|max:255',
    //         'country_id' => 'required|exists:countries,country_id',
    //         'state_id' => 'required|exists:states,state_id',
    //         'city_id' => 'required|exists:cities,city_id',
    //         'pincode' => 'required|string|max:10',
    //         'lab_incharge' => 'required|exists:master_admins,id',
    //         'branch_logo_path' => 'nullable|image|max:2048',
    //     ]);

    //     // Check email uniqueness in User table
    //     $emailTaken = false;
    //     if (!empty($request->id)) {
    //         $branch = Branch::findOrFail($request->id);
    //         if (User::where('status', '!=', 'delete')->where('email', $request->email)->where('id', '!=', $branch->user_id)->exists()) {
    //             $emailTaken = true;
    //         }
    //     } else {
    //         if (User::where('status', '!=', 'delete')->where('email', $request->email)->exists()) {
    //             $emailTaken = true;
    //         }
    //     }
    //     if ($emailTaken) {
    //         return redirect()->back()->with('error', 'Sorry, This Email Has Already Been Taken !');
    //     }

    //     $branchInput = [
    //         'branch_name' => $request->branch_name,
    //         'email' => $request->email,
    //         'mobile' => $request->mobile, // Use normalized mobile
    //         'address' => $request->address,
    //         'country_id' => $request->country_id,
    //         'state_id' => $request->state_id,
    //         'city_id' => $request->city_id,
    //         'pincode' => $request->pincode,
    //         'lab_incharge' => $request->lab_incharge,
    //         'status' => 'active',
    //     ];

    //     if ($request->hasFile('branch_logo_path')) {
    //         $file = $request->file('branch_logo_path');
    //         $branchInput['branch_logo_name'] = $file->getClientOriginalName();
    //         $branchInput['branch_logo_path'] = $file->store('images/branches', 'public');
    //     } elseif (!empty($request->id)) {
    //         $branch = Branch::find($request->id);
    //         $branchInput['branch_logo_name'] = $branch->branch_logo_name ?? null;
    //         $branchInput['branch_logo_path'] = $branch->branch_logo_path ?? null;
    //     }

    //     return DB::transaction(function () use ($request, $RolesPrivileges, $branchInput) {
    //         $currentUserId = Auth::guard('master_admins')->user()->id;
    //         $currentIp = $request->ip();
    //         if (!empty($request->id)) {
    //             $branch = Branch::find($request->id);
    //             if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'branch_edit')) {
    //                 // Update User model if user_id exists
    //                 if ($branch->user_id) {
    //                     User::where('id', $branch->user_id)->update([
    //                         'name' => $request->branch_name,
    //                         'email' => $request->email,
    //                         'mobile' => $request->mobile,
    //                         'address' => $request->address,
    //                         'role_id' => 1,
    //                         'modified_by' => $currentUserId,
    //                         'modified_ip_address' => $currentIp,
    //                     ]);
    //                 }

    //                 $branchInput['modified_by'] = $currentUserId;
    //                 $branchInput['modified_ip_address'] = $currentIp;

    //                 Branch::where('id', $request->id)->update($branchInput);

    //                 return redirect('admin/branches')->with('success', 'Branch updated successfully!');
    //             } else {
    //                 return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
    //             }
    //         } else {
    //             if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'branch_add')) {
    //                 // Prepare data for User model
    //                 $userInput = [
    //                     'type' => 'branch',
    //                     'name' => $request->branch_name,
    //                     'email' => $request->email,
    //                     'password' => Hash::make('12345678'),
    //                     'mobile' => $request->mobile,
    //                     'address' => $request->address,
    //                     'status' => 'active',
    //                     'role_id' => null,
    //                     'created_by' => $currentUserId,
    //                     'created_ip_address' => $currentIp,
    //                 ];

    //                 // Create User record first
    //                 $user = User::create($userInput);
    //                 $userId = $user->id;

    //                 // Now set user_id in branchInput
    //                 $branchInput['user_id'] = $userId;
    //                 $branchInput['created_by'] = $currentUserId;
    //                 $branchInput['created_ip_address'] = $currentIp;

    //                 $branch = Branch::create($branchInput);

    //                 $branch->branch_code = 'BR' . str_pad($branch->id, 3, '0', STR_PAD_LEFT);
    //                 $branch->save();

    //                 return redirect('admin/branches')->with('success', 'Branch added successfully!');
    //             } else {
    //                 return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
    //             }
    //         }
    //     });
    // }


    public function store(Request $request)
    {
        // dd($request->all());

        $role_id = Auth::guard('master_admins')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)
            ->where('status', 'active')
            ->select('privileges')
            ->first();

        // Normalize mobile number
        $mobile = $request->mobile;
        if (!str_starts_with($mobile, '+91') && preg_match('/^[0-9]{10}$/', $mobile)) {
            $mobile = '+91' . $mobile; // Prepend +91 if it's a 10-digit number
            $request->merge(['mobile' => $mobile]);
        }

        // Updated validation (removed country, state, city, pincode, lab_incharge)
        $request->validate([
            'type' => 'required|in:branch,collection_center,hospital',
            'branch_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:branches,email,' . ($request->id ?? 'NULL') . ',id',
            'mobile' => 'required|string|regex:/^\+91[0-9]{10}$/',
            'password' => 'nullable|min:8', // Optional for edit, but min length if provided; required only for new via frontend
            'address' => 'required|string|max:255',
            'branch_logo_path' => 'nullable|image|max:2048',
        ]);

        // Check email uniqueness in User table
        $emailTaken = false;
        if (!empty($request->id)) {
            $branch = Branch::findOrFail($request->id);
            if (User::where('status', '!=', 'delete')->where('email', $request->email)->where('id', '!=', $branch->user_id)->exists()) {
                $emailTaken = true;
            }
        } else {
            if (User::where('status', '!=', 'delete')->where('email', $request->email)->exists()) {
                $emailTaken = true;
            }
        }
        if ($emailTaken) {
            return redirect()->back()->with('error', 'Sorry, This Email Has Already Been Taken !');
        }

        $branchInput = [
            'type' => $request->type, // Dynamic type only in branches table
            'branch_name' => $request->branch_name,
            'email' => $request->email,
            'mobile' => $request->mobile, // Use normalized mobile
            'address' => $request->address,
            'status' => 'active',
        ];

        if ($request->hasFile('branch_logo_path')) {
            $file = $request->file('branch_logo_path');
            $branchInput['branch_logo_name'] = $file->getClientOriginalName();
            $branchInput['branch_logo_path'] = $file->store('images/branches', 'public');
        } elseif (!empty($request->id)) {
            $branch = Branch::find($request->id);
            $branchInput['branch_logo_name'] = $branch->branch_logo_name ?? null;
            $branchInput['branch_logo_path'] = $branch->branch_logo_path ?? null;
        }

        return DB::transaction(function () use ($request, $RolesPrivileges, $branchInput) {
            $currentUserId = Auth::guard('master_admins')->user()->id;
            $currentIp = $request->ip();
            if (!empty($request->id)) {
                $branch = Branch::find($request->id);
                if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'branch_edit')) {
                    // Update User model if user_id exists
                    if ($branch->user_id) {
                        $userUpdate = [
                            'name' => $request->branch_name,
                            'email' => $request->email,
                            'mobile' => $request->mobile,
                            'address' => $request->address,
                            'type' => 'branch', // Hardcoded 'branch' in users table
                            'role_id' => 7,
                            'modified_by' => $currentUserId,
                            'modified_ip_address' => $currentIp,
                        ];
                        if (!empty($request->password)) {
                            $userUpdate['password'] = Hash::make($request->password);
                        }
                        User::where('id', $branch->user_id)->update($userUpdate);
                    }

                    $branchInput['modified_by'] = $currentUserId;
                    $branchInput['modified_ip_address'] = $currentIp;

                    Branch::where('id', $request->id)->update($branchInput);

                    return redirect('admin/branches')->with('success', 'Branch/Collection Center/Hospital updated successfully!');
                } else {
                    return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
                }
            } else {
                if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'branch_add')) {
                    // Prepare data for User model (password required for new)
                    if (empty($request->password)) {
                        return redirect()->back()->with('error', 'Password is required for new entries.');
                    }
                    $userInput = [
                        'type' => 'branch', // Hardcoded 'branch' in users table
                        'name' => $request->branch_name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'mobile' => $request->mobile,
                        'address' => $request->address,
                        'status' => 'active',
                        'role_id' => 7,
                        'created_by' => $currentUserId,
                        'created_ip_address' => $currentIp,
                    ];

                    // Create User record first
                    $user = User::create($userInput);
                    $userId = $user->id;

                    // Now set user_id in branchInput
                    $branchInput['user_id'] = $userId;
                    $branchInput['created_by'] = $currentUserId;
                    $branchInput['created_ip_address'] = $currentIp;

                    $branch = Branch::create($branchInput);

                    $branch->branch_code = 'BR' . str_pad($branch->id, 3, '0', STR_PAD_LEFT);
                    $branch->save();

                    return redirect('admin/branches')->with('success', 'Branch/Collection Center/Hospital added successfully!');
                } else {
                    return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
                }
            }
        });
    }
    


    public function data_table(Request $request)
    {

        
        $branches = Branch::with(['labIncharge'])
            ->where('status', '!=', 'delete')
            ->orderBy('id', 'DESC')
            ->select('id', 'branch_code','type','branch_name', 'email', 'mobile', 'address', 'lab_incharge', 'status', 'branch_logo_path')
            ->get();

        

        if ($request->ajax()) {
            return DataTables::of($branches)
                ->addIndexColumn()

                ->addColumn('branch_code', function ($row) {
                    return !empty($row->branch_code) ? $row->branch_code : '';
                })

                ->addColumn('type', function ($row) {
                    if (!empty($row->type)) {
                        return ucwords(str_replace('_', ' ', $row->type));
                    }
                    return '';
                })

                ->addColumn('branch_name', function ($row) {
                    return !empty($row->branch_name) ? $row->branch_name : '';
                })
                ->addColumn('branch_logo', function ($row) {
                    return $row->branch_logo_path 
                        ? '<img src="' . asset('storage/' . $row->branch_logo_path) . '" alt="' . $row->branch_name . '" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">'
                        : 'N/A';
                })
                ->addColumn('address', function ($row) {
                    return !empty($row->address) ? $row->address : '';
                })
                // ->addColumn('lab_incharge', function ($row) {
                //     return $row->labIncharge ? $row->labIncharge->user_name : 'N/A';
                // })
                ->addColumn('mobile', function ($row) {
                    return !empty($row->mobile) ? $row->mobile : '';
                })
                ->addColumn('email', function ($row) {
                    return !empty($row->email) ? $row->email : '';
                })




                ->addColumn('status', function ($row) {
                    $role_id = Auth::guard('master_admins')->user()->role_id;
                    $RolesPrivileges = Role_privilege::where('status', 'active')->where('id', $role_id)->select('privileges')->first();

                    $isChecked = $row->status == 'active' ? 'checked' : '';

                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'branch_status_change')) {
                        return '<input type="checkbox" class="change-status" data-id="' . $row->id . '" data-table="branches" data-flash="Status Changed Successfully!" ' . $isChecked . '>';
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
                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'branch_view')) {
                        $actionBtn .= '<a href="' . url('admin/branches/view/' . $row->id) . '" 
                                    class="btn btn-icon btn-info me-1" 
                                    title="View Branch" 
                                    data-bs-toggle="tooltip" 
                                    style="background:#fff; color:#6267ae; border:1px solid #6267ae;">
                                    <i class="mdi mdi-eye"></i>
                                </a>';
                    }

            
                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'branch_edit')) {
                        $actionBtn .= '<a href="' . url('admin/branches/edit/' . $row->id) . '" 
                                        class="btn btn-icon btn-warning me-1" 
                                        title="Edit Pet Parent" 
                                        data-bs-toggle="tooltip" 
                                        style="background:#fff; color:#f6b51d; border:1px solid #f6b51d;">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>';
                    } 


                if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'branch_delete')) {
                    $actionBtn .= '<a href="javascript:void(0)" 
                                    data-id="' . $row->id . '" 
                                    data-table="branches" 
                                    data-flash="Branch Deleted Successfully!" 
                                    class="btn btn-icon btn-danger delete me-1" 
                                    title="Delete Branch" 
                                    data-bs-toggle="tooltip" 
                                    style="background:#fff; color:#cc235e; border:1px solid #cc235e;">
                                    <i class="mdi mdi-trash-can"></i>
                                </a>';
                } 

                    return $actionBtn;
                })
                

                ->rawColumns(['branch_logo', 'status', 'action'])
                ->make(true);
        }
    }




    public function edit($id)
    {
        $branch = Branch::find($id);
        if (!$branch) {
            return redirect('admin/branches')->with('error', 'Branch not found!');
        }
        $countries = Country::get();
        $states = State::where('country_id', $branch->country_id)->get();
        $cities = City::where('state_id', $branch->state_id)->get();
        $labincharge = Master_admin::where('status', 'active')->where('role_id', 2)->get();

        return view('Admin.Branches.add-branches', compact('branch', 'countries', 'states', 'cities', 'labincharge'));
    }

    public function view($id)
    {
        $branch = Branch::find($id);
        if (!$branch) {
            return redirect('admin/branches')->with('error', 'Branch not found!');
        }
        
        // Load related data manually instead of using relationships
        $country = Country::where('country_id', $branch->country_id)->first();
        $state = State::where('state_id', $branch->state_id)->first();
        $city = City::where('city_id', $branch->city_id)->first();
        $labIncharge = Master_admin::where('id', $branch->lab_incharge)->first();
        
        return view('Admin.Branches.view-branch', compact('branch', 'country', 'state', 'city', 'labIncharge'));
    }

    public function delete($id)
    {
        $role_id = Auth::guard('master_admins')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('status', 'active')->where('id', $role_id)->select('privileges')->first();

        if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'branches_delete')) {
            Branch::where('id', $id)->update(['status' => 'delete']);
            return redirect('admin/branches')->with('success', 'Branch deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }
    }



    public function getStates($countryId)
    {
        $states = State::where('country_id', $countryId)->get(['state_id', 'name']);
        return response()->json($states);
    }

    public function getCities($stateId)
    {
        $cities = City::where('state_id', $stateId)->get(['city_id', 'name']);
        return response()->json($cities);
    }
}
