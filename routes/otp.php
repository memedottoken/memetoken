<?php

use App\Http\Controllers\Auth\OtpController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    // OTP email code    
    Route::get('verify-otp/{code}', [OtpController::class, 'verifyOtp'])
        ->name('otp.verify');

    Route::post('otp-resend', [OtpController::class, 'resend'])
        ->name('otp.resend');
    // For modal login flow
    Route::post('send-otp', [OtpController::class, 'sendOtp'])
        ->name('otp.send');

    Route::post('modal-verify', [OtpController::class, 'modalVerify'])
        ->name('modal.verify');
});
