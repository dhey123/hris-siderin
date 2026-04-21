<?php

namespace App\Http\Controllers\SHE;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Exports\HealthReportExport;
use Maatwebsite\Excel\Facades\Excel;

class HealthReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with([
            'company',
            'department',
            'position',
            'suratDokters',
            'mcus' => function ($q) {
                $q->orderByDesc('tanggal_mcu');
            }
        ]);

        // ================= SEARCH =================
        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nik', 'like', "%$search%")
                  ->orWhere('full_name', 'like', "%$search%")
                  ->orWhereHas('department', function ($q2) use ($search) {
                      $q2->where('department_name', 'like', "%$search%");
                  })
                  ->orWhereHas('position', function ($q2) use ($search) {
                      $q2->where('position_name', 'like', "%$search%");
                  });
            });
        }

        // ================= FILTER COMPANY =================
        if ($request->company) {
            $query->where('company_id', $request->company);
        }

        // ================= FILTER DEPARTMENT =================
        if ($request->department) {
            $query->where('department_id', $request->department);
        }

        // ================= FILTER STATUS =================
        if ($request->status) {
            if ($request->status == 'sakit') {
                $query->whereHas('suratDokters');
            }

            if ($request->status == 'belum_mcu') {
                $query->whereDoesntHave('mcus');
            }

            if ($request->status == 'sehat') {
                $query->whereDoesntHave('suratDokters')
                      ->whereHas('mcus');
            }
        }

        $employees = $query->paginate(10)->withQueryString();

        // ambil data untuk dropdown
        $companies = Company::all();
        $departments = Department::all();

        return view('she.health.riwayat.index', compact(
            'employees',
            'companies',
            'departments'
        ));
    }

    public function export()
    {
        return Excel::download(
            new HealthReportExport,
            'riwayat_kesehatan_karyawan.xlsx'
        );
    }
}