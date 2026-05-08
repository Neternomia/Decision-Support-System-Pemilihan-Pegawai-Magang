@extends('layouts.app')

@section('title', 'Tambah Parameter')

@section('content')

<div class="container">
    <div class="card shadow p-4">
        <h1 class="mb-4">Tambah Parameter</h1>

        <!-- Form untuk Menambah Parameter -->
        <form action="{{ route('parameter.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Parameter</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="bobot" class="form-label">Bobot</label>
                <input type="number" class="form-control" id="bobot" name="bobot" min="0" max="100" required>
            </div>
            <div class="mb-3">
                <label for="kriteria_id" class="form-label">Pilih Kriteria</label>
                <select class="form-control" id="kriteria_id" name="kriteria_id" required>
                    @foreach ($kriterias as $kriteria)
                        <option value="{{ $kriteria->id }}">{{ $kriteria->nama }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

@endsection
