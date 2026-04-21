<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::orderBy('location_name')->paginate(10);
        return view('locations.index', compact('locations'));
    }

    public function create()
    {
        return view('locations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'location_name' => 'required|string|max:255'
        ]);

        Location::create([
            'location_name' => $request->location_name
        ]);

        return redirect()->route('locations.index')->with('success', 'Location berhasil ditambahkan.');
    }

    public function edit(Location $location)
    {
        return view('locations.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $request->validate([
            'location_name' => 'required|string|max:255'
        ]);

        $location->update([
            'location_name' => $request->location_name
        ]);

        return redirect()->route('locations.index')->with('success', 'Location berhasil diperbarui.');
    }

    public function destroy(Location $location)
    {
        $location->delete();
        return redirect()->route('locations.index')->with('success', 'Location berhasil dihapus.');
    }
}
