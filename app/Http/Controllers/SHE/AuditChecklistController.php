<?php
namespace App\Http\Controllers\SHE;
use App\Http\Controllers\Controller;

use App\Models\AuditChecklist;
use Illuminate\Http\Request;

class AuditChecklistController extends Controller
{
    public function index()
{
    $checklists = AuditChecklist::orderBy('kategori')
        ->orderByRaw("CAST(SUBSTRING_INDEX(kode, '-', -1) AS UNSIGNED)")
        ->get();

    return view('settings.audit-checklist.index', compact('checklists'));
}
    public function create()
    {
        return view('settings.audit-checklist.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'kode' => 'required',
        'kategori' => 'required',
        'item' => 'required',
        'aktif' => 'required|boolean'
    ]);

    AuditChecklist::create([
        'kode' => $request->kode,
        'kategori' => $request->kategori,
        'item' => $request->item,
        'aktif' => $request->aktif,
    ]);

    return redirect()->route('settings.audit-checklist.index')
        ->with('success', 'Checklist berhasil ditambahkan.');
}

    public function edit($id)
    {
        $checklist = AuditChecklist::findOrFail($id);

        return view('settings.audit-checklist.edit', compact('checklist'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'kode' => 'required',
        'kategori' => 'required',
        'item' => 'required',
        'aktif' => 'required|boolean'
    ]);

    $checklist = AuditChecklist::findOrFail($id);

    $checklist->update([
        'kode' => $request->kode,
        'kategori' => $request->kategori,
        'item' => $request->item,
        'aktif' => $request->aktif,
    ]);

    return redirect()->route('settings.audit-checklist.index')
        ->with('success', 'Checklist berhasil diperbarui.');
}

    public function destroy($id)
    {
        $checklist = AuditChecklist::findOrFail($id);
        $checklist->delete();

        return redirect()->route('settings.audit-checklist.index')
            ->with('success', 'Checklist berhasil dihapus.');
    }
}