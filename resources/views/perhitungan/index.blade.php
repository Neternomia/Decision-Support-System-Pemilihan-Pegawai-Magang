@extends('layouts.app')

@section('title', 'Perhitungan')

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

h2{
    font-weight: bold;
    color: #333; /* Hitam pekat */
}

h4{
    font-weight: 500;
    color: #333; /* Hitam pekat */
}
</style>

<div class="container">
    <h2 class="mb-4">Data Perhitungan</h2>

    <!-- Periode Aktif -->
    <div class="alert alert-primary d-inline-flex align-items-center p-3 shadow-sm" role="alert" style="border-radius: 8px;">
        <i class="fas fa-calendar-alt me-2" style="color: #007bff;"></i>
        <span><strong>Periode Aktif:</strong> {{ $periode_aktif->year }} - {{ $periode_aktif->category }}</span>
    </div>

    <!-- Tabel Normalisasi Bobot -->
    <h4 class="mt-4">Normalisasi Nilai</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                @foreach ($kriteria as $krit)
                    <th>{{ $krit->kode }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach ($kriteria as $krit)
                    <td>{{ number_format($krit->nilai_normalisasi, 2) }}</td>
                @endforeach
            </tr>
        </tbody>
    </table>

    <!-- Tabel Data Nilai Parameter -->
    <h4 class="mt-4">Data Nilai Parameter</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th></th>
                @foreach ($kriteria as $krit)
                    <th>{{ $krit->kode }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($alternatif as $alt)
                <tr>
                    <td><strong>{{ $alt->kode_alternatif }}</strong></td>
                    @foreach ($kriteria as $krit)
                        <td>
                            @php
                                $penilaian_alt = $penilaian->where('alternatif_id', $alt->id)->where('kriteria_id', $krit->id)->first();
                                echo $penilaian_alt ? $penilaian_alt->nilai : '-';
                            @endphp
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tabel Nilai Utility -->
    <h4 class="mt-4">Nilai Utility</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th></th>
                @foreach ($kriteria as $krit)
                    <th>{{ $krit->kode }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($alternatif as $alt)
                <tr>
                    <td><strong>{{ $alt->kode_alternatif }}</strong></td>
                    @foreach ($kriteria as $krit)
                        <td>{{ number_format($utility[$alt->id][$krit->id], 2) }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tabel Nilai Akhir -->
    <h4 class="mt-4">Nilai Akhir</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Alternatif</th>
                <th>Nilai Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alternatif as $alt)
                <tr>
                    <td>{{ $alt->kode_alternatif }}</td>
                    <td>{{ number_format($nilai_akhir[$alt->id], 4) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tombol menuju halaman hasil akhir -->
    <div class="mt-4">
        <a href="{{ route('hasil_akhir.index') }}" class="btn btn-primary">Lihat Hasil Akhir</a>
    </div>
</div>

@endsection
