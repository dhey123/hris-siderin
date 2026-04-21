<?php


namespace App\Http\Controllers\SHE;
use App\Http\Controllers\Controller;

use App\Models\Risk;
use App\Models\RiskAssessment;
use App\Models\RiskMitigation;
use App\Models\RiskEmergencyPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


class RiskController extends Controller
{
    // ================= IDENTIFIKASI =================
    public function index()
    {
        $risks = Risk::orderByDesc('tanggal_update')->get();
        return view('she.risk.identifikasi.index', compact('risks'));
    }

    public function create()
    {
        return view('she.risk.identifikasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_risiko' => 'required|string|max:255',
            'kategori' => 'required|in:Safety,Health,Environment,Bencana Alam',
            'deskripsi' => 'nullable|string',
            'tanggal_identifikasi' => 'required|date',
            'owner' => 'nullable|string|max:255',
        ]);

        $exists = Risk::where('nama_risiko', $request->nama_risiko)
            ->where('kategori', $request->kategori)
            ->whereDate('tanggal_identifikasi', $request->tanggal_identifikasi)
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'Risiko ini sudah terdaftar pada tanggal tersebut.');
        }

        Risk::create([
            'nama_risiko' => $request->nama_risiko,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'status' => 'Open',
            'tanggal_identifikasi' => $request->tanggal_identifikasi,
            'tanggal_update' => now(),
            'owner' => $request->owner,
        ]);

        return redirect()->route('she.risk.identifikasi.index')
            ->with('success', 'Risiko berhasil ditambahkan');
    }

    public function edit($id)
    {
        $risk = Risk::findOrFail($id);
        return view('she.risk.identifikasi.edit', compact('risk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_risiko' => 'required|string|max:255',
            'kategori' => 'required|in:Safety,Health,Environment,Bencana Alam,Tsunami,Gempa',
            'deskripsi' => 'nullable|string',
            'tanggal_identifikasi' => 'required|date',
            'owner' => 'nullable|string|max:255',
        ]);

        $risk = Risk::findOrFail($id);
        $risk->update([
            'nama_risiko' => $request->nama_risiko,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'tanggal_identifikasi' => $request->tanggal_identifikasi,
            'owner' => $request->owner,
            'tanggal_update' => now(),
        ]);

        return redirect()->route('she.risk.identifikasi.index')
            ->with('success', 'Risiko berhasil diperbarui');
    }

    public function destroy($id)
    {
        $risk = Risk::findOrFail($id);
        $risk->delete();

        return redirect()->route('she.risk.identifikasi.index')
            ->with('success', 'Risiko berhasil dihapus');
    }

    // ================= PENILAIAN =================
    public function penilaian($id)
    {
        $risk = Risk::with('assessments')->findOrFail($id);
        return view('she.risk.penilaian.index', compact('risk'));
    }

    public function storePenilaian(Request $request, $id)
    {
        $request->validate([
            'likelihood' => 'required|in:Low,Medium,High',
            'impact' => 'required|in:Minor,Major,Critical',
        ]);

        $risk = Risk::findOrFail($id);

        $likelihoodMap = ['Low' => 1, 'Medium' => 2, 'High' => 3];
        $impactMap = ['Minor' => 1, 'Major' => 2, 'Critical' => 3];
        $score = $likelihoodMap[$request->likelihood] * $impactMap[$request->impact];

        $level = match(true) {
            $score <= 2 => 'Low',
            $score <= 4 => 'Medium',
            default => 'High',
        };

        RiskAssessment::create([
            'risk_id' => $risk->id,
            'likelihood' => $request->likelihood,
            'impact' => $request->impact,
            'risk_score' => $score,
            'risk_level' => $level,
            'assessed_by' => auth()->user()->name ?? 'System',
            'assessed_at' => Carbon::now(),
        ]);

        $risk->update([
            'status' => 'In Progress',
            'tanggal_update' => now(),
        ]);

        return redirect()->route('she.risk.identifikasi.index')
            ->with('success', 'Penilaian risiko berhasil disimpan');
    }

    public function penilaianGlobal(Request $request)
{
    $query = RiskAssessment::with('risk')->whereHas('risk');

    // Filter Level
    if ($request->filled('level')) {
        $query->where('risk_level', $request->level);
    }

    // Filter Kategori
    if ($request->filled('kategori')) {
        $query->whereHas('risk', function ($q) use ($request) {
            $q->where('kategori', $request->kategori);
        });
    }

    // Filter Tanggal
    if ($request->filled('from') && $request->filled('to')) {
        $query->whereBetween('assessed_at', [
            $request->from,
            $request->to
        ]);
    }

    $penilaian = $query->orderByDesc('assessed_at')->get();

    return view('she.risk.penilaian.global', compact('penilaian'));
}
public function exportPenilaian()
{
    $penilaian = RiskAssessment::with('risk')
        ->orderByDesc('assessed_at')
        ->get();

    $total = $penilaian->count();
    $high = $penilaian->where('risk_level', 'High')->count();
    $medium = $penilaian->where('risk_level', 'Medium')->count();
    $low = $penilaian->where('risk_level', 'Low')->count();

    $periodeAwal = $penilaian->min('assessed_at');
    $periodeAkhir = $penilaian->max('assessed_at');

    $data = [
        'penilaian' => $penilaian,
        'total' => $total,
        'high' => $high,
        'medium' => $medium,
        'low' => $low,
        'periodeAwal' => $periodeAwal,
        'periodeAkhir' => $periodeAkhir,
        'tanggalCetak' => now(),
        'namaPerusahaan' => 'PT CONTOH MAJU SEJAHTERA',
        'noDokumen' => 'FR-SHE-001',
        'revisi' => '00'
    ];

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
        'she.risk.penilaian.pdf',
        $data
    )->setPaper('a4', 'landscape');

    return $pdf->download('Laporan_Penilaian_Risiko.pdf');
}
    // ================= MITIGASI =================
    public function mitigasi($id)
    {
        $risk = Risk::with('mitigations')->findOrFail($id);
        return view('she.risk.mitigasi.index', compact('risk'));
    }

    public function storeMitigasi(Request $request, $id)
    {
        $request->validate([
            'mitigasi' => 'required|string',
            'owner' => 'nullable|string|max:255',
        ]);

        RiskMitigation::create([
            'risk_id' => $id,
            'tindakan' => $request->mitigasi,
            'pic' => $request->owner,
            'deadline' => now(),
            'status' => 'Open',
        ]);

        return redirect()->route('she.risk.identifikasi.index')
            ->with('success', 'Mitigasi risiko berhasil disimpan');
    }

    // ================= MITIGASI =================
    // Halaman Global Mitigasi
    public function mitigasiGlobal()
    {
        $mitigasi = RiskMitigation::with('risk')->get();
        $risks = Risk::all(); // untuk dropdown pilih risiko
        return view('she.risk.mitigasi.global', [
            'mitigasi' => $mitigasi,
            'risks' => $risks
        ]);
    }

    // Simpan Mitigasi dari Global Form
    public function storeMitigasiGlobal(Request $request)
{
    $request->validate([
        'risk_id' => 'required|exists:risks,id',
        'tindakan' => 'required|string',
        'pic' => 'nullable|string|max:255',
        'deadline' => 'nullable|date',
        'status' => 'required|in:Planned,Ongoing,Done',
        'efektivitas' => 'nullable|string|max:255',
        'lampiran' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:2048',
    ]);
        $pathLampiran = null;

    if ($request->hasFile('lampiran')) {
        $pathLampiran = $request->file('lampiran')
            ->store('mitigasi_lampiran', 'public');
    }

            RiskMitigation::create([
        'risk_id' => $request->risk_id,
        'tindakan' => $request->tindakan,
        'pic' => $request->pic,
        'deadline' => $request->deadline,
        'status' => $request->status,
        'efektivitas' => $request->efektivitas,
        'lampiran' => $pathLampiran,
    ]);

    return redirect()->route('she.risk.mitigasi.global')
                     ->with('success', 'Mitigasi baru berhasil ditambahkan');

}
public function editMitigasiGlobal($id)
{
    $mitigasi = RiskMitigation::findOrFail($id);
    $risks = Risk::all();

    return view('she.risk.mitigasi.edit', compact('mitigasi', 'risks'));
}

