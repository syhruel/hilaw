@extends('dokter.layouts.app')

@section('title', 'Dokter Dashboard')
@section('page-title', 'Dashboard Dokter')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ auth()->user()->consultationsAsDoctor()->count() }}</h3>
                <p>Total Konsultasi</p>
            </div>
            <div class="icon">
                <i class="fas fa-comments"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ auth()->user()->consultationsAsDoctor()->whereDate('created_at', today())->count() }}</h3>
                <p>Konsultasi Hari Ini</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box {{ auth()->user()->is_online ? 'bg-success' : 'bg-danger' }}">
            <div class="inner">
                <h3>{{ auth()->user()->is_online ? 'Online' : 'Offline' }}</h3>
                <p>Status Anda</p>
                <p>Tarif Konsultasi Anda: <strong>Rp {{ number_format(auth()->user()->tarif_konsultasi, 0, ',', '.') }} / jam</strong></p>
            </div>
            <div class="icon">
                <i class="fas fa-power-off"></i>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Selamat Datang, Dr. {{ auth()->user()->name }}!</h3>
        <div class="card-tools">
            <form method="POST" action="{{ route('dokter.toggle-online') }}" style="display: inline;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn {{ auth()->user()->is_online ? 'btn-danger' : 'btn-success' }}">
                    <i class="fas fa-power-off"></i>
                    {{ auth()->user()->is_online ? 'Set Offline' : 'Set Online' }}
                </button>
            </form>
        </div>
    </div>
    <div class="card-body">
        <p>Ini adalah dashboard dokter untuk mengelola konsultasi dan pembayaran.</p>
        <p>Status Anda saat ini: <strong>{{ auth()->user()->is_online ? 'Online' : 'Offline' }}</strong></p>
        @if(auth()->user()->is_online)
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> Anda sedang online dan dapat menerima konsultasi dari pasien.
            </div>
        @else
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i> Anda sedang offline. Pasien tidak dapat melihat profil Anda.
            </div>
        @endif
    </div>
</div>
@endsection
