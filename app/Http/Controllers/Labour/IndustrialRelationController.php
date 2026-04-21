<?php

namespace App\Http\Controllers\Labour;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IndustrialRelation;
use Illuminate\Support\Str;

class IndustrialRelationController extends Controller
{

    public function index(Request $request)
    {
        $query = IndustrialRelation::query();

        // FILTER JENIS
        if ($request->jenis && $request->jenis != 'Semua') {
            $query->where('jenis', $request->jenis);
        }

        // SEARCH JUDUL
        if ($request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $relations = $query->latest()->paginate(10);

        return view('labour.relations.index', compact('relations'));
    }


    public function create()
    {
        return view('labour.relations.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'jenis' => 'required',
            'tanggal' => 'required|date',
            'status' => 'required',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        $data = $request->all();

        // UPLOAD FILE
        if ($request->hasFile('file_dokumen')) {

            $file = $request->file('file_dokumen');

            // AUTO RENAME FILE
            $filename = time() . '_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();

            $file->storeAs('industrial', $filename, 'public');

            $data['file_dokumen'] = 'industrial/' . $filename;
        }

        IndustrialRelation::create($data);

        return redirect()
            ->route('labour.relations.index')
            ->with('success', 'Data berhasil ditambahkan');
    }


    public function edit($id)
    {
        $relation = IndustrialRelation::findOrFail($id);

        return view('labour.relations.edit', compact('relation'));
    }


    public function update(Request $request, $id)
    {
        $relation = IndustrialRelation::findOrFail($id);

        $request->validate([
            'jenis' => 'required',
            'judul' => 'required',
            'tanggal' => 'required|date',
            'status' => 'required',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        $data = $request->all();

        // UPDATE FILE
        if ($request->hasFile('file_dokumen')) {

            $file = $request->file('file_dokumen');

            $filename = time() . '_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();

            $file->storeAs('industrial', $filename, 'public');

            $data['file_dokumen'] = 'industrial/' . $filename;
        }

        $relation->update($data);

        return redirect()
            ->route('labour.relations.index')
            ->with('success', 'Data berhasil diupdate');
    }


    public function destroy($id)
    {
        $relation = IndustrialRelation::findOrFail($id);

        $relation->delete();

        return redirect()
            ->route('labour.relations.index')
            ->with('success', 'Data berhasil dihapus');
    }
}