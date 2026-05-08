@extends('layouts.app')

@section('title', 'Edit Kriteria')

@section('content')

    <div class="container">
        <div class="card shadow p-4">
            <h1 class="mb-4">Edit Kriteria</h1>

            <form action="{{ route('kriteria.update', $kriteria->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="kode" class="form-label">Kode Kriteria</label>
                    <input type="text" class="form-control" name="kode" value="{{ $kriteria->kode }}" required>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Kriteria</label>
                    <input type="text" class="form-control" name="nama" value="{{ $kriteria->nama }}" required>
                </div>
                <div class="mb-3">
                    <label for="bobot" class="form-label">Bobot Kriteria (%)</label>
                    <input type="number" class="form-control" name="bobot" value="{{ $kriteria->bobot }}" required min="0" max="100">
                </div>
                <div class="mb-3">
                    <label for="tipe" class="form-label">Tipe Kriteria</label>
                    <select name="tipe" class="form-control" required>
                        <option value="cost" {{ $kriteria->tipe == 'cost' ? 'selected' : '' }}>Cost</option>
                        <option value="benefit" {{ $kriteria->tipe == 'benefit' ? 'selected' : '' }}>Benefit</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('kriteria.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
    
@endsection