<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil Perhitungan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .table-container {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f8f8;
            font-weight: bold;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }

        .header {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
        }

        .header p {
            font-size: 14px;
            color: #555;
            margin: 5px 0;
        }

        .header .title {
            font-size: 18px;
            font-weight: bold;
        }

    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <p class="title">Laporan Hasil Perhitungan</p>
            <p> Periode Magang:     @if(request('periode_id'))
                                        {{ $periods->where('id', request('periode_id'))->first()->year }} - 
                                        {{ $periods->where('id', request('periode_id'))->first()->category }}
                                    @else
                                        Semua Periode
                                    @endif
            </p>
            <p>Tanggal: {{ now()->format('d M Y') }}</p>
        </div>

        <h1>Data Hasil Perhitungan</h1>

        <div class="table-container">
            <table>
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

        <div class="footer">
            <p>Dicetak oleh: {{ auth()->user()->name }}</p>
            <p>&copy; {{ date('Y') }} - Laporan Hasil Perhitungan</p>
        </div>
    </div>

</body>
</html>
