<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::orderBy('position_name')->paginate(10);
        return view('settings.positions.index', compact('positions'));
    }

    public function create()
    {
        return view('settings.positions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'position_name' => 'required|unique:positions,position_name',
        ]);

        Position::create([
            'position_name' => $request->position_name,
        ]);

        return redirect()
            ->route('settings.positions.index')
            ->with('success', 'Jabatan berhasil ditambahkan');
    }

    public function edit(Position $position)
    {
        return view('settings.positions.edit', compact('position'));
    }

    public function update(Request $request, Position $position)
    {
        $request->validate([
            'position_name' => 'required|unique:positions,position_name,' . $position->id,
        ]);

        $position->update([
            'position_name' => $request->position_name,
        ]);

        return redirect()
            ->route('settings.positions.index')
            ->with('success', 'Jabatan berhasil diperbarui');
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return back()->with('success', 'Jabatan berhasil dihapus');
    }
}
