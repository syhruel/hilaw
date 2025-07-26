<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PendingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        \Log::info('User fields:', $user->toArray());
        
        if (!$user || $user->role !== 'dokter') {
            return redirect('/')->with('error', 'Akses ditolak');
        }

        if ($user->is_approved && $user->was_pending && $user->approval_status === 'approved') {

            $user->update(['was_pending' => false]);
            
            return redirect()->route('dokter.dashboard')
                ->with('success', 'Selamat! Akun Anda telah disetujui oleh admin. Selamat datang di dashboard dokter!');
        }

        if ($user->is_approved) {
            return redirect()->route('dokter.dashboard');
        }

        return view('dokter.pending', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        if (!$user || $user->role !== 'dokter') {
            return redirect('/')->with('error', 'Akses ditolak');
        }

        if ($user->is_approved) {
            return redirect()->route('dokter.dashboard');
        }

        \Log::info('Request data:', $request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email', 
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'foto' => $user->foto ? 'nullable|image|mimes:jpeg,png,jpg|max:10240' : 'required|image|mimes:jpeg,png,jpg|max:10240',
            'keahlian' => 'required|string|max:255',
            'pengalaman_tahun' => 'required|integer|min:0|max:50',
            'pengalaman_deskripsi' => 'required|string',
            'lulusan_universitas' => 'required|string|max:255',
            'alamat' => 'required|string',
            'tarif_konsultasi' => 'required|numeric|min:0',
            'hari_mulai' => 'required|string',
            'hari_selesai' => 'nullable|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'sertifikat' => $user->sertifikat ? 'nullable|file|mimes:pdf,jpeg,png,jpg|max:10240' : 'required|file|mimes:pdf,jpeg,png,jpg|max:10240',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'keahlian' => $request->keahlian,
            'pengalaman_tahun' => $request->pengalaman_tahun,
            'pengalaman_deskripsi' => $request->pengalaman_deskripsi,
            'lulusan_universitas' => $request->lulusan_universitas,
            'alamat' => $request->alamat,
            'tarif_konsultasi' => $request->tarif_konsultasi,
            'approval_status' => 'pending',
            'is_approved' => false,
            'rejection_reason' => null,
            'was_pending' => true,
        ];

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $updateData['foto'] = $request->file('foto')->store('dokter-photos', 'public');
        }

        if ($request->hasFile('sertifikat')) {
            if ($user->sertifikat) {
                Storage::disk('public')->delete($user->sertifikat);
            }
            $updateData['sertifikat'] = $request->file('sertifikat')->store('dokter-certificates', 'public');
        }

        $jadwal_kerja = $request->hari_mulai;
        if ($request->filled('hari_selesai') && $request->hari_selesai !== $request->hari_mulai) {
            $jadwal_kerja .= '-' . $request->hari_selesai;
        }
        $jadwal_kerja .= ' ' . $request->jam_mulai . '-' . $request->jam_selesai;
        $updateData['jadwal_kerja'] = $jadwal_kerja;

        \Log::info('Data akan diupdate:', $updateData);

        try {
            $user->update($updateData);
            \Log::info('Update berhasil');
            
            $user->refresh();
            \Log::info('Data setelah update:', $user->toArray());
            
        } catch (\Exception $e) {
            \Log::error('Error update:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }

        return redirect()->route('dokter.pending')->with('success', 'Data profil berhasil dikirim untuk persetujuan admin.');
    }

    public function parseJadwalKerja($jadwal_kerja)
    {
        if (!$jadwal_kerja) {
            return [
                'hari_mulai' => null,
                'hari_selesai' => null,
                'jam_mulai' => null,
                'jam_selesai' => null,
            ];
        }

        // Format: "senin 08:00-17:00" atau "senin-jumat 08:00-17:00"
        $parts = explode(' ', $jadwal_kerja);
        $hari = $parts[0] ?? '';
        $jam = $parts[1] ?? '';

        $hari_parts = explode('-', $hari);
        $hari_mulai = $hari_parts[0] ?? '';
        $hari_selesai = isset($hari_parts[1]) ? $hari_parts[1] : null;

        $jam_parts = explode('-', $jam);
        $jam_mulai = $jam_parts[0] ?? '';
        $jam_selesai = $jam_parts[1] ?? '';

        return [
            'hari_mulai' => $hari_mulai,
            'hari_selesai' => $hari_selesai,
            'jam_mulai' => $jam_mulai,
            'jam_selesai' => $jam_selesai,
        ];
    }
}