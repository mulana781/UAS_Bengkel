@extends('layouts.app')

@section('title', 'Edit Service Note - Bengkel Management')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2>Edit Service Note</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('service-notes.update', $serviceNote) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="service_id" class="form-label">Service</label>
                        <select name="service_id" id="service_id" class="form-select @error('service_id') is-invalid @enderror" required>
                            <option value="">Select Service</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ (old('service_id') ?? $serviceNote->service_id) == $service->id ? 'selected' : '' }}>
                                    {{ $service->vehicle->license_plate }} - {{ $service->service_type }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea name="note" id="note" rows="3" class="form-control @error('note') is-invalid @enderror" required>{{ old('note') ?? $serviceNote->note }}</textarea>
                        @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cost" class="form-label">Cost (Rp)</label>
                        <input type="number" name="cost" id="cost" class="form-control @error('cost') is-invalid @enderror" value="{{ old('cost') ?? $serviceNote->cost }}" required>
                        @error('cost')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('service-notes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Service Note
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 