<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string|null $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = Auth::guard($guard)->user();

            Log::info('RedirectIfAuthenticated middleware triggered', [
                'user_id' => $user->id,
                'role' => $user->role,
                'is_approved' => $user->role === 'dokter' ? $user->is_approved : null,
                'current_route' => $request->route() ? $request->route()->getName() : 'unknown'
            ]);

            if ($user->role === 'dokter') {
                if (!$user->is_approved) {
                    Log::info('Redirecting unapproved dokter to pending page');
                    return redirect()->route('dokter.pending.simple');
                }
                Log::info('Redirecting approved dokter to dashboard');
                return redirect()->route('dokter.dashboard');
            }

            if ($user->role === 'admin') {
                Log::info('Redirecting admin to dashboard');
                return redirect()->route('admin.dashboard');
            }

            Log::info('Redirecting pengguna to dashboard');
            return redirect()->route('pengguna.dashboard');
        }

        return $next($request);
    }
}