<?php

namespace App\Http\Controllers\Admin\Appointments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\RefereeDoctor;
use App\Models\Pet;
use App\Models\Master\Master_admin;
use App\Models\Master\Role_privilege;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\Test;
use App\Models\Appointment;
use App\Models\Petparent;
use App\Models\AppointmentTest;
use App\Mail\AppointmentConfirmation;
use Illuminate\Support\Facades\Mail;
use App\Models\TestResults;
use App\Models\User;



class AppointmentsController extends Controller
{
    
    public function index(){
        return view('Admin.Appointments.index'); 
    }


    public function add(){
        $branches = Branch::where('status','active')->get();
        $refereeDoctors = RefereeDoctor::where('status','active')->get();
        $pets = Pet::with('petParent')->where('status','active')->get();
        
        $tests = Test::with(['parameters'])
            ->where('status', 'active')
            ->orderBy('id', 'DESC')
            ->paginate(8);


        return view('Admin.Appointments.add-aapontments', compact('branches','refereeDoctors','pets','tests')); 
    }



    public function getPetDetails($pet_id)
    {
        $pet = Pet::with('petParent')->findOrFail($pet_id);

        return response()->json([
            'pet_id' => $pet->id,
            'pet_code' => $pet->pet_code,
            'pet_type' => $pet->type . ' ' . $pet->breed,
            'pet_gender' => $pet->gender,
            'pet_dob' => $pet->dob,
            'pet_age' => $pet->age,
            'owner_name' => $pet->petParent->name,
            'owner_phone' => $pet->petParent->mobile,
        ]);
    }

    public function getPetDetailsByCode($pet_code)
    {
        $pet = Pet::with('petParent')->where('pet_code', $pet_code)->firstOrFail();
        return response()->json([
            'pet_id' => $pet->id,
            'pet_code' => $pet->pet_code,
            'pet_type' => $pet->type . ' ' . $pet->breed,
            'pet_gender' => $pet->gender,
            'pet_dob' => $pet->dob,
            'owner_name' => $pet->petParent->name,
            'owner_phone' => $pet->petParent->mobile,
        ]);
    }


