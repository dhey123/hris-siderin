<?php

namespace App\Http\Controllers\SHE;
use App\Http\Controllers\Controller;
use App\Models\Audit;
use App\Models\AuditChecklist;
use App\Models\AuditDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class AuditController extends Controller
{
    // ================= INDEX =================
    public function index(Request $request)
{
    $query = Audit::with('details');

    // ================= FILTER =================
    if ($request->search) {
        $query->where('kode_audit', 'like', '%' . $request->search . '%');
    }

    if ($request->status) {
        $query->where('status', $request->status);
    }

    if ($request->area) {
        $query->where('area', $request->area);
    }

    if ($request->from && $request->to) {
        $query->whereBetween('tanggal_audit', [$request->from, $request->to]);
    }

    $audits = $query->orderByDesc('tanggal_audit')->paginate(10);

    // ================= SUMMARY =================
    $total_audit = Audit::count();
    $audit_selesai = Audit::where('status', 'selesai')->count();
    $audit_pending = Audit::whereIn('status', ['draft','followup'])->count();

    $progress = $total_audit > 0 
        ? round(($audit_selesai / $total_audit) * 100)
        : 0;

    $chartData = [
        'selesai' => $audit_selesai,
        'pending' => $audit_pending
    ];

    return view('she.environment.audit.index', compact(
        'audits',
        'total_audit',
        'audit_selesai',
        'audit_pending',
        'progress',
        'chartData'
    ));
}

    // ================= CREATE =================
    public function create()
    {
        return view('she.environment.audit.create');
    }

    // ================= STORE =================
    public function store(Request $request)
{
    $audit = Audit::create([
        'kode_audit' => 'AUD-' . date('Y') . '-' . rand(100,999),
        'jenis_audit' => $request->jenis_audit,
        'area' => $request->area,
        'tanggal_audit' => $request->tanggal_audit,
        'auditor' => auth()->user()->name,
        'status' => 'draft',
        'catatan' => $request->catatan,
        'created_by' => auth()->id(),
    ]);

    // 🔥 Ambil semua checklist aktif
    $checklists = AuditChecklist::where('aktif', 1)->get();

    foreach ($checklists as $checklist) {
    AuditDetail::create([
        'audit_id' => $audit->id,
        'audit_checklist_id' => $checklist->id,
        'hasil' => 'observasi', // default aman
    ]);
}

    return redirect()->route('she.environment.audit.show', $audit->id);
}

    // ================= SHOW =================
    public function show($id)
{
    $audit = Audit::with('details.checklist')->findOrFail($id);

    return view('she.environment.audit.show', compact('audit'));
}

    // ================= EDIT =================
    public function edit($id)
{
    $audit = Audit::findOrFail($id);
    return view('she.environment.audit.edit', compact('audit'));
}

public function update(Request $request, $id)
{
    $audit = Audit::findOrFail($id);

    // Update audit utama
    $audit->update([
        'kode_audit' => $request->kode_audit,
        'jenis_audit' => $request->jenis_audit,
        'area' => $request->area,
        'tanggal_audit' => $request->tanggal_audit,
        'status' => $request->status,
        'auditor' => $request->auditor,
    ]);

    // Update checklist sekaligus
    if ($request->hasil) {
        foreach ($request->hasil as $detailId => $value) {
            $detail = AuditDetail::find($detailId);
            if ($detail) {
                $detail->update([
                    'hasil' => $value,
                    'temuan' => $request->temuan[$detailId] ?? null,
                    'tindak_lanjut' => $request->tindak_lanjut[$detailId] ?? null,
                    'target_selesai' => $request->target_selesai[$detailId] ?? null,
                ]);
            }
        }
    }

    return redirect()->route('she.environment.audit.show', $audit->id)
        ->with('success', 'Audit & checklist berhasil disimpan.');
}

    // ================= DELETE =================
    public function destroy($id)
    {
        $audit = Audit::findOrFail($id);
        $audit->delete();

        return redirect()->route('she.environment.audit.index')->with('success', 'Audit berhasil dihapus.');
    }
   public function updateHasil(Request $request, $id)
{
    $audit = Audit::findOrFail($id);

    foreach ($request->hasil as $detailId => $value) {
        $detail = AuditDetail::find($detailId);
        if ($detail) {
            $detail->update([
                'hasil' => $value,
                'temuan' => $request->temuan[$detailId] ?? null,
                'tindak_lanjut' => $request->tindak_lanjut[$detailId] ?? null,
                'target_selesai' => $request->target_selesai[$detailId] ?? null,
            ]);
        }
    }

    // Update status audit jadi selesai jika semua checklist selesai
    $audit->update(['status' => 'selesai']);

    return redirect()->route('she.environment.audit.show', $audit->id)
        ->with('success', 'Hasil audit berhasil disimpan.');
}
 public function downloadPdf($id)
    {
        $audit = Audit::with('details.checklist')->findOrFail($id);

        $pdf = Pdf::loadView('she.environment.audit.pdf', compact('audit'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download($audit->kode_audit . '.pdf');
    }
}