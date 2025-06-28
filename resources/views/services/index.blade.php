@extends('layouts.app')

@section('title', 'Services - Bengkel Management')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Daftar Service</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('services.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Service
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kendaraan</th>
                            <th>Pemilik</th>
                            <th>Kilometer</th>
                            <th>Keluhan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $service)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $service->service_date ? \Carbon\Carbon::parse($service->service_date)->format('d/m/Y') : '-' }}</td>
                                <td>{{ $service->vehicle->license_plate }}</td>
                                <td>{{ $service->vehicle->customer->name }}</td>
                                <td>{{ $service->kilometer ?? '-' }}</td>
                                <td>{{ $service->service_type }}</td>
                                <td>
                                    <span class="badge bg-{{ $service->status === 'completed' ? 'success' : 'warning' }}">
                                        {{ ucfirst($service->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('services.show', $service) }}" class="btn btn-sm btn-info text-white">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('services.edit', $service) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus service ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data service.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $services->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 