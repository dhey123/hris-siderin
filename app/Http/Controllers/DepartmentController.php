<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::orderBy('department_name')->paginate(10);
        return view('settings.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('settings.departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required|unique:departments,department_name',
        ]);

        Department::create([
            'department_name' => $request->department_name,
        ]);

        return redirect()->route('settings.departments.index')
                         ->with('success', 'Department berhasil ditambahkan');
    }

    public function edit(Department $department)
    {
        return view('settings.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'department_name' => 'required|unique:departments,department_name,' . $department->id,
        ]);

        $department->update([
            'department_name' => $request->department_name,
        ]);

        return redirect()->route('settings.departments.index')
                         ->with('success', 'Department berhasil diperbarui');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return back()->with('success', 'Department berhasil dihapus');
    }
}
