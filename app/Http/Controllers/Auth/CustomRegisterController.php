<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CustomRegisterController extends Controller
{
    public function showDokterForm()
    {
        return view('auth.register-dokter');
    }

    public function registerDokter(Request $request)
    {
        \Log::info('=== DOKTER REGISTRATION START ===', [
            'email' => $request->email
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password wajib diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'dokter',
            'is_approved' => false,
            'approval_status' => 'pending',
        ]);

        \Log::info('Dokter created', [
            'user_id' => $user->id,
            'role' => $user->role,
            'email' => $user->email,
            'is_approved' => $user->is_approved
        ]);

        // Kirim email verification
        event(new Registered($user));
        
        // Login user
        Auth::login($user);

        \Log::info('=== REDIRECTING DOKTER TO EMAIL VERIFICATION ===');

        // Redirect ke halaman verifikasi email
        return redirect()->route('verification.notice')
            ->with('success', 'Registrasi berhasil! Silakan verifikasi email Anda terlebih dahulu sebelum melengkapi profil.');
    }
}
