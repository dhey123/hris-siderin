<?php

namespace App\Http\Controllers\SHE;
use App\Http\Controllers\Controller;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Inspection;
use App\Models\InspectionDetail;
use App\Models\InspectionChecklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InspectionController extends Controller
{
    // ============================
    // INDEX
    // ============================
    public function index()
    {
        $inspections = Inspection::with('user')->latest()->get();
        return view('she.environment.inspeksi.index', compact('inspections'));
    }

    // ============================
    // CREATE
    // ============================
    public function create()
    {
        $checklists = InspectionChecklist::where('aktif',1)
    ->orderByRaw("CAST(SUBSTRING_INDEX(kode,'.',1) AS UNSIGNED)")
    ->orderByRaw("CAST(SUBSTRING_INDEX(kode,'.',-1) AS UNSIGNED)")
    ->get([
        'id',
        'kode',
        'item',
        'standar',
        'kategori'
    ]);

        return view('she.environment.inspeksi.create', compact('checklists'));
    }

    // ============================
    // STORE
    // ============================
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'area'    => 'required',
            'jenis'   => 'required',
            'hasil'   => 'required|array'
        ]);

        // ============================
        // GENERATE NOMOR INSPEKSI
        // ============================
        $last = Inspection::latest()->first();

        $urutan = 1;
        if ($last && $last->nomor_inspeksi) {
            $lastNumber = (int) substr($last->nomor_inspeksi, -4);
            $urutan = $lastNumber + 1;
        }

        $nomor = 'INSP-' . date('Ymd') . '-' . str_pad($urutan, 4, '0', STR_PAD_LEFT);

        // ============================
        // HEADER
        // ============================
        $inspection = Inspection::create([
            'nomor_inspeksi' => $nomor,
            'tanggal'        => $request->tanggal,
            'area'           => $request->area,
            'jenis'          => $request->jenis,
            'kategori'       => 'Environment',
            'user_id'        => Auth::id(),
            'status'         => 'Open',
            'keterangan'     => $request->catatan
        ]);

        // ============================
        // DETAIL
        // ============================
        foreach ($request->hasil as $checklistId => $hasil) {

            $checklist = InspectionChecklist::find($checklistId);
            if(!$checklist) continue;

            InspectionDetail::create([
                'inspection_id' => $inspection->id,
                'checklist_id'  => $checklistId,
                'item'          => $checklist->item,
                'standar'       => $checklist->standar,
                'hasil'         => $hasil,
                'keterangan'    => $request->keterangan[$checklistId] ?? null
            ]);
        }

        return redirect()
            ->route('she.environment.inspeksi.index')
            ->with('success','Data inspeksi berhasil disimpan');
    }

    // ============================
    // SHOW
    // ============================
    public function show($id)
    {
        $inspection = Inspection::with('details','user')->findOrFail($id);
        return view('she.environment.inspeksi.show', compact('inspection'));
    }

    // ============================
    // EDIT
    // ============================
    public function edit($id)
    {
        $inspection = Inspection::with('details')->findOrFail($id);

        $checklists = InspectionChecklist::where('aktif',1)
    ->orderByRaw("CAST(SUBSTRING_INDEX(kode,'.',1) AS UNSIGNED)")
    ->orderByRaw("CAST(SUBSTRING_INDEX(kode,'.',-1) AS UNSIGNED)")
    ->get([
        'id',
        'kode',
        'item',
        'standar',
        'kategori'
    ]);
        return view('she.environment.inspeksi.edit', compact('inspection','checklists'));
    }

    // ============================
    // UPDATE
    // ============================
    public function update(Request $request, $id)
    {
        $inspection = Inspection::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date',
            'area'    => 'required',
            'jenis'   => 'required',
            'hasil'   => 'required|array'
        ]);

        $inspection->update([
            'tanggal'    => $request->tanggal,
            'area'       => $request->area,
            'jenis'      => $request->jenis,
            'status'     => $request->status,
            'keterangan' => $request->catatan
        ]);

        // hapus detail lama
        $inspection->details()->delete();

        // simpan ulang detail
        foreach ($request->hasil as $checklistId => $hasil) {

            $checklist = InspectionChecklist::find($checklistId);
            if(!$checklist) continue;

            InspectionDetail::create([
                'inspection_id' => $inspection->id,
                'checklist_id'  => $checklistId,
                'item'          => $checklist->item,
                'standar'       => $checklist->standar,
                'hasil'         => $hasil,
                'keterangan'    => $request->keterangan[$checklistId] ?? null
            ]);
        }

        return redirect()
            ->route('she.environment.inspeksi.index')
            ->with('success','Data inspeksi berhasil diupdate');
    }

    // ============================
    // DESTROY
    // ============================
    public function destroy($id)
    {
        Inspection::findOrFail($id)->delete();
        return back()->with('success','Data inspeksi berhasil dihapus');
    }

    // ============================
    // DOWNLOAD PDF
    // ============================
    public function downloadPdf($id)
    {
        $inspection = Inspection::with('details','user')->findOrFail($id);

        $pdf = Pdf::loadView('she.environment.inspeksi.pdf', compact('inspection'))
                    ->setPaper('A4', 'portrait');

        return $pdf->download('inspection-'.$inspection->nomor_inspeksi.'.pdf');
    }
}