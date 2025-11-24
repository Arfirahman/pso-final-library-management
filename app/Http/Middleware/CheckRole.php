<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role) // Tetap 3 argumen, karena hanya untuk 'role'
    {
        // Jika tidak ada user_id di sesi, kita biarkan AuthMiddleware yang menangani.
        // Tapi sebagai fallback, lebih baik tetap ada redirect ke login jika tiba-tiba sesi hilang di sini.
        if (!session('user_id')) {
            return redirect()->route('login');
        }

        $user = User::find(session('user_id'));

        if ($user && $user->role === $role) {
            return $next($request);
        }

        // Hapus sesi yang tidak valid dan redirect ke login
        session()->forget(['user_id', 'role']);
        return redirect()->route('login')->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk halaman ini.');
    }
}