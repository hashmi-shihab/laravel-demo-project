<?php

use App\Http\Controllers\AUTH\AuthenticateController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsVerifyEmail;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('Dashboard');
    }
    return redirect()->route('login');
});
Route::get('login', [AuthenticateController::class, 'loginPage'])->name('login');
Route::post('login', [AuthenticateController::class, 'login'])->name('Login');
Route::get('registration', [AuthenticateController::class, 'registration'])->name('Register.Get');
Route::post('post-registration', [AuthenticateController::class, 'postRegistration'])->name('Register.Post');
Route::get('account-verify/{token}', [AuthenticateController::class, 'verifyAccount'])->name('User.Verify');
Route::get('forget-password', [AuthenticateController::class, 'showForgetPasswordForm'])->name('Forget.Password.Get');
Route::post('forget-password', [AuthenticateController::class, 'submitForgetPasswordForm'])->name('Forget.Password.Post');
Route::get('reset-password/{token}', [AuthenticateController::class, 'showResetPasswordForm'])->name('Reset.Password.Get');
Route::post('reset-password', [AuthenticateController::class, 'submitResetPasswordForm'])->name('Reset.Password.Post');

Route::middleware(['auth',IsVerifyEmail::class])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('Dashboard');
    Route::post('logout', [AuthenticateController::class, 'logout'])->name('Logout');
});

