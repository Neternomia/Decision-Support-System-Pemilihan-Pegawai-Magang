@extends('layouts.app')

@section('title', 'Periode')

@section('content')

<style>
    /* Font utama */
body {
    font-family: 'Roboto', sans-serif;
}

/* Judul Periode */
h1.my-4 {
    font-weight: bold;
    color: #333; /* Hitam pekat */
}

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
    <h1 class="my-4">Periode</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('periods.store') }}" method="POST" class="mb-4">
        @csrf
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="year" class="form-control" placeholder="Tahun (YYYY)" required>
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select" required>
                    <option value="">Pilih Kategori</option>
                    <option value="Jan-Jun">Jan-Jun</option>
                    <option value="Jul-Dec">Jul-Dec</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Tambah Periode</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tahun</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($periods as $period)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $period->year }}</td>
                    <td>{{ $period->category }}</td>
                    <td>
                        <span class="badge bg-{{ $period->status ? 'success' : 'danger' }}">
                            {{ $period->status ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-toggle-status btn-{{ $period->status ? 'danger' : 'success' }}" 
                                data-id="{{ $period->id }}">
                            {{ $period->status ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-toggle-status').forEach(button => {
            button.addEventListener('click', function () {
                const periodId = this.dataset.id;
                const url = `/periods/${periodId}/toggle-status`;
                const btn = this;

                fetch(url, { method: 'PATCH', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                    .then(response => response.json())
                    .then(data => {
                        btn.classList.toggle('btn-success', !btn.classList.contains('btn-success'));
                        btn.classList.toggle('btn-danger', !btn.classList.contains('btn-danger'));
                        btn.textContent = data.status === 'Aktif' ? 'Nonaktifkan' : 'Aktifkan';
                        btn.closest('tr').querySelector('.badge').textContent = data.status;
                        btn.closest('tr').querySelector('.badge').classList.toggle('bg-success', data.status === 'Aktif');
                        btn.closest('tr').querySelector('.badge').classList.toggle('bg-danger', data.status === 'Tidak Aktif');
                    });
            });
        });
    });
</script>
@endpush
