<?php

namespace App\Http\Controllers\Labour;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GovernmentRelation;

class GovernmentRelationController extends Controller
{
    public function index()
    {
        $governments = GovernmentRelation::latest()->paginate(10);

        return view('labour.government.index', compact('governments'));
    }

    public function create()
    {
        return view('labour.government.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'instansi' => 'required',
        'agenda' => 'required',
        'tanggal' => 'required|date',
        'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048'
    ]);

    $data = $request->all();

    if($request->hasFile('lampiran')){
        $file = $request->file('lampiran')->store('government','public');
        $data['lampiran'] = $file;
    }
    $data['status'] = $request->status ?? 'Terjadwal';
    GovernmentRelation::create($data);

    return redirect()->route('labour.government.index')
        ->with('success','Data berhasil ditambahkan');
}

    public function edit($id)
    {
        $government = GovernmentRelation::findOrFail($id);

        return view('labour.government.edit', compact('government'));
    }

    public function update(Request $request, $id)
{
    $government = GovernmentRelation::findOrFail($id);

    $request->validate([
        'instansi' => 'required',
        'agenda' => 'required',
        'tanggal' => 'required|date',
        'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
    ]);

    $data = $request->all();

    if($request->hasFile('lampiran')){
        $file = $request->file('lampiran')->store('government','public');
        $data['lampiran'] = $file;
    }

    $government->update($data);

    return redirect()->route('labour.government.index')
        ->with('success','Data berhasil diupdate');
}
    public function destroy($id)
    {
        $government = GovernmentRelation::findOrFail($id);

        $government->delete();

        return redirect()->route('labour.government.index')
            ->with('success','Data berhasil dihapus');
    }
}