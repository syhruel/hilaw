@extends('admin.layouts.app')

@section('title', 'Detail Dokter')
@section('page-title', 'Detail Dokter')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Informasi Dokter</h4>
                <div class="card-tools">
                    <a href="{{ route('dokter.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('dokter.edit', $dokter->id) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center mb-3">
                            @if($dokter->foto)
                                <img src="{{ asset('storage/' . $dokter->foto) }}" 
                                     alt="{{ $dokter->name }}" 
                                     class="img-fluid rounded-circle"
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                                     style="width: 150px; height: 150px;">
                                    <i class="fas fa-user-md fa-4x text-white"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="text-center">
                            <h5 class="mb-1">{{ $dokter->name }}</h5>
                            <p class="text-muted mb-2">{{ $dokter->keahlian }}</p>
                            <span class="badge badge-{{ $dokter->is_approved ? 'success' : 'warning' }}">
                                {{ $dokter->is_approved ? 'Disetujui' : 'Pending' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">Nama Lengkap</th>
                                <td>: {{ $dokter->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>: {{ $dokter->email }}</td>
                            </tr>
                            <tr>
                                <th>Keahlian</th>
                                <td>: {{ $dokter->keahlian }}</td>
                            </tr>
                            <tr>
                                <th>Lulusan Universitas</th>
                                <td>: {{ $dokter->lulusan_universitas }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>: 
                                    <span class="badge badge-{{ $dokter->is_approved ? 'success' : 'warning' }}">
                                        {{ $dokter->is_approved ? 'Disetujui' : 'Pending' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Tanggal Bergabung</th>
                                <td>: {{ $dokter->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Pengalaman</h4>
            </div>
            <div class="card-body">
                <p>{{ $dokter->pengalaman }}</p>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h4 class="card-title">Alamat</h4>
            </div>
            <div class="card-body">
                <p>{{ $dokter->alamat }}</p>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h4 class="card-title">Aksi</h4>
            </div>
            <div class="card-body">
                @if(!$dokter->is_approved)
                    <form action="{{ route('dokter.approve', $dokter->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success btn-block mb-2" 
                                onclick="return confirm('Yakin ingin menyetujui dokter ini?')">
                            <i class="fas fa-check"></i> Setujui Dokter
                        </button>
                    </form>
                @endif
                
                <a href="{{ route('dokter.edit', $dokter->id) }}" class="btn btn-primary btn-block mb-2">
                    <i class="fas fa-edit"></i> Edit Data
                </a>
                
                <form action="{{ route('dokter.destroy', $dokter->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block" 
                            onclick="return confirm('Yakin ingin menghapus dokter ini?')">
                        <i class="fas fa-trash"></i> Hapus Dokter
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@if($dokter->is_approved)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Statistik Dokter</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-calendar-check"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Konsultasi</span>
                                    <span class="info-box-number">-</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Pasien Aktif</span>
                                    <span class="info-box-number">-</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-star"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Rating</span>
                                    <span class="info-box-number">-</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger"><i class="fas fa-clock"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Waktu Respon</span>
                                    <span class="info-box-number">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection