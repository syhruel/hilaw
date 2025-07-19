<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function create($dokter_id)
    {
        $dokter = User::where('role', 'dokter')
            ->where('is_approved', true)
            ->where('is_online', true)
            ->findOrFail($dokter_id);

        return view('pengguna.consultations.create', compact('dokter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dokter_id' => 'required|exists:users,id',
            'keluhan' => 'required|string',
            'durasi' => 'required|integer|min:1|max:5', 
        ]);

        $dokter = User::findOrFail($request->dokter_id);
        $tarifPerJam = $dokter->tarif_konsultasi;

        if (is_null($tarifPerJam)) {
            return back()->with('error', 'Tarif belum ditentukan.');
        }

        $durationJam = (int) $request->durasi;
        $durationMenit = $durationJam * 60;
        $totalTarif = $tarifPerJam * $durationJam;

        $consultation = Consultation::create([
            'user_id' => auth()->id(),
            'dokter_id' => $request->dokter_id,
            'keluhan' => $request->keluhan,
            'duration_hours' => $durationJam,
            'duration_minutes' => $durationMenit,
            'tarif' => $totalTarif,
            'status' => 'pending',
        ]);

        return redirect()->route('pengguna.consultations.payment', $consultation->id);
    }

    public function payment($id)
    {
        $consultation = Consultation::where('user_id', auth()->id())
            ->with('dokter')
            ->findOrFail($id);

        return view('pengguna.consultations.payment', compact('consultation'));
    }

    public function processPayment(Request $request, $id)
    {
        $consultation = Consultation::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'payment_method' => 'required|string',
            'payment_proof' => 'required|image|max:2048',
        ]);

        $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');

        Payment::create([
            'consultation_id' => $consultation->id,
            'amount' => $consultation->tarif,
            'payment_method' => $request->payment_method,
            'payment_proof' => $proofPath,
            'status' => 'pending'
        ]);

        $consultation->update(['status' => 'paid']);

        return redirect()->route('pengguna.consultations.index')
            ->with('success', 'Pembayaran berhasil diupload, menunggu persetujuan');
    }

    public function index()
    {
        $consultations = Consultation::where('user_id', auth()->id())
            ->with(['dokter', 'payment'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pengguna.consultations.index', compact('consultations'));
    }

    public function show($id)
    {
        $consultation = Consultation::where('user_id', auth()->id())
            ->with(['dokter', 'payment'])
            ->findOrFail($id);

        return view('pengguna.consultations.show', compact('consultation'));
    }

    public function chat($id)
    {
        $consultation = Consultation::where('user_id', auth()->id())
            ->with(['dokter', 'payment'])
            ->findOrFail($id);

        if ($consultation->status !== 'approved') {
            return redirect()->route('pengguna.consultations.index')
                ->with('error', 'Konsultasi belum disetujui oleh dokter.');
        }

        if (!$consultation->payment || $consultation->payment->status !== 'approved') {
            return redirect()->route('pengguna.consultations.index')
                ->with('error', 'Pembayaran belum disetujui.');
        }

        return view('pengguna.consultations.chat', compact('consultation'));
    }
}
