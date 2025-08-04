<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Consultation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PaymentApprovalController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['consultation.user', 'consultation'])
            ->whereHas('consultation', function ($query) {
                $query->where('dokter_id', Auth::id());
            })
            ->latest()
            ->get();

        return view('dokter.payments.index', compact('payments'));
    }

    public function show($id)
    {
        $payment = Payment::with(['consultation.user', 'consultation'])
            ->whereHas('consultation', function ($query) {
                $query->where('dokter_id', Auth::id());
            })
            ->findOrFail($id);

        return view('dokter.payments.show', compact('payment'));
    }

    // METHOD approve() DAN reject() SUDAH DIHAPUS
    // SEKARANG HANYA ADMIN YANG BISA APPROVE/REJECT PEMBAYARAN
}