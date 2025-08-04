<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $pengacara = User::where('role', 'dokter') 
            ->where('is_approved', true)
            ->where('approval_status', 'approved') 
            ->whereNotNull('keahlian')
            ->where('keahlian', '!=', '')
            ->orderBy('is_online', 'desc')
            ->take(6)
            ->get();

        return view('welcome', compact('pengacara'));
    }
}