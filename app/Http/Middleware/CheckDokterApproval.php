<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckDokterApproval
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        
        // Pastikan user adalah dokter
        if ($user->role !== 'dokter') {
            \Log::warning('Non-dokter trying to access dokter route', [
                'user_id' => $user->id,
                'role' => $user->role
            ]);
            return redirect()->route('dashboard');
        }
        
        // Jika email belum diverifikasi, redirect ke verification
        if (!$user->hasVerifiedEmail()) {
            \Log::info('Dokter email not verified', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);
            return redirect()->route('verification.notice')
                ->with('error', 'Silakan verifikasi email Anda terlebih dahulu.');
        }
        
        // Jika dokter belum diapprove, redirect ke pending
        if (!$user->is_approved) {
            \Log::info('Dokter not approved, redirecting to pending', [
                'user_id' => $user->id,
                'approval_status' => $user->approval_status
            ]);
            return redirect()->route('dokter.pending')
                ->with('info', 'Akun Anda masih menunggu persetujuan admin.');
        }
        
        return $next($request);
    }
}