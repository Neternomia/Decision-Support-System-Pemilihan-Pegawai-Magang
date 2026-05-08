@extends('layouts.app')

@section('title', 'Update Alternatif')

@section('content')

<div class="container">
    <div class="card shadow p-4">
        <h1>Edit Alternatif</h1>
        
        <form action="{{ route('alternatif.update', $alternatif->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="kode_alternatif">Kode Alternatif</label>
                <input type="text" name="kode_alternatif" id="kode_alternatif" class="form-control" value="{{ $alternatif->kode_alternatif }}" required>
            </div>
            <div class="form-group">
                <label for="nama_alternatif">Nama Alternatif</label>
                <input type="text" name="nama_alternatif" id="nama_alternatif" class="form-control" value="{{ $alternatif->nama_alternatif }}" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>
    </div>
</div>

@endsection