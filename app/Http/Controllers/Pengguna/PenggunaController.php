<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\User;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    /**
     * Display pengguna dashboard
     */
    public function index()
    {
        $user = auth()->user();
        
        if (!$user || $user->role !== 'pengguna') {
            return redirect('/')->with('error', 'Akses ditolak');
        }

        // Hitung total konsultasi user
        $totalConsultations = Consultation::where('user_id', $user->id)->count();
        
        // Hitung konsultasi aktif (status pending atau approved)
        $activeConsultations = Consultation::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved'])
            ->count();
        
        // Hitung ahli hukum yang sedang online
        $activeLawyers = User::where('role', 'dokter')
            ->where('is_approved', 1)
            ->where('is_online', 1)
            ->count();
        
        // Ambil konsultasi terbaru (jika ada)
        $recentConsultations = Consultation::where('user_id', $user->id)
            ->with(['dokter'])
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('pengguna.dashboard', compact(
            'user',
            'totalConsultations',
            'activeConsultations', 
            'activeLawyers',
            'recentConsultations'
        ));
    }
}