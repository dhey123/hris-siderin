<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmploymentType;
use App\Models\LeaveRequest;
use App\Models\RecruitmentApplicant;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // =========================
        // TOTAL KARYAWAN
        // =========================
        $total_employee = Employee::where('status', 'Active')->count();

        // =========================
        // TIPE KARYAWAN
        // =========================
        $staff = Employee::where('status', 'Active')->whereHas('employmentType', fn($q) => $q->where('type_name', 'Staff'))->count();
        $produksi = Employee::where('status', 'Active')->whereHas('employmentType', fn($q) => $q->where('type_name', 'Produksi'))->count();
        $borongan = Employee::where('status', 'Active')->whereHas('employmentType', fn($q) => $q->where('type_name', 'Borongan'))->count();

        // =========================
        // KONTRAK AKAN HABIS (30 hari)
        // =========================
        $kontrak_habis = Employee::kontrakAkanHabis()->count();

        // =========================
        // KARYAWAN KELUAR
        // =========================
        $resign = Employee::where('status', 'Inactive')->count();

        // =========================
        // CUTI HARI INI
        // =========================
        $cuti_hari_ini = 0;
        if (class_exists(LeaveRequest::class)) { $cuti_hari_ini = LeaveRequest::whereDate('start_date', Carbon::today())->count();}

        // =========================
        // CUTI PENDING
        // =========================
        $cuti_pending = 0;
        if (class_exists(LeaveRequest::class)) {$cuti_pending = LeaveRequest::where('status', 'pending')->count();}

        // =========================
        // RECRUITMENT (PELAMAR)
        // =========================
        $kandidat = 0;
        if (class_exists(RecruitmentApplicant::class)) {$kandidat = RecruitmentApplicant::count();}

        // =========================
        // INTERVIEW (contoh stage)
        // =========================
        $interview = 0;
        if (class_exists(RecruitmentApplicant::class)) {$interview = RecruitmentApplicant::where('stage', 'interview')->count();}

        // =========================
        // CHART DATA (UTAMA)
        // =========================
        $chart = [
            'labels' => ['Staff', 'Produksi', 'Borongan'],
            'data' => [$staff, $produksi, $borongan]
        ];

        // =========================
        // KPI TAMBAHAN (UNTUK CHART BARU)
        // =========================
        $chart_kpi = [
            'labels' => ['Staff', 'Produksi', 'Borongan', 'Kontrak', 'Cuti'],
            'data' => [$staff, $produksi, $borongan, $kontrak_habis, $cuti_hari_ini]
        ];

        // =========================
        // ALERT (PENTING BANGET)
        // =========================
        $alerts = [
            'kontrak' => $kontrak_habis,
            'cuti_pending' => $cuti_pending,
            'interview' => $interview
        ];

        // =========================
        // CALENDAR EVENTS (SIMPLE)
        // =========================
        $events = [];

        // 🔥 CUTI
        if (class_exists(LeaveRequest::class)) {
            foreach (LeaveRequest::latest()->take(5)->get() as $cuti) {
                $events[] = [
                    'title' => 'Cuti - ' . ($cuti->employee->full_name ?? ''),
                    'start' => $cuti->start_date,
                    'color' => '#16a34a'
                ];
            }
        }

        // 🔥 KONTRAK HABIS
        foreach (Employee::kontrakAkanHabis()->take(5)->get() as $emp) {
            $events[] = [
                'title' => 'Kontrak - ' . $emp->full_name,
                'start' => $emp->tanggal_akhir_kontrak,
                'color' => '#f97316'
            ];
        }

        return view('dashboard', compact(
            'total_employee',
            'staff',
            'produksi',
            'borongan',
            'kontrak_habis',
            'resign',
            'cuti_hari_ini',
            'cuti_pending',
            'kandidat',
            'interview',
            'chart',
            'chart_kpi',
            'alerts',
            'events'
        ));
    }
}