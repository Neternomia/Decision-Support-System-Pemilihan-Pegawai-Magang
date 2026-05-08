<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use Illuminate\Http\Request;

class AlternatifController extends Controller
{
    public function index()
    {
        $alternatifs = Alternatif::all(); // Ambil semua data alternatif
        return view('alternatif.index', compact('alternatifs'));
    }

    public function create()
    {
        return view('alternatif.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_alternatif' => 'required',
            'nama_alternatif' => 'required',
        ]);

        Alternatif::create($request->all());
        return redirect()->route('alternatif.index')->with('success', 'Alternatif created successfully!');
    }

    public function edit($id)
    {
        $alternatif = Alternatif::findOrFail($id);
        return view('alternatif.edit', compact('alternatif'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_alternatif' => 'required',
            'nama_alternatif' => 'required',
        ]);

        $alternatif = Alternatif::findOrFail($id);
        $alternatif->update($request->all());
        return redirect()->route('alternatif.index')->with('success', 'Alternatif updated successfully!');
    }

    public function destroy($id)
    {
        $alternatif = Alternatif::findOrFail($id);
        $alternatif->delete();
        return redirect()->route('alternatif.index')->with('success', 'Alternatif deleted successfully!');
    }
}
