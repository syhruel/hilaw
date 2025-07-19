<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_dokter' => User::where('role', 'dokter')->count(),
            'dokter_pending' => User::where('role', 'dokter')->where('is_approved', false)->count(),
            'total_pengguna' => User::where('role', 'pengguna')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}