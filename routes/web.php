<?php

use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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

// User management routes (protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/users', [UserController::class, 'index'])
        ->middleware('role.permission:view users')
        ->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])
        ->middleware('role.permission:create user')
        ->name('users.create');
    Route::post('/users', [UserController::class, 'store'])
        ->middleware('role.permission:create user')
        ->name('users.store');
    Route::put('/users/{user}/role', [UserController::class, 'updateRole'])
        ->middleware('role.permission:edit user role')
        ->name('users.update-role');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->middleware('role.permission:edit user role')
        ->name('users.destroy');
});

