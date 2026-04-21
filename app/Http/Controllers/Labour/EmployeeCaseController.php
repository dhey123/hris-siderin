<?php

namespace App\Http\Controllers\Labour;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeCase;
use App\Models\Employee;

class EmployeeCaseController extends Controller
{
    public function index()
    {
        $cases = EmployeeCase::with('employee')
            ->latest()
            ->paginate(10);

        return view('labour.cases.index', compact('cases'));
    }

    public function create()
    {
        $employees = Employee::leftJoin('departments','employees.department_id','=','departments.id')
            ->leftJoin('companies','employees.company_id','=','companies.id')
            ->select(
                'employees.id',
                'employees.full_name',
                'departments.department_name',
                'companies.company_name'
            )
            ->orderBy('employees.full_name')
            ->get();

        return view('labour.cases.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'jenis_kasus' => 'required',
            'tanggal' => 'required|date',
            'status' => 'required',
            'kronologi' => 'nullable'
        ]);

        EmployeeCase::create([
            'employee_id' => $request->employee_id,
            'jenis_kasus' => $request->jenis_kasus,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
            'kronologi' => $request->kronologi,
        ]);

        return redirect()->route('labour.cases.index')
            ->with('success','Kasus berhasil ditambahkan');
    }

    public function edit($id)
{
    $case = EmployeeCase::with(['employee.company','employee.department'])
        ->findOrFail($id);

    return view('labour.cases.edit', compact('case'));
}
public function update(Request $request, $id)
{
    $request->validate([
        'jenis_kasus' => 'required',
        'tanggal' => 'required|date',
        'status' => 'required'
    ]);

    $case = EmployeeCase::findOrFail($id);

    $case->update([
        'jenis_kasus' => $request->jenis_kasus,
        'tanggal' => $request->tanggal,
        'status' => $request->status,
        'kronologi' => $request->kronologi
    ]);

    return redirect()->route('labour.cases.index')
        ->with('success','Kasus berhasil diperbarui');
}
    public function destroy($id)
    {
        $case = EmployeeCase::findOrFail($id);

        $case->delete();

        return redirect()->route('labour.cases.index')
            ->with('success','Kasus berhasil dihapus');
    }
    public function show($id)
{
    $case = EmployeeCase::with(['employee.company','employee.department'])
        ->findOrFail($id);

    return view('labour.cases.show', compact('case'));
}
}