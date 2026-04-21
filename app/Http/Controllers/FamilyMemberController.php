<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\FamilyMember;
use Illuminate\Http\Request;

class FamilyMemberController extends Controller
{
    /**
     * Show list family by employee
     */
    public function index($employee_id)
    {
        $employee = Employee::with('familyMembers')->findOrFail($employee_id);
        $family = $employee->familyMembers;

        return view('family.index', compact('employee', 'family'));
    }

    /**
     * Show form create
     */
    public function create($employee_id)
    {
        $employee = Employee::findOrFail($employee_id);
        return view('family.create', compact('employee'));
    }

    /**
     * Store data family member
     */
    public function store(Request $request, $employee_id)
    {
        $request->validate([
            'name' => 'required',
            'relationship' => 'required',
            'birth_date' => 'nullable|date',
            'is_dependent' => 'sometimes|boolean',
        ]);

        $isDependent = $request->has('is_dependent') ? true : false;

        // Hanya anak yang dihitung sebagai tanggungan
        if ($isDependent && str_contains(strtolower($request->relationship), 'anak')) {
            $current = FamilyMember::where('employee_id', $employee_id)
                ->where('is_dependent', true)
                ->whereRaw("LOWER(relationship) LIKE '%anak%'")
                ->count();

            if ($current >= 3) {
                return back()->withErrors([
                    'is_dependent' => 'Maksimal tanggungan pajak adalah 3 anak'
                ]);
            }
        } else {
            // Kalau bukan anak, tetap simpan tapi tidak dihitung pajak
            $isDependent = false;
        }

        FamilyMember::create([
            'employee_id' => $employee_id,
            'name' => $request->name,
            'relationship' => $request->relationship,
            'birth_date' => $request->birth_date,
            'is_dependent' => $isDependent,
        ]);

        return redirect()
            ->route('family.index', $employee_id)
            ->with('success', 'Anggota keluarga berhasil ditambahkan');
    }

    /**
     * Show edit form
     */
    public function edit($employee_id, $id)
    {
        $employee = Employee::findOrFail($employee_id);
        $family = FamilyMember::findOrFail($id);

        return view('family.edit', compact('employee', 'family'));
    }

    /**
     * Update data family member
     */
    public function update(Request $request, $employee_id, $id)
    {
        $family = FamilyMember::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'relationship' => 'required',
            'birth_date' => 'nullable|date',
            'is_dependent' => 'sometimes|boolean',
        ]);

        $isDependent = $request->has('is_dependent') ? true : false;

        // Hanya anak yang dihitung
        if ($isDependent && str_contains(strtolower($request->relationship), 'anak')) {
            $current = FamilyMember::where('employee_id', $employee_id)
                ->where('is_dependent', true)
                ->whereRaw("LOWER(relationship) LIKE '%anak%'")
                ->where('id', '!=', $id)
                ->count();

            if ($current >= 3) {
                return back()->withErrors([
                    'is_dependent' => 'Maksimal tanggungan pajak adalah 3 anak'
                ]);
            }
        } else {
            $isDependent = false;
        }

        $family->update([
            'name' => $request->name,
            'relationship' => $request->relationship,
            'birth_date' => $request->birth_date,
            'is_dependent' => $isDependent,
        ]);

        return redirect()->route('family.index', $employee_id)
                         ->with('success', 'Data anggota keluarga berhasil diupdate');
    }

    /**
     * Delete family member
     */
    public function destroy($employee_id, $id)
    {
        $family = FamilyMember::findOrFail($id);
        $family->delete();

        return redirect()->route('family.index', $employee_id)
                         ->with('success', 'Data anggota keluarga berhasil dihapus');
    }
}
