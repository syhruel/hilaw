@extends('pengguna.layouts.app')

@section('title', 'Profil Dokter')
@section('page-title', 'Profil Dokter')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 text-center">
                @if($dokter->foto)
                    <img src="{{ asset('storage/' . $dokter->foto) }}" class="rounded-circle mb-3" width="150" height="150">
                @else
                    <div class="bg-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 150px; height: 150px;">
                        <i class="fas fa-user-md text-white fa-4x"></i>
                    </div>
                @endif
                <h4>Dr. {{ $dokter->name }}</h4>
                <p class="text-muted">{{ $dokter->keahlian }}</p>
                <span class="badge badge-success">
                    <i class="fas fa-circle"></i> Online
                </span>
            </div>
            <div class="col-md-8">
                <h5>Informasi Dokter</h5>
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Keahlian:</strong></td>
                        <td>{{ $dokter->keahlian }}</td>
                    </tr>
                    <tr>
                        <td><strong>Pengalaman:</strong></td>
                        <td>{{ $dokter->pengalaman }}</td>
                    </tr>
                    <tr>
                        <td><strong>Lulusan:</strong></td>
                        <td>{{ $dokter->lulusan_universitas }}</td>
                    </tr>
                    <tr>
                        <td><strong>Alamat:</strong></td>
                        <td>{{ $dokter->alamat }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tarif Konsultasi:</strong></td>
                        <td class="font-weight-bold text-success">Rp {{ number_format($dokter->tarif_konsultasi, 0, ',', '.') }}</td>
                    </tr>
                </table>
                <div class="mt-4">
                    <a href="{{ route('pengguna.consultations.create', $dokter->id) }}" class="btn btn-primary">
                        <i class="fas fa-comments"></i> Mulai Konsultasi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
