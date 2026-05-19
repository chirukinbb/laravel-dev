<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view("auth.login");
    }

    // Handle login request with static credentials (demo only)
    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        if (Auth::attempt(['email' => $request->post('email'), 'password' => $request->post('password')], true)) {

            return redirect()->intended("/dashboard");
        }

        return back()->withErrors([
            "email" => "The provided credentials do not match our records.",
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            "email" => "required|email|unique:users,email",
            "name" => "required",
        ]);

        // Generate a random password
        $password = Str::random(12);

        // Create user with generated password
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
        ]);

        try {
            $user->notify(new NewUserNotification($password));

            return redirect()->route('login')
                ->with('success', 'Registration successful! Please check your email for the password.');
        } catch (\Exception $e) {
            $user->delete();

            return back()->withErrors([
                'email' => 'Failed to send registration email. Please try again later.'
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect("/login");
    }
}
