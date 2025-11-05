<?php

namespace App\Http\Controllers\Branch\Pet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Pet;
use App\Models\Petparent;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Master\Role_privilege;
use App\Models\Branch;

class BranchPetController extends Controller
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

    public function index()
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (!empty($rolesPrivileges) && str_contains($rolesPrivileges->privileges, 'pets_view')){
             return view('Branch.Pet.index'); 
        }else {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }
    }

    public function add()
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (!empty($rolesPrivileges) && str_contains($rolesPrivileges->privileges, 'pets_add')){

            $petparents = Petparent::where('created_by', $this->branchUserId)
                ->where('status', 'active')
                ->get();
            return view('Branch.Pet.add-pet', compact('petparents'));
        }else {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }
    }

    public function edit($id)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'pets_edit')){
             return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }

        $pet = Pet::where('id', $id)->where('created_by', $this->branchUserId)->firstOrFail();
        $petparents = Petparent::where('created_by', $this->branchUserId)
            ->where('status', 'active')
            ->get();
        return view('Branch.Pet.add-pet', compact('pet', 'petparents'));
    }

    public function store(Request $request)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (empty($rolesPrivileges) || (!str_contains($rolesPrivileges->privileges, 'pets_add') && !str_contains($rolesPrivileges->privileges, 'pets_edit'))){
             return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }

        $request->validate([
            'pet_parent_id' => 'required|exists:petparents,id',
            'name' => 'required|string|max:255',
            'species' => 'required|in:Canine,Feline,Avian,Other',
            'breed' => 'nullable|string|max:255',
            'type' => 'required|in:Dog,Cat,Bird,Other',
            'gender' => 'required|in:Male,Female',
            'dob' => 'nullable|date|before_or_equal:today',
            'age' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $petInput = [
            'pet_parent_id' => $request->pet_parent_id,
            'name' => $request->name,
            'species' => $request->species,
            'breed' => $request->breed,
            'type' => $request->type,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'age' => $request->age,
            'weight' => $request->weight,
            'status' => 'active',
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $petInput['image_name'] = $file->getClientOriginalName();
            $petInput['image_path'] = $file->store('images/pets', 'public');
        } elseif (!empty($request->id)) {
            $pet = Pet::find($request->id);
            $petInput['image_name'] = $pet->image_name ?? null;
            $petInput['image_path'] = $pet->image_path ?? null;
        }

        return DB::transaction(function () use ($request, $petInput) {
            $ipAddress = $request->ip();

            if (!empty($request->id)) {
                $petInput['modified_by'] = $this->branchUserId;
                $petInput['modified_ip_address'] = $ipAddress;

                Pet::where('id', $request->id)->update($petInput);

                return redirect('branch/pet')->with('success', 'Pet updated successfully!');
            } else {
                $petInput['created_by'] = $this->branchUserId;
                $petInput['created_ip_address'] = $ipAddress;

                $pet = Pet::create($petInput);

                $pet->pet_code = 'PET' . str_pad($pet->id, 3, '0', STR_PAD_LEFT);
                $pet->save();

                return redirect('branch/pet')->with('success', 'Pet added successfully!');
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

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'pets_view')){
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

        if ($request->ajax()) {
            $pets = Pet::with(['petParent'])
                ->where('created_by', $this->branchUserId)
                ->where('status', '!=', 'delete')
                ->select('id', 'pet_code', 'pet_parent_id', 'name', 'gender', 'dob', 'status', 'image_path');
                
            return DataTables::eloquent($pets)
                ->addIndexColumn()
                ->addColumn('pet_code', function ($row) {
                    return !empty($row->pet_code) ? $row->pet_code : '';
                })
                ->addColumn('pet_parent', function ($row) {
                    return $row->petParent ? $row->petParent->name : 'N/A';
                })
                ->addColumn('name', function ($row) {
                    return !empty($row->name) ? $row->name : '';
                })
                ->addColumn('gender', function ($row) {
                    return !empty($row->gender) ? $row->gender : '';
                })
                ->addColumn('dob', function ($row) {
                    return !empty($row->dob) ? $row->dob : 'N/A';
                })
                ->addColumn('image', function ($row) {
                    return $row->image_path 
                        ? '<img src="' . asset('storage/' . $row->image_path) . '" alt="' . $row->name . '" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">'
                        : 'N/A';
                })
                ->addColumn('status', function ($row) {
                    $isChecked = $row->status == 'active' ? 'checked' : '';

                    return '<label class="switch"><input type="checkbox" class="change-status" data-id="' . $row->id . '" data-table="pets" data-flash="Status Changed Successfully!" ' . $isChecked . '><span class="slider"></span></label>';
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '';
                    $actionBtn .= '<a href="' . url('branch/pet/view/' . $row->id) . '" 
                                    class="btn btn-icon btn-info me-1" 
                                    title="View Pet" 
                                    data-bs-toggle="tooltip" 
                                    style="background:#fff; color:#6267ae; border:1px solid #6267ae;">
                                    <i class="mdi mdi-eye"></i>
                                </a>';
                    $actionBtn .= '<a href="' . url('branch/pet/edit/' . $row->id) . '" 
                                    class="btn btn-icon btn-warning me-1" 
                                    title="Edit Pet" 
                                    data-bs-toggle="tooltip" 
                                    style="background:#fff; color:#f6b51d; border:1px solid #f6b51d;">
                                    <i class="mdi mdi-pencil"></i>
                                </a>';
                    $actionBtn .= '<a href="javascript:void(0)" 
                                    data-id="' . $row->id . '" 
                                    data-table="pets" 
                                    data-flash="Pet Deleted Successfully!" 
                                    class="btn btn-icon btn-danger delete" 
                                    title="Delete Pet" 
                                    data-bs-toggle="tooltip" 
                                    style="background:#fff; color:#cc235e; border:1px solid #cc235e;">
                                    <i class="mdi mdi-trash-can"></i>
                                </a>';

                    return $actionBtn;
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }
        
        return response()->json(['error' => 'Invalid request'], 400);
    }


    public function view($id)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'pets_view')){
             return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }

        $pet = Pet::with('petParent')->where('id', $id)->where('created_by', $this->branchUserId)->firstOrFail();
        return view('Branch.Pet.view-pet', compact('pet'));
    }
}