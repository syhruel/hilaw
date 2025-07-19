<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['consultation.user', 'consultation.dokter'])->get();
        return view('admin.payments.index', compact('payments'));
    }

    public function approve($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id()
        ]);
        
        $payment->consultation->update(['status' => 'approved']);
        
        return redirect()->back()->with('success', 'Pembayaran berhasil disetujui');
    }

    public function reject($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update(['status' => 'rejected']);
        
        return redirect()->back()->with('success', 'Pembayaran ditolak');
    }
}
