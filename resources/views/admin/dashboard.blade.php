@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total_dokter'] }}</h3>
                <p>Total Dokter</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-md"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['dokter_pending'] }}</h3>
                <p>Dokter Pending</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['total_pengguna'] }}</h3>
                <p>Total Pengguna</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Selamat Datang, {{ auth()->user()->name }}!</h3>
    </div>
    <div class="card-body">
        <p>Ini adalah dashboard admin untuk mengelola sistem rumah sakit.</p>
    </div>
</div>
@endsection
