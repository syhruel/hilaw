<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Carbon\Carbon;

class PenggunaManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'pengguna');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by verification status
        if ($request->filled('verified')) {
            if ($request->verified == '1') {
                $query->whereNotNull('email_verified_at');
            } else {
                $query->whereNull('email_verified_at');
            }
        }

        // Filter by suspended status
        if ($request->filled('suspended')) {
            if ($request->suspended == '1') {
                $query->where('is_suspended', true);
            } else {
                $query->where('is_suspended', false);
            }
        }

        // Filter by active status
        if ($request->filled('active')) {
            if ($request->active == '1') {
                // Active in last 5 minutes
                $query->where('last_active_at', '>=', now()->subMinutes(5));
            } else {
                $query->where(function($q) {
                    $q->whereNull('last_active_at')
                      ->orWhere('last_active_at', '<', now()->subMinutes(5));
                });
            }
        }

        $pengguna = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.pengguna.index', compact('pengguna'));
    }

    public function create()
    {
        return view('admin.pengguna.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', 'in:male,female'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pengguna',
            'phone' => $request->phone,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'is_suspended' => false, // default tidak suspended
            'last_active_at' => now(), // set saat pertama kali dibuat
            // Field untuk konsistensi dengan registrasi mandiri
            'is_approved' => false,
            'was_pending' => false,
            'approval_status' => null,
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
        ];

        // Auto verify email if requested
        if ($request->auto_verify) {
            $data['email_verified_at'] = now();
        }

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('pengguna/foto', 'public');
        }

        $user = User::create($data);

        return redirect()->route('admin.pengguna.index')
                         ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function show(User $pengguna)
    {
        // Pastikan ini adalah pengguna dengan role 'pengguna'
        if ($pengguna->role !== 'pengguna') {
            abort(404);
        }

        return view('admin.pengguna.show', compact('pengguna'));
    }

    public function edit(User $pengguna)
    {
        // Pastikan ini adalah pengguna dengan role 'pengguna'
        if ($pengguna->role !== 'pengguna') {
            abort(404);
        }

        return view('admin.pengguna.edit', compact('pengguna'));
    }

    public function update(Request $request, User $pengguna)
    {
        // Pastikan ini adalah pengguna dengan role 'pengguna'
        if ($pengguna->role !== 'pengguna') {
            abort(404);
        }

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $pengguna->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', 'in:male,female'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];

        // Only validate password if it's being updated
        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        $request->validate($rules);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
        ];

        // Update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Delete old foto if exists
            if ($pengguna->foto) {
                Storage::disk('public')->delete($pengguna->foto);
            }
            $data['foto'] = $request->file('foto')->store('pengguna/foto', 'public');
        }

        $pengguna->update($data);

        return redirect()->route('admin.pengguna.index')
                         ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $pengguna)
    {
        // Pastikan ini adalah pengguna dengan role 'pengguna'
        if ($pengguna->role !== 'pengguna') {
            abort(404);
        }

        // Delete foto if exists
        if ($pengguna->foto) {
            Storage::disk('public')->delete($pengguna->foto);
        }

        $pengguna->delete();

        return redirect()->route('admin.pengguna.index')
                         ->with('success', 'Pengguna berhasil dihapus.');
    }

    public function verifyEmail(User $pengguna)
    {
        if ($pengguna->role !== 'pengguna') {
            abort(404);
        }

        $pengguna->update([
            'email_verified_at' => now()
        ]);

        return redirect()->back()
                         ->with('success', 'Email pengguna berhasil diverifikasi.');
    }

    public function unverifyEmail(User $pengguna)
    {
        if ($pengguna->role !== 'pengguna') {
            abort(404);
        }

        $pengguna->update([
            'email_verified_at' => null
        ]);

        return redirect()->back()
                         ->with('success', 'Verifikasi email pengguna berhasil dibatalkan.');
    }

    public function deletePhoto(User $pengguna)
    {
        if ($pengguna->role !== 'pengguna') {
            abort(404);
        }

        if ($pengguna->foto) {
            Storage::disk('public')->delete($pengguna->foto);
            $pengguna->update(['foto' => null]);
        }

        return redirect()->back()
                         ->with('success', 'Foto pengguna berhasil dihapus.');
    }

    public function suspendUser(User $pengguna)
    {
        if ($pengguna->role !== 'pengguna') {
            abort(404);
        }

        $pengguna->update([
            'is_suspended' => true
        ]);

        return redirect()->back()
                         ->with('success', 'Pengguna berhasil disuspend.');
    }

    public function unsuspendUser(User $pengguna)
    {
        if ($pengguna->role !== 'pengguna') {
            abort(404);
        }

        $pengguna->update([
            'is_suspended' => false
        ]);

        return redirect()->back()
                         ->with('success', 'Pengguna berhasil diaktifkan kembali.');
    }
}