<?php

namespace App\Http\Controllers\Doctor\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User; // Centralized User Model
use App\Traits\HelperTrait; // If you use timezone logic

class DoctorLoginController extends Controller
{
    use HelperTrait;

    /**
     * Show the doctor login form
     */
    public function index()
    {
        return !empty(Session::has('Doctor*%'))
            ? redirect()->route('doctor.dashboard')
            : view('Doctor.Logins.login');
    }

    /**
     * Handle doctor login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Filter centralized user table for doctor type
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'type' => 'doctor',   // Filter by type
            'status' => 'active'  // Ensure active user
        ];

        // Attempt authentication
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Verify user type
            if ($user->type !== 'doctor') {
                Auth::logout();
                return back()->with('error', 'Invalid user type for this login.');
            }

            // Verify user status
            if ($user->status !== 'active') {
                Auth::logout();
                return back()->with('error', 'Your account is inactive. Please contact administrator.');
            }

            // Update last login details
            $updateData = [
                'last_login' => now(),
                'token' => Str::random(64),
                'timezone' => $this->getTimezoneByIp($request->ip()) ?? 'Asia/Kolkata',
            ];
            User::find($user->id)->update($updateData);

            // Login to doctor guard
            Auth::guard('doctor')->login($user);

            // Store session key
            Session::put('Doctor*%', $user->id);

            return redirect()->route('doctor.dashboard')->with('success', 'Login Successfully!');
        }

        return back()->with('error', 'Invalid login credentials.');
    }

    /**
     * Logout doctor user
     */
    public function logout(Request $request)
    {
        Auth::logout();
        Auth::guard('doctor')->logout();
        Session::forget('Doctor*%');
        return redirect('/doctor-login')->with('success', 'Logout Successfully!');
    }

    /**
     * Show change password form
     */
    public function change_password()
    {
        return view('Doctor.Settings.change-password');
    }

    /**
     * Update doctor user password
     */
    public function update(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|max:30|confirmed',
            'new_password_confirmation' => 'required'
        ], [
            'new_password_confirmation.required' => 'The confirm password field is required',
            'new_password.confirmed' => 'The confirm password does not match',
        ]);

        $user = User::find(Auth::guard('doctor')->user()->id);

        // Check if new password matches old one
        if (Hash::check($request->new_password, $user->password)) {
            return redirect('/doctor/change-password')->with('error', 'New password must not be same as old password!');
        }

        // Verify and update password
        if ($user && Hash::check($request->old_password, $user->password)) {
            $user->update(['password' => Hash::make($request->new_password)]);

            // Logout after password change
            Auth::logout();
            Auth::guard('doctor')->logout();
            Session::forget('Doctor*%');

            return redirect('/doctor')->with('success', 'Password changed successfully!');
        }

        return redirect('/doctor/change-password')->with('error', 'Invalid old password!');
    }
}
