<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\OTPNotification;
use Illuminate\Http\Request;
use App\Services\UrlCrypt;
use Illuminate\Validation\ValidationException;
use RateLimiter;

class OtpController extends Controller
{

    /**
     * Handle the initial modal login request.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'name' => 'required|nullable',
            'email' => 'required|email',
            'to' => 'string',
        ]);
        $user = $request->user();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->email_verified_at = null;
        $user->save();
        $otp = $user->generateOTP();
        $user->notify(new OTPNotification($otp, 'Connect Your Email', route('otp.verify', ['code' => UrlCrypt::encrypt($otp)])));
        // handle link
        $request->session()->put('url', $request->to);
        return  back();
    }

    /**
     * Handle OTP verification and user login/registration.
     */
    public function modalVerify(Request $request)
    {
        $request->validate(['otp' => 'required|string']);
        $user = $request->user();
        if (!$user->verifyOTP($request->otp)) {
            throw ValidationException::withMessages(['otp' => ['Invalid OTP']]);;
        }
        $user->update(['email_verified_at' => now()]);
        return back();
    }

    /**
     * Via email button
     */
    public function verifyOtp(Request $request, $code)
    {
        $url =  $request->session()->pull('url', '/');
        $otp = UrlCrypt::decrypt($code);
        $user = $request->user();
        if (!$user || !$user->verifyOTP($otp)) {
            return redirect()->to($url)->with('error', 'The provided OTP is Invalid.');
        }
        $user->update(['email_verified_at' => now()]);
        return redirect()->to($url);
    }
    /**
     * Resend authentication request with throttling.
     */
    public function resend(Request $request)
    {
        $key = 'otp_resend_' . ($request->ip() ?? '0');
        if (RateLimiter::tooManyAttempts($key, 10)) { // 3 attempts max
            $seconds = RateLimiter::availableIn($key);
            return back()->with(
                'error',
                __(
                    'Please wait :seconds seconds before requesting another OTP.',
                    ['seconds' => $seconds]
                )
            );
        }
        RateLimiter::hit($key, 5); // Lock for 5 minutes (300 seconds)
        $user = $request->user();
        $otp = $user->generateOTP();
        $user->notify(new OTPNotification(
            $otp,
            'Login to Your Account',
            route('otp.verify', ['code' => UrlCrypt::encrypt($otp)])
        ));
        return back()->with('success', __('OTP has been resent to your contact.'));
    }
}
