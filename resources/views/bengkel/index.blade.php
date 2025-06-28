@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Bengkel</h5>
                    <a href="{{ route('bengkel.create') }}" class="btn btn-primary">Tambah Bengkel</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Bengkel</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Jam Operasional</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bengkels as $bengkel)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $bengkel->nama_bengkel }}</td>
                                    <td>{{ $bengkel->alamat }}</td>
                                    <td>{{ $bengkel->telepon }}</td>
                                    <td>{{ $bengkel->jam_operasional }}</td>
                                    <td>{{ $bengkel->status ? 'Aktif' : 'Tidak Aktif' }}</td>
                                    <td>
                                        <a href="{{ route('bengkel.show', $bengkel->id) }}" class="btn btn-info btn-sm">Detail</a>
                                        <a href="{{ route('bengkel.edit', $bengkel->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('bengkel.destroy', $bengkel->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus bengkel ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $bengkels->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 