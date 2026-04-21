<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\EmploymentStatus;
use App\Models\Bank;


class SetController extends Controller
{
    public function departmentsIndex()
    {
        $departments = Department::all();
        return view('settings.departments.index', compact('departments'));
    }

    public function departmentsCreate()
    {
        return view('settings.departments.create');
    }

    public function departmentsStore(Request $request)
    {
        $request->validate(['name' => 'required|unique:departments,name']);
        Department::create($request->all());
        return redirect()->route('settings.departments.index')
                         ->with('success', 'Department berhasil ditambahkan');
    }

    public function departmentsEdit(Department $department)
    {
        return view('settings.departments.edit', compact('department'));
    }

    public function departmentsUpdate(Request $request, Department $department)
    {
        $request->validate(['name' => 'required|unique:departments,name,' . $department->id]);
        $department->update($request->all());
        return redirect()->route('settings.departments.index')
                         ->with('success', 'Department berhasil diperbarui');
    }

    public function departmentsDestroy(Department $department)
    {
        $department->delete();
        return redirect()->route('settings.departments.index')
                         ->with('success', 'Department berhasil dihapus');
    }

    // ========================= STATUS KERJA =========================
public function employmentStatusIndex()
{
    $employmentStatuses = EmploymentStatus::all();
    return view('settings.employment_status.index', compact('employmentStatuses'));
}

public function employmentStatusCreate()
{
    return view('settings.employment_status.create');
}

public function employmentStatusStore(Request $request)
{
    $request->validate(['status_name' => 'required|unique:employment_statuses,status_name']);
    EmploymentStatus::create($request->all());
    return redirect()->route('settings.employment_status.index')
                     ->with('success', 'Status Kerja berhasil ditambahkan');
}

public function employmentStatusEdit(EmploymentStatus $employmentStatus)
{
    return view('settings.employment_status.edit', compact('employmentStatus'));
}

public function employmentStatusUpdate(Request $request, EmploymentStatus $employmentStatus)
{
    $request->validate([
        'status_name' => 'required|unique:employment_statuses,status_name,' . $employmentStatus->id
    ]);
    $employmentStatus->update($request->all());
    return redirect()->route('settings.employment_status.index')
                     ->with('success', 'Status Kerja berhasil diperbarui');
}

public function employmentStatusDestroy(EmploymentStatus $employmentStatus)
{
    $employmentStatus->delete();
    return redirect()->route('settings.employment_status.index')
                     ->with('success', 'Status Kerja berhasil dihapus');
}

// ========================= BANK =========================
public function banksIndex()
{
    $banks = Bank::all();
    return view('settings.banks.index', compact('banks'));
}

public function banksCreate()
{
    return view('settings.banks.create');
}

public function banksStore(Request $request)
{
    $request->validate(['bank_name' => 'required|unique:banks,bank_name']);
    Bank::create($request->all());
    return redirect()->route('settings.banks.index')
                     ->with('success', 'Bank berhasil ditambahkan');
}

public function banksEdit(Bank $bank)
{
    return view('settings.banks.edit', compact('bank'));
}

public function banksUpdate(Request $request, Bank $bank)
{
    $request->validate(['bank_name' => 'required|unique:banks,bank_name,' . $bank->id]);
    $bank->update($request->all());
    return redirect()->route('settings.banks.index')
                     ->with('success', 'Bank berhasil diperbarui');
}

public function banksDestroy(Bank $bank)
{
    $bank->delete();
    return redirect()->route('settings.banks.index')
                     ->with('success', 'Bank berhasil dihapus');
}


}