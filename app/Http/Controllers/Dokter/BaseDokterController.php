<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BaseDokterController extends Controller
{
    protected function checkApproval()
    {
        $user = Auth::user();
        
        if (!$user->is_approved) {
            return redirect()->route('dokter.pending')
                ->with('warning', 'Akun Anda belum disetujui admin.');
        }
        
        return null;
    }
}