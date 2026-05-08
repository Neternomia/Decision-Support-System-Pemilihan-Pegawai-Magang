@extends('layouts.app')

@section('title', 'Daftar Parameter')

@section('content')
<style>
    .table thead tr {
    background-color: #FFA07A; /* Warna orange soft */
    color: #FFFFFF; /* Teks putih agar kontras */
    text-transform: uppercase;
    font-weight: bold;
}

.table thead th {
    padding: 12px;
    border-bottom: 2px solid #ff8c66; /* Garis bawah yang lebih gelap untuk efek estetik */
}
</style>
<div class="container">
    <h1 class="mb-4" style="font-weight: bold;color: #333;">Daftar Parameter Berdasarkan Kriteria</h1>

    <!-- Tampilkan Pesan Sukses -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tombol Tambah Parameter -->
    <a href="{{ route('parameter.create') }}" class="btn btn-primary mb-4">Tambah Parameter</a>

    <!-- Loop untuk menampilkan Kriteria dan Parameter masing-masing -->
    @foreach ($kriterias as $kriteria)
        <div class="card mb-4">
            <div class="card-header">
                <h4>{{ $kriteria->nama }}</h4>
            </div>
            <div class="card-body">
                <!-- Tabel Parameter -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Parameter</th>
                            <th>Bobot</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kriteria->parameters as $parameter)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $parameter->nama }}</td>
                                <td>{{ $parameter->bobot }}</td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('parameter.edit', $parameter->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('parameter.destroy', $parameter->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin ingin menghapus parameter ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>

@endsection
