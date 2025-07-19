<?php
namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;

class DokterController extends Controller
{
    
    public function index()
    {
        return view('dokter.dashboard');
    }

    public function payments()
    {
        $dokterId = auth()->id();

        $payments = Payment::with(['consultation.user'])
            ->whereHas('consultation', function ($query) use ($dokterId) {
                $query->where('dokter_id', $dokterId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dokter.payments.index', compact('payments'));
    }

}