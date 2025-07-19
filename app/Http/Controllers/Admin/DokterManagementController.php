<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

    public function show(User $dokter)
    {
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

    public function edit(User $dokter)
    {
        return view('admin.dokter.edit', compact('dokter'));
    }

    public function update(Request $request, User $dokter)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $dokter->id,
            'foto' => 'nullable|image|max:10240',
            'keahlian' => 'required|string|max:255',
            'pengalaman' => 'required|string',
            'lulusan_universitas' => 'required|string|max:255',
            'alamat' => 'required|string',
            'tarif_konsultasi' => 'required|numeric|min:0',
        ]);

        $data = $request->only([
            'name', 'email', 'keahlian', 'pengalaman', 
            'lulusan_universitas', 'alamat', 'tarif_konsultasi'
        ]);

        if ($request->hasFile('foto')) {
            if ($dokter->foto) {
                Storage::disk('public')->delete($dokter->foto);
            }

            $data['foto'] = $request->file('foto')->store('dokter-photos', 'public');
        }

        $dokter->update($data);

        return redirect()->route('dokter.index')->with('success', 'Dokter berhasil diupdate');
    }



    public function destroy(User $dokter)
    {
        if ($dokter->foto) {
            Storage::disk('public')->delete($dokter->foto);
        }
        $dokter->delete();
        return redirect()->route('dokter.index')->with('success', 'Dokter berhasil dihapus');
    }

    public function approve($id)
    {
        $dokter = User::findOrFail($id);
        $dokter->update(['is_approved' => true]);

        // Jika belum ada tarif/jadwal, arahkan ke form pengisian
        if (!$dokter->tarif_konsultasi || !$dokter->jadwal_kerja) {
            return redirect()->route('dokter.setJadwalHargaForm', $dokter->id)
                ->with('success', 'Dokter disetujui. Silakan lengkapi tarif & jadwal.');
        }

        return redirect()->route('dokter.index')->with('success', 'Dokter berhasil disetujui');
    }

    public function showJadwalHargaForm($id)
    {
        $dokter = User::findOrFail($id);
        return view('admin.dokter.set_jadwal_harga', compact('dokter'));
    }

    public function saveJadwalHarga(Request $request, $id)
    {
        $request->validate([
            'tarif_konsultasi' => 'required|numeric|min:0',
            'hari_mulai' => 'required|string',
            'hari_selesai' => 'nullable|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $dokter = User::findOrFail($id);

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


}
