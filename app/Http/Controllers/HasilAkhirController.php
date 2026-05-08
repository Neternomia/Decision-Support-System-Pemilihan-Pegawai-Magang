<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\Penilaian;
use App\Models\Period;
use App\Models\HasilPerhitungan;
use Illuminate\Http\Request;

class HasilAkhirController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil periode aktif
        $periode_aktif = Period::where('status', 1)->first();

        if (!$periode_aktif) {
            return redirect()->back()->with('error', 'Periode aktif tidak ditemukan!');
        }

        // 2. Ambil data kriteria, penilaian, dan alternatif untuk periode aktif
        $kriteria = Kriteria::all();
        $penilaian = Penilaian::where('periods_id', $periode_aktif->id)->get();
        $alternatif_ids = $penilaian->pluck('alternatif_id')->unique();
        $alternatif = Alternatif::whereIn('id', $alternatif_ids)->get();

        if ($alternatif->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data penilaian untuk periode ini!');
        }

        // 3. Hitung nilai akhir untuk setiap alternatif
        $nilai_akhir = [];
        foreach ($alternatif as $alt) {
            $nilai_akhir[$alt->id] = 0;
            foreach ($kriteria as $krit) {
                $nilai_penilaian = $penilaian->where('alternatif_id', $alt->id)->where('kriteria_id', $krit->id)->first();
                if ($nilai_penilaian) {
                    $nilai = $nilai_penilaian->nilai;
                    $c_min = $penilaian->where('kriteria_id', $krit->id)->min('nilai');
                    $c_max = $penilaian->where('kriteria_id', $krit->id)->max('nilai');

                    $utility = $c_max - $c_min != 0
                        ? ($krit->tipe === 'benefit' 
                            ? ($nilai - $c_min) / ($c_max - $c_min) 
                            : ($c_max - $nilai) / ($c_max - $c_min))
                        : 1;

                    $total_bobot = $kriteria->sum('bobot');
                    $nilai_normalisasi = $krit->bobot / $total_bobot;

                    $nilai_akhir[$alt->id] += $nilai_normalisasi * $utility;
                }
            }
        }

        // 4. Simpan nilai akhir ke database dengan ranking
        arsort($nilai_akhir); // Urutkan nilai akhir secara descending
        $rank = 1;
        foreach ($nilai_akhir as $alternatif_id => $nilai) {
            HasilPerhitungan::updateOrCreate(
                [
                    'alternatif_id' => $alternatif_id,
                    'period_id' => $periode_aktif->id,
                ],
                [
                    'nilai_akhir' => $nilai,
                    'ranking' => $rank++,
                ]
            );
        }

        // 5. Ambil hasil perhitungan untuk ditampilkan
        $hasil_perhitungan = HasilPerhitungan::where('period_id', $periode_aktif->id)
            ->orderBy('ranking') // Urutkan berdasarkan ranking
            ->get();

        return view('hasil_akhir.index', compact('hasil_perhitungan', 'periode_aktif'));
    }
}
