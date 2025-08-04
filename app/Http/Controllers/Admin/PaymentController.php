<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['consultation.user', 'consultation.dokter'])
            ->orderBy('created_at', 'desc') // Urutkan dari data terbaru
            ->orderBy('id', 'desc') // Tambahan pengurutan berdasarkan ID sebagai fallback
            ->get();
        return view('admin.payments.index', compact('payments'));
    }

    public function show($id)
    {
        $payment = Payment::with(['consultation.user', 'consultation.dokter'])
            ->findOrFail($id);
        return view('admin.payments.show', compact('payment'));
    }

    public function approve(Request $request, $id)
    {
        try {
            $payment = Payment::with(['consultation'])->findOrFail($id);
            
            // Validasi status pembayaran
            if ($payment->status !== 'pending') {
                return redirect()->back()->with('error', 'Pembayaran ini sudah diproses sebelumnya.');
            }

            // Validasi apakah bukti pembayaran sudah ada
            if (!$payment->payment_proof) {
                return redirect()->back()->with('error', 'Bukti pembayaran belum diupload oleh pasien.');
            }

            // Update status pembayaran
            $payment->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => Auth::id(),
                'rejection_reason' => null,
                'rejected_at' => null,
                'rejected_by' => null
            ]);

            // Update status konsultasi
            $consultation = $payment->consultation;
            if ($consultation && $consultation->status == 'paid') {
                $consultation->update([
                    'status' => 'approved'
                ]);
            }

            Log::info('Payment approved by admin', [
                'payment_id' => $payment->id,
                'consultation_id' => $consultation->id,
                'admin_id' => Auth::id()
            ]);

            return redirect()->route('admin.payments.index')
                ->with('success', 'Pembayaran berhasil disetujui. Konsultasi siap dimulai.');

        } catch (\Exception $e) {
            Log::error('Error approving payment', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyetujui pembayaran. Silakan coba lagi.');
        }
    }

    public function reject(Request $request, $id)
    {
        try {
            $payment = Payment::with(['consultation'])->findOrFail($id);
            
            // Validasi status pembayaran
            if ($payment->status !== 'pending') {
                return redirect()->back()->with('error', 'Pembayaran ini sudah diproses sebelumnya.');
            }

            $request->validate([
                'rejection_reason' => 'required|string|min:10|max:500'
            ], [
                'rejection_reason.required' => 'Alasan penolakan wajib diisi',
                'rejection_reason.min' => 'Alasan penolakan minimal 10 karakter',
                'rejection_reason.max' => 'Alasan penolakan maksimal 500 karakter'
            ]);

            // Update status pembayaran dengan detail penolakan
            $payment->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
                'rejected_at' => now(),
                'rejected_by' => Auth::id(),
                'approved_at' => null,
                'approved_by' => null
            ]);

            // Update status konsultasi ke payment_rejected
            $consultation = $payment->consultation;
            if ($consultation) {
                $consultation->update([
                    'status' => 'payment_rejected'
                ]);
            }

            Log::info('Payment rejected by admin', [
                'payment_id' => $payment->id,
                'consultation_id' => $consultation->id,
                'admin_id' => Auth::id(),
                'rejection_reason' => $request->rejection_reason
            ]);

            return redirect()->route('admin.payments.index')
                ->with('success', 'Pembayaran berhasil ditolak. Pasien akan mendapat notifikasi dan dapat mengupload ulang bukti pembayaran.');

        } catch (\Exception $e) {
            Log::error('Error rejecting payment', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menolak pembayaran. Silakan coba lagi.');
        }
    }

    public function destroy($id)
    {
        try {
            $payment = Payment::with(['consultation'])->findOrFail($id);
            
            // Simpan informasi untuk logging sebelum dihapus
            $paymentInfo = [
                'payment_id' => $payment->id,
                'consultation_id' => $payment->consultation->id ?? null,
                'user_name' => $payment->consultation->user->name ?? 'Unknown',
                'amount' => $payment->amount,
                'status' => $payment->status,
                'admin_id' => Auth::id()
            ];

            // Hapus file bukti pembayaran jika ada
            if ($payment->payment_proof && Storage::exists($payment->payment_proof)) {
                Storage::delete($payment->payment_proof);
                Log::info('Payment proof file deleted', [
                    'payment_id' => $payment->id,
                    'file_path' => $payment->payment_proof
                ]);
            }

            // Update status konsultasi jika diperlukan
            $consultation = $payment->consultation;
            if ($consultation) {
                // Jika pembayaran yang dihapus adalah pembayaran yang sudah disetujui
                // maka ubah status konsultasi kembali ke 'pending_payment'
                if ($payment->status === 'approved' && $consultation->status === 'approved') {
                    $consultation->update([
                        'status' => 'pending_payment'
                    ]);
                }
            }

            // Hapus data pembayaran
            $payment->delete();

            Log::info('Payment deleted by admin', $paymentInfo);

            return redirect()->route('admin.payments.index')
                ->with('success', 'Data pembayaran berhasil dihapus dari sistem.');

        } catch (\Exception $e) {
            Log::error('Error deleting payment', [
                'payment_id' => $id,
                'error' => $e->getMessage(),
                'admin_id' => Auth::id()
            ]);
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data pembayaran. Silakan coba lagi.');
        }
    }
}