<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\ProfileChange;
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
        
        $certificateStatus = $this->getCertificateStatus($dokter->id);
        
        return view('dokter.profile.show', compact('dokter', 'certificateStatus'));
    }

    public function edit()
    {
        $dokter = Auth::user();
        
        $jadwalParsed = $this->parseJadwalKerja($dokter->jadwal_kerja);
        
        $pendingChanges = $dokter->profileChanges()
            ->where('status', 'pending')
            ->latest()
            ->get();
        
        $certificateStatus = $this->getCertificateStatus($dokter->id);
        
        return view('dokter.profile.edit', compact('dokter', 'jadwalParsed', 'pendingChanges', 'certificateStatus'));
    }

    private function getCertificateStatus($userId)
    {
        $recentChange = ProfileChange::where('user_id', $userId)
            ->whereIn('status', ['approved', 'rejected'])
            ->where('changes', 'LIKE', '%sertifikat%')
            ->latest()
            ->first();

        if (!$recentChange) {
            return null;
        }

        $changes = $recentChange->changes; 
        
        if (!isset($changes['sertifikat'])) {
            return null;
        }

        if ($recentChange->status === 'approved') {
            if ($changes['sertifikat'] === null) {
                return [
                    'type' => 'success',
                    'message' => 'Penghapusan sertifikat telah disetujui admin',
                    'date' => $recentChange->approved_at
                ];
            } else {
                return [
                    'type' => 'success', 
                    'message' => 'Upload sertifikat telah disetujui admin',
                    'date' => $recentChange->approved_at
                ];
            }
        } elseif ($recentChange->status === 'rejected') {
            return [
                'type' => 'danger',
                'message' => 'Pengajuan sertifikat ditolak: ' . $recentChange->rejection_reason,
                'date' => $recentChange->rejected_at
            ];
        }

        return null;
    }

    public function update(Request $request)
    {
        $dokter = Auth::user();
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($dokter->id)],
            'keahlian' => ['required', 'string', 'max:255'],
            'lulusan_universitas' => ['required', 'string', 'max:255'],
            'pengalaman_tahun' => ['nullable', 'integer', 'min:0', 'max:50'],
            'pengalaman_deskripsi' => ['nullable', 'string'],
            'alamat' => ['required', 'string'],
            'tarif_konsultasi' => ['required', 'numeric', 'min:0'],
            
            'hari_mulai' => ['required', 'string', 'in:senin,selasa,rabu,kamis,jumat,sabtu,minggu'],
            'hari_berakhir' => ['nullable', 'string', 'in:senin,selasa,rabu,kamis,jumat,sabtu,minggu'],
            'jam_mulai' => ['required', 'string', 'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/'],
            'jam_berakhir' => ['required', 'string', 'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/'],
            
            'foto' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:10240'],
            'sertifikat' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'current_password' => ['nullable', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if ($request->filled('hari_berakhir')) {
            $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
            $hariMulaiIndex = array_search($request->hari_mulai, $days);
            $hariBerakhirIndex = array_search($request->hari_berakhir, $days);
            
            if ($hariBerakhirIndex <= $hariMulaiIndex) {
                return back()->withErrors(['hari_berakhir' => 'Hari berakhir harus setelah hari mulai']);
            }
        }

        if ($request->jam_mulai >= $request->jam_berakhir) {
            return back()->withErrors(['jam_berakhir' => 'Jam berakhir harus setelah jam mulai']);
        }

        if ($request->filled('password')) {
            if (!$request->filled('current_password')) {
                return back()->withErrors(['current_password' => 'Password saat ini wajib diisi untuk mengubah password']);
            }
            
            if (!Hash::check($request->current_password, $dokter->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak benar']);
            }
        }

        $hasPendingSertifikat = ProfileChange::where('user_id', $dokter->id)
            ->where('status', 'pending')
            ->where('changes', 'LIKE', '%sertifikat%')
            ->exists();

        if ($hasPendingSertifikat && $request->hasFile('sertifikat')) {
            return back()->withErrors(['sertifikat' => 'Anda masih memiliki pengajuan sertifikat yang menunggu persetujuan admin. Tunggu hingga disetujui sebelum mengupload sertifikat baru.']);
        }

        if ($request->hasFile('sertifikat')) {
            return $this->submitSertifikatForApproval($request, $dokter);
        } else {
            return $this->updateProfileDirectly($request, $dokter);
        }
    }

    private function submitSertifikatForApproval(Request $request, $dokter)
    {
        $this->updateBasicData($request, $dokter);
        
        $sertifikatPath = $request->file('sertifikat')->store('dokter/sertifikat/pending', 'public');
        
        ProfileChange::create([
            'user_id' => $dokter->id,
            'changes' => json_encode(['sertifikat' => $sertifikatPath]),
            'old_data' => json_encode(['sertifikat' => $dokter->sertifikat]),
            'status' => 'pending',
        ]);
        
        return redirect()->route('dokter.profile.show')
            ->with('success', 'Profil berhasil diperbarui.')
            ->with('info', 'Upload sertifikat menunggu persetujuan admin. Anda akan mendapat notifikasi setelah disetujui.');
    }

    private function updateProfileDirectly(Request $request, $dokter)
    {
        $this->updateBasicData($request, $dokter);
        
        return redirect()->route('dokter.profile.show')
            ->with('success', 'Profil berhasil diperbarui');
    }

    private function updateBasicData(Request $request, $dokter)
    {
        $dokter->name = $request->name;
        $dokter->email = $request->email;
        $dokter->keahlian = $request->keahlian;
        $dokter->lulusan_universitas = $request->lulusan_universitas;
        $dokter->alamat = $request->alamat;
        $dokter->tarif_konsultasi = $request->tarif_konsultasi;
        
        if ($request->filled('pengalaman_tahun')) {
            $dokter->pengalaman_tahun = $request->pengalaman_tahun;
        }
        
        if ($request->filled('pengalaman_deskripsi')) {
            $dokter->pengalaman_deskripsi = $request->pengalaman_deskripsi;
        }
        
        $dokter->jadwal_kerja = $this->generateJadwalKerja($request);
        
        if ($request->hasFile('foto')) {
            if ($dokter->foto) {
                Storage::disk('public')->delete($dokter->foto);
            }
            $dokter->foto = $request->file('foto')->store('dokter/foto', 'public');
        }
        
        if ($request->filled('password')) {
            $dokter->password = Hash::make($request->password);
        }
        
        $dokter->save();
    }

    private function generateJadwalKerja(Request $request)
    {
        $hariIndonesia = [
            'senin' => 'Senin',
            'selasa' => 'Selasa', 
            'rabu' => 'Rabu',
            'kamis' => 'Kamis',
            'jumat' => 'Jumat',
            'sabtu' => 'Sabtu',
            'minggu' => 'Minggu'
        ];

        $hariMulai = $hariIndonesia[$request->hari_mulai];
        $jamMulai = $request->jam_mulai;
        $jamBerakhir = $request->jam_berakhir;

        if ($request->filled('hari_berakhir')) {
            $hariBerakhir = $hariIndonesia[$request->hari_berakhir];
            return "{$hariMulai} - {$hariBerakhir}: {$jamMulai} - {$jamBerakhir}";
        } else {
            return "{$hariMulai}: {$jamMulai} - {$jamBerakhir}";
        }
    }

    public function parseJadwalKerja($jadwalKerja)
    {
        $hariIndonesia = [
            'Senin' => 'senin',
            'Selasa' => 'selasa',
            'Rabu' => 'rabu', 
            'Kamis' => 'kamis',
            'Jumat' => 'jumat',
            'Sabtu' => 'sabtu',
            'Minggu' => 'minggu'
        ];

        $parsed = [
            'hari_mulai' => '',
            'hari_berakhir' => '',
            'jam_mulai' => '',
            'jam_berakhir' => ''
        ];

        if (empty($jadwalKerja)) {
            return $parsed;
        }

        // Pattern for range of days: "Senin - Jumat: 08:00 - 17:00"
        if (preg_match('/^(\w+)\s*-\s*(\w+):\s*(\d{2}:\d{2})\s*-\s*(\d{2}:\d{2})$/', $jadwalKerja, $matches)) {
            $parsed['hari_mulai'] = $hariIndonesia[$matches[1]] ?? '';
            $parsed['hari_berakhir'] = $hariIndonesia[$matches[2]] ?? '';
            $parsed['jam_mulai'] = $matches[3];
            $parsed['jam_berakhir'] = $matches[4];
        }
        // Pattern for single day: "Senin: 08:00 - 17:00"
        elseif (preg_match('/^(\w+):\s*(\d{2}:\d{2})\s*-\s*(\d{2}:\d{2})$/', $jadwalKerja, $matches)) {
            $parsed['hari_mulai'] = $hariIndonesia[$matches[1]] ?? '';
            $parsed['jam_mulai'] = $matches[2];
            $parsed['jam_berakhir'] = $matches[3];
        }

        return $parsed;
    }

    public function deletePhoto()
    {
        $dokter = Auth::user();
        
        if ($dokter->foto) {
            Storage::disk('public')->delete($dokter->foto);
            $dokter->foto = null;
            $dokter->save();
            
            return redirect()->route('dokter.profile.edit')
                ->with('success', 'Foto profil berhasil dihapus');
        }
        
        return redirect()->route('dokter.profile.edit')
            ->with('error', 'Tidak ada foto untuk dihapus');
    }

    public function deleteCertificate()
    {
        $dokter = Auth::user();
        
        if (!$dokter->sertifikat) {
            return redirect()->route('dokter.profile.edit')
                ->with('error', 'Tidak ada sertifikat untuk dihapus');
        }

        $hasPending = ProfileChange::where('user_id', $dokter->id)
            ->where('status', 'pending')
            ->where('changes', 'LIKE', '%sertifikat%')
            ->exists();

        if ($hasPending) {
            return redirect()->route('dokter.profile.edit')
                ->with('error', 'Anda masih memiliki pengajuan sertifikat yang menunggu persetujuan. Tunggu hingga disetujui sebelum mengajukan penghapusan.');
        }

        ProfileChange::create([
            'user_id' => $dokter->id,
            'changes' => json_encode(['sertifikat' => null]),
            'old_data' => json_encode(['sertifikat' => $dokter->sertifikat]),
            'status' => 'pending',
        ]);
        
        return redirect()->route('dokter.profile.edit')
            ->with('info', 'Pengajuan penghapusan sertifikat telah dikirim dan menunggu persetujuan admin.');
    }
}