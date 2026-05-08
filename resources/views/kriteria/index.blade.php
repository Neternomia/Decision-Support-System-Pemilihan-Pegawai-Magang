@extends('layouts.app')

@section('title', 'Kriteria')

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
        <h1 class="mb-4" style="font-weight: bold; color: #333;">Daftar Kriteria</h1>

        <!-- Tampilkan Pesan Sukses -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tombol Tambah Kriteria -->
        <a href="{{ route('kriteria.create') }}" 
            class="btn btn-primary mb-4 
            @if($kriterias->count() >= $maxKriteria) 
                disabled 
            @endif">
            Tambah Kriteria
        </a>

        <!-- Tabel Kriteria -->
        <table class="table">
            <thead>
                <tr style="background-color: #FFA07A;">
                    <th>No</th>
                    <th>Kode Kriteria</th>
                    <th>Nama Kriteria</th>
                    <th>Bobot Kriteria (%)</th>
                    <th>Tipe Kriteria</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kriterias as $kriteria)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $kriteria->kode }}</td>
                        <td>{{ $kriteria->nama }}</td>
                        <td>{{ $kriteria->bobot }}</td>
                        <td>{{ ucfirst($kriteria->tipe) }}</td>
                        <td>
                            <!-- Tombol Edit -->
                            <a href="{{ route('kriteria.edit', $kriteria->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            
                            <!-- Tombol Hapus -->
                            <form action="{{ route('kriteria.destroy', $kriteria->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin ingin menghapus kriteria ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