public function updateMitigasiGlobal(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:Planned,Ongoing,Done',
        'efektivitas' => 'nullable|string|max:255',
    ]);

    $mitigasi = RiskMitigation::findOrFail($id);

    $mitigasi->update([
        'status' => $request->status,
        'efektivitas' => $request->efektivitas,
    ]);

    return redirect()->route('she.risk.mitigasi.global')
        ->with('success', 'Mitigasi berhasil diperbarui');
}

public function exportMitigasi()
{
    $mitigasi = RiskMitigation::with('risk')->get();

    $pdf = Pdf::loadView('she.risk.mitigasi.pdf', [
        'mitigasi' => $mitigasi,
        'noDokumen' => 'FR-SHE-02',
        'revisi' => '00',
        'tanggalCetak' => now(),
        'periode' => 'Seluruh Data'
    ])
    ->setPaper('a4', 'portrait');

    return $pdf->download('Laporan-Mitigasi-Risiko.pdf');
}


//TANGGAP DARURAT
   public function tanggapDarurat($id)
{
    $risk = Risk::with('emergencyPlan')->findOrFail($id);
    return view('she.risk.tanggap-darurat.index', compact('risk'));
}

public function storeTanggapDarurat(Request $request, $id)
{
    $risk = Risk::with('emergencyPlan')->findOrFail($id);

    if ($risk->emergencyPlan) {
        return back()->with('error', 'Rencana darurat sudah ada untuk risiko ini.');
    }

    $request->validate([
        'rencana_darurat' => 'required|string',
        'contact_person' => 'nullable|string|max:255',
        
    ]);

    RiskEmergencyPlan::create([
        'risk_id' => $risk->id,
        'rencana' => $request->rencana_darurat,
        'contact_person' => $request->contact_person,
        'catatan' => $request->catatan,
    ]);

    return redirect()
        ->route('she.risk.tanggap-darurat.index', $risk->id)
        ->with('success', 'Rencana tanggap darurat berhasil disimpan');
}
public function editTanggapDarurat($id)
{
    $risk = Risk::with('emergencyPlan')->findOrFail($id);
    return view('she.risk.tanggap-darurat.edit', compact('risk'));
}

