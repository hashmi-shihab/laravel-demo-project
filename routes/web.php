<?php

use App\Http\Controllers\AUTH\AuthenticateController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('Dashboard');
    }
    return redirect()->route('login');
});
Route::get('login', [AuthenticateController::class, 'loginPage'])->name('login');
Route::post('login', [AuthenticateController::class, 'login'])->name('Login');
Route::get('forget-password', [AuthenticateController::class, 'showForgetPasswordForm'])->name('Forget.Password.Get');
Route::post('forget-password', [AuthenticateController::class, 'submitForgetPasswordForm'])->name('Forget.Password.Post');
Route::get('reset-password/{token}', [AuthenticateController::class, 'showResetPasswordForm'])->name('Reset.Password.Get');
Route::post('reset-password', [AuthenticateController::class, 'submitResetPasswordForm'])->name('Reset.Password.Post');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('Dashboard');
    Route::post('logout', [AuthenticateController::class, 'logout'])->name('Logout');
});

