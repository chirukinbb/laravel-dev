<?php

use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::get("/login", [AuthController::class, "showLoginForm"])->name("login");
Route::post("/login", [AuthController::class, "login"])->name('signin');
Route::get("/register", function () {
    return view('auth.register');
})->name('register.form');
Route::post("/register", [AuthController::class, "register"])->name('register');
Route::post("/logout", [AuthController::class, "logout"])->name("logout");

// Password Reset Routes
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Password Confirmation Routes
Route::get('/password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
Route::post('/password/confirm', [ConfirmPasswordController::class, 'confirm']);

// Email Verification Routes
Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

// Simple dashboard (protected)
Route::get("/dashboard", [\App\Http\Controllers\DashboardController::class, 'index'])->middleware('auth')->name("dashboard");

// Redirect root to login
Route::get("/", function () {
    return redirect()->route('login');
});

