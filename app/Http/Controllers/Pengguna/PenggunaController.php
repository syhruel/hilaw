<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
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

        return view('pengguna.dashboard', compact('user'));
    }
}