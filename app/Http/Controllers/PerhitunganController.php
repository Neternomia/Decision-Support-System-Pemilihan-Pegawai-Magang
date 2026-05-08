<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\Penilaian;
use App\Models\Period; // Model Periode
use Illuminate\Http\Request;

class PerhitunganController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil periode aktif atau yang dipilih
        $periode_aktif = Period::where('status', 1)->first();

        if (!$periode_aktif) {
            return redirect()->back()->with('error', 'Periode aktif tidak ditemukan!');
        }

        // 2. Ambil data berdasarkan periode aktif
        $kriteria = Kriteria::all();
        $penilaian = Penilaian::where('periods_id', $periode_aktif->id)->get();

        // Ambil alternatif yang memiliki data penilaian untuk periode ini
        $alternatif_ids = $penilaian->pluck('alternatif_id')->unique();
        $alternatif = Alternatif::whereIn('id', $alternatif_ids)->get();

        if ($alternatif->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data penilaian untuk periode ini!');
        }

        // 3. Normalisasi Bobot Kriteria
        $total_bobot = $kriteria->sum('bobot');
        foreach ($kriteria as $krit) {
            $krit->nilai_normalisasi = $krit->bobot / $total_bobot;
        }

        // 4. Hitung Nilai Utility
        $utility = [];
        foreach ($alternatif as $alt) {
            foreach ($kriteria as $krit) {
                $nilai_penilaian = $penilaian->where('alternatif_id', $alt->id)
                                            ->where('kriteria_id', $krit->id)
                                            ->first();

                if (!$nilai_penilaian) {
                    // Jika data penilaian untuk kriteria ini tidak ada, skip perhitungan untuk alternatif ini
                    return redirect()->back()->with('error', 'Data penilaian tidak lengkap untuk kriteria pada alternatif: ' . $alt->nama_alternatif);
                }

                $nilai = $nilai_penilaian->nilai;

                // Ambil nilai minimum dan maksimum untuk kriteria ini
                $c_min = $penilaian->where('kriteria_id', $krit->id)->min('nilai');
                $c_max = $penilaian->where('kriteria_id', $krit->id)->max('nilai');

                if ($c_max - $c_min != 0) {
                    if ($krit->tipe == 'benefit') {
                        $utility[$alt->id][$krit->id] = ($nilai - $c_min) / ($c_max - $c_min);
                    } else { // Jenis 'Cost'
                        $utility[$alt->id][$krit->id] = ($c_max - $nilai) / ($c_max - $c_min);
                    }
                } else {
                    $utility[$alt->id][$krit->id] = 1; // Jika nilai min dan max sama
                }
            }
        }

        // 5. Hitung Nilai Akhir dan simpan ke tabel hasil_perhitungan
        $nilai_akhir = [];
        foreach ($alternatif as $alt) {
            $nilai_akhir[$alt->id] = 0;
            foreach ($kriteria as $krit) {
                $nilai_akhir[$alt->id] += $krit->nilai_normalisasi * $utility[$alt->id][$krit->id];
            }

            // 6. Periksa apakah sudah ada data perhitungan untuk alternatif_id dan period_id yang sama
            $existingResult = \App\Models\HasilPerhitungan::where('alternatif_id', $alt->id)
                                                           ->where('period_id', $periode_aktif->id)
                                                           ->first();

            if ($existingResult) {
                // Jika data sudah ada, lakukan update
                $existingResult->nilai_akhir = $nilai_akhir[$alt->id];
                $existingResult->save();
            } else {
                // Jika data belum ada, simpan data baru
                \App\Models\HasilPerhitungan::create([
                    'alternatif_id' => $alt->id,
                    'period_id' => $periode_aktif->id,
                    'nilai_akhir' => $nilai_akhir[$alt->id],
                ]);
            }
        }

        // 7. Kirim data ke view
        return view('perhitungan.index', compact(
            'kriteria',
            'alternatif',
            'penilaian',
            'utility',
            'nilai_akhir',
            'periode_aktif'
        ));
    }
}
