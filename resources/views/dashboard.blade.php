@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    /* Warna ikon dan teks oranye soft gelap */
    .stat-card .stat-icon i {
        color: #D07A45; /* Warna oranye gelap untuk ikon */
        font-size: 2.5rem; /* Ukuran ikon */
    }

    .stat-card .stat-info h2 {
        color: #D07A45; /* Warna oranye gelap untuk heading */
        font-size: 1.5rem; /* Ukuran teks heading */
        font-weight: bold; /* Teks tebal */
    }

    .stat-card .stat-info p {
        color: #D07A45; /* Warna oranye gelap untuk teks angka */
        font-size: 1.25rem; /* Ukuran teks angka */
        font-weight: 500; /* Teks semi-tebal */
    }

    /* Menambahkan efek hover */
    .stat-card:hover {
        background-color: #F2D2A9; /* Latar belakang berubah saat hover */
        transition: background-color 0.3s ease; /* Animasi halus */
    }

    .stat-card:hover .stat-icon i,
    .stat-card:hover .stat-info h2,
    .stat-card:hover .stat-info p {
        color: #B5651D; /* Warna lebih gelap saat hover */
    }


</style>
<div class="container mt-4">
    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first('message') }}
        </div>
    @endif

    <!-- Statistik -->
    <div class="statistics-row row">
        <div class="stat-card card-laporan col-md-6 mb-4">
            <div class="stat-icon">
                <i class="fas fa-fw fa-calendar"></i>
            </div>
            <div class="stat-info">
                <h2>Periode</h2>
                <p>{{ $periodeCount }}</p> <!-- Data dinamis -->
            </div>
        </div>
        <div class="stat-card card-kriteria col-md-6 mb-4">
            <div class="stat-icon">
                <i class="fas fa-check-square"></i>
            </div>
            <div class="stat-info">
                <h2>Kriteria</h2>
                <p>{{ $kriteriaCount }}</p> <!-- Data dinamis -->
            </div>
        </div>
        <div class="stat-card card-laporan col-md-6 mb-4">
            <div class="stat-icon">
                <i class="fas fa-check-double"></i>
            </div>
            <div class="stat-info">
                <h2>Alternatif</h2>
                <p>{{ $alternatifCount }}</p> <!-- Data dinamis -->
            </div>
        </div>
        <div class="stat-card card-penilaian col-md-6 mb-4">
            <div class="stat-icon">
                <i class="fas fa-sliders-h"></i>
            </div>
            <div class="stat-info">
                <h2>Parameter</h2>
                <p>{{ $parameterCount }}</p> <!-- Data dinamis -->
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="card shadow">
            <div class="card-header text-center justify-content-end">
                <h5>Nilai Anak Magang Periode 
                    <span id="activePeriodText">{{ $activePeriod->year }} - {{ $activePeriod->category }}</span>
                </h5>
            </div>
            <div class="card-body">
                <!-- Dropdown untuk memilih periode -->
                <div class="mb-3">
                    <label for="selectPeriod" class="form-label">Pilih Periode:</label>
                    <select id="selectPeriod" class="form-select">
                        @foreach ($periods as $period)
                            <option value="{{ $period->id }}" 
                                    {{ $activePeriod->id == $period->id ? 'selected' : '' }}>
                                {{ $period->year }} - {{ $period->category }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <canvas id="barChart" style="height: 300px; max-height: 300px; width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let barChart; // Variabel global untuk grafik

    function updateChart(periodId) {
        // Kirim permintaan AJAX untuk mendapatkan data hasil perhitungan berdasarkan periode
        fetch(`/dashboard/chart-data?period_id=${periodId}`)
            .then(response => response.json())
            .then(data => {
                // Perbarui teks periode aktif
                document.getElementById('activePeriodText').textContent = `${data.activePeriod.year} - ${data.activePeriod.category}`;

                // Perbarui data grafik
                barChart.data.labels = data.results.map(result => result.nama_alternatif);
                barChart.data.datasets[0].data = data.results.map(result => result.nilai_akhir);
                barChart.update();
            })
            .catch(error => console.error('Error:', error));
    }

    document.addEventListener('DOMContentLoaded', function () {
        const canvas = document.getElementById('barChart');
        const ctxBar = canvas.getContext('2d');

        // Inisialisasi grafik
        barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: @json($results->pluck('alternatif.nama_alternatif')->toArray()),
                datasets: [{
                    label: 'Hasil Perhitungan',
                    data: @json($results->pluck('nilai_akhir')->toArray()),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Mengizinkan tinggi khusus diterapkan
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Tambahkan event listener pada dropdown
        const selectPeriod = document.getElementById('selectPeriod');
        selectPeriod.addEventListener('change', function () {
            const selectedPeriodId = this.value;
            updateChart(selectedPeriodId);
        });
    });
</script>
@endpush

