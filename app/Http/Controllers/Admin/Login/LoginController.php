<?php

namespace App\Http\Controllers\Admin\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\HelperTrait;
use App\Models\User;

class LoginController extends Controller
{
    use HelperTrait;

    public function index(){ 
        return Auth::guard('master_admins')->check() ? redirect()->route("admin.dashboard") : view('Admin.Logins.login'); 
    }

    public function admin_login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        // Centralized credentials with TYPE filter (matches migration enum 'type')
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'type' => 'admin',  // Use 'type' column and enum value 'admin' (not 'role' or 'master_admin')
            'status' => 'active'
        ];

        // Attempt authentication directly on the guard
        if (Auth::guard('master_admins')->attempt($credentials)) {
            $user = Auth::guard('master_admins')->user();
            
            // Update last_login
            $user->update(['last_login' => now()]);
            
            return redirect()->route("admin.dashboard")->with('success', 'Login Successfully!');
        }

        // Existing error handling
        return back()->with('error', 'Invalid credentials.');
    }

    public function logout(Request $request)
    {
        Auth::guard('master_admins')->logout();
        return redirect('/admin')->with('success', 'Logout Successfully!');
    }

    public function change_password()
    {
        return view('Admin.Settings.change-password');
    }

    public function update(Request $request)
    {
        // Enhanced validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|max:30|confirmed|different:old_password',
            'new_password_confirmation' => 'required'
        ], [
            'old_password.required' => 'The old password field is required',
            'new_password.required' => 'The new password field is required',
            'new_password.min' => 'The new password must be at least 8 characters',
            'new_password.max' => 'The new password must not exceed 30 characters',
            'new_password.confirmed' => 'The new password confirmation does not match',
            'new_password.different' => 'The new password must be different from the old password',
            'new_password_confirmation.required' => 'The confirm password field is required',
        ]);  
        
        $user = User::find(Auth::guard('master_admins')->user()->id);
        
        // Check if old password matches
        if (!$user || !Hash::check($request->old_password, $user->password)) {
            return redirect('/admin/change-password')->with('error','Invalid old password!');
        }
        
        // Check if new password is same as old password
        if (Hash::check($request->new_password, $user->password)) {
            return redirect('/admin/change-password')->with('error','New password must not be same as old password!');
        }
        
        // Update password
        $user->update(['password' => Hash::make($request->new_password)]);
        
        // Logout and redirect to login
        Auth::guard('master_admins')->logout();
        
        return redirect('/admin')->with('success','Password changed successfully! Please login with your new password.');
    }
}