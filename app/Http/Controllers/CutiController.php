<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratDokter;
use App\Models\LeaveType;
use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use App\Models\Employee;
use Carbon\Carbon;
use App\Exports\LeaveBalanceExport;
use Maatwebsite\Excel\Facades\Excel;

class CutiController extends Controller
{
    // =========================
    // DASHBOARD
    // =========================
    public function index()
    {
        return view('cuti.index');
    }

    // =========================
    // JENIS CUTI
    // =========================
    public function types()
    {
        $types = LeaveType::all();
        return view('settings.jeniscuti.types', compact('types'));
    }

    public function createType()
    {
        return view('settings.jeniscuti.create');
    }

    public function storeType(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
        ]);

        LeaveType::create($request->only('name', 'description'));

        return back()->with('success', 'Jenis cuti berhasil ditambahkan.');
    }

    public function editType($id)
    {
        $type = LeaveType::findOrFail($id);
        return view('settings.jeniscuti.edit', compact('type'));
    }

    public function updateType(Request $request, $id)
    {
        $type = LeaveType::findOrFail($id);
        $type->update($request->only('name', 'description'));

        return back()->with('success', 'Jenis cuti berhasil diupdate.');
    }

    public function destroyType($id)
    {
        LeaveType::findOrFail($id)->delete();
        return back()->with('success', 'Jenis cuti berhasil dihapus.');
    }

    // =========================
    // REQUEST VIEW
    // =========================
    public function requests()
    {
        $employees = Employee::with(['department', 'position', 'employmentStatus', 'company'])
            ->get()
            ->map(function ($e) {

                $status = strtolower($e->employmentStatus?->status_name ?? '');
                

                return [
                    'id' => $e->id,
                    'full_name' => $e->full_name,

                    'department_name' => $e->department?->department_name ?? '-',
                    'position_name' => $e->position?->position_name ?? '-',

                    // FIX BIAR TIDAK "-"
                    'employment_status' => $e->employmentStatus?->status_name ?? '-',
                    'company_name' => $e->company?->company_name ?? $e->company?->name ?? '-',

                    // optional kalau mau dipakai di frontend
                    'status_key' => $status,
                ];
            });

        $types = LeaveType::all();

        $leaveRequests = LeaveRequest::with([
            'employee.department',
            'employee.position',
            'leaveType'
        ])->latest()->get();
        $doctorLetters = SuratDokter::latest()->get();
        return view('cuti.requests', [
    'employees' => $employees,
    'types' => $types,
    'leaveRequests' => $leaveRequests,
    'doctorLetters' => $doctorLetters,
]);
    }

    // =========================
    // STORE REQUEST
    // =========================
    public function storeRequest(Request $request)
{
    $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'leave_type_id' => 'required|exists:leave_types,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'reason' => 'nullable|string|max:255',
    ]);

    $start = Carbon::parse($request->start_date);
    $end   = Carbon::parse($request->end_date);
    $totalDays = $start->diffInDays($end) + 1;

    $employee = Employee::with(['employmentStatus'])->findOrFail($request->employee_id);
    $leaveType = LeaveType::findOrFail($request->leave_type_id);

    // =========================
    // BLOCK CUTI TAHUNAN (VERSI CLEAN)
    // =========================
    if ($leaveType->name === 'Cuti Tahunan') {

        if (!$employee->isEligibleForAnnualLeave()) {
            return back()->with('error', 'Hanya karyawan kontrak dan tetap yang mendapat cuti tahunan');
        }
    }

    // =========================
    // VALIDASI SALDO
    // =========================
    if ($leaveType->default_quota !== null) {

        $balance = LeaveBalance::firstOrCreate(
            [
                'employee_id' => $employee->id,
                'leave_type_id' => $leaveType->id,
                'year' => $start->year,
            ],
            [
                'quota' => $leaveType->default_quota,
                'used' => 0,
            ]
        );

        if (($balance->quota - $balance->used) < $totalDays) {
            return back()->with('error', 'Sisa cuti tidak cukup');
        }
    }

    LeaveRequest::create([
        'employee_id' => $employee->id,
        'leave_type_id' => $leaveType->id,
        'start_date' => $start,
        'end_date' => $end,
        'total_days' => $totalDays,
        'reason' => $request->reason,
        'status' => 'Pending',
    ]);

    return back()->with('success', 'Cuti berhasil diajukan');
}

