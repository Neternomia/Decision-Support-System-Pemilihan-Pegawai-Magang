<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Alternatif;
use App\Models\Period;
use App\Models\Kriteria;
use App\Models\Parameter;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function selectAlternatif()
    {
        // Ambil periode aktif
        $activePeriode = Period::where('status', true)->first();

        // Ambil semua alternatif (dibatasi dengan pagination)
        $alternatifs = Alternatif::paginate(6);

        // Kirim data ke view
        return view('penilaian.select', compact('activePeriode', 'alternatifs'));
    }

    public function storeSelectedAlternatif(Request $request)
    {
        $request->validate([
            'alternatif_ids' => 'required|array',
        ]);
    
        // Simpan ke session
        session([
            'selected_alternatifs' => $request->alternatif_ids,
        ]);
    
        return redirect()->route('penilaian.form');
    }

    public function penilaianForm()
    {
         // Ambil periode aktif
        $activePeriode = Period::where('status', true)->first();

        // Ambil alternatif yang dipilih dari session
        $selectedAlternatifs = Alternatif::whereIn('id', session('selected_alternatifs'))->get();
        
        // Ambil kriteria beserta parameter yang terkait
        $kriterias = Kriteria::with('parameters')->get();

        return view('penilaian.form', compact('activePeriode', 'selectedAlternatifs', 'kriterias'));
    }

    public function savePenilaian(Request $request)
    {
        $request->validate([
            'nilai' => 'required|array',
            'periods_id' => 'required|exists:periods,id',
        ]);        

        // Cari periode aktif
        $activePeriode = Period::where('status', 1)->first();

        // Ambil alternatif yang dipilih dari session
        $selectedAlternatifs = session('selected_alternatifs');

        foreach ($request->nilai as $alternatifId => $kriteriaData) {
            foreach ($kriteriaData as $kriteriaId => $parameterId) {
                // Ambil bobot dari parameter
                $parameter = Parameter::find($parameterId);

                Penilaian::create([
                    'alternatif_id' => $alternatifId,
                    'kriteria_id' => $kriteriaId,
                    'parameter_id' => $parameterId,
                    'periods_id' => $activePeriode->id,
                    'nilai' => $parameter ? $parameter->bobot : 0, // Gunakan bobot atau default 0 jika parameter tidak ditemukan
                ]);
            }
        }

        return redirect()->route('penilaian.form')->with('success', 'Penilaian berhasil disimpan.');
    }

}
