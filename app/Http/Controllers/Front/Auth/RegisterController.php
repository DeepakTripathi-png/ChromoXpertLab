<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Petparent;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name'  => 'required|string|max:255',
                'gender'     => 'required|string',
                'mobile'     => 'required|string|max:15|unique:users,mobile',
                'email'      => 'required|email|unique:users,email',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            // ✅ Create user
            $user = User::create([
                'type' => 'petparent',
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
                'status' => 'active',
                'created_ip_address' => $request->ip(),
            ]);
            $code = 'PP' . str_pad($user->id, 4, '0', STR_PAD_LEFT);
            // ✅ Create pet parent record (code will auto-generate in model)
            $petParent = PetParent::create([
                'code' => $code,
                'user_id' => $user->id,
                'name' => $request->first_name . ' ' . $request->last_name,
                'gender'     => $request->gender,
                'mobile'     => $request->mobile,
                'email'      => $request->email,
                'created_ip_address' => $request->ip(),
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Registration successful!',
                'user'    => $user,
                'petparent' => $petParent,
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

?>