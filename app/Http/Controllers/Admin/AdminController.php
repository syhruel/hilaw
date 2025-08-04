<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Consultation;
use App\Models\Payment;
use App\Models\ProfileChange;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_dokter' => User::where('role', 'dokter')->count(),
            'dokter_pending' => User::where('role', 'dokter')->where('is_approved', false)->count(),
            'dokter_approved' => User::where('role', 'dokter')->where('is_approved', true)->count(),
            'total_pengguna' => User::where('role', 'pengguna')->count(),
            'total_konsultasi' => Consultation::count(),
            'konsultasi_hari_ini' => Consultation::whereDate('created_at', Carbon::today())->count(),
            'konsultasi_pending' => Consultation::where('status', 'pending')->count(),
            'total_pembayaran' => Payment::where('status', 'paid')->sum('amount'),
            'pembayaran_pending' => Payment::where('status', 'pending')->count(),
            'profile_changes_pending' => ProfileChange::where('status', 'pending')->count(),
        ];

        // Data untuk chart konsultasi per bulan (6 bulan terakhir)
        $consultationChart = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = Consultation::whereYear('created_at', $date->year)
                               ->whereMonth('created_at', $date->month)
                               ->count();
            $consultationChart[] = [
                'month' => $date->format('M Y'),
                'count' => $count
            ];
        }

        // Dokter terbaru
        $recentDoctors = User::where('role', 'dokter')
                           ->latest()
                           ->take(5)
                           ->get();

        // Konsultasi terbaru
        $recentConsultations = Consultation::with(['user', 'dokter'])
                                         ->latest()
                                         ->take(5)
                                         ->get();

        return view('admin.dashboard', compact('stats', 'consultationChart', 'recentDoctors', 'recentConsultations'));
    }
}