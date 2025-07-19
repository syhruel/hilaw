<?php
namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;

class PenggunaController extends Controller
{
    public function index()
    {
        return view('pengguna.dashboard');
    }
}