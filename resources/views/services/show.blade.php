@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Servis</h5>
                    <div>
                        <a href="{{ route('services.edit', $service->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Informasi Kendaraan</h6>
                            <table class="table table-sm">
                                <tr>
                                    <th width="150">Pemilik</th>
                                    <td>{{ $service->vehicle->customer->name }}</td>
                                </tr>
                                <tr>
                                    <th>No. Polisi</th>
                                    <td>{{ $service->vehicle->license_plate }}</td>
                                </tr>
                                <tr>
                                    <th>Merk/Model</th>
                                    <td>{{ $service->vehicle->brand }} {{ $service->vehicle->model }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Informasi Servis</h6>
                            <table class="table table-sm">
                                <tr>
                                    <th width="150">Tanggal</th>
                                    <td>{{ $service->date->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Kilometer</th>
                                    <td>{{ number_format($service->kilometer) }} km</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($service->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($service->status == 'in_progress')
                                            <span class="badge bg-primary">Dalam Pengerjaan</span>
                                        @elseif($service->status == 'completed')
                                            <span class="badge bg-success">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h6>Deskripsi Masalah</h6>
                            <p>{{ $service->description }}</p>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Catatan Servis</h6>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                                    <i class="bi bi-plus"></i> Tambah Catatan
                                </button>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Catatan</th>
                                            <th>Biaya</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($service->serviceNotes as $index => $note)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $note->note }}</td>
                                                <td>Rp {{ number_format($note->cost) }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-sm edit-note" 
                                                            data-id="{{ $note->id }}"
                                                            data-note="{{ $note->note }}"
                                                            data-cost="{{ $note->cost }}">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <form action="{{ route('service-notes.destroy', $note->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus catatan ini?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Belum ada catatan servis</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2" class="text-end">Total Biaya:</th>
                                            <th colspan="2">Rp {{ number_format($service->total_cost) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Catatan -->
<div class="modal fade" id="addNoteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('service-notes.store') }}" method="POST">
                @csrf
                <input type="hidden" name="service_id" value="{{ $service->id }}">
                
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Catatan Servis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="note" class="form-label">Catatan</label>
                        <textarea name="note" id="note" rows="3" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="cost" class="form-label">Biaya</label>
                        <input type="number" name="cost" id="cost" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Catatan -->
<div class="modal fade" id="editNoteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editNoteForm" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-header">
                    <h5 class="modal-title">Edit Catatan Servis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_note" class="form-label">Catatan</label>
                        <textarea name="note" id="edit_note" rows="3" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_cost" class="form-label">Biaya</label>
                        <input type="number" name="cost" id="edit_cost" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle edit note button clicks
    document.querySelectorAll('.edit-note').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const note = this.dataset.note;
            const cost = this.dataset.cost;
            
            document.getElementById('edit_note').value = note;
            document.getElementById('edit_cost').value = cost;
            document.getElementById('editNoteForm').action = `/service-notes/${id}`;
            
            new bootstrap.Modal(document.getElementById('editNoteModal')).show();
        });
    });
});
</script>
@endpush
@endsection 