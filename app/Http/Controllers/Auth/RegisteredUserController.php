<?php
// RegisteredUserController.php - FIXED
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
     * Proses registrasi.
     */
    public function store(Request $request): RedirectResponse
    {
        \Log::info('=== REGISTRATION START ===', [
            'email' => $request->email,
            'role' => $request->role
        ]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:pengguna,dokter'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_approved' => $request->role === 'dokter' ? false : true,
        ]);

        \Log::info('User created', [
            'user_id' => $user->id,
            'role' => $user->role,
            'is_approved' => $user->is_approved
        ]);

        event(new Registered($user));
        Auth::login($user);

        \Log::info('User logged in', [
            'auth_check' => auth()->check(),
            'auth_user_id' => auth()->id()
        ]);

        if ($user->role === 'pengguna') {
            \Log::info('=== REDIRECTING PENGGUNA ===');
            return redirect()->route('pengguna.dashboard')->with('success', 'Registrasi berhasil!');
        }
        
        if ($user->role === 'dokter' && !$user->is_approved) {
            \Log::info('=== REDIRECTING DOKTER TO PENDING ===');
            return redirect()->route('dokter.pending.simple')
                ->with('success', 'Registrasi berhasil! Akun Anda sedang menunggu persetujuan admin.');
        }
        
        if ($user->role === 'dokter' && $user->is_approved) {
            \Log::info('=== REDIRECTING APPROVED DOKTER ===');
            return redirect()->route('dokter.dashboard')->with('success', 'Registrasi berhasil!');
        }
        
        if ($user->role === 'admin') {
            \Log::info('=== REDIRECTING ADMIN ===');
            return redirect()->route('admin.dashboard')->with('success', 'Registrasi berhasil!');
        }

        \Log::warning('=== FALLBACK REDIRECT ===', ['role' => $user->role]);
        return redirect('/dashboard');
    }
}