public function updateTanggapDarurat(Request $request, $id)
{
    $risk = Risk::with('emergencyPlan')->findOrFail($id);

    $request->validate([
        'rencana_darurat' => 'required|string',
        'contact_person' => 'nullable|string|max:255',
        'catatan' => 'nullable|string',
    ]);

    $risk->emergencyPlan->update([
        'rencana' => $request->rencana_darurat,
        'contact_person' => $request->contact_person,
        'catatan' => $request->catatan,
    ]);

    return redirect()
        ->route('she.risk.tanggap-darurat.index', $risk->id)
        ->with('success', 'Berhasil diupdate');
}

public function destroyTanggapDarurat($id)
{
    $risk = Risk::with('emergencyPlan')->findOrFail($id);

    if ($risk->emergencyPlan) {
        $risk->emergencyPlan->delete();
    }

    return redirect()
        ->route('she.risk.tanggap-darurat.index', $risk->id)
        ->with('success', 'Berhasil dihapus');
}

public function tanggapDaruratGlobal()
{
    $darurat = RiskEmergencyPlan::with('risk')->get();
    return view('she.risk.tanggap-darurat.global', compact('darurat'));
}
public function exportTanggapDarurat()
{
    $data = RiskEmergencyPlan::all(); // atau pake filter periode

    $pdf = Pdf::loadView('she.risk.tanggap-darurat.pdf', [
        'data' => $data,
        'periode' => 'Seluruh Data'
    ])->setPaper('A4', 'portrait');

    return $pdf->download('Laporan-Tanggap-Darurat.pdf');
}
    // ================= DASHBOARD =================
    public function dashboard()
    {
        $total = Risk::count();
        $open = Risk::where('status', 'Open')->count();
        $closed = Risk::where('status', 'Closed')->count();

        $kategori = Risk::select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        $level = RiskAssessment::select('risk_level', DB::raw('count(*) as total'))
            ->groupBy('risk_level')
            ->pluck('total', 'risk_level');

        $topRisks = Risk::orderByDesc('tanggal_update')->take(5)->get();

        return view('she.risk.dashboard', compact(
            'total', 'open', 'closed', 'kategori', 'level', 'topRisks'
        ));
    }
    // ================= REFERENSI =================
public function struktur()
{
    return view('she.risk.referensi.struktur');
}

public function job()
{
    return view('she.risk.referensi.job');
}

}