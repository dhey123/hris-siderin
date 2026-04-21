<?php

namespace App\Http\Controllers\Labour;

use App\Models\BpjsHistory;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\BpjsRecord;
use App\Exports\BpjsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BpjsImport;

class BpjsController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');
        $search = $request->search;

        // Ambil karyawan aktif
        $employees = Employee::where('status', 'Active')->pluck('id');

        // Generate BPJS bulanan (anti double)
        foreach ($employees as $empId) {
            BpjsRecord::firstOrCreate(
                [
                    'employee_id' => $empId,
                    'bulan' => $bulan,
                    'tahun' => $tahun
                ],
                [
                    'bpjs_kesehatan' => Employee::find($empId)?->isBorongan() ? 'mandiri' : 'unpaid'
                ]
            );
        }

        $query = BpjsRecord::with([
            'employee.company',
            'employee.department',
            'employee.position'
        ])
        ->where('bulan', $bulan)
        ->where('tahun', $tahun);

        if ($search) {
            $query->whereHas('employee', function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $data = $query->latest()->get();

        return view('labour.bpjs.index', compact('data', 'bulan', 'tahun', 'search'));
    }

    public function update(Request $request, $id)
    {
        $bpjs = BpjsRecord::with('employee')->findOrFail($id);
        $isBorongan = $bpjs->employee->isBorongan();

        // 🔥 DEFAULT VALUE (BIAR AJAX GAK ERROR)
        $bpjsKes = $request->bpjs_kesehatan ?? $bpjs->bpjs_kesehatan ?? 'unpaid';
        $bpjsTk  = $request->bpjs_ketenagakerjaan ?? $bpjs->bpjs_ketenagakerjaan ?? 'unpaid';

        // VALIDASI
        $request->validate([
            'bpjs_ketenagakerjaan' => 'required|in:paid,unpaid',
        ]);

        // HANDLE BORONGAN
        if ($isBorongan) {
            $bpjsKes = 'mandiri';
        }

        $updateData = [
            'bpjs_ketenagakerjaan' => $bpjsTk,
            'tanggal_bayar_ketenagakerjaan' =>
                $bpjsTk === 'paid' ? now() : null,

            'bpjs_kesehatan' => $bpjsKes,
            'tanggal_bayar_kesehatan' =>
                $bpjsKes === 'paid' ? now() : null,
        ];

        // HISTORY
        if (
            (!$isBorongan && $bpjs->bpjs_kesehatan != $bpjsKes) ||
            $bpjs->bpjs_ketenagakerjaan != $bpjsTk
        ) {
            BpjsHistory::create([
                'bpjs_record_id' => $bpjs->id,
                'bpjs_kesehatan' => $bpjs->bpjs_kesehatan ?? 'mandiri',
                'bpjs_ketenagakerjaan' => $bpjs->bpjs_ketenagakerjaan,
                'tanggal_bayar' => now(),
                'updated_by' => Auth::user()->name ?? 'system'
            ]);
        }

        $bpjs->update($updateData);

        // 🔥 SUPPORT AJAX & NORMAL
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Update berhasil',
                'data' => $bpjs
            ]);
        }

        return back()->with('success', 'Status BPJS berhasil diupdate');
    }

    public function show($id)
    {
        $data = BpjsRecord::with([
            'employee.company',
            'employee.department',
            'employee.position'
        ])->findOrFail($id);

        return view('labour.bpjs.show', compact('data'));
    }

    public function bulkUpdate(Request $request)
    {
        $ids = $request->input('ids');
        $status = $request->input('status');

        if (!$ids || !is_array($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'IDs tidak valid'
            ], 422);
        }

        if (!in_array($status, ['paid', 'unpaid'])) {
            return response()->json([
                'success' => false,
                'message' => 'Status tidak valid'
            ], 422);
        }

        $updated = 0;

        foreach ($ids as $id) {

            $bpjs = BpjsRecord::with('employee')->find($id);
            if (!$bpjs) continue;

            $isBorongan = $bpjs->employee->isBorongan();

            $updateData = [
                'bpjs_ketenagakerjaan' => $status,
                'tanggal_bayar_ketenagakerjaan' =>
                    $status === 'paid' ? now() : null,
            ];

            if (!$isBorongan) {
                $updateData['bpjs_kesehatan'] = $status;
                $updateData['tanggal_bayar_kesehatan'] =
                    $status === 'paid' ? now() : null;
            } else {
                $updateData['bpjs_kesehatan'] = 'mandiri';
                $updateData['tanggal_bayar_kesehatan'] = null;
            }

            // HISTORY
            if (
                (!$isBorongan && $bpjs->bpjs_kesehatan != $status) ||
                $bpjs->bpjs_ketenagakerjaan != $status
            ) {
                BpjsHistory::create([
                    'bpjs_record_id' => $bpjs->id,
                    'bpjs_kesehatan' => $bpjs->bpjs_kesehatan,
                    'bpjs_ketenagakerjaan' => $bpjs->bpjs_ketenagakerjaan,
                    'tanggal_bayar' => now(),
                    'updated_by' => Auth::user()->name ?? 'system'
                ]);
            }

            $bpjs->update($updateData);
            $updated++;
        }

        return response()->json([
            'success' => true,
            'message' => 'Bulk update berhasil',
            'updated' => $updated
        ]);
    }

    public function export(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        return Excel::download(
            new BpjsExport($bulan, $tahun),
            'bpjs_' . $bulan . '_' . $tahun . '.xlsx'
        );
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120'
        ]);

        $import = new BpjsImport();

        Excel::import($import, $request->file('file'));

        if (count($import->errors)) {
            return back()->with('error_list', $import->errors);
        }

        return back()->with('success', 'Import berhasil!');
    }

    public function template()
    {
        $employees = \App\Models\Employee::with('company')->get();

        $data = $employees->map(function ($emp) {
            return [
                'nik' => $emp->nik,
                'nama' => $emp->full_name,
                'bulan' => now()->format('F'),
                'tahun' => date('Y'),
                'bpjs_kesehatan' => $emp->isBorongan() ? 'mandiri' : 'unpaid',
                'bpjs_ketenagakerjaan' => 'unpaid',
                'total_iuran' => 0,
            ];
        });

        return Excel::download(
            new class($data) implements 
                \Maatwebsite\Excel\Concerns\FromCollection,
                \Maatwebsite\Excel\Concerns\WithHeadings {

                protected $data;

                public function __construct($data)
                {
                    $this->data = $data;
                }

                public function collection()
                {
                    return $this->data;
                }

                public function headings(): array
                {
                    return [
                        'nik',
                        'nama',
                        'bulan',
                        'tahun',
                        'bpjs_kesehatan',
                        'bpjs_ketenagakerjaan',
                        'total_iuran',
                    ];
                }
            },
            'template_bpjs_auto.xlsx'
        );
    }
}