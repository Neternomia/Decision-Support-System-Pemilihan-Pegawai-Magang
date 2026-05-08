<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Period;
use App\Models\HasilPerhitungan; // Sesuaikan dengan model hasil perhitungan
use App\Models\Kriteria;
use App\Models\Parameter;
use App\Models\Penilaian; // Memastikan Penilaian dimasukkan
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data jumlah periode, kriteria, alternatif, dan parameter
        $periodeCount = Period::count();
        $kriteriaCount = Kriteria::count();
        $alternatifCount = Alternatif::count();
        $parameterCount = Parameter::count();
        $periods = Period::all();

        // Ambil periode aktif
        $activePeriod = Period::where('status', 1)->first();

        if (!$activePeriod) {
            return view('dashboard', [
                'periodeCount' => $periodeCount,
                'kriteriaCount' => $kriteriaCount,
                'alternatifCount' => $alternatifCount,
                'parameterCount' => $parameterCount,
                'alternatifs' => collect([]), // Kosongkan jika tidak ada periode aktif
                'results' => collect([]), // Ganti rankings dengan hasil perhitungan
            ])->withErrors(['message' => 'Tidak ada periode aktif saat ini.']);
        }

        // Ambil alternatif yang memiliki penilaian pada periode aktif
        $alternatifs = Penilaian::where('periods_id', $activePeriod->id)
            ->with('alternatif')
            ->get()
            ->pluck('alternatif')
            ->unique('id');

        // Ambil data hasil perhitungan
        $results = HasilPerhitungan::where('period_id', $activePeriod->id)
            ->with('alternatif')  // Mengambil data alternatif terkait
            ->orderBy('nilai_akhir', 'desc')  // Urutkan berdasarkan nilai akhir
            ->get();

        // Kirim data ke view
        return view('dashboard', compact(
            'periodeCount', 'kriteriaCount', 'alternatifCount', 'parameterCount',
            'alternatifs', 'results', 'activePeriod', 'periods'
        ));

    }

    public function getChartData(Request $request)
    {
        $periodId = $request->query('period_id');
        $activePeriod = Period::findOrFail($periodId);

        // Ambil data hasil perhitungan
        $results = HasilPerhitungan::where('period_id', $periodId)
            ->with('alternatif')  // Ambil data alternatif terkait
            ->orderBy('nilai_akhir', 'desc')  // Urutkan berdasarkan nilai akhir
            ->get()
            ->map(function ($result) {
                return [
                    'nama_alternatif' => $result->alternatif->nama_alternatif,
                    'nilai_akhir' => $result->nilai_akhir,
                ];
            });

        return response()->json([
            'activePeriod' => $activePeriod,
            'results' => $results,
        ]);
    }

}

