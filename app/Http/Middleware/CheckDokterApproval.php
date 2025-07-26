<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CheckDokterApproval
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        Log::info('CheckDokterApproval middleware called', [
            'route' => $request->route() ? $request->route()->getName() : 'unknown',
            'user_id' => $user ? $user->id : null,
            'user_role' => $user ? $user->role : null,
            'is_approved' => $user ? $user->is_approved : null,
            'approval_status' => $user ? $user->approval_status : null
        ]);
        
        if ($user && $user->role === 'dokter' && !$user->is_approved) {
            Log::warning('Dokter not approved, redirecting to pending');
            return redirect()->route('dokter.pending')->with('warning', 'Akun Anda belum disetujui admin. Silakan tunggu persetujuan.');
        }

        return $next($request);
    }
}