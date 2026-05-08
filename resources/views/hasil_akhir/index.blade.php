@extends('layouts.app')

@section('title', 'Data Hasil Akhir')

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
    <h2 class="mb-4">Data Hasil Akhir</h2>
    <!-- Periode Aktif -->
    <div class="alert alert-primary d-inline-flex align-items-center p-3 shadow-sm" role="alert" style="border-radius: 8px;">
        <i class="fas fa-calendar-alt me-2" style="color: #007bff;"></i>
        <span><strong>Periode Aktif:</strong> {{ $periode_aktif->year }} - {{ $periode_aktif->category }}</span>
    </div>

    <!-- Data Perengkingan -->
    <h4>Data Perengkingan</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Alternatif</th>
                <th>Nilai Akhir</th>
                <th>Perengkingan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hasil_perhitungan as $hasil)
                <tr>
                    <td>{{ $loop->iteration }}</td> <!-- Gunakan $loop->iteration -->
                    <td>{{ $hasil->alternatif->kode_alternatif }}</td>
                    <td>{{ $hasil->alternatif->nama_alternatif }}</td>
                    <td>{{ number_format($hasil->nilai_akhir, 2) }}</td>
                    <td>{{ $hasil->ranking }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Catatan Kesimpulan -->
    <h4 class="mt-4">Catatan Kesimpulan</h4>
    <p>
        Anak magang yang teladan pada tahun <strong>{{ $periode_aktif->year }}</strong> dengan periode magang <strong>{{ $periode_aktif->category }}</strong> adalah 
        <strong>{{ $hasil_perhitungan->first()->alternatif->nama_alternatif }}</strong>.
    </p>
</div>

@endsection
