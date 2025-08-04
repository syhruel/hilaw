<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PendingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        \Log::info('Pending page access attempt', [
            'user_id' => $user->id,
            'role' => $user->role,
            'email_verified' => $user->hasVerifiedEmail(),
            'is_approved' => $user->is_approved
        ]);
        
        // Pastikan user adalah dokter
        if ($user->role !== 'dokter') {
            return redirect()->route('dashboard');
        }
        
        // Jika email belum diverifikasi, redirect ke verification
        if (!$user->hasVerifiedEmail()) {
            \Log::info('Email not verified, redirecting to verification');
            return redirect()->route('verification.notice')
                ->with('info', 'Silakan verifikasi email Anda terlebih dahulu.');
        }
        
        // Jika sudah diapprove, redirect ke dashboard dokter
        if ($user->is_approved) {
            \Log::info('Doctor already approved, redirecting to dashboard');
            return redirect()->route('dokter.dashboard');
        }
        
        return view('dokter.pending', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        // Pastikan email sudah diverifikasi
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice')
                ->with('error', 'Silakan verifikasi email Anda terlebih dahulu.');
        }
        
        // Pastikan user adalah dokter dan belum diapprove
        if ($user->role !== 'dokter' || $user->is_approved) {
            return redirect()->route('dashboard');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|numeric',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'nullable|date|before:today',
            'keahlian' => 'required|string|max:255',
            'lulusan_universitas' => 'required|string|max:255',
            'alamat' => 'required|string',
            'pengalaman_tahun' => 'required|integer|min:0|max:50',
            'pengalaman_deskripsi' => 'required|string',
            'tarif_konsultasi' => 'required|numeric|min:0',
            'hari_mulai' => 'required|string|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'hari_selesai' => 'nullable|string|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'jam_mulai' => 'required|string',
            'jam_selesai' => 'required|string',
            'foto' => $user->foto ? 'nullable|image|mimes:jpeg,png,jpg|max:10240' : 'required|image|mimes:jpeg,png,jpg|max:10240',
            'sertifikat' => $user->sertifikat ? 'nullable|file|mimes:pdf,jpeg,png,jpg|max:10240' : 'required|file|mimes:pdf,jpeg,png,jpg|max:10240',
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah digunakan',
            'phone.required' => 'Nomor telepon wajib diisi',
            'phone.numeric' => 'Nomor telepon harus berupa angka',
            'gender.required' => 'Jenis kelamin wajib dipilih',
            'gender.in' => 'Jenis kelamin harus laki-laki atau perempuan',
            'date_of_birth.date' => 'Tanggal lahir harus berupa tanggal yang valid',
            'date_of_birth.before' => 'Tanggal lahir harus sebelum hari ini',
            'keahlian.required' => 'Spesialisasi/Keahlian wajib diisi',
            'lulusan_universitas.required' => 'Lulusan universitas wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'pengalaman_tahun.required' => 'Pengalaman tahun wajib diisi',
            'pengalaman_deskripsi.required' => 'Deskripsi pengalaman wajib diisi',
            'tarif_konsultasi.required' => 'Tarif konsultasi wajib diisi',
            'tarif_konsultasi.numeric' => 'Tarif konsultasi harus berupa angka',
            'tarif_konsultasi.min' => 'Tarif konsultasi minimal 0',
            'hari_mulai.required' => 'Hari mulai wajib dipilih',
            'jam_mulai.required' => 'Jam mulai wajib diisi',
            'jam_selesai.required' => 'Jam selesai wajib diisi',
            'foto.required' => 'Foto profil wajib diupload',
            'foto.image' => 'File foto harus berupa gambar',
            'foto.mimes' => 'Foto harus berformat JPEG, PNG, atau JPG',
            'foto.max' => 'Ukuran foto maksimal 10MB',
            'sertifikat.required' => 'Sertifikat wajib diupload',
            'sertifikat.mimes' => 'Sertifikat harus berformat PDF, JPEG, PNG, atau JPG',
            'sertifikat.max' => 'Ukuran sertifikat maksimal 10MB',
            'pengalaman_tahun.integer' => 'Pengalaman tahun harus berupa angka',
            'pengalaman_tahun.min' => 'Pengalaman tahun minimal 0',
            'pengalaman_tahun.max' => 'Pengalaman tahun maksimal 50',
        ]);

        // Format jadwal kerja - PERBAIKAN: Format yang konsisten dengan tampilan admin
        $jadwal_kerja = ucfirst($request->hari_mulai); // Kapitalisasi huruf pertama
        if ($request->hari_selesai && $request->hari_selesai !== $request->hari_mulai) {
            $jadwal_kerja .= '-' . ucfirst($request->hari_selesai);
        }
        $jadwal_kerja .= ': ' . $request->jam_mulai . ' - ' . $request->jam_selesai; // Tambah titik dua dan spasi

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone, // PERBAIKAN: Pastikan phone disimpan
            'gender' => $request->gender, // PERBAIKAN: Pastikan gender disimpan
            'date_of_birth' => $request->date_of_birth ? $request->date_of_birth : null, // PERBAIKAN: Pastikan date_of_birth disimpan
            'keahlian' => $request->keahlian,
            'lulusan_universitas' => $request->lulusan_universitas,
            'alamat' => $request->alamat,
            'pengalaman_tahun' => (int) $request->pengalaman_tahun,
            'pengalaman_deskripsi' => $request->pengalaman_deskripsi,
            'tarif_konsultasi' => (float) $request->tarif_konsultasi,
            'jadwal_kerja' => $jadwal_kerja,
            // PERBAIKAN: Simpan hari_mulai, hari_selesai, jam_mulai, jam_selesai untuk referensi edit form
            'hari_mulai' => $request->hari_mulai,
            'hari_selesai' => $request->hari_selesai,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'approval_status' => 'pending', // Reset status ke pending jika data diupdate
            'rejection_reason' => null, // Clear rejection reason
        ];

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }
            
            $foto = $request->file('foto');
            // PERBAIKAN: Gunakan path yang konsisten dengan admin
            $fotoPath = $foto->store('dokter-photos', 'public');
            $updateData['foto'] = $fotoPath;
        }

        // Handle sertifikat upload
        if ($request->hasFile('sertifikat')) {
            // Hapus sertifikat lama jika ada
            if ($user->sertifikat && Storage::disk('public')->exists($user->sertifikat)) {
                Storage::disk('public')->delete($user->sertifikat);
            }
            
            $sertifikat = $request->file('sertifikat');
            // PERBAIKAN: Gunakan path yang konsisten dengan admin
            $sertifikatPath = $sertifikat->store('dokter/sertifikat/approved', 'public');
            $updateData['sertifikat'] = $sertifikatPath;
        }

        // Update user data
        $user->update($updateData);

        \Log::info('Doctor profile updated', [
            'user_id' => $user->id,
            'updated_fields' => array_keys($updateData),
            'phone' => $updateData['phone'],
            'gender' => $updateData['gender'],
            'date_of_birth' => $updateData['date_of_birth'],
            'tarif_konsultasi' => $updateData['tarif_konsultasi'],
            'jadwal_kerja' => $updateData['jadwal_kerja']
        ]);

        return redirect()->route('dokter.pending')
            ->with('success', 'Profil berhasil diperbarui. Menunggu persetujuan admin.');
    }
}