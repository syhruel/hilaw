@extends('admin.layouts.app')

@section('title', 'Kelola Dokter')
@section('page-title', 'Kelola Dokter')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Dokter</h3>
        <div class="card-tools">
            <a href="{{ route('dokter.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Dokter
            </a>
        </div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="10%">Foto</th>
                        <th width="20%">Nama</th>
                        <th width="20%">Email</th>
                        <th>Status</th>
                        <th>Online</th>
                        <th width="30%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dokters as $key => $dokter)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            @if($dokter->foto)
                                <img src="{{ asset('storage/' . $dokter->foto) }}" 
                                     alt="Foto" class="img-circle" width="40" height="40">
                            @else
                                <i class="fas fa-user-circle fa-2x text-muted"></i>
                            @endif
                        </td>
                        <td>{{ $dokter->name }}</td>
                        <td>{{ $dokter->email }}</td>
                        <td>
                            @if($dokter->is_approved)
                                <span class="badge badge-success">Disetujui</span>
                            @else
                                <span class="badge badge-warning">Pending</span>
                            @endif
                        </td>
                        <td>
                            @if($dokter->is_online)
                                <span class="badge badge-success">Online</span>
                            @else
                                <span class="badge badge-danger">Offline</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('dokter.show', $dokter->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Detail
                            </a>

                            <a href="{{ route('dokter.edit', $dokter->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            <form method="POST" action="{{ route('dokter.destroy', $dokter->id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.dokter.toggle-online', $dokter->id) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $dokter->is_online ? 'btn-secondary' : 'btn-success' }}">
                                    <i class="fas fa-power-off"></i>
                                    {{ $dokter->is_online ? 'Set Offline' : 'Set Online' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
