<?php
namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserLoginController extends Controller
{
    // Generate and store OTP in users table
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:10|exists:users,mobile',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>'error','message'=>$validator->errors()->first()], 422);
        }

        $mobile = $request->mobile;
        //$user = User::where('mobile', $mobile)->first();
        $user = User::where('mobile', $mobile)
                ->where('type', 'petparent')
                ->first();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mobile number not found or user type invalid.',
            ], 422);
        }        
        // generate 4-digit OTP
        //$otp = mt_rand(1000, 9999);
        $otp = '1234';
        $expiry = now()->addMinutes(5);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => $expiry,
            'otp_attempts' => 0,
        ]);

        // TODO: call actual SMS provider here (e.g. Twilio, MSG91)
        // SmsService::send($mobile, "Your login OTP is {$otp}");

        return response()->json([
            'status' => 'success',
            'message' => 'OTP sent successfully.',
            // For development only — remove in production:
            'otp' => $otp,
        ]);
    }

    // Verify OTP and log the user in
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:10',
            'otp' => 'required|digits:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ]);
        }

        $user = User::where('mobile', $request->mobile)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found!',
            ]);
        }

        if ($user->otp !== $request->otp) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid OTP!',
            ]);
        }

        if ($user->otp_expires_at && now()->greaterThan($user->otp_expires_at)) {
            return response()->json([
                'status' => 'error',
                'message' => 'OTP has expired. Please request a new one.',
            ]);
        }

        // ✅ OTP matched — login user
        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
            'otp_attempts' => 0,
            'last_login' => now(),
        ]);

        Auth::login($user);

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful!',
            'user' => $user,
        ]);
    }


    // Resend OTP (regenerate)
    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:10|exists:users,mobile',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>'error','message'=>$validator->errors()->first()], 422);
        }

        //$user = User::where('mobile', $request->mobile)->first();
        $user = User::where('mobile', $request->mobile)
                ->where('type', 'petparent')
                ->first();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mobile number not found or user type invalid.',
            ], 422);
        }  
        $otp = mt_rand(1000, 9999);
        $expiry = now()->addMinutes(5);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => $expiry,
            'otp_attempts' => 0,
        ]);

        // TODO: call SMS provider
        // SmsService::send($request->mobile, "Your new OTP is {$otp}");

        return response()->json([
            'status'=>'success',
            'message'=>'OTP resent successfully',
            // dev only:
            'otp' => $otp,
        ]);
    }
    public function logout(Request $request)
    {
        // Log out the user
        Auth::logout();

        // Invalidate the session and regenerate CSRF token for security
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect back to home (or any page you want)
        return redirect('/')->with('success', 'You have been logged out successfully.');
    }
}
?>