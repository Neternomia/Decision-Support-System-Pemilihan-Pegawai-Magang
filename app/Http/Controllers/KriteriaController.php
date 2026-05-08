<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriterias = Kriteria::all();
        $maxKriteria = 5; // batas maksimal jumlah kriteria

        // Kirim variabel maxKriteria ke view
        return view('kriteria.index', compact('kriterias', 'maxKriteria'));
    }

    public function create()
    {
        return view('kriteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:kriterias',
            'nama' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:100',
            'tipe' => 'required|in:cost,benefit',
        ]);

        Kriteria::create($request->all());

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        return view('kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:kriterias,kode,' . $id,
            'nama' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:100',
            'tipe' => 'required|in:cost,benefit',
        ]);

        $kriteria = Kriteria::findOrFail($id);
        $kriteria->update($request->all());

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        $kriteria->delete();

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil dihapus');
    }
}
