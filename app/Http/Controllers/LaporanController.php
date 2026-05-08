<?php

namespace App\Http\Controllers;

use App\Models\HasilPerhitungan;
use App\Models\Period;
use Illuminate\Http\Request;
use PDF;  // Library untuk generate PDF

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil daftar periode untuk dropdown
        $periods = Period::all();
        
        // Jika ada periode yang dipilih, ambil data berdasarkan periode tersebut
        $periode_id = $request->input('periode_id');
        $hasilPerhitungan = HasilPerhitungan::when($periode_id, function ($query, $periode_id) {
            return $query->where('period_id', $periode_id);
        })
        ->with('alternatif')
        ->orderBy('ranking', 'asc')  // Mengurutkan berdasarkan nilai_akhir secara descending
        ->get();

        return view('laporan.index', compact('hasilPerhitungan', 'periods'));
    }

    public function exportPdf(Request $request)
    {
        // Ambil semua periode untuk dropdown
        $periods = Period::all();

        // Ambil data hasil perhitungan berdasarkan periode yang dipilih
        $periode_id = $request->input('periode_id');
        $hasilPerhitungan = HasilPerhitungan::when($periode_id, function ($query, $periode_id) {
            return $query->where('period_id', $periode_id);
        })
        ->with('alternatif')
        ->orderBy('ranking', 'asc')  // Mengurutkan berdasarkan ranking secara ascending
        ->get();

        // Generate PDF menggunakan library 'dompdf'
        $pdf = PDF::loadView('laporan.pdf', compact('hasilPerhitungan', 'periods'));

        // Download PDF
        return $pdf->download('laporan_perhitungan.pdf');
    }
}
