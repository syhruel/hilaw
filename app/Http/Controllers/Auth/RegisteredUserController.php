<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan halaman registrasi.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Proses registrasi pengguna biasa.
     */
    public function store(Request $request): RedirectResponse
    {
        \Log::info('=== REGISTRATION START ===', [
            'email' => $request->email,
            'role' => $request->role ?? 'pengguna'
        ]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password wajib diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pengguna', 
            'phone' => null, 
            'gender' => null, 
            'date_of_birth' => null, 
            'foto' => null, 
            'is_suspended' => false, // Default tidak suspended
            'last_active_at' => now(), 
            // Field untuk dokter (set default values)
            'is_approved' => false,
            'was_pending' => false,
            'rejection_reason' => null,
            'is_online' => false,
            'tarif_konsultasi' => null,
            'jadwal_kerja' => null,
            'keahlian' => null,
            'lulusan_universitas' => null,
            'alamat' => null,
            'pengalaman_tahun' => null,
            'pengalaman_deskripsi' => null,
            'sertifikat' => null,
        ]);

        \Log::info('Pengguna created', [
            'user_id' => $user->id,
            'role' => $user->role,
            'email' => $user->email,
            'is_suspended' => $user->is_suspended,
            'last_active_at' => $user->last_active_at
        ]);

        // Kirim email verification
        event(new Registered($user));
        
        // Login user
        Auth::login($user);

        \Log::info('=== REDIRECTING TO EMAIL VERIFICATION ===');
        
        // Redirect ke halaman verifikasi email
        return redirect()->route('verification.notice')
            ->with('success', 'Registrasi berhasil! Silakan cek email Anda untuk memverifikasi akun.');
    }
}