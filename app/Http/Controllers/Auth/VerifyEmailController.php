<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended('/dashboard?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        $user = $request->user();
        \Log::info('Email verified successfully', [
            'user_id' => $user->id,
            'role' => $user->role,
            'email' => $user->email
        ]);

        // Redirect berdasarkan role setelah verifikasi
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Email berhasil diverifikasi!');
        } 
        elseif ($user->role === 'dokter') {
            if (!$user->is_approved) {
                return redirect()->route('dokter.pending')
                    ->with('success', 'Email berhasil diverifikasi! Silakan lengkapi profil Anda.');
            }
            return redirect()->route('dokter.dashboard')
                ->with('success', 'Email berhasil diverifikasi!');
        } 
        else {
            return redirect()->route('pengguna.dashboard')
                ->with('success', 'Email berhasil diverifikasi!');
        }
    }
}
