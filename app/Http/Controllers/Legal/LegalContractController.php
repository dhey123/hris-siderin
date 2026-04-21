<?php

namespace App\Http\Controllers\Legal;

use App\Http\Controllers\Controller;

use App\Models\LegalContract;
use App\Models\LegalVendor;
use App\Models\JenisKontrak;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LegalContractController extends Controller
{
    /**
     * LIST KONTRAK
     */
    public function index(Request $request)
    {
        $query = LegalContract::with(['vendor','jenis']);

        // SEARCH
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nomor_kontrak', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_kontrak', 'like', '%' . $request->search . '%');
            });
        }

        // FILTER STATUS
        if ($request->filled('status')) {

            if ($request->status == 'expired') {
                $query->whereDate('tanggal_berakhir', '<', Carbon::today());
            }

            if ($request->status == 'soon') {
                $query->whereBetween('tanggal_berakhir', [
                    Carbon::today(),
                    Carbon::today()->addDays(30)
                ]);
            }

            if ($request->status == 'aktif') {
                $query->whereDate('tanggal_berakhir', '>', Carbon::today()->addDays(30));
            }
        }

        $contracts = $query
            ->orderBy('created_at','desc')
            ->paginate(10)
            ->withQueryString();

        return view('legal.contracts.index', compact('contracts'));
    }


    /**
     * FORM CREATE
     */
    public function create()
    {
        $vendors = LegalVendor::orderBy('nama_vendor')->get();
        $jenisList = JenisKontrak::orderBy('nama_jenis')->get();

        return view('legal.contracts.create', compact('vendors','jenisList'));
    }


    /**
     * SIMPAN KONTRAK
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_id' => 'nullable|exists:legal_vendors,id',
            'nomor_kontrak' => 'required|unique:legal_contracts,nomor_kontrak',
            'nama_kontrak' => 'required|string|max:255',
            'jenis_kontrak_id' => 'required|exists:jenis_kontrak,id',
            'nilai_kontrak' => 'nullable|numeric',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'keterangan' => 'nullable|string'
        ]);

        // Upload file
        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')
                ->store('legal/contracts', 'public');
        }

        LegalContract::create($validated);

        return redirect()
            ->route('legal.contracts.index')
            ->with('success','Kontrak berhasil dibuat.');
    }


    /**
     * FORM EDIT
     */
    public function edit(LegalContract $contract)
    {
        $vendors = LegalVendor::orderBy('nama_vendor')->get();
        $jenisList = JenisKontrak::orderBy('nama_jenis')->get();

        return view('legal.contracts.edit', compact(
            'contract',
            'vendors',
            'jenisList'
        ));
    }


    /**
     * UPDATE KONTRAK
     */
    public function update(Request $request, LegalContract $contract)
    {
        $validated = $request->validate([
            'vendor_id' => 'nullable|exists:legal_vendors,id',
            'nomor_kontrak' => 'required|unique:legal_contracts,nomor_kontrak,' . $contract->id,
            'nama_kontrak' => 'required|string|max:255',
            'jenis_kontrak_id' => 'required|exists:jenis_kontrak,id',
            'nilai_kontrak' => 'nullable|numeric',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'keterangan' => 'nullable|string'
        ]);

        // Upload file baru
        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')
                ->store('legal/contracts', 'public');
        }

        $contract->update($validated);

        return redirect()
            ->route('legal.contracts.index')
            ->with('success','Kontrak berhasil diperbarui.');
    }


    /**
     * DELETE KONTRAK
     */
    public function destroy(LegalContract $contract)
    {
        $contract->delete();

        return redirect()
            ->route('legal.contracts.index')
            ->with('success','Kontrak berhasil dihapus.');
    }


    /**
     * EXPORT PDF
     */
    public function exportPdf()
    {
        $contracts = LegalContract::with(['vendor','jenis'])->get();

        $pdf = Pdf::loadView('legal.contracts.pdf', compact('contracts'));

        return $pdf->download('laporan_kontrak.pdf');
    }


    /**
     * EXPORT EXCEL
     */
    public function exportExcel()
    {
        $contracts = LegalContract::with(['vendor','jenis'])->get();

        return response()
            ->view('legal.contracts.export_excel', compact('contracts'))
            ->header('Content-Type','application/vnd.ms-excel')
            ->header('Content-Disposition','attachment; filename=laporan_kontrak.xls');
    }
}