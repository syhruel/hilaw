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
            'foto' => 'nullable|image|max:10240',
            'keahlian' => 'required|string|max:255',
            'pengalaman' => 'required|string',
            'lulusan_universitas' => 'required|string|max:255',
            'alamat' => 'required|string',
            'tarif_konsultasi' => 'required|numeric|min:0',
            'hari_mulai' => 'required|string',
            'hari_selesai' => 'nullable|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('dokter-photos', 'public');
        }

        $jadwal_kerja = $request->hari_mulai;
        if ($request->filled('hari_selesai') && $request->hari_selesai !== $request->hari_mulai) {
            $jadwal_kerja .= '-' . $request->hari_selesai;
        }
        $jadwal_kerja .= ' ' . $request->jam_mulai . '-' . $request->jam_selesai;

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'dokter',
            'is_approved' => true,
            'approval_status' => 'approved',
            'foto' => $fotoPath,
            'keahlian' => $request->keahlian,
            'pengalaman' => $request->pengalaman,
            'lulusan_universitas' => $request->lulusan_universitas,
            'alamat' => $request->alamat,
            'tarif_konsultasi' => $request->tarif_konsultasi,
            'jadwal_kerja' => $jadwal_kerja,
        ]);

        return redirect()->route('dokter.index')->with('success', 'Dokter berhasil ditambahkan');
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
            'foto' => 'nullable|image|max:10240',
            'sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'keahlian' => 'required|string|max:255',
            'pengalaman' => 'required|string',
            'lulusan_universitas' => 'required|string|max:255',
            'alamat' => 'required|string',
            'tarif_konsultasi' => 'required|numeric|min:0',
        ]);

        $changes = $request->only([
            'name', 'email', 'keahlian', 'pengalaman', 
            'lulusan_universitas', 'alamat', 'tarif_konsultasi'
        ]);

        if ($request->hasFile('foto')) {
            $changes['foto'] = $request->file('foto')->store('dokter-photos', 'public');
        }

        if ($request->hasFile('sertifikat')) {
            $changes['sertifikat'] = $request->file('sertifikat')->store('dokter-certificates', 'public');
        }

        $oldData = $dokter->only([
            'name', 'email', 'keahlian', 'pengalaman', 
            'lulusan_universitas', 'alamat', 'tarif_konsultasi', 'foto', 'sertifikat'
        ]);

        ProfileChange::create([
            'user_id' => $dokter->id,
            'changes' => json_encode($changes),
            'old_data' => json_encode($oldData),
            'status' => 'pending'
        ]);

        return redirect()->route('dokter.index')->with('success', 'Pengajuan perubahan profil berhasil dikirim. Menunggu persetujuan admin.');
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