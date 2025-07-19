<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DokterOnlineController extends Controller
{
    public function toggleOnline($id)
    {
        $dokter = User::where('role', 'dokter')->findOrFail($id);
        $dokter->update(['is_online' => !$dokter->is_online]);
        
        $status = $dokter->is_online ? 'online' : 'offline';
        return redirect()->back()->with('success', "Dokter berhasil di-{$status}-kan");
    }
}