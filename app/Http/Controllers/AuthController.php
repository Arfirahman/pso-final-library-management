<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            session(['user_id' => $user->id, 'role' => $user->role]);
            \Log::info('Session set: user_id=' . $user->id . ', role=' . $user->role); // Debug
            // dd(session()->all()); // Cek session
            if ($user->role == 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }
        }

        return redirect()->back()->with('error', 'Login failed, please check your email or password.');
    }

    public function logout()
    {
        session()->forget(['user_id', 'role']);
        return redirect()->route('login');
    }
}