@extends('layouts.app')

@section('title', 'Tambah Alternatif')

@section('content')

<div class="container">
    <div class="card shadow p-4">
        <h1>Tambah Alternatif</h1>
        
        <form action="{{ route('alternatif.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="kode_alternatif">Kode Alternatif</label>
                <input type="text" name="kode_alternatif" id="kode_alternatif" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="nama_alternatif">Nama Alternatif</label>
                <input type="text" name="nama_alternatif" id="nama_alternatif" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        </form>
    </div>
</div>

@endsection