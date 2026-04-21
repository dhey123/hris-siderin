<?php

namespace App\Http\Controllers;

use App\Models\EmploymentStatus;
use Illuminate\Http\Request;

class EmploymentStatusController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $statuses = EmploymentStatus::when($search, function($q) use ($search) {
                $q->where('status_name', 'like', "%$search%");
            })
            ->orderBy('status_name', 'asc')
            ->paginate(10);

        return view('employment_statuses.index', compact('statuses', 'search'));
    }

    public function create()
    {
        return view('employment_statuses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'status_name' => 'required|unique:employment_statuses,status_name',
            'description' => 'nullable'
        ]);

        EmploymentStatus::create($request->all());

        return redirect()->route('employment_statuses.index')
            ->with('success', 'Employment Status berhasil ditambahkan!');
    }

    public function edit(EmploymentStatus $employment_status)
    {
        return view('employment_statuses.edit', compact('employment_status'));
    }

    public function update(Request $request, EmploymentStatus $employment_status)
    {
        $request->validate([
            'status_name' => 'required|unique:employment_statuses,status_name,' . $employment_status->id,
            'description' => 'nullable'
        ]);

        $employment_status->update($request->all());

        return redirect()->route('employment_statuses.index')
            ->with('success', 'Employment Status berhasil diupdate!');
    }

    public function destroy(EmploymentStatus $employment_status)
    {
        $employment_status->delete();

        return redirect()->route('employment_statuses.index')
            ->with('success', 'Employment Status berhasil dihapus!');
    }
}
