<?php

namespace App\Http\Controllers\Legal;

use App\Http\Controllers\Controller;
use App\Models\LegalCompliance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LegalComplianceController extends Controller
{
    public function index()
    {
        $compliances = LegalCompliance::latest()->paginate(10);
        return view('legal.compliance.index', compact('compliances'));
    }

    public function create()
    {
        return view('legal.compliance.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_compliance' => 'required',
            'nomor' => 'nullable',
            'tanggal_terbit' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx'
        ]);

        $data = $request->only([
            'nama_compliance',
            'nomor',
            'tanggal_terbit',
            'tanggal_berakhir'
        ]);

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('legal/compliance','public');
        }

        LegalCompliance::create($data);

        return redirect()->route('legal.compliance.index')
            ->with('success','Data compliance berhasil ditambahkan');
    }

    public function edit(LegalCompliance $compliance)
    {
        return view('legal.compliance.edit', compact('compliance'));
    }

    public function update(Request $request, LegalCompliance $compliance)
    {
        $request->validate([
            'nama_compliance' => 'required',
            'nomor' => 'nullable',
            'tanggal_terbit' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx'
        ]);

        $data = $request->only([
            'nama_compliance',
            'nomor',
            'tanggal_terbit',
            'tanggal_berakhir'
        ]);

        if ($request->hasFile('file')) {

            if ($compliance->file_path) {
                Storage::disk('public')->delete($compliance->file_path);
            }

            $data['file_path'] = $request->file('file')->store('legal/compliance','public');
        }

        $compliance->update($data);

        return redirect()->route('legal.compliance.index')
            ->with('success','Data compliance berhasil diupdate');
    }

    public function destroy(LegalCompliance $compliance)
    {
        if ($compliance->file_path) {
            Storage::disk('public')->delete($compliance->file_path);
        }

        $compliance->delete();

        return redirect()->route('legal.compliance.index')
            ->with('success','Data compliance berhasil dihapus');
    }
}