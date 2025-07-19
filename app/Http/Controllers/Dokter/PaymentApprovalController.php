<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentApprovalController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['consultation.user'])
            ->whereHas('consultation', function ($query) {
                $query->where('dokter_id', Auth::id());
            })
            ->latest()
            ->get();

        return view('dokter.payments.index', compact('payments'));
    }

    public function approve($id)
    {
        $payment = \App\Models\Payment::findOrFail($id);

        $payment->status = 'approved';
        $payment->save();

        $consultation = $payment->consultation;
        if ($consultation && $consultation->status == 'paid') {
            $consultation->status = 'approved'; 
            $consultation->save();
        }

        return redirect()->back()->with('success', 'Pembayaran disetujui. Konsultasi siap dimulai.');
    }

}
