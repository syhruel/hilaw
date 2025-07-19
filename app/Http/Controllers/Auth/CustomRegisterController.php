<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CustomRegisterController extends Controller
{
    public function showDokterForm()
    {
        return view('auth.register-dokter');
    }

    public function registerDokter(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'foto' => 'required|image|max:10240', // 10MB
            'keahlian' => 'required|string|max:255',
            'pengalaman' => 'required|string',
            'lulusan_universitas' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('dokter-photos', 'public');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'dokter',
            'is_approved' => false,
            'foto' => $fotoPath,
            'keahlian' => $request->keahlian,
            'pengalaman' => $request->pengalaman,
            'lulusan_universitas' => $request->lulusan_universitas,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Tunggu persetujuan admin.');
    }
}