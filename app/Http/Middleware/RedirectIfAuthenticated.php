<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                Log::info('RedirectIfAuthenticated middleware triggered', [
                    'user_id' => $user->id,
                    'role' => $user->role,
                    'current_route' => $request->route()?->getName(),
                    'current_path' => $request->path(),
                    'email_verified' => $user->hasVerifiedEmail()
                ]);

                // Only redirect if user is accessing auth pages (login, register, etc)
                $authRoutes = [
                    'login', 
                    'register', 
                    'register.dokter',
                    'password.request', 
                    'password.reset'
                ];
                
                $currentRoute = $request->route()?->getName();
                
                // If user is accessing auth routes, redirect them to their dashboard
                if (in_array($currentRoute, $authRoutes)) {
                    
                    // If email not verified, let them access verification pages
                    if (!$user->hasVerifiedEmail()) {
                        Log::info('User email not verified, allowing access to auth pages');
                        return $next($request);
                    }
                    
                    // Redirect verified users to their appropriate dashboard
                    switch ($user->role) {
                        case 'admin':
                            Log::info('Redirecting authenticated admin from auth page');
                            return redirect()->route('admin.dashboard');
                            
                        case 'dokter':
                            if (!$user->is_approved) {
                                Log::info('Redirecting unapproved dokter from auth page');
                                return redirect()->route('dokter.pending');
                            }
                            Log::info('Redirecting approved dokter from auth page');
                            return redirect()->route('dokter.dashboard');
                            
                        case 'pengguna':
                        default:
                            Log::info('Redirecting pengguna from auth page');
                            return redirect()->route('pengguna.dashboard');
                    }
                }
            }
        }

        return $next($request);
    }
}