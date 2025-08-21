<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Auth\OTPController;
use App\Http\Controllers\Auth\OtpLoginController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\RegisteredUserEmailController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;

Route::middleware('guest')->group(function () {
    Route::get('/choose/register', [PageController::class, 'chooseRegister'])
        ->name('choose.register');

    Route::get('/choose/login', [PageController::class, 'chooseLogin'])
        ->name('choose.login');

    Route::get('register', [RegisteredUserEmailController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserEmailController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');

    Route::get('reset-password-success', [NewPasswordController::class, 'success'])
        ->name('password.success');

    Route::post('/login/otp/send', [OtpLoginController::class, 'sendOtp'])->name('login.otp.send');

    Route::get('/verify-otp/{userId}', [RegisteredUserEmailController::class, 'showVerifyForm'])->name('verify.otp');
    Route::post('/verify-otp/{userId}', [RegisteredUserEmailController::class, 'verifyOtp'])->name('verify.otp.submit');
});

Route::middleware('auth')->group(function () {

    Route::get('/choose/account-type', [PageController::class, 'chooseAccount'])
        ->name('choose.account');

    Route::post('/choose-account-type', [PageController::class, 'chooseAccountStore'])->name('choose.account.store');


    Route::get('/create/account', [PageController::class, 'createAccount'])
        ->name('create.account');

    Route::post('/create/account', [PageController::class, 'createAccountStore'])
        ->name('create.account.store');


    Route::get('verify-email', EmailVerificationPromptController::class)
    ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::post('logout-user', [AuthenticatedSessionController::class, 'destroyUserProfile'])
        ->name('logout-user');
});
