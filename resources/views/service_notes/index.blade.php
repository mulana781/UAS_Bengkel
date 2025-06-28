@extends('layouts.app')

@section('title', 'Service Notes - Bengkel Management')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h2>Service Notes</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('service-notes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Service Note
        </a>
    </div>
</div>

<!-- Service Notes Table -->
@if($serviceNotes->count() > 0)
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Service</th>
                            <th>Vehicle</th>
                            <th>Note</th>
                            <th>Cost</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($serviceNotes as $note)
                            <tr>
                                <td>{{ $note->id }}</td>
                                <td>{{ $note->service->service_type }}</td>
                                <td>{{ $note->service->vehicle->license_plate }}</td>
                                <td>{{ Str::limit($note->note, 50) }}</td>
                                <td>Rp {{ number_format($note->cost, 0, ',', '.') }}</td>
                                <td>{{ $note->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('service-notes.edit', $note) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('service-notes.destroy', $note) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this note?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $serviceNotes->links() }}
            </div>
        </div>
    </div>
@else
    <div class="alert alert-info">
        No service notes found. <a href="{{ route('service-notes.create') }}">Create one now</a>.
    </div>
@endif
@endsection 