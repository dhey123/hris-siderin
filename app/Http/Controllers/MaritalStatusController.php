<?php

namespace App\Http\Controllers;

use App\Models\MaritalStatus;
use Illuminate\Http\Request;

class MaritalStatusController extends Controller
{
    public function index()
    {
        $maritalstatus = MaritalStatus::orderBy('marital_status_name')->get();
        return view('masters.maritalstatus.index', compact('maritalstatus'));
    }

    public function create()
    {
        return view('masters.maritalstatus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'marital_status_name' => 'required'
        ]);

        MaritalStatus::create([
            'marital_status_name' => $request->marital_status_name
        ]);

        return redirect()->route('maritalstatus.index')
            ->with('success', 'Status Pernikahan berhasil ditambahkan!');
    }

    public function edit(MaritalStatus $maritalstatus)
    {
        return view('masters.maritalstatus.edit', compact('maritalstatus'));
    }

    public function update(Request $request, MaritalStatus $maritalstatus)
    {
        $request->validate([
            'marital_status_name' => 'required'
        ]);

        $maritalstatus->update([
            'marital_status_name' => $request->marital_status_name
        ]);

        return redirect()->route('maritalstatus.index')
            ->with('success', 'Status Pernikahan berhasil diupdate!');
    }

    public function destroy(MaritalStatus $maritalstatus)
    {
        $maritalstatus->delete();
        return redirect()->route('maritalstatus.index')
            ->with('success', 'Status Pernikahan berhasil dihapus!');
    }
}
