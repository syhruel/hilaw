<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ProfileChange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DokterManagementController extends Controller
{
    public function index()
    {
        $dokters = User::where('role', 'dokter')->get();
        return view('admin.dokter.index', compact('dokters'));
    }

    public function create()
    {
        return view('admin.dokter.create');
    }

    public function show($id)
    {
        $dokter = User::findOrFail($id);
        
        if ($dokter->role !== 'dokter') {
            abort(404);
        }

        return view('admin.dokter.show', compact('dokter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:102400',
            'sertifikat' => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:102400',
            'keahlian' => 'required|string|max:255',
            'pengalaman_tahun' => 'required|integer|min:0|max:50',
            'pengalaman_deskripsi' => 'required|string',
            'lulusan_universitas' => 'required|string|max:255',
            'alamat' => 'required|string',
            'tarif_konsultasi' => 'required|string', // Ubah ke string karena ada formatting
            'hari_mulai' => 'required|string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'hari_selesai' => 'nullable|string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'is_online' => 'boolean',
        ], [
            'name.required' => 'Nama ahli hukum wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'foto.image' => 'File foto harus berupa gambar',
            'foto.mimes' => 'Format foto harus JPEG, JPG, atau PNG',
            'foto.max' => 'Ukuran foto maksimal 10MB',
            'sertifikat.mimes' => 'Format sertifikat harus PDF, JPEG, JPG, atau PNG',
            'sertifikat.max' => 'Ukuran sertifikat maksimal 10MB',
            'keahlian.required' => 'Bidang keahlian hukum wajib diisi',
            'pengalaman_tahun.required' => 'Pengalaman tahun wajib diisi',
            'pengalaman_tahun.integer' => 'Pengalaman tahun harus berupa angka',
            'pengalaman_tahun.min' => 'Pengalaman tahun minimal 0',
            'pengalaman_tahun.max' => 'Pengalaman tahun maksimal 50',
            'pengalaman_deskripsi.required' => 'Deskripsi pengalaman wajib diisi',
            'lulusan_universitas.required' => 'Lulusan universitas wajib diisi',
            'alamat.required' => 'Alamat kantor/praktik wajib diisi',
            'tarif_konsultasi.required' => 'Tarif konsultasi wajib diisi',
            'hari_mulai.required' => 'Hari mulai wajib dipilih',
            'hari_mulai.in' => 'Hari mulai tidak valid',
            'hari_selesai.in' => 'Hari selesai tidak valid',
            'jam_mulai.required' => 'Jam mulai wajib diisi',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid',
            'jam_selesai.required' => 'Jam selesai wajib diisi',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid',
            'jam_selesai.after' => 'Jam selesai harus lebih besar dari jam mulai',
        ]);

        try {
            // Bersihkan format tarif konsultasi (hapus titik pemisah ribuan)
            $tarif_konsultasi = (float) str_replace('.', '', $request->tarif_konsultasi);

            // Handle file uploads
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $fotoName = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
                $fotoPath = $foto->storeAs('dokter-photos', $fotoName, 'public');
            }

            $sertifikatPath = null;
            if ($request->hasFile('sertifikat')) {
                $sertifikat = $request->file('sertifikat');
                $sertifikatName = time() . '_' . uniqid() . '.' . $sertifikat->getClientOriginalExtension();
                $sertifikatPath = $sertifikat->storeAs('dokter/sertifikat/approved', $sertifikatName, 'public');
            }

            // Build jadwal kerja string
            $jadwal_kerja = $request->hari_mulai;
            
            // If hari_selesai is provided and different from hari_mulai, create range
            if ($request->filled('hari_selesai') && $request->hari_selesai !== $request->hari_mulai) {
                $jadwal_kerja .= '-' . $request->hari_selesai;
            }
            
            $jadwal_kerja .= ': ' . $request->jam_mulai . ' - ' . $request->jam_selesai;

            // AUTO APPROVE: Dokter yang dibuat admin selalu langsung terverifikasi
            $isApproved = true; // Selalu true untuk dokter yang dibuat admin
            $approvalStatus = 'approved'; // Selalu approved

            // Create dokter
            $dokter = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'email_verified_at' => now(), // ✅ TAMBAHAN: Set email sebagai terverifikasi
                'password' => Hash::make($request->password),
                'role' => 'dokter',
                'is_approved' => $isApproved, // Selalu true
                'approval_status' => $approvalStatus, // Selalu approved
                'is_online' => $request->has('is_online') && $request->is_online,
                'foto' => $fotoPath,
                'sertifikat' => $sertifikatPath,
                'keahlian' => $request->keahlian,
                'pengalaman_tahun' => $request->pengalaman_tahun,
                'pengalaman_deskripsi' => $request->pengalaman_deskripsi,
                'lulusan_universitas' => $request->lulusan_universitas,
                'alamat' => $request->alamat,
                'tarif_konsultasi' => $tarif_konsultasi,
                'jadwal_kerja' => $jadwal_kerja,
                // Hapus verified_at dan verified_by karena kolom tidak ada
            ]);

            // Log the activity
            Log::info('New dokter created and auto-approved by admin', [
                'dokter_id' => $dokter->id,
                'dokter_name' => $dokter->name,
                'dokter_email' => $dokter->email,
                'created_by' => auth()->user()->name ?? 'System',
                'created_by_id' => auth()->user()->id ?? null,
                'approval_status' => $approvalStatus,
                'auto_approved' => true,
                'email_verified' => true // ✅ TAMBAHAN: Log email verification
            ]);

            $message = 'Ahli hukum "' . $dokter->name . '" berhasil ditambahkan, otomatis terverifikasi, dan email sudah diaktifkan';

            return redirect()->route('dokter.index')->with('success', $message);

        } catch (\Exception $e) {
            // Log error
            Log::error('Error creating ahli hukum: ' . $e->getMessage(), [
                'request_data' => $request->except(['password', 'foto', 'sertifikat']),
                'error_trace' => $e->getTraceAsString()
            ]);

            // Clean up uploaded files if database creation failed
            if (isset($fotoPath) && $fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
            if (isset($sertifikatPath) && $sertifikatPath && Storage::disk('public')->exists($sertifikatPath)) {
                Storage::disk('public')->delete($sertifikatPath);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan ahli hukum: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $dokter = User::findOrFail($id);
        
        if ($dokter->role !== 'dokter') {
            abort(404);
        }

        return view('admin.dokter.edit', compact('dokter'));
    }

    public function update(Request $request, $id)
    {
        $dokter = User::findOrFail($id);
        
        if ($dokter->role !== 'dokter') {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $dokter->id,
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:102400',
            'sertifikat' => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:102400',
            'keahlian' => 'required|string|max:255',
            'pengalaman_tahun' => 'required|integer|min:0|max:50',
            'pengalaman' => 'required|string', // Ubah dari pengalaman_deskripsi ke pengalaman
            'lulusan_universitas' => 'required|string|max:255',
            'alamat' => 'required|string',
            'tarif_konsultasi' => 'required|string', // Ubah ke string karena ada formatting
            'hari_mulai' => 'nullable|string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'hari_selesai' => 'nullable|string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i|after:jam_mulai',
            'is_online' => 'boolean',
        ], [
            'name.required' => 'Nama ahli hukum wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'foto.image' => 'File foto harus berupa gambar',
            'foto.mimes' => 'Format foto harus JPEG, JPG, atau PNG',
            'foto.max' => 'Ukuran foto maksimal 10MB',
            'sertifikat.mimes' => 'Format sertifikat harus PDF, JPEG, JPG, atau PNG',
            'sertifikat.max' => 'Ukuran sertifikat maksimal 10MB',
            'keahlian.required' => 'Bidang keahlian hukum wajib diisi',
            'pengalaman_tahun.required' => 'Pengalaman tahun wajib diisi',
            'pengalaman_tahun.integer' => 'Pengalaman tahun harus berupa angka',
            'pengalaman_tahun.min' => 'Pengalaman tahun minimal 0',
            'pengalaman_tahun.max' => 'Pengalaman tahun maksimal 50',
            'pengalaman.required' => 'Deskripsi pengalaman wajib diisi', // Ubah pesan error
            'lulusan_universitas.required' => 'Lulusan universitas wajib diisi',
            'alamat.required' => 'Alamat kantor/praktik wajib diisi',
            'tarif_konsultasi.required' => 'Tarif konsultasi wajib diisi',
            'hari_mulai.in' => 'Hari mulai tidak valid',
            'hari_selesai.in' => 'Hari selesai tidak valid',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid',
            'jam_selesai.after' => 'Jam selesai harus lebih besar dari jam mulai',
        ]);

        try {
            // Bersihkan format tarif konsultasi (hapus titik pemisah ribuan)
            $tarif_konsultasi = (float) str_replace('.', '', $request->tarif_konsultasi);

            // Handle file uploads
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'keahlian' => $request->keahlian,
                'pengalaman_tahun' => $request->pengalaman_tahun,
                'pengalaman_deskripsi' => $request->pengalaman, // Simpan ke pengalaman_deskripsi
                'lulusan_universitas' => $request->lulusan_universitas,
                'alamat' => $request->alamat,
                'tarif_konsultasi' => $tarif_konsultasi,
                'is_online' => $request->has('is_online') && $request->is_online,
            ];

            // Build jadwal kerja string hanya jika semua field jadwal diisi
            if ($request->filled('hari_mulai') && $request->filled('jam_mulai') && $request->filled('jam_selesai')) {
                $jadwal_kerja = $request->hari_mulai;
                
                // If hari_selesai is provided and different from hari_mulai, create range
                if ($request->filled('hari_selesai') && $request->hari_selesai !== $request->hari_mulai) {
                    $jadwal_kerja .= '-' . $request->hari_selesai;
                }
                
                $jadwal_kerja .= ': ' . $request->jam_mulai . ' - ' . $request->jam_selesai;
                $updateData['jadwal_kerja'] = $jadwal_kerja;
            }

            // Handle foto upload
            if ($request->hasFile('foto')) {
                // Delete old foto if exists
                if ($dokter->foto && Storage::disk('public')->exists($dokter->foto)) {
                    Storage::disk('public')->delete($dokter->foto);
                }
                
                $foto = $request->file('foto');
                $fotoName = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
                $fotoPath = $foto->storeAs('dokter-photos', $fotoName, 'public');
                $updateData['foto'] = $fotoPath;
            }

            // Handle sertifikat upload
            if ($request->hasFile('sertifikat')) {
                // Delete old sertifikat if exists
                if ($dokter->sertifikat && Storage::disk('public')->exists($dokter->sertifikat)) {
                    Storage::disk('public')->delete($dokter->sertifikat);
                }
                
                $sertifikat = $request->file('sertifikat');
                $sertifikatName = time() . '_' . uniqid() . '.' . $sertifikat->getClientOriginalExtension();
                $sertifikatPath = $sertifikat->storeAs('dokter/sertifikat/approved', $sertifikatName, 'public');
                $updateData['sertifikat'] = $sertifikatPath;
            }

            // Update the dokter
            $dokter->update($updateData);

            // Log the activity
            Log::info('Ahli hukum updated by admin', [
                'dokter_id' => $dokter->id,
                'dokter_name' => $dokter->name,
                'dokter_email' => $dokter->email,
                'updated_by' => auth()->user()->name ?? 'System',
                'changes' => array_keys($updateData)
            ]);

            return redirect()->route('dokter.show', $dokter->id)
                ->with('success', 'Data ahli hukum "' . $dokter->name . '" berhasil diperbarui');

        } catch (\Exception $e) {
            // Log error
            Log::error('Error updating ahli hukum: ' . $e->getMessage(), [
                'dokter_id' => $dokter->id,
                'request_data' => $request->except(['foto', 'sertifikat']),
                'error_trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data ahli hukum: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $dokter = User::findOrFail($id);
        
        if ($dokter->role !== 'dokter') {
            abort(404);
        }

        if ($dokter->foto) {
            Storage::disk('public')->delete($dokter->foto);
        }

        if ($dokter->sertifikat) {
            Storage::disk('public')->delete($dokter->sertifikat);
        }
        
        $dokter->delete();
        return redirect()->route('dokter.index')->with('success', 'Dokter berhasil dihapus');
    }

    public function approve($id)
    {
        $dokter = User::findOrFail($id);
        
        if ($dokter->role !== 'dokter') {
            abort(404);
        }
        
        $dokter->update([
            'is_approved' => true,
            'approval_status' => 'approved',
            'rejection_reason' => null 
        ]);

        return redirect()->route('dokter.show', $dokter->id)->with('success', 'Dokter berhasil disetujui');
    }

    public function reject(Request $request, $id)
    {
        $dokter = User::findOrFail($id);
        
        if ($dokter->role !== 'dokter') {
            abort(404);
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:1000'
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi',
            'rejection_reason.max' => 'Alasan penolakan maksimal 1000 karakter'
        ]);
        
        $dokter->update([
            'is_approved' => false,
            'approval_status' => 'rejected',
            'rejection_reason' => $request->rejection_reason
        ]);

        return redirect()->route('dokter.show', $dokter->id)->with('success', 'Dokter berhasil ditolak');
    }

    public function toggleOnline($id)
    {
        $dokter = User::findOrFail($id);
        
        if ($dokter->role !== 'dokter') {
            abort(404);
        }

        $dokter->update([
            'is_online' => !$dokter->is_online
        ]);

        $status = $dokter->is_online ? 'online' : 'offline';
        return redirect()->route('dokter.index')->with('success', "Status dokter berhasil diubah menjadi {$status}");
    }

    public function showJadwalHargaForm($id)
    {
        $dokter = User::findOrFail($id);
        
        if ($dokter->role !== 'dokter') {
            abort(404);
        }
        
        return view('admin.dokter.set_jadwal_harga', compact('dokter'));
    }

    public function saveJadwalHarga(Request $request, $id)
    {
        $dokter = User::findOrFail($id);
        
        if ($dokter->role !== 'dokter') {
            abort(404);
        }

        $request->validate([
            'tarif_konsultasi' => 'required|numeric|min:0',
            'hari_mulai' => 'required|string',
            'hari_selesai' => 'nullable|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $jadwal = $request->hari_mulai;
        if ($request->filled('hari_selesai') && $request->hari_selesai !== $request->hari_mulai) {
            $jadwal .= '-' . $request->hari_selesai;
        }
        $jadwal .= ' ' . $request->jam_mulai . '-' . $request->jam_selesai;

        $dokter->update([
            'tarif_konsultasi' => $request->tarif_konsultasi,
            'jadwal_kerja' => $jadwal,
        ]);

        return redirect()->route('dokter.index')->with('success', 'Tarif & Jadwal berhasil disimpan');
    }

    public function approveProfileChange($changeId)
    {
        try {
            $change = ProfileChange::findOrFail($changeId);
            $dokter = $change->user;

            $changes = $change->changes;
            $oldData = $change->old_data; 

            // Validasi data
            if (!is_array($changes) || empty($changes)) {
                return redirect()->route('dokter.index')
                    ->with('error', 'Data perubahan tidak valid atau kosong');
            }

            if (isset($changes['sertifikat'])) {
                if ($changes['sertifikat'] === null) {
                    if ($dokter->sertifikat && Storage::disk('public')->exists($dokter->sertifikat)) {
                        Storage::disk('public')->delete($dokter->sertifikat);
                    }
                    $dokter->sertifikat = null;
                } else {
                    $tempPath = $changes['sertifikat'];
                    
                    if (Storage::disk('public')->exists($tempPath)) {
                        $finalPath = str_replace('/pending/', '/approved/', $tempPath);
                        
                        $finalDir = dirname($finalPath);
                        if (!Storage::disk('public')->exists($finalDir)) {
                            Storage::disk('public')->makeDirectory($finalDir);
                        }
                        
                        Storage::disk('public')->copy($tempPath, $finalPath);
                        
                        if (isset($oldData['sertifikat']) && $oldData['sertifikat'] && Storage::disk('public')->exists($oldData['sertifikat'])) {
                            Storage::disk('public')->delete($oldData['sertifikat']);
                        }
                        
                        Storage::disk('public')->delete($tempPath);
                        
                        $dokter->sertifikat = $finalPath;
                    }
                }
                
                $dokter->save();
            }

            $change->update([
                'status' => 'approved',
                'approved_at' => now(),
                'rejection_reason' => null
            ]);

            return redirect()->route('dokter.index')
                ->with('success', 'Perubahan sertifikat dokter "' . $dokter->name . '" berhasil disetujui');

        } catch (\Exception $e) {
            Log::error('Error approving profile change: ' . $e->getMessage());
            return redirect()->route('dokter.index')
                ->with('error', 'Terjadi kesalahan saat menyetujui perubahan profil: ' . $e->getMessage());
        }
    }

    public function rejectProfileChange(Request $request, $changeId)
    {
        try {
            $request->validate([
                'rejection_reason' => 'required|string|max:500'
            ], [
                'rejection_reason.required' => 'Alasan penolakan wajib diisi',
                'rejection_reason.max' => 'Alasan penolakan maksimal 500 karakter'
            ]);

            $change = ProfileChange::findOrFail($changeId);
            
            $changes = $change->changes; 

            if (is_array($changes)) {
                if (isset($changes['foto']) && $changes['foto']) {
                    if (Storage::disk('public')->exists($changes['foto'])) {
                        Storage::disk('public')->delete($changes['foto']);
                    }
                }

                if (isset($changes['sertifikat']) && $changes['sertifikat']) {
                    if (Storage::disk('public')->exists($changes['sertifikat'])) {
                        Storage::disk('public')->delete($changes['sertifikat']);
                    }
                }
            }

            $change->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
                'approved_at' => null,
                'rejected_at' => now()
            ]);

            return redirect()->route('dokter.index')
                ->with('success', 'Perubahan profil dokter "' . $change->user->name . '" berhasil ditolak');

        } catch (\Exception $e) {
            Log::error('Error rejecting profile change: ' . $e->getMessage());
            return redirect()->route('dokter.index')
                ->with('error', 'Terjadi kesalahan saat menolak perubahan profil: ' . $e->getMessage());
        }
    }
    
    public function showProfileChange($changeId)
    {
        $change = ProfileChange::with('user')->findOrFail($changeId);
        
        $changes = $change->changes; 
        $oldData = $change->old_data; 
        
        return view('admin.dokter.profile_change_detail', compact('change', 'changes', 'oldData'));
    }

    public function pendingProfileChanges()
    {
        $pendingChanges = ProfileChange::with('user')
            ->where('status', 'pending')
            ->whereHas('user', function($query) {
                $query->where('role', 'dokter');
            })
            ->latest()
            ->get();
        
        return view('admin.dokter.pending_changes', compact('pendingChanges'));
    }
}