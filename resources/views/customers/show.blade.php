@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Pelanggan</h5>
                    <div>
                        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <th width="30%">Nama</th>
                                    <td>{{ $customer->name }}</td>
                                </tr>
                                <tr>
                                    <th>Telepon</th>
                                    <td>{{ $customer->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $customer->address }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Daftar Kendaraan</h6>
                            <a href="{{ route('vehicles.create', ['customer_id' => $customer->id]) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah Kendaraan
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Merek</th>
                                            <th>Model</th>
                                            <th>Nomor Plat</th>
                                            <th>Tahun</th>
                                            <th>Jumlah Servis</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($customer->vehicles as $vehicle)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
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
                                                <td colspan="7" class="text-center">Tidak ada data kendaraan</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="mb-0">Riwayat Servis</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Kendaraan</th>
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
                                                <td>{{ $service->date->format('d/m/Y') }}</td>
                                                <td>
                                                    {{ $service->vehicle->brand }} {{ $service->vehicle->model }}
                                                    <br>
                                                    <small class="text-muted">{{ $service->vehicle->plate_number }}</small>
                                                </td>
                                                <td>{{ number_format($service->kilometer, 0, ',', '.') }} km</td>
                                                <td>{{ Str::limit($service->description, 50) }}</td>
                                                <td>
                                                    @if($service->status == 'pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                    @elseif($service->status == 'in_progress')
                                                        <span class="badge bg-info">Dalam Pengerjaan</span>
                                                    @else
                                                        <span class="badge bg-success">Selesai</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('services.show', $service->id) }}" 
                                                        class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Tidak ada riwayat servis</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 