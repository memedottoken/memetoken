<?php

use App\Http\Controllers\Auth\Web3AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::post('login', [Web3AuthController::class, 'create'])
        ->name('login');
    Route::post('code', [Web3AuthController::class, 'authCode'])->name('auth.code');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [Web3AuthController::class, 'destroy'])
        ->name('logout');
});
