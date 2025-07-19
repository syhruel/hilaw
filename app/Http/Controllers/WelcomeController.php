<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $doctors = User::where('role', 'dokter')
                       ->where('is_approved', true) 
                       ->whereNotNull('keahlian')
                       ->where('keahlian', '!=', '')
                       ->orderBy('is_online', 'desc')
                       ->take(6)
                       ->get();

        return view('welcome', compact('doctors'));
    }
}
