<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Consultation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokterController extends Controller
{
    public function index()
    {
        // Mengambil ahli hukum yang online dan sudah disetujui (tampilkan hanya 6 teratas untuk 3x2 grid)
        $dokters = User::dokter()
            ->approved()
            ->online()
            ->orderBy('name', 'asc')
            ->take(6) // Ubah dari 4 ke 6 untuk 3 per baris x 2 baris
            ->get();

        // Tidak perlu map lagi karena sudah ada method di model
        return view('pengguna.dokters.index', compact('dokters'));
    }   

    public function all(Request $request)
    {
        $query = User::dokter()
            ->approved()
            ->online()
            ->orderBy('name', 'asc');

        // Filter berdasarkan keahlian jika ada
        if ($request->filled('specialty')) {
            $query->where('keahlian', 'like', '%' . $request->specialty . '%');
        }

        // Filter berdasarkan pencarian nama
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('keahlian', 'like', '%' . $request->search . '%')
                  ->orWhere('lulusan_universitas', 'like', '%' . $request->search . '%');
            });
        }

        $dokters = $query->paginate(12)->withQueryString();

        // Mengambil daftar spesialis untuk filter dropdown
        $specialties = User::dokter()
            ->approved()
            ->online()
            ->whereNotNull('keahlian')
            ->distinct()
            ->pluck('keahlian')
            ->sort()
            ->values();

        return view('pengguna.dokters.all', compact('dokters', 'specialties'));
    }

    public function show($id)
    {
        // Mengambil detail ahli hukum berdasarkan ID
        $dokter = User::dokter()
            ->approved()
            ->online()
            ->findOrFail($id);
        
        return view('pengguna.dokters.show', compact('dokter'));
    }

    // Method untuk AJAX search (optional)
    public function search(Request $request)
    {
        $searchTerm = $request->get('q');
        
        $dokters = User::dokter()
            ->approved()
            ->online()
            ->where(function($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('keahlian', 'like', '%' . $searchTerm . '%')
                      ->orWhere('lulusan_universitas', 'like', '%' . $searchTerm . '%');
            })
            ->limit(10)
            ->get(['id', 'name', 'keahlian', 'foto']);

        return response()->json($dokters);
    }
}