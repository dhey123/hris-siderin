<?php


namespace App\Http\Controllers\SHE;

use App\Http\Controllers\Controller;
use App\Models\Apd;
use App\Models\ApdLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApdLogController extends Controller
{
    /**
     * Tampilkan riwayat pemakaian APD
     */
    public function index(Apd $apd)
    {
        $logs = ApdLog::where('apd_id', $apd->id)
                      ->orderByDesc('tanggal')
                      ->get();

        return view('she.safety.apdlogs.index', compact('apd', 'logs'));
    }

    /**
     * Form pakai APD
     */
    public function create(Apd $apd)
    {
        return view('she.safety.apdlogs.create', compact('apd'));
    }

    /**
     * Simpan pemakaian APD
     */
    public function store(Request $request, Apd $apd)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jumlah'  => 'required|integer|min:1',
            'dipakai_oleh' => 'nullable|string|max:255', // bisa diketik manual
            'keterangan' => 'nullable|string',
        ]);

        // Pastikan stok cukup
        if ($request->jumlah > $apd->stok_saat_ini) {
            return back()
                ->withErrors(['jumlah' => 'Stok APD tidak mencukupi'])
                ->withInput();
        }

        DB::transaction(function () use ($request, $apd) {

            // Pastikan stok_saat_ini tidak NULL
            if (is_null($apd->stok_saat_ini)) {
                $apd->update(['stok_saat_ini' => $apd->stok_awal ?? 0]);
            }

            $stok_awal  = $apd->stok_saat_ini;           // stok sebelum dipakai
            $stok_akhir = $stok_awal - $request->jumlah; // stok setelah dipakai

            // Simpan log lengkap
            ApdLog::create([
                'apd_id'       => $apd->id,
                'tanggal'      => $request->tanggal,
                'stok_awal'    => $stok_awal,
                'jumlah'       => $request->jumlah,
                'stok_akhir'   => $stok_akhir,
                'dipakai_oleh' => $request->dipakai_oleh ?? '-', 
                'keterangan'   => $request->keterangan,
                'user'         => '-', // placeholder user login
            ]);

            // Update stok saat ini di APD
            $apd->update(['stok_saat_ini' => $stok_akhir]);
        });

        return redirect()
            ->route('she.safety.apd.logs.index', $apd->id)
            ->with('success', 'Pemakaian APD berhasil dicatat');
    }

    /**
     * Hapus log pemakaian
     */
    public function destroy(ApdLog $log)
    {
        $apd_id = $log->apd_id;

        DB::transaction(function () use ($log) {
            $apd = Apd::findOrFail($log->apd_id);

            // Kembalikan stok saat ini
            $apd->update([
                'stok_saat_ini' => $apd->stok_saat_ini + $log->jumlah
            ]);

            $log->delete();
        });

        return redirect()
            ->route('she.safety.apd.logs.index', $apd_id)
            ->with('success', 'Riwayat pemakaian berhasil dihapus');
    }
    /**
     * Recalculate semua stok lama (opsional)
     * Jalankan sekali kalau log lama belum konsisten
     */
    public function recalcLogs()
    {
        Apd::all()->each(function($apd) {
            $logs = ApdLog::where('apd_id', $apd->id)
                          ->orderBy('tanggal')
                          ->orderBy('id')
                          ->get();

            $stok = $apd->stok_awal ?? 0;

            DB::transaction(function() use ($logs, $apd, &$stok) {
                foreach ($logs as $log) {
                    $log->stok_awal = $stok;
                    $log->stok_akhir = $stok - $log->jumlah;
                    if (!$log->dipakai_oleh || $log->dipakai_oleh === '-') {
                        $log->dipakai_oleh = 'HRD';
                    }
                    $log->save();

                    $stok = $log->stok_akhir;
                }

                $apd->stok_saat_ini = $stok;
                $apd->save();
            });
        });

        return redirect()->back()->with('success', 'Semua log APD telah direcalculate');
    }
}
