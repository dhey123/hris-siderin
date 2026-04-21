<?php

namespace App\Http\Controllers\SHE;

use App\Http\Controllers\Controller;
use App\Models\Waste;
use App\Models\WasteLog;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class WasteController extends Controller
{
    // ================================
    // INDEX
    // ================================
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'data');

        $wastes = Waste::with('logs')->get();

        $logs = WasteLog::with('waste')
            ->where('tipe_log','Keluar')
            ->latest()
            ->get();

        return view('she.environment.limbah.index', compact('tab','wastes','logs'));
    }

    // ================================
    // FORM TAMBAH
    // ================================
    public function create()
    {
        return view('she.environment.limbah.create');
    }

    // ================================
    // SIMPAN LIMBAH MASUK
    // ================================
    public function store(Request $request)
    {
        $request->validate([
            'no_dokumen' => 'required',
            'tanggal' => 'required|date',
            'nama_limbah' => 'required',
            'jenis_limbah' => 'required',
            'kategori' => 'required',
            'jumlah' => 'required|numeric|min:1',
            'satuan' => 'required',
            'sumber_limbah' => 'required',
            'lokasi_penyimpanan' => 'required',
            'tujuan_pengelolaan' => 'required',
            'foto' => 'nullable|image|max:2048',
            'keterangan' => 'nullable'
        ]);

        DB::transaction(function() use ($request) {

            $data = $request->except('foto');

            $data['metode_pengelolaan'] = $request->metode_pengelolaan ?? '-';
            $data['status_pengelolaan'] = 'Disimpan';

            $hari = $request->jenis_limbah === 'B3' ? 90 : 180;
            $data['tanggal_maksimal'] =
                Carbon::parse($request->tanggal)->addDays($hari);

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time().'_'.$file->getClientOriginalName();
                $file->storeAs('public/wastes', $filename);
                $data['foto'] = 'wastes/'.$filename;
            }

            $waste = Waste::create($data);

            // log masuk (stok awal)
            WasteLog::create([
                'waste_id' => $waste->id,
                'tipe_log' => 'Masuk',
                'jumlah' => $request->jumlah,
                'keterangan' => 'Stok awal',
                'user_id' => Auth::id()
            ]);
        });

        return redirect()
            ->route('she.environment.limbah.index')
            ->with('success', 'Data limbah masuk berhasil disimpan');
    }

    // ================================
    // DETAIL
    // ================================
    public function show($id)
    {
        $waste = Waste::with('logs')->findOrFail($id);
        return view('she.environment.limbah.show', compact('waste'));
    }

    // ================================
    // HAPUS
    // ================================
    public function destroy($id)
    {
        $waste = Waste::findOrFail($id);

        if ($waste->foto && Storage::exists('public/'.$waste->foto)) {
            Storage::delete('public/'.$waste->foto);
        }

        $waste->logs()->delete();
        $waste->delete();

        return back()->with('success', 'Data limbah berhasil dihapus');
    }

    // ================================
    // FORM KELUAR (🔥 FIX)
    // ================================
    public function createKeluar($id)
    {
        $waste = Waste::with('logs')->findOrFail($id);

        // 🔥 ambil dari jumlah utama
        $totalKeluar = $waste->logs
            ->where('tipe_log','Keluar')
            ->sum('jumlah');

        $sisa_limbah = $waste->jumlah - $totalKeluar;

        return view('she.environment.limbah.keluar', compact('waste','sisa_limbah'));
    }

    // ================================
    // SIMPAN KELUAR (🔥 FIX)
    // ================================
    public function storeKeluar(Request $request, $id)
    {
        $waste = Waste::with('logs')->findOrFail($id);

        $totalKeluar = $waste->logs
            ->where('tipe_log','Keluar')
            ->sum('jumlah');

        $sisa_limbah = $waste->jumlah - $totalKeluar;

        // kalau habis
        if ($sisa_limbah <= 0) {
            return back()->with('error', 'Sisa limbah sudah habis');
        }

        $request->validate([
            'jumlah' => "required|numeric|min:0.01|max:$sisa_limbah",
            'foto' => 'nullable|image|max:2048',
            'keterangan' => 'nullable|string'
        ]);

        DB::transaction(function() use ($request, $waste) {

            WasteLog::create([
                'waste_id' => $waste->id,
                'tipe_log' => 'Keluar',
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan,
                'user_id' => Auth::id()
            ]);

        });

        return redirect()
            ->route('she.environment.limbah.index', ['tab' => 'logbook'])
            ->with('success', 'Log keluar berhasil disimpan');
    }

    // ================================
    // EXPORT EXCEL
    // ================================
   public function downloadExcel(Request $request)
{
    return Excel::download(
        new \App\Exports\WasteLogExport(
            $request->from,
            $request->to,
            $request->jenis
        ),
        'logbook-limbah.xlsx'
    );
}
    
}