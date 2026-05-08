<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Parameter;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    // Menampilkan Semua Parameter
    public function index()
    {
        $kriterias = Kriteria::with('parameters')->get();

        return view('parameter.index', compact('kriterias'));
    }

    // Menampilkan Form Tambah Parameter
    public function create()
    {
        $kriterias = Kriteria::all(); // Ambil semua kriteria untuk dropdown
        return view('parameter.create', compact('kriterias'));
    }

    // Menyimpan Data Parameter
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:100',
            'kriteria_id' => 'required|exists:kriterias,id', // Validasi foreign key kriteria
        ]);

        Parameter::create($request->all());

        return redirect()->route('parameter.index')->with('success', 'Parameter berhasil ditambahkan');
    }

    // Menampilkan Form Edit Parameter
    public function edit($id)
    {
        $parameter = Parameter::findOrFail($id);
        $kriterias = Kriteria::all();
        return view('parameter.edit', compact('parameter', 'kriterias'));
    }

    // Mengupdate Data Parameter
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0|max:100',
            'kriteria_id' => 'required|exists:kriterias,id',
        ]);

        $parameter = Parameter::findOrFail($id);
        $parameter->update($request->all());

        return redirect()->route('parameter.index')->with('success', 'Parameter berhasil diperbarui');
    }

    // Menghapus Parameter
    public function destroy($id)
    {
        $parameter = Parameter::findOrFail($id);
        $parameter->delete();

        return redirect()->route('parameter.index')->with('success', 'Parameter berhasil dihapus');
    }
}
