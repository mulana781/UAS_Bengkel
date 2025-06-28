@extends('layouts.app')

@section('title', 'Edit Service - Bengkel Management')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Service</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('services.update', $service) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="vehicle_id" class="form-label">Kendaraan</label>
                            <select class="form-select @error('vehicle_id') is-invalid @enderror" id="vehicle_id" name="vehicle_id" required>
                                <option value="">Pilih Kendaraan</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}" {{ old('vehicle_id', $service->vehicle_id) == $vehicle->id ? 'selected' : '' }}>
                                        {{ $vehicle->license_plate }} - {{ $vehicle->customer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('vehicle_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="service_date" class="form-label">Tanggal Service</label>
                            <input type="date" class="form-control @error('service_date') is-invalid @enderror" id="service_date" name="service_date" value="{{ old('service_date', $service->service_date ? \Carbon\Carbon::parse($service->service_date)->format('Y-m-d') : '') }}" required>
                            @error('service_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="service_type" class="form-label">Jenis Service</label>
                            <input type="text" class="form-control @error('service_type') is-invalid @enderror" id="service_type" name="service_type" value="{{ old('service_type', $service->service_type) }}" required>
                            @error('service_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kilometer" class="form-label">Kilometer</label>
                            <input type="number" class="form-control @error('kilometer') is-invalid @enderror" id="kilometer" name="kilometer" value="{{ old('kilometer', $service->kilometer) }}" required>
                            @error('kilometer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="pending" {{ old('status', $service->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ old('status', $service->status) == 'in_progress' ? 'selected' : '' }}>Dalam Pengerjaan</option>
                                <option value="completed" {{ old('status', $service->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('services.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Update Service</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 