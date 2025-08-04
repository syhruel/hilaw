<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Cek apakah email sudah diverifikasi
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice')
                ->with('error', 'Silakan verifikasi email Anda terlebih dahulu.');
        }
        
        // Cek role
        if ($user->role !== $role) {
            \Log::warning('User with wrong role trying to access route', [
                'user_id' => $user->id,
                'user_role' => $user->role,
                'required_role' => $role
            ]);
            return redirect()->route('dashboard');
        }
        
        // Khusus untuk dokter, cek approval status juga
        if ($role === 'dokter' && !$user->is_approved) {
            return redirect()->route('dokter.pending');
        }
        
        return $next($request);
    }
}