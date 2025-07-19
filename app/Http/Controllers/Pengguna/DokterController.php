<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Consultation;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class DokterController extends Controller
{
    public function index()
    {
        $dokters = User::where('role', 'dokter')
        ->where('is_approved', true)
        ->where('is_online', true)
        ->get()
        ->map(function ($dokter) {
            $dokter->konsultasi_aktif = $dokter->konsultasiAktifDengan(auth()->id())->first();
            return $dokter;
        });

        return view('pengguna.dokters.index', compact('dokters'));
    }   

    public function show($id)
    {
        $dokter = User::where('role', 'dokter')
            ->where('is_approved', true)
            ->where('is_online', true)
            ->findOrFail($id);
            
        return view('pengguna.dokters.show', compact('dokter'));
    }
}