@extends('admin.layouts.app')

@section('title', 'Buat Invoice Baru')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container {
        width: 100% !important;
    }
    .select2-selection {
        height: 38px !important;
        border: 1px solid #ced4da !important;
        border-radius: 0.25rem !important;
    }
    .select2-selection__rendered {
        line-height: 36px !important;
        padding-left: 12px !important;
    }
    .select2-selection__arrow {
        height: 36px !important;
    }
    .consultation-card {
        border: 1px solid #e3e6f0;
        border-radius: 8px;
        transition: all 0.3s;
    }
    .consultation-card:hover {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    .consultation-item {
        padding: 15px;
        border-bottom: 1px solid #f8f9fc;
    }
    .consultation-item:last-child {
        border-bottom: none;
    }
    .consultation-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .user-info {
        font-weight: 600;
        color: #5a5c69;
    }
    .doctor-info {
        color: #858796;
        font-size: 0.9em;
    }
    .tarif-info {
        font-weight: bold;
        color: #1cc88a;
    }
    .date-info {
        color: #6c757d;
        font-size: 0.85em;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Buat Invoice Baru
                    </h6>
                    <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Kembali
                    </a>
                </div>

                <form method="POST" action="{{ route('admin.invoices.store') }}">
                    @csrf
                    <div class="card-body">
                        <!-- Consultation Selection -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label font-weight-bold">Pilih Konsultasi yang Selesai *</label>
                                    <select name="consultation_id" id="consultation_id" class="form-control" required>
                                        <option value="">-- Pilih Konsultasi --</option>
                                        @foreach($completedConsultations as $consult)
                                        <option value="{{ $consult->id }}" 
                                                {{ (old('consultation_id') == $consult->id || ($consultation && $consultation->id == $consult->id)) ? 'selected' : '' }}
                                                data-patient="{{ $consult->user->name }}"
                                                data-patient-email="{{ $consult->user->email }}"
                                                data-doctor="{{ $consult->dokter->name }}"
                                                data-doctor-specialty="{{ $consult->dokter->keahlian ?? 'Pengacara Umum' }}"
                                                data-tarif="{{ $consult->tarif }}"
                                                data-keluhan="{{ $consult->keluhan }}"
                                                data-date="{{ $consult->chat_ended_at->format('d/m/Y H:i') }}">
                                            {{ $consult->user->name }} - {{ $consult->dokter->name }} 
                                            ({{ $consult->chat_ended_at->format('d/m/Y') }}) - 
                                            Rp {{ number_format($consult->tarif, 0, ',', '.') }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('consultation_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Consultation Details Preview -->
                        <div id="consultation-details" class="row" style="{{ $consultation ? '' : 'display: none;' }}">
                            <div class="col-md-12">
                                <div class="consultation-card bg-light">
                                    <div class="card-header bg-primary text-white">
                                        <h6 class="mb-0">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            Detail Konsultasi Hukum
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label font-weight-bold">Klien</label>
                                                    <input type="text" id="patient-name" class="form-control" readonly
                                                           value="{{ $consultation ? $consultation->user->name : '' }}">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label font-weight-bold">Email Klien</label>
                                                    <input type="text" id="patient-email" class="form-control" readonly
                                                           value="{{ $consultation ? $consultation->user->email : '' }}">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label font-weight-bold">Masalah Hukum</label>
                                                    <textarea id="keluhan" class="form-control" rows="3" readonly>{{ $consultation ? $consultation->keluhan : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label font-weight-bold">Pengacara</label>
                                                    <input type="text" id="doctor-name" class="form-control" readonly
                                                           value="{{ $consultation ? $consultation->dokter->name : '' }}">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label font-weight-bold">Spesialisasi</label>
                                                    <input type="text" id="doctor-specialty" class="form-control" readonly
                                                           value="{{ $consultation ? ($consultation->dokter->keahlian ?? 'Pengacara Umum') : '' }}">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label font-weight-bold">Tanggal Selesai</label>
                                                    <input type="text" id="consultation-date" class="form-control" readonly
                                                           value="{{ $consultation ? $consultation->chat_ended_at->format('d/m/Y H:i') : '' }}">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Invoice Calculation -->
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6 offset-md-6">
                                                <div class="card border-success">
                                                    <div class="card-header bg-success text-white">
                                                        <h6 class="card-title mb-0">
                                                            <i class="fas fa-calculator mr-2"></i>
                                                            Rincian Biaya
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between mb-3">
                                                            <span class="font-weight-bold">Biaya Konsultasi Hukum:</span>
                                                            <span id="subtotal" class="text-success font-weight-bold">
                                                                {{ $consultation ? 'Rp ' . number_format($consultation->tarif, 0, ',', '.') : 'Rp 0' }}
                                                            </span>
                                                        </div>
                                                        <hr>
                                                        <div class="d-flex justify-content-between">
                                                            <strong class="text-primary">Total Pembayaran:</strong>
                                                            <strong id="total-amount" class="text-primary h5">
                                                                {{ $consultation ? 'Rp ' . number_format($consultation->tarif, 0, ',', '.') : 'Rp 0' }}
                                                            </strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="row mt-4">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-label font-weight-bold">Catatan (Opsional)</label>
                                    <textarea name="notes" class="form-control" rows="3" 
                                              placeholder="Tambahkan catatan untuk invoice ini...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" id="submit-btn" disabled>
                                    <i class="fas fa-save mr-1"></i>
                                    Buat Invoice
                                </button>
                                <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times mr-1"></i>
                                    Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Select2
    $('#consultation_id').select2({
        placeholder: '-- Pilih Konsultasi --',
        allowClear: true,
        width: '100%'
    });

    const consultationSelect = $('#consultation_id');
    const detailsDiv = $('#consultation-details');
    const submitBtn = $('#submit-btn');

    consultationSelect.change(function() {
        const selectedOption = $(this).find('option:selected');
        
        if ($(this).val()) {
            // Show details
            detailsDiv.slideDown();
            submitBtn.prop('disabled', false);
            
            // Get data from selected option
            const patientName = selectedOption.data('patient');
            const patientEmail = selectedOption.data('patient-email');
            const doctorName = selectedOption.data('doctor');
            const doctorSpecialty = selectedOption.data('doctor-specialty');
            const tarif = selectedOption.data('tarif');
            const keluhan = selectedOption.data('keluhan');
            const date = selectedOption.data('date');
            
            // Update form fields
            $('#patient-name').val(patientName);
            $('#patient-email').val(patientEmail);
            $('#doctor-name').val(doctorName);
            $('#doctor-specialty').val(doctorSpecialty);
            $('#keluhan').val(keluhan);
            $('#consultation-date').val(date);
            
            // Calculate amounts (no tax)
            const totalAmount = tarif;
            
            $('#subtotal').text('Rp ' + formatNumber(totalAmount));
            $('#total-amount').text('Rp ' + formatNumber(totalAmount));
            
        } else {
            detailsDiv.slideUp();
            submitBtn.prop('disabled', true);
        }
    });

    // Initialize if consultation is pre-selected
    if (consultationSelect.val()) {
        consultationSelect.trigger('change');
    }
});

function formatNumber(num) {
    return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
</script>
@endpush