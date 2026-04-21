<?php

namespace App\Http\Controllers\Legal;

use App\Http\Controllers\Controller;
use App\Models\LegalDocument;
use App\Models\LegalVendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LegalDocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = LegalDocument::with('vendor');

        // 🔍 Search
        if ($request->filled('search')) {
            $query->where('nama_dokumen', 'like', '%' . $request->search . '%');
        }

        $documents = $query->latest()->get();

        // 🎯 Filter Status (karena status adalah accessor)
        if ($request->filled('status')) {
            $documents = $documents->filter(function ($doc) use ($request) {
                return $doc->status === $request->status;
            });
        }

        // 🔄 Manual Pagination karena pakai collection filter
        $currentPage = request()->get('page', 1);
        $perPage = 10;

        $documents = new \Illuminate\Pagination\LengthAwarePaginator(
            $documents->forPage($currentPage, $perPage),
            $documents->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query()
            ]
        );

        return view('legal.documents.index', compact('documents'));
    }

    public function create()
    {
        $vendors = LegalVendor::where('status', 'Aktif')->get();
        return view('legal.documents.create', compact('vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_dokumen'     => 'required|string|max:255',
            'kategori'         => 'required|string|max:100',
            'nomor_dokumen'    => 'nullable|string|max:100',
            'tanggal_terbit'   => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date',
            'vendor_id'        => 'nullable|exists:legal_vendors,id',
            'file_path'        => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        $data = $request->except('file_path');

        // Upload File
        if ($request->hasFile('file_path')) {
            $path = $request->file('file_path')
                            ->store('legal_documents', 'public');
            $data['file_path'] = $path;
        }

        LegalDocument::create($data);

        return redirect()
            ->route('legal.documents.index')
            ->with('success', 'Dokumen berhasil ditambahkan');
    }

    public function edit(LegalDocument $document)
    {
        $vendors = LegalVendor::where('status', 'Aktif')->get();
        return view('legal.documents.edit', compact('document', 'vendors'));
    }

    public function update(Request $request, LegalDocument $document)
    {
        $request->validate([
            'nama_dokumen'     => 'required|string|max:255',
            'kategori'         => 'required|string|max:100',
            'nomor_dokumen'    => 'nullable|string|max:100',
            'tanggal_terbit'   => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date',
            'vendor_id'        => 'nullable|exists:legal_vendors,id',
            'file_path'        => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        $data = $request->except('file_path');

        // Jika upload file baru
        if ($request->hasFile('file_path')) {

            // Hapus file lama jika ada
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            $path = $request->file('file_path')
                            ->store('legal_documents', 'public');

            $data['file_path'] = $path;
        }

        $document->update($data);

        return redirect()
            ->route('legal.documents.index')
            ->with('success', 'Dokumen berhasil diupdate');
    }

    public function destroy(LegalDocument $document)
    {
        // Hapus file dari storage
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Dokumen berhasil dihapus');
    }
}