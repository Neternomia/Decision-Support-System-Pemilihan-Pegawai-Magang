<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Period;

class PeriodController extends Controller
{
    public function index()
    {
        $periods = Period::all();

        // Ambil periode aktif
        $activePeriode = Period::where('status', true)->first();
        return view('periods.index', compact('periods', 'activePeriode'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|digits:4',
            'category' => 'required|in:Jan-Jun,Jul-Dec',
        ]);

        Period::create($validated);

        return redirect()->route('periods.index')->with('success', 'Periode berhasil ditambahkan.');
    }

    public function toggleStatus(Period $period)
    {
        // Jika periode ini diaktifkan, nonaktifkan periode lainnya
        if ($period->status == 0) {
            // Nonaktifkan semua periode lainnya
            Period::where('status', 1)->update(['status' => 0]);

            // Aktifkan periode ini
            $period->update(['status' => 1]);
        } else {
            // Jika periode sudah aktif, nonaktifkan
            $period->update(['status' => 0]);
        }

        return response()->json(['status' => $period->status ? 'Aktif' : 'Tidak Aktif']);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->status === 'active') {
                // Pastikan tidak ada periode aktif lain
                Period::where('status', 'active')->update(['status' => 'inactive']);
            }
        });
    }

}
