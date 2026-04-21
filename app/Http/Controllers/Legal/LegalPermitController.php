<?php

namespace App\Http\Controllers\Legal;

use App\Http\Controllers\Controller;
use App\Models\LegalPermit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LegalPermitController extends Controller
{
    public function index(Request $request)
{
    $query = LegalPermit::query();

    if ($request->search) {
        $query->where('nama_izin','like','%'.$request->search.'%')
              ->orWhere('nomor_izin','like','%'.$request->search.'%');
    }

    $permits = $query->latest()->paginate(10);

    return view('legal.permits.index', compact('permits'));
}

    public function create()
    {
        return view('legal.permits.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_izin' => 'required',
            'nomor_izin' => 'nullable',
            'instansi_penerbit' => 'nullable',
            'tanggal_terbit' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date',
            'keterangan' => 'nullable',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png'
        ]);

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('legal_permits','public');
        }

        LegalPermit::create($data);

        return redirect()->route('legal.permits.index')
            ->with('success','Data izin berhasil ditambahkan');
    }

    public function edit(LegalPermit $permit)
    {
        return view('legal.permits.edit', compact('permit'));
    }

    public function update(Request $request, LegalPermit $permit)
    {
        $data = $request->validate([
            'nama_izin' => 'required',
            'nomor_izin' => 'nullable',
            'instansi_penerbit' => 'nullable',
            'tanggal_terbit' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date',
            'keterangan' => 'nullable',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png'
        ]);

        if ($request->hasFile('file')) {

    if ($permit->file) {
        Storage::disk('public')->delete($permit->file);
    }

    $data['file'] = $request->file('file')->store('legal_permits','public');
}
        

        $permit->update($data);

        return redirect()->route('legal.permits.index')
            ->with('success','Data izin berhasil diupdate');
    }

    public function destroy(LegalPermit $permit)
    {
        $permit->delete();

        return back()->with('success','Data izin berhasil dihapus');
    }
}