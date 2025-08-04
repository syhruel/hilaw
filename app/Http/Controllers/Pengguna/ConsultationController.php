<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
            ->with('dokter', 'payment')
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

        $isReupload = false;

        // Cek apakah ada payment yang di-reject sebelumnya
        if ($consultation->payment && $consultation->payment->status === 'rejected') {
            // Hapus file bukti lama
            if ($consultation->payment->payment_proof) {
                Storage::disk('public')->delete($consultation->payment->payment_proof);
            }
            // Hapus record payment lama
            $consultation->payment->delete();
            $isReupload = true;
        }

        // Upload bukti pembayaran baru
        $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');

        // Buat payment record baru
        Payment::create([
            'consultation_id' => $consultation->id,
            'amount' => $consultation->tarif,
            'payment_method' => $request->payment_method,
            'payment_proof' => $proofPath,
            'status' => 'pending'
        ]);

        // Update status consultation menjadi 'paid'
        $consultation->update(['status' => 'paid']);

        // Log untuk debugging
        Log::info('Payment processed', [
            'consultation_id' => $consultation->id,
            'consultation_status' => $consultation->status,
            'is_reupload' => $isReupload
        ]);

        $message = $isReupload ? 
            'Bukti pembayaran baru berhasil diupload! Menunggu persetujuan dokter.' : 
            'Pembayaran berhasil diupload, menunggu persetujuan dokter';

        return redirect()->route('pengguna.consultations.index')
            ->with('success', $message);
    }

    public function index()
    {
        // Hanya tampilkan konsultasi yang benar-benar butuh action dari user
        // Status: pending (perlu bayar), payment_rejected (perlu upload ulang), paid (menunggu approval)
        $consultations = Consultation::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'paid'])
            ->orWhere(function($query) {
                $query->where('user_id', auth()->id())
                      ->whereHas('payment', function($paymentQuery) {
                          $paymentQuery->where('status', 'rejected');
                      });
            })
            ->with(['dokter', 'payment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Debug log untuk melihat status konsultasi
        foreach($consultations as $consultation) {
            Log::info('Active Consultation Debug', [
                'id' => $consultation->id,
                'status' => $consultation->status,
                'payment_status' => $consultation->payment ? $consultation->payment->status : 'no_payment',
                'rejection_reason' => $consultation->payment && $consultation->payment->status === 'rejected' ? $consultation->payment->rejection_reason : null
            ]);
        }

        return view('pengguna.consultations.index', compact('consultations'));
    }

    public function history(Request $request)
    {
        // Base query
        $baseQuery = Consultation::where('user_id', auth()->id())
            ->with(['dokter', 'payment']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $baseQuery->where(function($query) use ($search) {
                $query->where('keluhan', 'like', '%' . $search . '%')
                      ->orWhereHas('dokter', function($dokterQuery) use ($search) {
                          $dokterQuery->where('name', 'like', '%' . $search . '%')
                                      ->orWhere('keahlian', 'like', '%' . $search . '%');
                      });
            });
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $baseQuery->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $baseQuery->whereDate('created_at', '<=', $request->date_to);
        }

        // Semua konsultasi untuk tab "Semua" (dengan filter)
        $allConsultations = (clone $baseQuery)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'all_page');

        // Konsultasi yang selesai (dengan filter)
        $completedConsultations = (clone $baseQuery)
            ->where('status', 'completed')
            ->orderBy('updated_at', 'desc')
            ->paginate(10, ['*'], 'completed_page');

        // Konsultasi yang dibatalkan atau ditolak (dengan filter)
        $cancelledConsultations = (clone $baseQuery)
            ->where(function($query) {
                $query->where('status', 'cancelled')
                      ->orWhere('status', 'payment_rejected');
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(10, ['*'], 'cancelled_page');

        return view('pengguna.consultations.history', compact(
            'allConsultations', 
            'completedConsultations', 
            'cancelledConsultations'
        ));
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

        if ($consultation->status !== 'approved' && $consultation->status !== 'completed') {
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