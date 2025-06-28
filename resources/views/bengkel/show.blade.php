@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Bengkel</h5>
                    <div>
                        <a href="{{ route('bengkel.edit', $bengkel->id) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('bengkel.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Nama Bengkel:</div>
                        <div class="col-md-8">{{ $bengkel->nama_bengkel }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Alamat:</div>
                        <div class="col-md-8">{{ $bengkel->alamat }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Telepon:</div>
                        <div class="col-md-8">{{ $bengkel->telepon }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Email:</div>
                        <div class="col-md-8">{{ $bengkel->email ?? '-' }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Jam Operasional:</div>
                        <div class="col-md-8">{{ $bengkel->jam_operasional }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Deskripsi:</div>
                        <div class="col-md-8">{{ $bengkel->deskripsi ?? '-' }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Status:</div>
                        <div class="col-md-8">
                            <span class="badge {{ $bengkel->status ? 'bg-success' : 'bg-danger' }}">
                                {{ $bengkel->status ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Dibuat pada:</div>
                        <div class="col-md-8">{{ $bengkel->created_at->format('d F Y H:i') }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Terakhir diperbarui:</div>
                        <div class="col-md-8">{{ $bengkel->updated_at->format('d F Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 