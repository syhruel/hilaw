<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DokterProfileController extends Controller
{
    public function show()
    {
        $dokter = Auth::user();
        return view('dokter.profile.show', compact('dokter'));
    }

    public function edit()
    {
        $dokter = Auth::user();
        return view('dokter.profile.edit', compact('dokter'));
    }

    public function update(Request $request)
    {
        $dokter = Auth::user();
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($dokter->id)],
            'keahlian' => ['required', 'string', 'max:255'],
            'lulusan_universitas' => ['required', 'string', 'max:255'],
            'pengalaman' => ['required', 'string'],
            'alamat' => ['required', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:10240'], // 10MB max
            'current_password' => ['nullable', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama dokter wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'keahlian.required' => 'Keahlian wajib diisi',
            'lulusan_universitas.required' => 'Lulusan universitas wajib diisi',
            'pengalaman.required' => 'Pengalaman wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format foto harus JPG, JPEG, atau PNG',
            'foto.max' => 'Ukuran foto maksimal 10MB',
            'current_password.required_with' => 'Password saat ini wajib diisi untuk mengubah password',
            'password.min' => 'Password baru minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($request->filled('password')) {
            if (!$request->filled('current_password')) {
                return back()->withErrors(['current_password' => 'Password saat ini wajib diisi untuk mengubah password']);
            }
            
            if (!Hash::check($request->current_password, $dokter->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak benar']);
            }
        }

        $dokter->name = $request->name;
        $dokter->email = $request->email;
        $dokter->keahlian = $request->keahlian;
        $dokter->lulusan_universitas = $request->lulusan_universitas;
        $dokter->pengalaman = $request->pengalaman;
        $dokter->alamat = $request->alamat;

        if ($request->filled('password')) {
            $dokter->password = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            if ($dokter->foto) {
                Storage::disk('public')->delete($dokter->foto);
            }
            
            $fotoPath = $request->file('foto')->store('dokter/foto', 'public');
            $dokter->foto = $fotoPath;
        }

        $dokter->save();

        return redirect()->route('dokter.profile.show')->with('success', 'Profil berhasil diperbarui');
    }

    public function deletePhoto()
    {
        $dokter = Auth::user();
        
        if ($dokter->foto) {
            Storage::disk('public')->delete($dokter->foto);
            
            $dokter->foto = null;
            $dokter->save();
            
            return redirect()->route('dokter.profile.edit')->with('success', 'Foto profil berhasil dihapus');
        }
        
        return redirect()->route('dokter.profile.edit')->with('error', 'Tidak ada foto untuk dihapus');
    }
}