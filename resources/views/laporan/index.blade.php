@extends('layouts.app')

@section('title', 'Laporan Hasil Perhitungan')

@section('content')
    <div class="container">
        <h1 class="my-4" style="font-weight: bold;color: #333;">Laporan Hasil Perhitungan</h1>

        <!-- Form Filter Periode -->
        <form method="GET" action="{{ route('laporan.index') }}" class="mb-4 p-4 shadow-sm rounded bg-light">
            <div class="form-group mb-3">
                <label for="periode_id" class="form-label fw-bold">Pilih Periode:</label>
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white">
                        <i class="fas fa-calendar-alt"></i>
                    </span>
                    <select name="periode_id" id="periode_id" class="form-select">
                        <option value="">Semua Periode</option>
                        @foreach($periods as $period)
                            <option value="{{ $period->id }}" {{ request('periode_id') == $period->id ? 'selected' : '' }}>
                                {{ $period->year }} - {{ $period->category }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3 w-100">
                 Tampilkan
            </button>
        </form>


        <!-- Menampilkan hasil perhitungan setelah periode dipilih -->
        @if(request('periode_id') && $hasilPerhitungan->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="hasilPerhitunganTable">
                    <thead>
                        <tr>
                            <th>Pegawai Magang</th>
                            <th>Nilai Akhir</th>
                            <th>Ranking</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hasilPerhitungan as $item)
                            <tr>
                                <td>{{ $item->alternatif->nama_alternatif }}</td>
                                <td>{{ number_format($item->nilai_akhir, 2) }}</td>
                                <td>{{ $item->ranking }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <a href="{{ route('laporan.exportPdf', ['periode_id' => request('periode_id')]) }}" class="btn btn-danger mt-3">Download PDF</a>
        @else
            @if(request('periode_id'))
                <p class="mt-3">Tidak ada data untuk periode yang dipilih.</p>
            @endif
        @endif
    </div>
@endsection
