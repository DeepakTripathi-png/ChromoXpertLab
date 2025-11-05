<?php

namespace App\Http\Controllers\Branch\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User; // Centralized User Model
use App\Traits\HelperTrait; // If you have this trait for timezone
use App\Models\Master\Role_privilege;

class BranchLoginController extends Controller
{
    use HelperTrait; // Add if you need timezone functionality

    /**
     * Show the branch login form
     */
    public function index()
    {
        return !empty(Session::has('BranchAdmin*%'))
            ? redirect()->route('branch.dashboard')
            : view('Branch.Logins.login');
    }

    /**
     * Handle branch login
     */
    // public function branch_login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);

    //     // Filter centralized user table for branch type
    //     $credentials = [
    //         'email' => $request->email,
    //         'password' => $request->password,
    //         'type' => 'branch',  // Filter by user type
    //         'status' => 'active' // Ensure user is active
    //     ];

    //     // Attempt authentication with type filter
    //     if (Auth::attempt($credentials)) {
    //         $user = Auth::user();

    //         // Additional check to ensure type is branch
    //         if ($user->type !== 'branch') {
    //             Auth::logout();
    //             return back()->with('error', 'Invalid user type for this login.');
    //         }

    //         // Check if user is active
    //         if ($user->status !== 'active') {
    //             Auth::logout();
    //             return back()->with('error', 'Your account is inactive. Please contact administrator.');
    //         }

    //         // Update last login info
    //         $updateData = [
    //             'last_login' => now(),
    //             'token' => Str::random(64),
    //             'timezone' => $this->getTimezoneByIp($request->ip()) ?? 'Asia/Kolkata', // If using HelperTrait
    //         ];
            
    //         User::find($user->id)->update($updateData);

    //         // Login to specific branch guard
    //         Auth::guard('branch')->login($user);

    //         // Save session with correct key
    //         Session::put('BranchAdmin*%', $user->id);

    //         return redirect()->route('branch.dashboard')->with('success', 'Login Successfully!');
    //     }

    //     return back()->with('error', 'Invalid login credentials.');
    // }


public function branch_login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    // Filter centralized user table for branch type
    $credentials = [
        'email' => $request->email,
        'password' => $request->password,
        'type' => 'branch',  // Filter by user type
        'status' => 'active' // Ensure user is active
    ];

    // Attempt authentication with type filter
    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // Additional check to ensure type is branch
        if ($user->type !== 'branch') {
            Auth::logout();
            return back()->with('error', 'Invalid user type for this login.');
        }

        // Check if user is active
        if ($user->status !== 'active') {
            Auth::logout();
            return back()->with('error', 'Your account is inactive. Please contact administrator.');
        }

        // Fetch privileges for redirect decision
        $role_id = $user->role_id;
        $rolesPrivileges = Role_privilege::where('id', $role_id)
            ->where('status', 'active')
            ->select('privileges')
            ->first();

        // Update last login info
        $updateData = [
            'last_login' => now(),
            'token' => Str::random(64),
            'timezone' => $this->getTimezoneByIp($request->ip()) ?? 'Asia/Kolkata', // If using HelperTrait
        ];
        
        User::find($user->id)->update($updateData);

        // Login to specific branch guard
        Auth::guard('branch')->login($user);

        // Save session with correct key
        Session::put('BranchAdmin*%', $user->id);

        // Permission-aware redirect
        if (!empty($rolesPrivileges) && str_contains($rolesPrivileges->privileges, 'dashboard_view')) {
            return redirect()->route('branch.dashboard')->with('success', 'Login Successfully!');
        } else {
            // Fallback: Redirect to a permitted section (e.g., notifications if available) or home
            // Example: Check for notifications_view; adjust as needed
            if (!empty($rolesPrivileges) && str_contains($rolesPrivileges->privileges, 'notifications_view')) {
                return redirect()->route('branch.notification.index')->with('info', 'Welcome! Accessing your permitted section.');
            }
            // Ultimate fallback: Back to login with guidance
            return back()->with('warning', 'Login successful, but no dashboard access. Contact admin for permissions.');
        }
    }

    return back()->with('error', 'Invalid login credentials.');
}

    /**
     * Logout branch user
     */
    public function logout(Request $request)
    {
        Auth::logout();
        Auth::guard('branch')->logout();
        Session::forget('BranchAdmin*%');
        return redirect('/branch-login')->with('success', 'Logout Successfully!');
    }

    /**
     * Show change password form
     */
    public function change_password()
    {
        return view('Branch.Settings.change-password');
    }

    /**
     * Update branch user password
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

        $user = User::find(Auth::guard('branch')->user()->id);

        // Check if new password is same as current
        if (Hash::check($request->new_password, $user->password)) {
            return redirect('/branch/change-password')->with('error', 'New password must not be same as old password!');
        }

        // Verify old password and update
        if ($user && Hash::check($request->old_password, $user->password)) {
            $user->update(['password' => Hash::make($request->new_password)]);
            
            // Logout after password change
            Auth::logout();
            Auth::guard('branch')->logout();
            Session::forget('BranchAdmin*%');
            
            return redirect('/branch-login')->with('success', 'Password changed successfully!');
        }

        return redirect('/branch/change-password')->with('error', 'Invalid old password!');
    }
}