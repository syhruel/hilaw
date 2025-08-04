<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        // Authenticate the user
        $request->authenticate();
        
        // Regenerate session to prevent session fixation attacks
        $request->session()->regenerate();

        $user = auth()->user();

        Log::info('User login attempt', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
            'email_verified' => $user->hasVerifiedEmail(),
            'is_approved' => $user->is_approved ?? 'N/A'
        ]);

        // Check if email is verified
        if (!$user->hasVerifiedEmail()) {
            Log::info('User email not verified, logging out');
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('login')
                ->with('error', 'Silakan verifikasi email Anda terlebih dahulu sebelum login.');
        }

        // Redirect based on user role - NO intended() to prevent loops
        switch ($user->role) {
            case 'admin':
                Log::info('Redirecting admin to dashboard');
                return redirect()->route('admin.dashboard');
                
            case 'dokter':
                if (!$user->is_approved) {
                    Log::info('Redirecting unapproved dokter to pending page');
                    return redirect()->route('dokter.pending');
                }
                Log::info('Redirecting approved dokter to dashboard');
                return redirect()->route('dokter.dashboard');
                
            case 'pengguna':
            default:
                Log::info('Redirecting pengguna to dashboard');
                return redirect()->route('pengguna.dashboard');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Log::info('User logging out', [
            'user_id' => auth()->id(),
            'email' => auth()->user()->email ?? 'unknown'
        ]);

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }
}