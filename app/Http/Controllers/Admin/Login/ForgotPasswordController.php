<?php

namespace App\Http\Controllers\Admin\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Master_admin; 
use Carbon\Carbon; 
use Illuminate\Support\Str;
use App\Mail\MailForgetPasswordLink;
use DB; 
use Mail; 
use Hash;

class ForgotPasswordController extends Controller
{
    public function showForgetPasswordForm()
    {
        return view('Admin.Forget-passwords.forget-password');
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $token = Str::random(64);

        if(!Master_admin::where('status','active')->where('email',$request->email)->exists()){
            return back()->with('error', 'Sorry, this mail is not associated with us!');
        }

        $password_reset_tokens_user = DB::table('password_reset_tokens')->where('email', $request->email)->first();
        if(!empty(isset($password_reset_tokens_user->email) && $password_reset_tokens_user->email)){
            DB::table('password_reset_tokens')->where('email', $request->email)->update([
                'email' => $request->email, 
                'token' => $token, 
                'created_at' => Carbon::now()
            ]);
        } else {
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email, 
                'token' => $token, 
                'created_at' => Carbon::now()
            ]);
        }

        $mailData = [
            'token' => $token,
        ];

        try {
            Mail::to($request->email)->send(new MailForgetPasswordLink($mailData));
        }catch (Throwable $e) {
            return redirect()->back()->with('error', 'Thank You ! Your Request Reached To Us, Mail Not Send , Make Sure Email is Right Or Network Connection is Proper');
        }
        return back()->with('success', 'We have e-mailed your password reset link!');
    }

    public function showResetPasswordForm($token) { 
        return view('Admin.Forget-passwords.change-forget-password', ['token' => $token]);
    }
  
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
        if(!Master_admin::where('status','active')->where('email',$request->email)->exists()){
            return back()->with('error', 'Sorry, this mail is not associated with us!');
        }
        $updatePassword = DB::table('password_reset_tokens')->where(['email' => $request->email, 'token' => $request->token])->first();
        if(!$updatePassword){
            return back()->withInput()->with('error', 'Invalid token!');
        }
        $user = Master_admin::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
        DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();
        return redirect('/admin')->with('success', 'Your password has been changed!');
    }
}
