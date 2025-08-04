<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class PublicController extends Controller
{
    public function tentang()
    {
        return view('public.tentang');
    }

    public function ahliHukum()
    {
        // Ambil data pengacara yang sudah disetujui dan online
        $pengacara = User::where('role', 'dokter')
                        ->where('approval_status', 'approved')
                        ->orderBy('is_online', 'desc')
                        ->orderBy('name', 'asc')
                        ->get();

        return view('public.ahli-hukum', compact('pengacara'));
    }

    public function kontak()
    {
        return view('public.kontak');
    }

    public function kontakStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string|max:2000',
        ]);

        // Di sini Anda bisa menambahkan logic untuk menyimpan ke database
        // atau mengirim email ke admin
        
        // Untuk sementara, kita redirect dengan pesan sukses
        return redirect()->route('kontak')->with('success', 'Pesan Anda telah terkirim. Kami akan segera menghubungi Anda.');
    }

    public function layanan()
    {
        return view('public.layanan');
    }

    public function bantuan()
    {
        return view('public.bantuan');
    }

    public function syaratKetentuan()
    {
        return view('public.syarat-ketentuan');
    }
}