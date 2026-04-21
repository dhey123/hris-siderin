<?php

namespace App\Http\Controllers\SHE;

use App\Http\Controllers\Controller;
use App\Models\SuratDokter;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SuratDokterController extends Controller
{
    public function index()
    {
        $suratDokters = SuratDokter::with([
            'employee.company',
            'employee.department',
            'employee.position'
        ])
        ->latest()
        ->paginate(10);

        return view('she.health.surat_dokter.index', compact('suratDokters'));
    }

    public function create()
    {
        $employees = Employee::with('department', 'position')->get()->map(function ($e) {
            return [
                'id' => $e->id,
                'full_name' => $e->full_name,
                'department_name' => $e->department?->department_name ?? '-',
                'position_name'   => $e->position?->position_name ?? '-',
            ];
        });

        return view('she.health.surat_dokter.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'     => 'required|exists:employees,id',
            'tanggal_surat'   => 'required|date',
            'hari_istirahat'  => 'required|integer|min:1',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'file_surat'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        DB::transaction(function () use ($request) {

            $leaveType = LeaveType::where('name', 'Cuti Sakit')->firstOrFail();

            // 🔥 ANTI DOUBLE CUTI
            $existing = LeaveRequest::where([
                'employee_id'   => $request->employee_id,
                'leave_type_id' => $leaveType->id,
                'start_date'    => $request->tanggal_mulai,
                'end_date'      => $request->tanggal_selesai,
            ])->first();

            if ($existing) {
                throw new \Exception('Cuti sakit di tanggal tersebut sudah ada.');
            }

            // 🔥 AUTO CREATE CUTI (APPROVED)
            $leaveRequest = LeaveRequest::create([
                'employee_id'   => $request->employee_id,
                'leave_type_id' => $leaveType->id,
                'start_date'    => $request->tanggal_mulai,
                'end_date'      => $request->tanggal_selesai,
                'total_days'    => $request->hari_istirahat,
                'reason'        => 'Sakit (Surat Dokter)',
                'status'        => 'Approved',
                'approved_at'   => now(),
            ]);

            // 🔥 UPLOAD FILE
            $filePath = null;
            if ($request->hasFile('file_surat')) {
                $filePath = $request->file('file_surat')->store('surat-dokter', 'public');
            }

            // 🔥 CREATE SURAT DOKTER
            SuratDokter::create([
                'employee_id'      => $request->employee_id,
                'leave_request_id' => $leaveRequest->id,
                'tanggal_surat'    => $request->tanggal_surat,
                'diagnosa'         => $request->diagnosa,
                'hari_istirahat'   => $request->hari_istirahat,
                'tanggal_mulai'    => $request->tanggal_mulai,
                'tanggal_selesai'  => $request->tanggal_selesai,
                'nama_dokter'      => $request->nama_dokter,
                'klinik'           => $request->klinik,
                'file_surat'       => $filePath,
            ]);
        });

        return redirect()->route('she.health.surat-dokter.index')
            ->with('success', 'Surat dokter & cuti sakit berhasil disimpan');
    }

    public function show(SuratDokter $suratDokter)
    {
        $suratDokter->load([
            'employee.department',
            'employee.position',
            'leaveRequest'
        ]);

        return view('she.health.surat_dokter.show', compact('suratDokter'));
    }

    public function edit(SuratDokter $suratDokter)
    {
        $employees = Employee::with('department', 'position')->get()->map(function ($e) {
            return [
                'id' => $e->id,
                'full_name' => $e->full_name,
                'department_name' => $e->department?->department_name ?? '-',
                'position_name'   => $e->position?->position_name ?? '-',
            ];
        });

        return view('she.health.surat_dokter.edit', compact('suratDokter', 'employees'));
    }

    public function update(Request $request, SuratDokter $suratDokter)
    {
        $request->validate([
            'employee_id'     => 'required|exists:employees,id',
            'tanggal_surat'   => 'required|date',
            'hari_istirahat'  => 'required|integer|min:1',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'file_surat'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        DB::transaction(function () use ($request, $suratDokter) {

            // 🔥 SYNC KE CUTI
            if ($suratDokter->leaveRequest) {
                $suratDokter->leaveRequest->update([
                    'employee_id' => $request->employee_id,
                    'start_date'  => $request->tanggal_mulai,
                    'end_date'    => $request->tanggal_selesai,
                    'total_days'  => $request->hari_istirahat,
                    'reason'      => 'Sakit (Surat Dokter)',
                    'status'      => 'Approved',
                ]);
            }

            // 🔥 HANDLE FILE
            $filePath = $suratDokter->file_surat;
            if ($request->hasFile('file_surat')) {
                if ($filePath) {
                    Storage::disk('public')->delete($filePath);
                }
                $filePath = $request->file('file_surat')->store('surat-dokter', 'public');
            }

            // 🔥 UPDATE SURAT
            $suratDokter->update([
                'employee_id'      => $request->employee_id,
                'tanggal_surat'    => $request->tanggal_surat,
                'diagnosa'         => $request->diagnosa,
                'hari_istirahat'   => $request->hari_istirahat,
                'tanggal_mulai'    => $request->tanggal_mulai,
                'tanggal_selesai'  => $request->tanggal_selesai,
                'nama_dokter'      => $request->nama_dokter,
                'klinik'           => $request->klinik,
                'file_surat'       => $filePath,
            ]);
        });

        return redirect()->route('she.health.surat-dokter.index')
            ->with('success', 'Surat dokter berhasil diperbarui');
    }

    public function destroy(SuratDokter $suratDokter)
    {
        if ($suratDokter->file_surat) {
            Storage::disk('public')->delete($suratDokter->file_surat);
        }

        // 🔥 HAPUS CUTI JUGA (SYNC)
        if ($suratDokter->leaveRequest) {
            $suratDokter->leaveRequest->delete();
        }

        $suratDokter->delete();

        return back()->with('success', 'Surat dokter berhasil dihapus');
    }
}