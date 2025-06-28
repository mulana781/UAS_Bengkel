@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Kendaraan</h5>
                    <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Kendaraan
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pemilik</th>
                                    <th>Merek</th>
                                    <th>Model</th>
                                    <th>Nomor Plat</th>
                                    <th>Tahun</th>
                                    <th>Jumlah Servis</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vehicles as $vehicle)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $vehicle->customer->name }}</td>
                                        <td>{{ $vehicle->brand }}</td>
                                        <td>{{ $vehicle->model }}</td>
                                        <td>{{ $vehicle->plate_number }}</td>
                                        <td>{{ $vehicle->year }}</td>
                                        <td>{{ $vehicle->services->count() }}</td>
                                        <td>
                                            <a href="{{ route('vehicles.show', $vehicle->id) }}" 
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('vehicles.edit', $vehicle->id) }}" 
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('vehicles.destroy', $vehicle->id) }}" 
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data kendaraan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $vehicles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 