// =========================
// APPROVAL LIST
// =========================
public function approvals()
{
    $leaveRequests = LeaveRequest::with([
        'employee.department',
        'employee.position',
        'leaveType'
    ])
    ->where('status', 'Pending')
    ->latest()
    ->get();

    return view('cuti.approvals', compact('leaveRequests'));
}

    // =========================
    // APPROVE
    // =========================
    public function approve(LeaveRequest $leaveRequest)
    {
        if ($leaveRequest->status === 'Approved') {
            return back()->with('error', 'Sudah approved');
        }

        $leaveType = $leaveRequest->leaveType;

        if ($leaveType->default_quota !== null) {

            $balance = LeaveBalance::firstOrCreate(
                [
                    'employee_id' => $leaveRequest->employee_id,
                    'leave_type_id' => $leaveRequest->leave_type_id,
                    'year' => Carbon::parse($leaveRequest->start_date)->year,
                ],
                [
                    'quota' => $leaveType->default_quota,
                    'used' => 0,
                ]
            );

            if (($balance->quota - $balance->used) < $leaveRequest->total_days) {
                return back()->with('error', 'Saldo cuti tidak cukup');
            }

            $balance->increment('used', $leaveRequest->total_days);
        }

        $leaveRequest->update([
            'status' => 'Approved',
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Approved');
    }

    public function reject(LeaveRequest $leaveRequest)
    {
        $leaveRequest->update([
            'status' => 'Rejected',
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Rejected');
    }

    // =========================
    // HISTORY
    // =========================
    public function history(Request $request)
    {
        $query = LeaveRequest::with('employee', 'leaveType');

        if ($request->leave_type_id) {
            $query->where('leave_type_id', $request->leave_type_id);
        }

        $leaveRequests = $query->latest()->get();
        $leaveTypes = LeaveType::all();

        return view('cuti.history', compact('leaveRequests', 'leaveTypes'));
    }

    // =========================
    // BALANCE
    // =========================
    public function balance(Request $request)
    {
        $year = $request->year ?? now()->year;

        $leaveType = LeaveType::where('name', 'Cuti Tahunan')->first();

        if (!$leaveType) {
            return back()->with('error', 'Cuti Tahunan belum ada');
        }

        $employees = Employee::whereHas('employmentStatus', function ($q) {
            $q->whereIn('status_name', ['Tetap', 'Kontrak']);
        })->get();

        foreach ($employees as $emp) {
            LeaveBalance::firstOrCreate(
                [
                    'employee_id' => $emp->id,
                    'leave_type_id' => $leaveType->id,
                    'year' => $year,
                ],
                [
                    'quota' => $leaveType->default_quota,
                    'used' => 0,
                ]
            );
        }

        $balances = LeaveBalance::with('employee.employmentStatus')
    ->where('year', $year)
    ->whereHas('employee.employmentStatus', function ($q) {
        $q->whereIn('status_name', ['Tetap', 'Kontrak']);
    })
    ->get();

        return view('cuti.balance', compact('balances', 'year'));
    }

    // =========================
    // RECAP
    // =========================
    public function recap(Request $request)
    {
        $month = $request->month ?? now()->format('Y-m');

        $start = Carbon::parse($month . '-01')->startOfMonth();
        $end   = Carbon::parse($month . '-01')->endOfMonth();

        $recap = LeaveRequest::with('employee')
            ->where('status', 'Approved')
            ->whereBetween('start_date', [$start, $end])
            ->get()
            ->groupBy('employee_id')
            ->map(function ($items) {
                return [
                    'employee' => $items->first()->employee,
                    'total_days' => $items->sum('total_days')
                ];
            });

        return view('cuti.recap', compact('recap', 'month'));
    }

    // =========================
    // EXPORT
    // =========================
    public function export(Request $request)
    {
        $year = $request->year ?? now()->year;

        return Excel::download(
            new LeaveBalanceExport($year),
            'rekap_cuti_'.$year.'.xlsx'
        );
    }

    // =========================
    // DETAIL EMPLOYEE
    // =========================
    public function employeeDetail($id)
    {
        $employee = Employee::with(['employmentStatus', 'company', 'department', 'position'])
            ->findOrFail($id);

        $history = LeaveRequest::with('leaveType')
            ->where('employee_id', $id)
            ->where('status', 'Approved')
            ->latest()
            ->get();

        return view('cuti.employee_detail', compact('employee', 'history'));
    }
}