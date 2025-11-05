<?php

namespace App\Http\Controllers\Admin\Pet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Pet;
use App\Models\Petparent;
use App\Models\Master\Role_privilege;
use Yajra\DataTables\Facades\DataTables;

class PetController extends Controller
{
    public function index()
    {
        return view('Admin.Pet.index');
    }

    public function add()
    {
        $petparents = Petparent::where('status', 'active')->get();
        return view('Admin.Pet.add-pet', compact('petparents'));
    }

    public function edit($id)
    {
        $pet = Pet::findOrFail($id);
        $petparents = Petparent::where('status', 'active')->get();
        return view('Admin.Pet.add-pet', compact('pet', 'petparents'));
    }

    public function store(Request $request)
    {
        $role_id = Auth::guard('master_admins')->user()->role_id;
        $RolesPrivileges = Role_privilege::where('id', $role_id)
            ->where('status', 'active')
            ->select('privileges')
            ->first();

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

        return DB::transaction(function () use ($request, $RolesPrivileges, $petInput) {
            if (!empty($request->id)) {
                if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'pet_edit')) {
                    $petInput['modified_by'] = Auth::guard('master_admins')->user()->id;
                    $petInput['modified_ip_address'] = $request->ip();

                    Pet::where('id', $request->id)->update($petInput);

                    return redirect('admin/pet')->with('success', 'Pet updated successfully!');
                } else {
                    return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
                }
            } else {
                if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'pet_add')) {
                    $petInput['created_by'] = Auth::guard('master_admins')->user()->id;
                    $petInput['created_ip_address'] = $request->ip();

                    $pet = Pet::create($petInput);

                    $pet->pet_code = 'PET' . str_pad($pet->id, 3, '0', STR_PAD_LEFT);
                    $pet->save();

                    return redirect('admin/pet')->with('success', 'Pet added successfully!');
                } else {
                    return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
                }
            }
        });
    }

  public function data_table(Request $request)
    {
        if ($request->ajax()) {
            $pets = Pet::with(['petParent'])
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
                    $role_id = Auth::guard('master_admins')->user()->role_id;
                    $RolesPrivileges = Role_privilege::where('status', 'active')->where('id', $role_id)->select('privileges')->first();

                    $isChecked = $row->status == 'active' ? 'checked' : '';

                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'pet_status_change')) {
                        return '<label class="switch"><input type="checkbox" class="change-status" data-id="' . $row->id . '" data-table="pets" data-flash="Status Changed Successfully!" ' . $isChecked . '><span class="slider"></span></label>';
                    } else {
                        return '<label class="switch"><input type="checkbox" disabled ' . $isChecked . '><span class="slider"></span></label>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '';
                    $role_id = Auth::guard('master_admins')->user()->role_id;
                    $RolesPrivileges = Role_privilege::where('status', 'active')->where('id', $role_id)->select('privileges')->first();

                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'pet_view')) {
                        $actionBtn .= '<a href="' . url('admin/pet/view/' . $row->id) . '" 
                                        class="btn btn-icon btn-info me-1" 
                                        title="View Pet" 
                                        data-bs-toggle="tooltip" 
                                        style="background:#fff; color:#6267ae; border:1px solid #6267ae;">
                                        <i class="mdi mdi-eye"></i>
                                    </a>';
                    }

                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'pet_edit')) {
                        $actionBtn .= '<a href="' . url('admin/pet/edit/' . $row->id) . '" 
                                        class="btn btn-icon btn-warning me-1" 
                                        title="Edit Pet" 
                                        data-bs-toggle="tooltip" 
                                        style="background:#fff; color:#f6b51d; border:1px solid #f6b51d;">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>';
                    }

                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'pet_delete')) {
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
                    }

                    return $actionBtn;
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }
        
        return response()->json(['error' => 'Invalid request'], 400);
    }


    public function view($id)
    {
        $pet = Pet::with('petParent')->findOrFail($id);
       

        return view('Admin.Pet.view-pet', compact('pet'));
    }
}