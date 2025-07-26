<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = auth()->user();

        \Log::info('Login successful', [
            'user_id' => $user->id,
            'role' => $user->role,
            'is_approved' => $user->is_approved ?? 'null'
        ]);

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } 
        elseif ($user->role === 'dokter') {
            if (!$user->is_approved) {
                return redirect()->route('dokter.pending.simple');
            }
            return redirect()->route('dokter.dashboard');
        } 
        else {
            return redirect()->route('pengguna.dashboard');
        }
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}