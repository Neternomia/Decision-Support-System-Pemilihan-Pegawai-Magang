@extends('layouts.app')

@section('title', 'Pilih Alternatif')

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
    <h1 style="font-weight: bold;color: #333;" class="mb-4">Data Penilaian</h1>

    {{-- Periode Aktif --}}
    @if($activePeriode)
        <div class="form-group">
            <label for="periode">Periode</label>
            <input type="text" id="periode" class="form-control" 
                value="{{ $activePeriode->year }} - {{ $activePeriode->category }}" readonly>
        </div>
    @else
        <div class="alert alert-warning">
            Tidak ada periode aktif. Harap aktifkan periode terlebih dahulu.
        </div>
    @endif

    {{-- Data Alternatif --}}
    @if($alternatifs->isNotEmpty())
        <form action="{{ route('penilaian.storeSelected') }}" method="POST">
            @csrf
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
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
                                <input type="checkbox" name="alternatif_ids[]" value="{{ $alternatif->id }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $alternatifs->links() }} {{-- Pagination --}}
            <button type="submit" class="btn btn-primary">Next</button>
        </form>
    @else
        <div class="alert alert-warning">Belum ada data alternatif yang tersedia.</div>
    @endif
</div>
@endsection
