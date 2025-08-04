<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Consultation;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::with(['consultation', 'user', 'dokter'])
                          ->when($request->search, function($query, $search) {
                              $query->where('invoice_number', 'like', "%{$search}%")
                                   ->orWhereHas('user', function($q) use ($search) {
                                       $q->where('name', 'like', "%{$search}%");
                                   });
                          })
                          ->when($request->status, function($query, $status) {
                              $query->where('status', $status);
                          })
                          ->orderBy('created_at', 'desc')
                          ->paginate(15);

        return view('admin.invoices.index', compact('invoices'));
    }

    public function create(Request $request)
    {
        $consultationId = $request->consultation_id;
        $consultation = null;
        
        if ($consultationId) {
            $consultation = Consultation::with(['user', 'dokter', 'payment'])
                                      ->where('status', 'approved')
                                      ->where('chat_ended_at', '!=', null)
                                      ->whereDoesntHave('invoice')
                                      ->findOrFail($consultationId);
        }

        $completedConsultations = Consultation::with(['user', 'dokter'])
                                            ->where('status', 'approved')
                                            ->where('chat_ended_at', '!=', null)
                                            ->whereDoesntHave('invoice')
                                            ->orderBy('chat_ended_at', 'desc')
                                            ->get();

        return view('admin.invoices.create', compact('consultation', 'completedConsultations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'consultation_id' => 'required|exists:consultations,id',
            'notes' => 'nullable|string|max:500'
        ]);

        $consultation = Consultation::with(['user', 'dokter', 'payment'])
                                  ->where('status', 'approved')
                                  ->where('chat_ended_at', '!=', null)
                                  ->whereDoesntHave('invoice')
                                  ->findOrFail($request->consultation_id);

        $invoice = new Invoice();
        $invoice->consultation_id = $consultation->id;
        $invoice->invoice_number = Invoice::generateInvoiceNumber();
        $invoice->user_id = $consultation->user_id;
        $invoice->dokter_id = $consultation->dokter_id;
        $invoice->calculateAmounts($consultation->tarif);
        $invoice->issued_at = Carbon::now();
        $invoice->status = 'issued';
        $invoice->notes = $request->notes;
        $invoice->save();

        return redirect()->route('admin.invoices.index')
                        ->with('success', 'Invoice berhasil dibuat dengan nomor: ' . $invoice->invoice_number);
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['consultation', 'user', 'dokter']);
        return view('admin.invoices.show', compact('invoice'));
    }

    public function downloadPdf(Invoice $invoice)
    {
        $invoice->load(['consultation', 'user', 'dokter']);
        
        $pdf = Pdf::loadView('admin.invoices.pdf', compact('invoice'))
                  ->setPaper('a4', 'portrait');
        
        $filename = 'Invoice-' . $invoice->invoice_number . '.pdf';
        
        return $pdf->download($filename);
    }

    public function destroy(Invoice $invoice)
    {
        $invoiceNumber = $invoice->invoice_number;
        $invoice->delete();

        return redirect()->route('admin.invoices.index')
                        ->with('success', 'Invoice ' . $invoiceNumber . ' berhasil dihapus');
    }

    // API endpoint untuk autocomplete
    public function getCompletedConsultations(Request $request)
    {
        $consultations = Consultation::with(['user', 'dokter'])
                                   ->where('status', 'approved')
                                   ->where('chat_ended_at', '!=', null)
                                   ->whereDoesntHave('invoice')
                                   ->when($request->search, function($query, $search) {
                                       $query->whereHas('user', function($q) use ($search) {
                                           $q->where('name', 'like', "%{$search}%");
                                       });
                                   })
                                   ->orderBy('chat_ended_at', 'desc')
                                   ->limit(10)
                                   ->get();

        return response()->json($consultations);
    }
}