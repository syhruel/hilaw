<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::where('dokter_id', auth()->id())
            ->with(['user', 'payment'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('dokter.consultations.index', compact('consultations'));
    }

    public function show($id)
    {
        $consultation = Consultation::where('dokter_id', auth()->id())
            ->with(['user', 'payment'])
            ->findOrFail($id);
            
        return view('dokter.consultations.show', compact('consultation'));
    }

    public function diagnose(Request $request, $id)
    {
        $consultation = Consultation::where('dokter_id', auth()->id())->findOrFail($id);
        
        $request->validate([
            'diagnosis' => 'required|string',
            'obat_resep' => 'nullable|string',
        ]);
        
        $consultation->update([
            'diagnosis' => $request->diagnosis,
            'obat_resep' => $request->obat_resep,
            'status' => 'completed'
        ]);
        
        return redirect()->back()->with('success', 'Diagnosis berhasil disimpan');
    }

    public function chat($id)
    {
        $consultation = Consultation::findOrFail($id);
        return view('dokter.consultations.chat', compact('consultation'));
    }

}