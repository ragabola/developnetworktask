<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PhoneVerificationController;
use App\Http\Controllers\Auth\RegisterUserController;
use Illuminate\Http\Request;

Route::post('/code/send', [PhoneVerificationController::class, 'send'])
    ->name('code.send');

Route::post('/code/verify', [PhoneVerificationController::class, 'verify'])
    ->name('code.verify');

Route::post('/register', RegisterUserController::class)->middleware('verified')
    ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');

Route::get('/user', fn(Request $request) => $request->user())->middleware('auth:sanctum');
