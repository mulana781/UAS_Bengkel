@extends('layouts.app')

@section('content')
<style>
body {
    background: linear-gradient(135deg, #232526 0%, #414345 100%);
    font-family: 'Roboto', Arial, sans-serif;
    color: #f5f5f5;
}
.card {
    background: #232526;
    border-radius: 16px;
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.17);
    border: 1px solid #444;
    color: #fff;
}
.card-header {
    background: #ffb300;
    color: #232526;
    border-radius: 16px 16px 0 0;
    font-weight: bold;
    letter-spacing: 1px;
}
.card .stat-label {
    color: #ffb300;
    font-size: 1rem;
    font-weight: 500;
}
.card .stat-value {
    color: #fff;
    font-size: 2rem;
    font-weight: bold;
}
.form-label {
    color: #ffb300;
    font-weight: 500;
}
.form-control {
    background: #232526;
    color: #fff;
    border: 1px solid #ffb300;
    border-radius: 8px;
    transition: border 0.3s;
}
.form-control:focus {
    border-color: #ff6f00;
    box-shadow: 0 0 0 2px #ffb30044;
}
.btn-primary {
    background: linear-gradient(90deg, #ffb300 0%, #ff6f00 100%);
    border: none;
    color: #232526;
    font-weight: bold;
    border-radius: 8px;
    transition: background 0.3s;
}
.btn-primary:hover {
    background: linear-gradient(90deg, #ff6f00 0%, #ffb300 100%);
    color: #fff;
}
.btn-secondary {
    background: #444;
    color: #ffb300;
    border: 1px solid #ffb300;
    border-radius: 8px;
}
.btn-secondary:hover {
    background: #ffb300;
    color: #232526;
}
.table {
    background: #232526;
    color: #fff;
}
.table th {
    color: #ffb300;
    background: #232526;
    font-weight: bold;
}
.table td {
    background: #232526;
    color: #fff;
}
.table-striped > tbody > tr:nth-of-type(odd) {
    background-color: #2d2d2d;
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Torque Garage</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('bengkel.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="nama_bengkel" class="form-label">Nama Bengkel</label>
                            <input type="text" class="form-control @error('nama_bengkel') is-invalid @enderror" id="nama_bengkel" name="nama_bengkel" value="{{ old('nama_bengkel') }}" required>
                            @error('nama_bengkel')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" value="{{ old('telepon') }}" required>
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jam_operasional" class="form-label">Jam Operasional</label>
                            <input type="text" class="form-control @error('jam_operasional') is-invalid @enderror" id="jam_operasional" name="jam_operasional" value="{{ old('jam_operasional') }}" required>
                            @error('jam_operasional')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="status" name="status" value="1" {{ old('status') ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">Status Aktif</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('bengkel.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 