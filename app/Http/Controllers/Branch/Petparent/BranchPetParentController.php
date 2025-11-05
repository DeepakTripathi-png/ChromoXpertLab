<?php

namespace App\Http\Controllers\Branch\Petparent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Petparent;
use App\Models\Master\Master_admin;
use App\Traits\MediaTrait;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;
use Yajra\DataTables\DataTables;
use Storage;
use Crypt;
use Session;
use App\Models\Pet;
use App\Models\User;
use App\Models\Master\Role_privilege;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;

class BranchPetParentController extends Controller
{
    protected $branchId;
    protected $branchUserId;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::guard('branch')->check()) {
                abort(403, 'Unauthorized access');
            }

            $user = Auth::guard('branch')->user();
            if ($user->role_id == 7) {
                $this->branchId = $user->branch->id;
                $this->branchUserId = $user->id;
            } else {
                $branch = Branch::where('user_id', $user->created_by)->first();
                if (!$branch) {
                    abort(403, 'Invalid branch access');
                }
                $this->branchId = $branch->id;
                $this->branchUserId = $user->created_by;
            }

            return $next($request);
        });
    }

    public function index(){
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (!empty($rolesPrivileges) && str_contains($rolesPrivileges->privileges, 'pet_parent_view')){
             return view('Branch.Petparent.index'); 
        }else {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }
    }

    public function add(){
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (!empty($rolesPrivileges) && str_contains($rolesPrivileges->privileges, 'pet_parent_add')){
             return view('Branch.Petparent.add-petparent'); 
        }else {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }
    }

    public function store(Request $request)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (empty($rolesPrivileges) || (!str_contains($rolesPrivileges->privileges, 'pet_parent_add') && !str_contains($rolesPrivileges->privileges, 'pet_parent_edit'))){
             return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }

        $userId = null;
        if (!empty($request->id)) {
            $petParent = Petparent::find($request->id);
            if ($petParent) {
                $oldEmail = $request->old_email ?? $petParent->email;
                $user = User::where('email', $oldEmail)->where('type', 'petparent')->first();
                $userId = $user ? $user->id : null;
            }
        }

        // Normalize phone (remove '+91' if exists)
        $normalizedPhone = preg_replace('/^\+91/', '', $request->mobile);

        // Custom validation logic
        $request->validate([
            'name' => 'required|string|max:255',
            // 'gender' => 'required|in:Male,Female,Other',
            'email' => 'required|email|max:255|unique:petparents,email,' . ($request->id ?? 'NULL') . ',id|unique:users,email,' . ($userId ?? 'NULL') . ',id',
            'mobile' => [
                'required',
                'string',
                'max:255',
                'min:4',
                function ($attribute, $value, $fail) use ($request, $normalizedPhone) {
                    $existingPetParent = Petparent::where(function ($q) use ($normalizedPhone) {
                        $q->where('mobile', $normalizedPhone)
                            ->orWhere('mobile', '+91' . $normalizedPhone);
                    });

                    if ($request->id) {
                        $existingPetParent->where('id', '!=', $request->id);
                    }

                    $existingPetParent = $existingPetParent->first();

                    $existingUser = User::where(function ($q) use ($normalizedPhone) {
                        $q->where('mobile', $normalizedPhone)
                            ->orWhere('mobile', '+91' . $normalizedPhone);
                    })->where('type', 'petparent')->first();

                    if ($existingPetParent || $existingUser) {
                        $fail('This mobile number is already in use.');
                    }
                },
            ],
            'address' => 'nullable|string|max:255',
        ]);

        $petparentInput = [
            'name' => $request->name,
            'gender' => $request->gender,
            'email' => $request->email,
            'mobile' => $normalizedPhone,  // Store normalized version
            'address' => $request->address,
            'status' => 'active',
        ];

        $userInput = [
            'type' => 'petparent',
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $normalizedPhone,  // Store normalized version
            'password' => Hash::make('12345678'),
            'address' => $request->address,
            'status' => 'active',
            'role_id' => null,
        ];

        return DB::transaction(function () use ($request, $petparentInput, $userInput, $userId) {
            $ipAddress = $request->ip();

            if (!empty($request->id)) {
                // UPDATE logic
                $petparentInput['modified_by'] = $this->branchUserId;
                $petparentInput['modified_ip_address'] = $ipAddress;
                $userInput['modified_by'] = $this->branchUserId;
                $userInput['modified_ip_address'] = $ipAddress;

                Petparent::where('id', $request->id)->update($petparentInput);

                if ($userId) {
                    User::where('id', $userId)->update($userInput);
                } else {
                    $oldEmail = $request->old_email ?? $request->email;
                    User::where('email', $oldEmail)->where('type', 'petparent')->update($userInput);
                }

                return redirect('branch/parent')->with('success', 'Pet Parent updated successfully!');
            } else {
                // CREATE logic
                $petparentInput['created_by'] = $this->branchUserId;
                $petparentInput['created_ip_address'] = $ipAddress;
                $userInput['created_by'] = $this->branchUserId;
                $userInput['created_ip_address'] = $ipAddress;

                // 1. Create User
                $user = User::create($userInput);

                // 2. Create Petparent with user_id
                $petparentInput['user_id'] = $user->id;
                $petParent = Petparent::create($petparentInput);

                // 3. Generate code using ID
                $petParent->code = 'PP' . str_pad($petParent->id, 4, '0', STR_PAD_LEFT);
                $petParent->save();

                return redirect('branch/parent')->with('success', 'Pet Parent added successfully!');
            }
        });
    }

    public function data_table(Request $request)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'pet_parent_view')){
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
        
        $petparents = Petparent::where('created_by', $this->branchUserId)
            ->where('status', '!=', 'delete')
            ->orderBy('id', 'DESC')
            ->select('id', 'code', 'name', 'gender', 'email', 'mobile', 'status')
            ->get();

        if ($request->ajax()) {
            return DataTables::of($petparents)
                ->addIndexColumn()
                ->addColumn('code', function ($row) {
                    return !empty($row->code) ? $row->code : '';
                })
                ->addColumn('name', function ($row) {
                    return !empty($row->name) ? $row->name : '';
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


                ->addColumn('action', function ($row) {
                $actionBtn = '';

                // Edit button
                $actionBtn .= '<a href="' . url('branch/parent/edit/' . $row->id) . '" 
                                class="btn btn-icon btn-warning me-1" 
                                title="Edit Pet Parent" 
                                data-bs-toggle="tooltip" 
                                style="background:#fff; color:#f6b51d; border:1px solid #f6b51d;">
                                <i class="mdi mdi-pencil"></i>
                            </a>';

                // Delete button
                $actionBtn .= '<a href="javascript:void(0)" 
                                data-id="' . $row->id . '" 
                                data-table="petparents" 
                                data-flash="Pet Parent Deleted Successfully!" 
                                class="btn btn-icon btn-danger delete me-1" 
                                title="Delete Pet Parent" 
                                data-bs-toggle="tooltip" 
                                style="background:#fff; color:#cc235e; border:1px solid #cc235e;">
                                <i class="mdi mdi-trash-can"></i>
                            </a>';
                return $actionBtn;
            })


                ->addColumn('status', function ($row) {

                    $isChecked = $row->status == 'active' ? 'checked' : '';

                    return '<input type="checkbox" class="change-status" data-id="' . $row->id . '" data-table="petparents" data-flash="Status Changed Successfully!" ' . $isChecked . '>';
                })


                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function edit($id)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'pet_parent_edit')){
             return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }

        $petparent = Petparent::where('id', $id)->where('created_by', $this->branchUserId)->first();

        if (!$petparent) {
            return redirect('branch/parent')->with('error', 'Pet Parent not found!');
        }

        return view('Branch.Petparent.add-petparent', compact('petparent'));
    }

    public function getOwnerPetsByPhone($phone)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'pet_parent_view')){
             return response()->json([
                'success' => false,
                'message' => 'Sorry, You Have No Permission For This Request!'
            ], 403);
        }

        try {
           
            if (substr($phone, 0, 3) === '+91') {
                $phone = substr($phone, 3);
            }

       
            $owner = Petparent::where('created_by', $this->branchUserId)
                    ->where('status','active')
                    ->where(function($q) use ($phone) {
                        $q->where('mobile', $phone)
                        ->orWhere('mobile', '+91' . $phone);
                    })
                    ->first();

            if (!$owner) {
                return response()->json([
                    'success' => false,
                    'message' => 'No owner found with this phone number.'
                ], 404);
            }

            $pets = Pet::where('status','active')->where('pet_parent_id', $owner->id)
                    ->select('id', 'name', 'pet_code', 'type', 'gender', 'dob')
                    ->get();
                

            return response()->json([
                'success' => true,
                'owner' => [
                    'name' => $owner->name,
                    'mobile' => $owner->mobile
                ],
                'pets' => $pets
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching owner details: ' . $e->getMessage()
            ], 500);
        }
    }
}