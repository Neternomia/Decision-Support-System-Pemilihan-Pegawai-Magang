@extends('layouts.app')

@section('title', 'Data Alternatif')

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
    <h1 class="mb-4" style="font-weight: bold; color: #333;">Data Alternatif</h1>
    <a href="{{ route('alternatif.create') }}" class="btn btn-primary mb-3">Tambah Alternatif</a>
    
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    
    <table class="table table-bordered">
        <thead>
            <tr style="background-color: #FFA07A;">
                <th>No</th>
                <th>Kode Alternatif</th>
                <th>Nama Alternatif</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alternatifs as $alternatif)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $alternatif->kode_alternatif }}</td>
                <td>{{ $alternatif->nama_alternatif }}</td>
                <td>
                    <a href="{{ route('alternatif.edit', $alternatif->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('alternatif.destroy', $alternatif->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus?')">
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