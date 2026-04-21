<?php

namespace App\Http\Controllers\SHE;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Incident;
use App\Models\Apd;
use App\Models\Pelatihan;
use App\Models\Apk;
use Barryvdh\DomPDF\Facade\Pdf;


class SafetyController extends Controller
{
   // DASHBOARD SAFETY
public function index()
{
    return view('she.safety.index');
}
    // INSIDEN INDEX
    public function insiden()
{
    $incidents = Incident::with(['employee.company','employee.department','employee.position'])
        ->orderByDesc('incident_date')
        ->get();
    $employees = Employee::orderBy('full_name')->get();

    // STATISTIK STATUS
    $stats = [
        'total'     => $incidents->count(),
        'terkirim'  => $incidents->where('status', 'terkirim')->count(),
        'ditangani' => $incidents->where('status', 'ditangani')->count(),
        'selesai'   => $incidents->where('status', 'selesai')->count(),
    ];

    // Chart status
    $chart = [
        'labels' => ['Terkirim', 'Ditangani', 'Selesai'],
        'data' => [
            $stats['terkirim'],
            $stats['ditangani'],
            $stats['selesai'],
        ],
    ];

    // 🔥 INSIDEN PER TAHUN
    $yearly = Incident::select(
            DB::raw('YEAR(incident_date) as year'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('year')
        ->orderBy('year')
        ->get();

    return view('she.safety.insiden.index', compact(
        'incidents',
        'employees',
        'stats',
        'chart',
        'yearly'   
    ));
}

    // CREATE INSIDEN (HALAMAN FORM)
    public function createInsiden()
{
    $employees = Employee::orderBy('full_name')->get();
    $incidents = Incident::orderByDesc('incident_date')->get();

    // Statistik & chart biar tab daftar muncul
    $stats = [
        'total'     => $incidents->count(),
        'terkirim'  => $incidents->where('status','terkirim')->count(),
        'ditangani' => $incidents->where('status','ditangani')->count(),
        'selesai'   => $incidents->where('status','selesai')->count(),
        'fatal'     => $incidents->where('severity','fatal')->count(),
    ];

    $chart = [
        'labels' => ['Terkirim','Ditangani','Selesai'],
        'data'   => [$stats['terkirim'],$stats['ditangani'],$stats['selesai']],
    ];

    return view('she.safety.insiden.create', compact(
        'employees','incidents','stats','chart'
    ));
}
    // INSIDEN STORE
    public function insidenStore(Request $request)
    {
        $request->validate([
            'employee_id'   => 'required|exists:employees,id',
            'department'    => 'required|string',
            'bagian'        => 'required|string',
            'incident_date' => 'required|date',
            'location'      => 'required|string',
            'incident_type' => 'required|string',
            'severity'      => 'required|in:ringan,sedang,berat,fatal',
            'description'   => 'nullable|string',
            'action_taken'  => 'nullable|string',
        ]);

        $employee = Employee::findOrFail($request->employee_id);

        Incident::create([
            'employee_id'   => $employee->id,
            'nama_karyawan' => $employee->full_name,
            'department'    => $request->department,
            'bagian'        => $request->bagian,
            'incident_date' => $request->incident_date,
            'location'      => $request->location,
            'incident_type' => $request->incident_type,
            'severity'      => $request->severity,
            'description'   => $request->description,
            'action_taken'  => $request->action_taken,
            'status'        => 'terkirim',
        ]);

        return redirect()
            ->route('she.safety.insiden.index')
            ->with('success', 'Data insiden berhasil dicatat');
    }

    // INSIDEN UPDATE STATUS
//===============================
    // Halaman edit
        public function insidenEdit($id)
        {
            $incident = Incident::with(['employee', 'employee.department', 'employee.position', 'employee.company'])
                                ->findOrFail($id);
            return view('she.safety.insiden.edit', compact('incident'));
        }

        // Update status & keterangan
public function insidenUpdate(Request $request, $id)
{
    $incident = Incident::findOrFail($id);

    $incident->status = $request->status;
    $incident->status_note = $request->status_note;
    $incident->save();

    // Setelah update, redirect ke halaman detail
    return redirect()->route('she.safety.insiden.show', $id)
                     ->with('success', 'Status insiden berhasil diperbarui');
}

// Halaman detail biasa
public function insidenShow($id)
{
    $incident = Incident::with(['employee.company','employee.department','employee.position'])
                        ->findOrFail($id);
    return view('she.safety.insiden.show', compact('incident'));
}
public function downloadPdf($id)
{
    // Ambil data insiden beserta relasi employee, department, position
    $incident = Incident::with('employee.department', 'employee.position')->findOrFail($id);

    // Load view PDF
    $pdf = Pdf::loadView('she.safety.insiden.pdf', compact('incident'))
              ->setPaper('a4', 'portrait');

    // Download PDF
    return $pdf->download('Insiden_'.$incident->employee->full_name.'_'.date('d-m-Y').'.pdf');
}
public function downloadAllPdf(Request $request)
{
    // Ambil periode
    $start = $request->start_date ?? now()->startOfYear()->toDateString();
    $end   = $request->end_date ?? now()->endOfYear()->toDateString();

    // Data insiden berdasarkan periode
    $incidents = Incident::with(['employee.department','employee.position'])
        ->whereBetween('incident_date', [$start, $end])
        ->orderBy('incident_date')
        ->get();

    // Statistik
    $stats = [
        'total'     => $incidents->count(),
        'terkirim'  => $incidents->where('status','terkirim')->count(),
        'ditangani' => $incidents->where('status','ditangani')->count(),
        'selesai'   => $incidents->where('status','selesai')->count(),
    ];

    $pdf = Pdf::loadView(
        'she.safety.insiden.pdf_all',
        compact('incidents','stats','start','end')
    )->setPaper('a4','landscape');

    return $pdf->download(
        'Laporan_Insiden_'.$start.'_sd_'.$end.'.pdf'
    );
}

    // INSIDEN DELETE
    public function insidenDestroy($id)
    {
        Incident::findOrFail($id)->delete();
        return back()->with('success', 'Data insiden berhasil dihapus');
    }


// ==============================================
    // APD
// ==============================================
    public function apd() // Dashboard APD (grid)
    {
        return view('she.safety.apd.index');
    }

    // List APD
    public function apdList()
{
    $apds = Apd::orderByDesc('created_at')->get();

    // 🔹 RINGKASAN
    $total_apd           = $apds->count();
    $total_stok_awal     = $apds->sum('stok_awal');
    $total_stok_saat_ini = $apds->sum('stok_saat_ini');
    $total_terpakai      = $total_stok_awal - $total_stok_saat_ini;

    return view('she.safety.apd.list', compact(
        'apds',
        'total_apd',
        'total_stok_awal',
        'total_stok_saat_ini',
        'total_terpakai',
    ));
}
    // Form tambah APD
    public function apdCreate()
    {
        return view('she.safety.apd.create');
    }

    // Simpan APD (CREATE)
    public function apdStore(Request $request)
    {
        $request->validate([
            'nama_apd'            => 'required|string|max:150',
            'jenis_apd'           => 'required|string|max:100',
            'department'          => 'required|string|max:255',
            'stok_awal'           => 'required|integer|min:0',
            'kondisi'             => 'required|in:Baik,Rusak,Hilang',
            'keterangan'          => 'nullable|string',
            'tanggal_pengadaan'   => 'required|date',
        ]);

        Apd::create([
            'nama_apd'          => $request->nama_apd,
            'jenis_apd'         => $request->jenis_apd,
            'department'        => $request->department,

            // 🔑 INIT STOK
            'stok_awal'         => $request->stok_awal,
            'stok_saat_ini'     => $request->stok_awal, // otomatis sama

            'kondisi'           => $request->kondisi,
            'keterangan'        => $request->keterangan,
            'tanggal_pengadaan' => $request->tanggal_pengadaan,
        ]);

        return redirect()
            ->route('she.safety.apd.list')
            ->with('success', 'APD berhasil ditambahkan');
    }

    // Form edit APD
    public function apdEdit($id)
    {
        $apd = Apd::findOrFail($id);
        return view('she.safety.apd.edit', compact('apd'));
    }

    // Update APD (EDIT)
    public function apdUpdate(Request $request, $id)
{
    $apd = Apd::findOrFail($id);

    $request->validate([
        'nama_apd'            => 'required|string|max:150',
        'jenis_apd'           => 'required|string|max:100',
        'department'          => 'required|string|max:255',
        'stok_awal'           => 'required|integer|min:0',
        'kondisi'             => 'required|in:Baik,Rusak,Hilang',
        'keterangan'          => 'nullable|string',
        'tanggal_pengadaan'   => 'required|date',
    ]);

    // Hitung stok_saat_ini baru
    $stok_pakai = $apd->stok_awal - $apd->stok_saat_ini; // total sudah dipakai

    if ($stok_pakai == 0) {
        // Belum pernah dipakai → sync stok_saat_ini dengan stok_awal baru
        $stok_saat_ini_baru = $request->stok_awal;
    } else {
        // Sudah dipakai → jangan rubah stok_saat_ini
        $stok_saat_ini_baru = $apd->stok_saat_ini;
    }

    $apd->update([
        'nama_apd'          => $request->nama_apd,
        'jenis_apd'         => $request->jenis_apd,
        'department'        => $request->department,
        'stok_awal'         => $request->stok_awal,
        'stok_saat_ini'     => $stok_saat_ini_baru,
        'kondisi'           => $request->kondisi,
        'keterangan'        => $request->keterangan,
        'tanggal_pengadaan' => $request->tanggal_pengadaan,
    ]);

    return redirect()
        ->route('she.safety.apd.list')
        ->with('success', 'APD berhasil diperbarui');
}

public function apdPrint()
{
    $apds = Apd::orderBy('nama_apd')->get();

    $total_stok_awal     = $apds->sum('stok_awal');
    $total_stok_saat_ini = $apds->sum('stok_saat_ini');
    $total_terpakai      = $total_stok_awal - $total_stok_saat_ini;

    $pdf = Pdf::loadView('she.safety.apd.print', compact(
        'apds',
        'total_stok_awal',
        'total_stok_saat_ini',
        'total_terpakai'
    ))->setPaper('a4', 'landscape');

    return $pdf->download('Laporan-APD.pdf');
}
    // Hapus APD
    public function apdDestroy($id)
    {
        $apd = Apd::findOrFail($id);
        $apd->delete();

        return redirect()
            ->route('she.safety.apd.list')
            ->with('success', 'APD berhasil dihapus');
    }


// ===================================================================
                         // PELATIHAN
// ===================================================================
        public function pelatihanIndex()
        {
            $pelatihans = Pelatihan::orderByRaw("
        FIELD(status, 'Jadwal dibuat', 'Reschedule', 'Dibatalkan', 'Selesai')
    ")->orderBy('tanggal', 'asc')->get();
            return view('she.safety.pelatihan.index', compact('pelatihans'));
        }

        public function pelatihanCreate()
        {
            return view('she.safety.pelatihan.create');
        }

        public function pelatihanStore(Request $request)
        {
            $request->validate([
                'nama_pelatihan' => 'required|string|max:150',
                'penyelenggara'  => 'nullable|string|max:255',
                'tanggal'        => 'required|date',
                'durasi'         => 'required|string|max:50',
                'department'     => 'nullable|string|max:100',
                'keterangan'     => 'nullable|string',
            ]);

            Pelatihan::create([
                'nama_pelatihan' => $request->nama_pelatihan,
                'penyelenggara'  => $request->penyelenggara,
                'tanggal'        => $request->tanggal,
                'durasi'         => $request->durasi,
                'department'     => $request->department,
                'keterangan'     => $request->keterangan,
                'status'         => 'Jadwal dibuat',
            ]);

            return redirect()
                ->route('she.safety.pelatihan.index')
                ->with('success', 'Pelatihan berhasil ditambahkan');
        }

        public function pelatihanEdit($id)
        {
            $pelatihan = Pelatihan::findOrFail($id);
            return view('she.safety.pelatihan.edit', compact('pelatihan'));
        }

        public function pelatihanUpdate(Request $request, $id)
        {
            $pelatihan = Pelatihan::findOrFail($id);

            $request->validate([
                'nama_pelatihan' => 'required|string|max:150',
                'penyelenggara'  => 'nullable|string|max:255',
                'tanggal'        => 'required|date',
                'durasi'         => 'required|string|max:50',
                'department'     => 'nullable|string|max:100',
                'keterangan'     => 'nullable|string',
                'status'         => 'required|in:Jadwal dibuat,Selesai,Dibatalkan',
            ]);

            $pelatihan->update($request->all());

            return redirect()
                ->route('she.safety.pelatihan.index')
                ->with('success', 'Pelatihan berhasil diperbarui');
        }

        public function pelatihanDestroy($id)
        {
            Pelatihan::findOrFail($id)->delete();
            return redirect()
                ->route('she.safety.pelatihan.index')
                ->with('success', 'Pelatihan berhasil dihapus');
        }

        /*
/public function pelatihanMateri() //baru mau dikembangkan
{
    $materis = MateriPelatihan::orderByDesc('created_at')->get();
    return view('she.safety.pelatihan.materi', compact('materis'));
}
*/
        
        public function pelatihanShow($id)
    {
        $pelatihan = Pelatihan::with('reschedules')->findOrFail($id);
        return view('she.safety.pelatihan.show', compact('pelatihan'));
    }


        public function pelatihanPrint()
        {
            $pelatihans = Pelatihan::with('reschedules')
                ->orderByDesc('tanggal')
                ->get();

            $pdf = Pdf::loadView(
                'she.safety.pelatihan.print',
                compact('pelatihans')
            )->setPaper('a4', 'landscape');

            return $pdf->download('laporan-pelatihan.pdf');
        }
        public function pelatihanPrintDetail($id)
        {
            $pelatihan = Pelatihan::with(['reschedules','evaluasi'])
                            ->findOrFail($id);

            $lastReschedule = $pelatihan->reschedules->last();
            $tanggalAktif = $lastReschedule
                ? \Carbon\Carbon::parse($lastReschedule->tanggal_baru)
                : \Carbon\Carbon::parse($pelatihan->tanggal);

            $pdf = Pdf::loadView(
                'she.safety.pelatihan.print-detail',
                compact('pelatihan','tanggalAktif')
            )->setPaper('a4', 'portrait');

            return $pdf->download('detail-pelatihan-'.$pelatihan->id.'.pdf');
        }
}