    public function store(Request $request)
    {
        //    dd($request->all());

            $role_id = Auth::guard('master_admins')->user()->role_id;
            $rolesPrivileges = Role_privilege::where('id', $role_id)
                ->where('status', 'active')
                ->select('privileges')
                ->first();

            if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'appointments_add')) {
                return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
            }

            $phone = $request->phone;
            if (!str_starts_with($phone, '+91') && preg_match('/^[0-9]{10}$/', $phone)) {
                $phone = '+91' . $phone;
                $request->merge(['phone' => $phone]);
            }

            
            $pet = Pet::find($request->pet_id);
            if (!$pet) {
                return redirect()->back()->with('error', 'Invalid pet ID provided.');
            }
            $request->merge(['petowner_id' => $pet->pet_parent_id]);

            $request->validate([
                'lab_id' => 'required|exists:branches,id',
                'referee_doctor_id' => 'required|exists:referee_doctors,id',
                'appointment_date' => 'required|date|after_or_equal:today',
                'appointment_time' => 'required|date_format:H:i',
                'pet_id' => 'required|exists:pets,id',
                'pet_code' => 'required|string|max:50',
                'pet_type' => 'required|string|max:100',
                'pet_gender' => 'required|in:Male,Female,Other',
                'pet_dob' => 'required|date|before:today',
                'pet_owner_name' => 'required|string|max:255',
                'phone' => 'required|string|regex:/^\+91[0-9]{10}$/',
                'petowner_id' => 'required|exists:petparents,id',
                'notes' => 'nullable|string|max:1000',
                'tests' => 'required|array|min:1',
                'tests.*' => 'exists:tests,id',
                'subtotal' => 'required|numeric|min:0',
                'total' => 'required|numeric|min:0',
                'discount' => 'nullable|numeric|min:0',
                // 'gst' => 'nullable|numeric|min:0',
                'paid_amount' => 'required|numeric|min:0',
                'total_amount' => 'required|numeric|min:0',
                'payment_mode' => 'required|in:Cash,Card,UPI,Bank Transfer',
                'transaction_id' => 'nullable|string|max:255',
                'payment_status' => 'required|in:Pending,Completed,Failed',
                'payment_date' => 'nullable|date',
            ]);

             $discount = 0; 
            if($request->discount_type == "percentage"){
               $discount = $request->subtotal - $request->total;
            }else{
                $discount = $request->discount_value;
            }

            $appointmentInput = [
                    'lab_id'               => $request->lab_id,
                    'referee_doctor_id'    => $request->referee_doctor_id,
                    'appointment_date'     => $request->appointment_date,
                    'appointment_time'     => $request->appointment_time,
                    'pet_id'               => $request->pet_id,
                    'petowner_id'          => $request->petowner_id,
                    'notes'                => $request->notes,
                    'subtotal'             => $request->subtotal,
                    'discount'             => $discount,
                    // 'gst'                  => $request->gst,
                    'total'                => $request->total,
                    'paid_amount'          => $request->paid_amount,
                    'due_amount'           => $request->total - $request->paid_amount,
                    'payment_mode'         => $request->payment_mode,
                    'transaction_id'       => $request->transaction_id,
                    'payment_status'       => $request->payment_status,
                    'payment_date'         => $request->payment_date,
                    'status'               => 'active',
                    'created_by'           => Auth::guard('master_admins')->user()->id,
                    'created_ip_address'   => $request->ip(),
                ];

                // Create appointment
                $appointment = Appointment::create($appointmentInput);

                // Generate and update appointment code
                $appointment->appointment_code = 'APT' . str_pad($appointment->id, 3, '0', STR_PAD_LEFT);
                $appointment->save();

              

            

                // Link tests to the appointment
                $testIdArray = $request->tests;

                if (!empty($testIdArray) && is_array($testIdArray)) {
                    foreach ($testIdArray as $testId) {

                        AppointmentTest::create([
                            'appointment_id' => $appointment->id,
                            'test_id'       => $testId,
                        ]);

                        TestResults::create([
                            'test_result_code' => 'TR' . str_pad($appointment->id, 4, '0', STR_PAD_LEFT),
                            'appointment_id' => $appointment->id,
                            'test_id' => $testId, 
                        ]);

                    }
                }

            return redirect()
            ->route('appointments.receipt', $appointment->id)
            ->with('success', 'Registration completed successfully!');

    }
    







    public function petAndPetparentStore(Request $request)
    {
        // Check permissions
        $role_id = Auth::guard('master_admins')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
            ->where('status', 'active')
            ->select('privileges')
            ->first();

        if (
            !$rolesPrivileges ||
            !str_contains($rolesPrivileges->privileges, 'pet_owners_add') ||
            !str_contains($rolesPrivileges->privileges, 'pet_add')
        ) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to perform this action.'
            ], 403);
        }

        try {
            // Validation
            $validator = Validator::make($request->all(), [
                'owner_name' => 'required|string|max:255',
                'owner_email' => 'required|email|max:255',
                'owner_mobile' => 'required|string|max:15',
                'owner_address' => 'nullable|string|max:255',
                'owner_gender' => 'nullable|in:Male,Female,Other',
                'pet_name' => 'required|string|max:255',
                'pet_species' => 'required|in:Canine,Feline,Avian,Other',
                'pet_breed' => 'nullable|string|max:255',
                'pet_type' => 'required|in:Dog,Cat,Bird,Other',
                'pet_gender' => 'required|in:Male,Female',
                'pet_dob' => 'nullable|date|before_or_equal:today',
                'pet_age' => 'nullable|string|max:255',
                'pet_weight' => 'nullable|numeric|min:0',
                'pet_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $validated = $validator->validated();

            // Normalize phone
            $normalizedPhone = preg_replace('/^\+91/', '', $validated['owner_mobile']);

            DB::beginTransaction();

            // Check if user exists
            $user = User::where('email', $validated['owner_email'])
                ->orWhere('mobile', $normalizedPhone)
                ->first();

            if (!$user) {
                $user = User::create([
                    'type' => 'petparent',
                    'name' => $validated['owner_name'],
                    'email' => $validated['owner_email'],
                    'mobile' => $normalizedPhone,
                    'password' => Hash::make('12345678'),
                    'address' => $validated['owner_address'],
                    'status' => 'active',
                    'role_id' => null,
                    'created_by' => Auth::guard('master_admins')->user()->id,
                    'created_ip_address' => $request->ip(),
                ]);
            }

            // Check if pet parent exists
            $petParent = Petparent::where('email', $validated['owner_email'])
                ->orWhere('mobile', $normalizedPhone)
                ->first();

            if (!$petParent) {
                $petParent = Petparent::create([
                    'user_id' => $user->id,
                    'name' => $validated['owner_name'],
                    'gender' => $request->owner_gender ?? null,
                    'email' => $validated['owner_email'],
                    'mobile' => $normalizedPhone,
                    'address' => $validated['owner_address'],
                    'status' => 'active',
                    'created_by' => Auth::guard('master_admins')->user()->id,
                    'created_ip_address' => $request->ip(),
                ]);

                $petParent->code = 'PP' . str_pad($petParent->id, 4, '0', STR_PAD_LEFT);
                $petParent->save();
            }

            // Create Pet
            $petInput = [
                'pet_parent_id' => $petParent->id,
                'name' => $validated['pet_name'],
                'species' => $validated['pet_species'],
                'breed' => $validated['pet_breed'],
                'type' => $validated['pet_type'],
                'gender' => $validated['pet_gender'],
                'dob' => $validated['pet_dob'],
                'age' => $validated['pet_age'],
                'weight' => $validated['pet_weight'],
                'status' => 'active',
                'created_by' => Auth::guard('master_admins')->user()->id,
                'created_ip_address' => $request->ip(),
            ];

            if ($request->hasFile('pet_image')) {
                $file = $request->file('pet_image');
                $petInput['image_name'] = $file->getClientOriginalName();
                $petInput['image_path'] = $file->store('images/pets', 'public');
            }

            $pet = Pet::create($petInput);
            $pet->pet_code = 'PET' . str_pad($pet->id, 3, '0', STR_PAD_LEFT);
            $pet->save();

            DB::commit();

            // Return response only once (outside transaction)
            return response()->json([
                'success' => true,
                'message' => 'Pet and Pet Parent added successfully!',
                'pet' => [
                    'id' => $pet->id,
                    'name' => $pet->name,
                    'pet_code' => $pet->pet_code,
                    'species' => $pet->species,
                    'breed' => $pet->breed,
                    'type' => $pet->type,
                    'gender' => $pet->gender,
                    'dob' => $pet->dob,
                    'age' => $pet->age,
                    'weight' => $pet->weight,
                    'image_path' => $pet->image_path ? asset('storage/' . $pet->image_path) : null,
                ],
                'pet_parent' => [
                    'id' => $petParent->id,
                    'name' => $petParent->name,
                    'gender' => $petParent->gender,
                    'email' => $petParent->email,
                    'mobile' => $petParent->mobile,
                    'address' => $petParent->address,
                    'code' => $petParent->code,
                ],
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Pet and Pet Parent Store - Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again.',
            ], 500);
        }
    }








    public function data_table(Request $request)
    {
        $appointments = Appointment::with(['branch', 'refereeDoctor', 'pet', 'pet.petParent', 'tests'])
            ->where('status', '!=', 'deleted')
            ->orderBy('created_at', 'DESC') // Sort by created_at in descending order
            ->get();

        if ($request->ajax()) {
            return DataTables::of($appointments)
                ->addIndexColumn()
                ->addColumn('appointment_code', function ($row) {
                    return !empty($row->appointment_code) ? $row->appointment_code : '';
                })
                ->addColumn('pet_code', function ($row) {
                    return !empty($row->pet->pet_code) ? $row->pet->pet_code : '';
                })
                ->addColumn('pet_name', function ($row) {
                    return !empty($row->pet->name) ? $row->pet->name : '';
                })
                ->addColumn('pet_parent_code', function ($row) {
                    return !empty($row->pet->petParent->code) ? $row->pet->petParent->code : '';
                })
                ->addColumn('pet_parent', function ($row) {
                    return !empty($row->pet->petParent->name) ? $row->pet->petParent->name : '';
                })
                ->addColumn('subtotal', function ($row) {
                    return !empty($row->subtotal) ? $row->subtotal : '';
                })
                ->addColumn('discount', function ($row) {
                    return !empty($row->discount) ? $row->discount : '';
                })
                ->addColumn('total', function ($row) {
                    return !empty($row->total) ? $row->total : '';
                })
                ->addColumn('date', function ($row) {
                    if (!empty($row->appointment_date) && !empty($row->appointment_time)) {
                        return \Carbon\Carbon::parse($row->appointment_date . ' ' . $row->appointment_time)
                            ->format('d F Y h:i A');
                    }
                    return '';
                })
                ->addColumn('payment_status', function ($row) {
                    return !empty($row->payment_status) ? $row->payment_status : '';
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '';
                    $role_id = Auth::guard('master_admins')->user()->role_id;
                    $RolesPrivileges = Role_privilege::where('status', 'active')->where('id', $role_id)->select('privileges')->first();

                    // View button
                    if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'appointments_view')) {
                        $actionBtn .= '<a href="' . url('admin/appointments/reciept/' . $row->id) . '" 
                                    class="btn btn-icon btn-info me-1" 
                                    title="View Appointment Reciept" 
                                    data-bs-toggle="tooltip" 
                                    style="background:#fff; color:#6267ae; border:1px solid #6267ae;">
                                    <i class="mdi mdi-eye"></i>
                                </a>';
                    }

                    return $actionBtn;
                })
                ->rawColumns(['action']) // Removed 'status' from rawColumns since it's commented out
                ->make(true);
        }
    }




    public function viewReciept($id){
        $appointmentDetails = Appointment::with(['branch', 'refereeDoctor', 'pet', 'pet.petParent', 'tests'])
                    ->where('id', $id)
                    ->first();
        return view('Admin.Appointments.reciept_view',compact('appointmentDetails'));
    }
        
    
    public function edit($id){
        $branches = Branch::where('status','active')->get();
        $refereeDoctors = RefereeDoctor::where('status','active')->get();
        $pets = Pet::with('petParent')->where('status','active')->get();
        
        $tests = Test::with(['parameters'])
            ->where('status', 'active')
            ->orderBy('id', 'DESC')
            ->paginate(8);

        $appointmentDetails = Appointment::with(['branch', 'refereeDoctor', 'pet', 'pet.petParent', 'tests'])
                    ->where('id', $id)
                    ->first();

        return view('Admin.Appointments.add-aapontments', compact('branches','refereeDoctors','pets','tests','appointmentDetails')); 
    }

    

}
