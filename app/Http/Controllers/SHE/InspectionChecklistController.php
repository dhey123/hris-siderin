<?php

namespace App\Http\Controllers\SHE;
use App\Http\Controllers\Controller;
use App\Models\InspectionChecklist;
use Illuminate\Http\Request;

class InspectionChecklistController extends Controller
{
    // ============================
    // INDEX
    // ============================
    public function index()
    {
         $checklists = InspectionChecklist::orderByRaw("
        CAST(SUBSTRING_INDEX(kode, '.', 1) AS UNSIGNED),
        CAST(SUBSTRING_INDEX(kode, '.', -1) AS UNSIGNED)
    ")->get();

        return view('she.inspection_checklists.index', compact('checklists'));
    }

    // ============================
    // CREATE
    // ============================
    public function create()
    {
        return view('she.inspection_checklists.create');
    }

    // ============================
    // STORE (MANUAL KODE)
    // ============================
    public function store(Request $request)
    {
        $request->validate([
            'kode'     => 'required|string|max:50',
            'kategori' => 'required|in:Safety,Health,Environment',
            'area'     => 'required|string|max:100',
            'item'     => 'required|string|max:255',
            'standar'  => 'nullable|string|max:255',
        ]);

        InspectionChecklist::create([
            'kode'     => $request->kode,
            'kategori' => $request->kategori,
            'area'     => $request->area,
            'item'     => $request->item,
            'standar'  => $request->standar,
            'aktif'    => $request->has('aktif') ? 1 : 0,
        ]);

        return redirect()
            ->route('she.inspection-checklists.index')
            ->with('success','Checklist berhasil ditambahkan');
    }

    // ============================
    // EDIT
    // ============================
    public function edit(InspectionChecklist $inspectionChecklist)
    {
        return view('she.inspection_checklists.edit', compact('inspectionChecklist'));
    }

    // ============================
    // UPDATE (MANUAL KODE)
    // ============================
    public function update(Request $request, InspectionChecklist $inspectionChecklist)
    {
        $request->validate([
            'kode'     => 'required|string|max:50',
            'kategori' => 'required|in:Safety,Health,Environment',
            'area'     => 'required|string|max:100',
            'item'     => 'required|string|max:255',
            'standar'  => 'nullable|string|max:255',
            'aktif'    => 'nullable|boolean'
        ]);

        $inspectionChecklist->update([
            'kode'     => $request->kode,
            'kategori' => $request->kategori,
            'area'     => $request->area,
            'item'     => $request->item,
            'standar'  => $request->standar,
            'aktif'    => $request->has('aktif') ? 1 : 0
        ]);

        return redirect()
            ->route('she.inspection-checklists.index')
            ->with('success', 'Checklist berhasil diperbarui');
    }

    // ============================
    // DESTROY
    // ============================
    public function destroy(InspectionChecklist $inspectionChecklist)
    {
        $inspectionChecklist->delete();

        return back()->with('success', 'Checklist berhasil dihapus');
    }

    // ============================
    // API LIST
    // ============================
    public function apiList(Request $request)
    {
        $kategori = $request->query('kategori');

        $checklists = InspectionChecklist::where('kategori', $kategori)
                         ->where('aktif', 1)
                         ->orderBy('kode')
                         ->get(['id','kode','item','standar']);

        return response()->json($checklists);
    }
}
