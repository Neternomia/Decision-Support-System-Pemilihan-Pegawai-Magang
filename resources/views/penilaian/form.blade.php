@extends('layouts.app')

@section('title', 'Form Penilaian')

@section('content')
<div class="container">
    <h1>Data Penilaian</h1>

    <!-- Tampilkan Pesan Sukses -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('penilaian.store') }}" method="POST">
        @csrf
        @if($activePeriode)
            <input type="hidden" name="periods_id" value="{{ $activePeriode->id }}">
        @else
            <div class="alert alert-warning">
                Tidak ada periode aktif. Harap aktifkan periode terlebih dahulu.
            </div>
            <button type="submit" class="btn btn-primary mr-2" disabled>Simpan</button>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Alternatif</th>
                    @foreach($kriterias as $kriteria)
                        <th>{{ $kriteria->kode }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($selectedAlternatifs as $alternatif)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $alternatif->nama_alternatif }}</td> <!-- Pastikan kolom 'nama' ada di database -->
                        @foreach($kriterias as $kriteria)
                            <td>
                                <select name="nilai[{{ $alternatif->id }}][{{ $kriteria->id }}]" class="form-control">
                                    <option value="" disabled selected>Pilih</option>
                                    @foreach($kriteria->parameters as $parameter)
                                        <option value="{{ $parameter->id }}">{{ $parameter->nama }}</option>
                                    @endforeach
                                </select>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary mr-2">Simpan</button>
            <button type="button" class="btn btn-warning" id="hitungButton">Hitung</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
    <script>
    document.getElementById("hitungButton").addEventListener("click", function() {
        window.location.href = "{{ url('/perhitungan') }}";  // Menambahkan '/' di awal untuk memastikan URL dari root
    });
    </script>
@endpush