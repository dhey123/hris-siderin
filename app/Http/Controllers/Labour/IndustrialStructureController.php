<?php

namespace App\Http\Controllers\Labour;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IndustrialStructure;

class IndustrialStructureController extends Controller
{
    public function index()
    {
        $structures = IndustrialStructure::latest()->paginate(10);

        return view('labour.structures.index', compact('structures'));
    }

    public function create()
    {
        return view('labour.structures.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'nullable',
            'pihak' => 'nullable',
            'kontak' => 'nullable',
            'keterangan' => 'nullable'
        ]);

        IndustrialStructure::create($request->all());

        return redirect()->route('labour.structures.index')
            ->with('success','Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $structure = IndustrialStructure::findOrFail($id);

        return view('labour.structures.show', compact('structure'));
    }

    public function edit($id)
    {
        $structure = IndustrialStructure::findOrFail($id);

        return view('labour.structures.edit', compact('structure'));
    }

    public function update(Request $request, $id)
    {
        $structure = IndustrialStructure::findOrFail($id);

        $request->validate([
            'nama' => 'required',
        ]);

        $structure->update($request->all());

        return redirect()->route('labour.structures.index')
            ->with('success','Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $structure = IndustrialStructure::findOrFail($id);

        $structure->delete();

        return redirect()->route('labour.structures.index')
            ->with('success','Data berhasil dihapus');
    }
}