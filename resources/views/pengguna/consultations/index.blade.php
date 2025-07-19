@extends('pengguna.layouts.app')

@section('title', 'Konsultasi Saya')
@section('page-title', 'Riwayat Konsultasi')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Konsultasi</h3>
        <div class="card-tools">
            <a href="{{ route('pengguna.dokters.index') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Konsultasi Baru
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Dokter</th>
                        <th>Keluhan</th>
                        <th>Tarif</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($consultations as $consultation)
                    <tr>
                        <td>Dr. {{ $consultation->dokter->name }}</td>
                        <td>{{ Str::limit($consultation->keluhan, 50) }}</td>
                        <td>Rp {{ number_format($consultation->tarif, 0, ',', '.') }}</td>
                        <td> {{ $consultation->status }}</td>
                        <td>{{ $consultation->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('pengguna.consultations.show', $consultation->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Detail
                            </a>

                            @if(in_array($consultation->status, ['approved', 'completed']))
                                <a href="{{ route('pengguna.consultations.chat', $consultation->id) }}" class="btn btn-sm btn-success">
                                    Chat
                                </a>
                            @endif

                            @if($consultation->status == 'pending')
                                <a href="{{ route('pengguna.consultations.payment', $consultation->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-credit-card"></i> Bayar
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection