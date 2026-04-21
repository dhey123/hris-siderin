<?php


namespace App\Http\Controllers\SHE;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Apk;
use Illuminate\Http\Request;

class ApkController extends Controller
{
    public function index()
    {
        $apks = Apk::orderByDesc('tanggal_update')->get();

        // SUMMARY CARD
        $total = Apk::count();
        $baik = Apk::where('kondisi', 'Baik')->count();
        $rusak = Apk::where('kondisi', 'Rusak')->count();
        $maintenance = Apk::where('kondisi', 'Perlu Maintenance')->count();

        // APK EXPIRED
        $expired = Apk::whereNotNull('expired_date')
            ->where('expired_date', '<', now())
            ->count();

        // APK HAMPIR EXPIRED (H-30)
        $hampirExpired = Apk::whereNotNull('expired_date')
            ->whereBetween('expired_date', [now(), now()->addDays(30)])
            ->count();

        return view('she.safety.apk.index', compact(
            'apks',
            'total',
            'baik',
            'rusak',
            'maintenance',
            'expired',
            'hampirExpired'
        ));
    }

    public function show($id)
    {
        $apk = Apk::findOrFail($id);
        return view('she.safety.apk.show', compact('apk'));
    }

    public function create()
    {
        return view('she.safety.apk.create');
    }

    // =====================
    // STORE
    // =====================
    public function store(Request $request)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|in:Baik,Rusak,Perlu Maintenance',
            'owner' => 'nullable|string|max:255',
            'tanggal_update' => 'nullable|date',
            'expired_date' => 'nullable|date',
        ]);

        Apk::create([
            'nama_alat' => $request->nama_alat,
            'lokasi' => $request->lokasi,
            'jumlah' => $request->jumlah,
            'kondisi' => $request->kondisi,
            'owner' => $request->owner,
            'tanggal_update' => $request->tanggal_update ?? now(),
            'expired_date' => $request->expired_date,
        ]);

        return redirect()->route('she.safety.apk.index')
            ->with('success', 'APK berhasil ditambahkan');
    }

    public function edit($id)
    {
        $apk = Apk::findOrFail($id);
        return view('she.safety.apk.edit', compact('apk'));
    }

    // =====================
    // UPDATE
    // =====================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|in:Baik,Rusak,Perlu Maintenance',
            'owner' => 'nullable|string|max:255',
            'tanggal_update' => 'nullable|date',
            'expired_date' => 'nullable|date',
        ]);

        $apk = Apk::findOrFail($id);

        $apk->update([
            'nama_alat' => $request->nama_alat,
            'lokasi' => $request->lokasi,
            'jumlah' => $request->jumlah,
            'kondisi' => $request->kondisi,
            'owner' => $request->owner,
            'tanggal_update' => $request->tanggal_update,
            'expired_date' => $request->expired_date,
        ]);

        return redirect()->route('she.safety.apk.index')
            ->with('success', 'APK berhasil diperbarui');
    }

    public function destroy($id)
    {
        Apk::findOrFail($id)->delete();

        return redirect()->route('she.safety.apk.index')
            ->with('success', 'APK berhasil dihapus');
    }

    // ==========================
    // CETAK PDF SEMUA APK
    // ==========================
    public function downloadPdf()
    {
        $apks = Apk::orderBy('nama_alat')->get();

        $total = Apk::count();
        $baik = Apk::where('kondisi', 'Baik')->count();
        $rusak = Apk::where('kondisi', 'Rusak')->count();
        $maintenance = Apk::where('kondisi', 'Perlu Maintenance')->count();

        $expired = Apk::whereNotNull('expired_date')
            ->where('expired_date', '<', now())
            ->count();

        $hampirExpired = Apk::whereNotNull('expired_date')
            ->whereBetween('expired_date', [now(), now()->addDays(30)])
            ->count();

        $pdf = Pdf::loadView('she.safety.apk.pdf', compact(
            'apks',
            'total',
            'baik',
            'rusak',
            'maintenance',
            'expired',
            'hampirExpired'
        ))->setPaper('A4', 'landscape');

        return $pdf->download('laporan_apk.pdf');
    }
}