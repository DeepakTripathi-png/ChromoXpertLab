<?php

namespace App\Http\Controllers\Branch\Appointment;

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
use App\Models\TestProfiles;
use Illuminate\Support\Facades\Mail;
use App\Models\TestResults;
use App\Models\User;

class BranchAppointmentController extends Controller
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
        //   dd($rolesPrivileges);        

        if (!empty($rolesPrivileges) && str_contains($rolesPrivileges->privileges, 'new_registration_view')){
             return view('Branch.Appointment.index'); 
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
        //   dd($rolesPrivileges);        

        if (!empty($rolesPrivileges) && str_contains($rolesPrivileges->privileges, 'new_registration_add')){

        $refereeDoctors = RefereeDoctor::where('status','active')->get();
        $branches = collect();
        $pets = collect();
        $branchLogin = null;
        $guard = null;

        if (Auth::guard('branch')->check()) {
            $guard = 'branch';

            if(Auth::guard('branch')->user()->role_id==7){
                  $branchLogin = Auth::guard('branch')->user()->branch;
                  $branches = collect([$branchLogin]);
            }else{
                  $branchLogin = Branch::find($this->branchId);
                  $branches = Branch::where('status','active')->get();
            }
            

          


            $pets = Pet::with('petParent')->where('status','active')->where('created_by', $this->branchUserId)->get();
        } else {
            abort(403, 'Unauthorized');
        }

        return view('Branch.Appointment.add-appointment', compact('refereeDoctors','pets','branches','branchLogin', 'guard')); 
         }else {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }
    }



    public function getPetDetails($pet_id)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'new_registration_view')){
             abort(403, 'Unauthorized');
        }

        $pet = Pet::with('petParent')->where('id', $pet_id)->where('created_by', $this->branchUserId)->firstOrFail();

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
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'new_registration_view')){
             abort(403, 'Unauthorized');
        }

        $pet = Pet::with('petParent')->where('pet_code', $pet_code)->where('created_by', $this->branchUserId)->firstOrFail();

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
        //  dd($request->all());


          $role_id = Auth::guard('branch')->user()->role_id;
         $rolesPrivileges = Role_privilege::where('id', $role_id)
                ->where('status', 'active')
                ->select('privileges')
                ->first();
        //   dd($rolesPrivileges);        

        if (!empty($rolesPrivileges) && str_contains($rolesPrivileges->privileges, 'new_registration_add')){

        if (!Auth::guard('branch')->check()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

   

        $phone = $request->phone;
        if (!str_starts_with($phone, '+91') && preg_match('/^[0-9]{10}$/', $phone)) {
            $phone = '+91' . $phone;
            $request->merge(['phone' => $phone]);
        }


        $pet = Pet::where('id', $request->pet_id)->first();
        if (!$pet) {
            return redirect()->back()->with('error', 'Invalid pet ID provided.');
        }
        $request->merge(['petowner_id' => $pet->pet_parent_id]);

        $rules = [
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
            'paid_amount' => 'required|numeric|min:0',
            'payment_mode' => 'required|in:Cash,Card,UPI,Bank Transfer',
            'transaction_id' => 'nullable|string|max:255',
            'payment_status' => 'required|in:Pending,Completed,Failed',
            'payment_date' => 'nullable|date',
        ];

        $request->validate($rules);


        $appointmentInput = [
                'lab_id'               => $this->branchId,
                'referee_doctor_id'    => $request->referee_doctor_id,
                'appointment_date'     => $request->appointment_date,
                'appointment_time'     => $request->appointment_time,
                'pet_id'               => $request->pet_id,
                'petowner_id'          => $request->petowner_id,
                'notes'                => $request->notes,
                'subtotal'             => $request->subtotal,
                'discount'             => $request->discount,
                'total'                => $request->total,
                'paid_amount'          => $request->paid_amount,
                'due_amount'           => $request->total - $request->paid_amount,
                'payment_mode'         => $request->payment_mode,
                'transaction_id'       => $request->transaction_id,
                'payment_status'       => $request->payment_status,
                'payment_date'         => $request->payment_date,
                'status'               => 'active',
                'created_by'           => $this->branchUserId,
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
        ->route('branch.appointments.receipt', $appointment->id)
        ->with('success', 'Registration completed successfully!');
         }else {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }
    }
    



    public function petAndPetparentStore(Request $request)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'new_registration_add')){
             return response()->json([
                'success' => false,
                'message' => 'Sorry, You Have No Permission For This Request!'
            ], 403);
        }

        // Normalize phone (remove '+91' if exists)
        $normalizedMobile = preg_replace('/^\+91/', '', $request->owner_mobile);

        // Custom validation logic
        $request->validate([
            'owner_name' => 'required|string|max:255',
            // 'owner_gender' => 'required|in:Male,Female,Other',
            'owner_email' => 'required|email|max:255|unique:petparents,email|unique:users,email',
            'owner_mobile' => [
                'required',
                'string',
                'regex:/^(?:\+91)?[0-9]{10}$/',
                'min:10',
                function ($attribute, $value, $fail) use ($normalizedMobile) {
                    $existingPetParent = Petparent::where(function ($q) use ($normalizedMobile) {
                        $q->where('mobile', $normalizedMobile)
                            ->orWhere('mobile', '+91' . $normalizedMobile);
                    })->first();

                    $existingUser = User::where(function ($q) use ($normalizedMobile) {
                        $q->where('mobile', $normalizedMobile)
                            ->orWhere('mobile', '+91' . $normalizedMobile);
                    })->where('type', 'petparent')->first();

                    if ($existingPetParent || $existingUser) {
                        $fail('This mobile number is already in use.');
                    }
                },
            ],
            'owner_address' => 'nullable|string|max:255',
            'pet_name' => 'required|string|max:255',
            'pet_code' => 'nullable|string|max:255',
            'pet_species' => 'required|in:Canine,Feline,Avian,Other',
            'pet_breed' => 'nullable|string|max:255',
            'pet_type' => 'required|in:Dog,Cat,Bird,Other',
            'pet_gender' => 'required|in:Male,Female',
            'pet_dob' => 'nullable|date|before_or_equal:today',
            'pet_age' => 'nullable|string|max:255',
            'pet_weight' => 'nullable|numeric|min:0',
            'pet_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        // Start transaction
        return DB::transaction(function () use ($request, $normalizedMobile) {
            $petparentInput = [
                'name' => $request->owner_name,
                'gender' => $request->owner_gender,
                'email' => $request->owner_email,
                'mobile' => $normalizedMobile,  // Store normalized version
                'address' => $request->owner_address,
                'status' => 'active',
            ];

            $userInput = [
                'type' => 'petparent',
                'name' => $request->owner_name,
                'email' => $request->owner_email,
                'mobile' => $normalizedMobile,  // Store normalized version
                'password' => Hash::make('12345678'),
                'address' => $request->owner_address,
                'status' => 'active',
                'role_id' => null,
            ];

            // 1. Create User
            $user = User::create($userInput);

            // 2. Create Petparent with user_id
            $petparentInput['user_id'] = $user->id;
            $petparentInput['created_by'] = $this->branchUserId;
            $petparentInput['created_ip_address'] = $request->ip();
            $petParent = Petparent::create($petparentInput);
            $petParent->code = 'PP' . str_pad($petParent->id, 4, '0', STR_PAD_LEFT);
            $petParent->save();

            $petInput = [
                'pet_parent_id' => $petParent->id,
                'name' => $request->pet_name,
                'species' => $request->pet_species,
                'breed' => $request->pet_breed,
                'type' => $request->pet_type,
                'gender' => $request->pet_gender,
                'dob' => $request->pet_dob,
                'age' => $request->pet_age,
                'weight' => $request->pet_weight,
                'status' => 'active',
                'created_by' => $this->branchUserId,
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

            $petData = [
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
            ];

            $petParentData = [
                'id' => $petParent->id,
                'name' => $petParent->name,
                'gender' => $petParent->gender,
                'email' => $petParent->email,
                'mobile' => $petParent->mobile,
                'address' => $petParent->address,
                'code' => $petParent->code,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Pet and Pet Parent added successfully!',
                'pet' => $petData,
                'pet_parent' => $petParentData,
            ], 200);
        });
    }



    public function data_table(Request $request)
    {
         $role_id = Auth::guard('branch')->user()->role_id;
         $rolesPrivileges = Role_privilege::where('id', $role_id)
                ->where('status', 'active')
                ->select('privileges')
                ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'new_registration_view')){
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
         $appointments = Appointment::where('lab_id', $this->branchId)->with(['branch', 'refereeDoctor', 'pet', 'pet.petParent', 'tests'])
            ->where('status', '!=', 'delete')
            ->orderBy('created_at', 'DESC') 
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
                    // $role_id = Auth::guard('branch')->user()->role_id;
                    // $RolesPrivileges = Role_privilege::where('status', 'active')->where('id', $role_id)->select('privileges')->first();

                    // View button
                    // if (!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'appointments_view')) {
                        $actionBtn .= '<a href="' . url('branch/appointments/reciept/' . $row->id) . '" 
                                    class="btn btn-icon btn-info me-1" 
                                    title="View Appointment Reciept" 
                                    data-bs-toggle="tooltip" 
                                    style="background:#fff; color:#6267ae; border:1px solid #6267ae;">
                                    <i class="mdi mdi-eye"></i>
                                </a>';
                    // }

                    return $actionBtn;
                })
                ->rawColumns(['action']) 
                ->make(true);
        }
    }


    public function viewReciept($id){
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'new_registration_view')){
             abort(403, 'Unauthorized');
        }

        $appointmentDetails = Appointment::with(['branch', 'refereeDoctor', 'pet', 'pet.petParent', 'tests'])
                    ->where('id', $id)
                    ->where('lab_id', $this->branchId)
                    ->first();

        if (!$appointmentDetails) {
            return redirect('branch/appointments')->with('error', 'Appointment not found!');
        }

        return view('Branch.Appointment.reciept_view',compact('appointmentDetails'));
    }
        
    
    public function edit($id){

          $role_id = Auth::guard('branch')->user()->role_id;
         $rolesPrivileges = Role_privilege::where('id', $role_id)
                ->where('status', 'active')
                ->select('privileges')
                ->first();
        //   dd($rolesPrivileges);        

        if (!empty($rolesPrivileges) && str_contains($rolesPrivileges->privileges, 'new_registration_edit')){


        if (!Auth::guard('branch')->check()) {
            abort(403, 'Unauthorized');
        }




        $branches = collect();
        if(Auth::guard('branch')->user()->role_id==7){
                   $branches = Branch::where('id', $this->branchId)->where('status','active')->get();
        }else{
                   $branches = Branch::where('id',$this->branchId)->where('status','active')->get();
        }




        $pets = Pet::with('petParent')->where('status','active')->where('created_by', $this->branchUserId)->get();
        $appointmentDetails = Appointment::with(['branch', 'refereeDoctor', 'pet', 'pet.petParent', 'tests'])
                    ->where('id', $id)
                    ->where('lab_id', $this->branchId)
                    ->first();
        
        $refereeDoctors = RefereeDoctor::where('status','active')->get();
        
        $tests = Test::with(['parameters'])
            ->where('status', 'active')
            ->orderBy('id', 'DESC')
            ->paginate(8);

        if (!$appointmentDetails) {
            return redirect('branch/appointments')->with('error', 'Appointment not found!');
        }

        return view('Branch.Appointments.add-aapontments', compact('branches','refereeDoctors','pets','tests','appointmentDetails')); 
         }else {
            return redirect()->back()->with('error', 'Sorry, You Have No Permission For This Request!');
        }
    }



    public function storeAjax(Request $request)
    {
        $role_id = Auth::guard('branch')->user()->role_id;

        $RolesPrivileges = Role_privilege::where('id', $role_id)
            ->where('status', 'active')
            ->select('privileges')
            ->first();

        if (!$RolesPrivileges || !str_contains($RolesPrivileges->privileges, 'referee_doctors_add')) {
            return response()->json([
                'success' => false,
                'errors' => ['permission' => 'Sorry, You Have No Permission For This Request!']
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'doctor_name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'email' => 'required|email|max:255|unique:referee_doctors,email',
            'mobile' => 'required|string|regex:/^\+91[0-9]{10}$/|unique:referee_doctors,mobile',
            'address' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

      


        return DB::transaction(function () use ($request) {
            $refereeDoctorInput = [
                'doctor_name' => $request->doctor_name,
                'gender' => $request->gender,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'commission_percent' => $request->commission_percent??0,
                'address' => $request->address,
                'status' => 'active',
                'created_by' => $this->branchUserId,
                'created_ip_address' => $request->ip(),
            ];

            // Create RefereeDoctor
            $refereeDoctor = RefereeDoctor::create($refereeDoctorInput);

            // Generate code using ID
            $refereeDoctor->code = 'RD' . str_pad($refereeDoctor->id, 4, '0', STR_PAD_LEFT); 
            $refereeDoctor->save();

            return response()->json([
                'success' => true,
                'message' => 'Referee Doctor added successfully!',
                'doctor' => [
                    'id' => $refereeDoctor->id,
                    'doctor_name' => $refereeDoctor->doctor_name,
                    'code' => $refereeDoctor->code,
                ]
            ], 201);
        });
    }



    public function getOwnerPetsByPhone($phone)
    {
        $role_id = Auth::guard('branch')->user()->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
               ->where('status', 'active')
               ->select('privileges')
               ->first();

        if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'new_registration_view')){
             abort(403, 'Unauthorized');
        }

        try {
        
            if (substr($phone, 0, 3) === '+91') {
                $phone = substr($phone, 3);
            }

    
            $query = Petparent::where('status','active')->where('created_by', $this->branchUserId);
            $owner = $query->where(function($q) use ($phone) {
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

            $petQuery = Pet::where('status','active')->where('created_by', $this->branchUserId);
            $pets = $petQuery->where('pet_parent_id', $owner->id)
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



public function search(Request $request)
{
    $role_id = Auth::guard('branch')->user()->role_id;
    $rolesPrivileges = Role_privilege::where('id', $role_id)
           ->where('status', 'active')
           ->select('privileges')
           ->first();

    if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'new_registration_view')){
         return response()->json([
            'success' => false,
            'message' => 'Sorry, You Have No Permission For This Request!'
        ], 403);
    }
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
    $role_id = Auth::guard('branch')->user()->role_id;
    $rolesPrivileges = Role_privilege::where('id', $role_id)
           ->where('status', 'active')
           ->select('privileges')
           ->first();

    if (empty($rolesPrivileges) || !str_contains($rolesPrivileges->privileges, 'new_registration_view')){
         return response()->json([
            'success' => false,
            'message' => 'Sorry, You Have No Permission For This Request!'
        ], 403);
    }
    $profile = TestProfiles::findOrFail($profileId);
    $tests = $profile->tests()
        ->select('tests.id', 'tests.name', 'tests.test_code', 'tests.total_price')
        ->get()
        ->makeHidden(['pivot']);

    return response()->json($tests);
}

}