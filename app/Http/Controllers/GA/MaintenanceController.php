<?php

namespace App\Http\Controllers\GA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Maintenance;
use App\Models\Asset;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maintenances = Maintenance::with('asset')
            ->latest()
            ->paginate(10);

        return view('ga.maintenance.index', compact('maintenances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assets = Asset::all();

        return view('ga.maintenance.create', compact('assets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|exists:ga_assets,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Maintenance::create([
            'asset_id' => $request->asset_id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'pending',
            'report_date' => now(),
        ]);

        return redirect()->route('ga.maintenance.index')
            ->with('success', 'Maintenance berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $maintenance = Maintenance::with('asset')->findOrFail($id);

        return view('ga.maintenance.show', compact('maintenance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $assets = Asset::all();

        return view('ga.maintenance.edit', compact('maintenance', 'assets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $maintenance = Maintenance::findOrFail($id);

        $request->validate([
            'asset_id' => 'required|exists:ga_assets,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,process,done',
        ]);

        $maintenance->update([
            'asset_id' => $request->asset_id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'finish_date' => $request->status === 'done' ? now() : null,
        ]);

        return redirect()->route('ga.maintenance.index')
            ->with('success', 'Maintenance berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $maintenance->delete();

        return redirect()->route('ga.maintenance.index')
            ->with('success', 'Maintenance berhasil dihapus');
    }
}