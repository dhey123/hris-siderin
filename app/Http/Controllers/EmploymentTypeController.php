<?php

namespace App\Http\Controllers;

use App\Models\EmploymentType;
use Illuminate\Http\Request;

class EmploymentTypeController extends Controller
{
    // LIST + SEARCH
    public function index(Request $request)
    {
        $search = $request->search;

        $types = EmploymentType::when($search, function ($query) use ($search) {
                $query->where('type_name', 'like', "%$search%");
            })
            ->orderBy('type_name', 'asc')
            ->paginate(10);

        return view('employment_types.index', compact('types', 'search'));
    }

    public function create()
    {
        return view('employment_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_name' => 'required|unique:employment_types,type_name',
        ]);

        EmploymentType::create([
            'type_name' => $request->type_name,
            'description' => $request->description,
        ]);

        return redirect()->route('employment_types.index')->with('success', 'Employment Type added successfully!');
    }

    public function edit(EmploymentType $employment_type)
    {
        return view('employment_types.edit', compact('employment_type'));
    }

    public function update(Request $request, EmploymentType $employment_type)
    {
        $request->validate([
            'type_name' => 'required|unique:employment_types,type_name,' . $employment_type->id,
        ]);

        $employment_type->update([
            'type_name' => $request->type_name,
            'description' => $request->description,
        ]);

        return redirect()->route('employment_types.index')->with('success', 'Employment Type updated.');
    }

    public function destroy(EmploymentType $employment_type)
    {
        $employment_type->delete();

        return redirect()->route('employment_types.index')->with('success', 'Employment Type deleted.');
    }
}
