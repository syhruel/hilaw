@extends('dokter.layouts.app')

@section('title', 'Konsultasi')
@section('page-title', 'Daftar Konsultasi')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Konsultasi Pasien</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Pasien</th>
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
                        <td>{{ $consultation->user->name }}</td>
                        <td>{{ Str::limit($consultation->keluhan, 50) }}</td>
                        <td>Rp {{ number_format($consultation->tarif, 0, ',', '.') }}</td>
                        <td>
                            @if($consultation->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($consultation->status == 'paid')
                                <span class="badge badge-info">Dibayar</span>
                            @elseif($consultation->status == 'approved')
                                <span class="badge badge-success">Disetujui</span>
                            @elseif($consultation->status == 'completed')
                                <span class="badge badge-primary">Selesai</span>
                            @endif
                        </td>
                        <td>{{ $consultation->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('dokter.consultations.show', $consultation->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Detail
                            </a>

                            @if(in_array($consultation->status, ['approved', 'completed']))
                                <a href="{{ route('dokter.consultations.chat', $consultation->id) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-comments"></i> Chat
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
