<?php

namespace App\Http\Controllers;

use App\Models\Religion;
use Illuminate\Http\Request;

class ReligionController extends Controller
{
    public function index()
    {
        $religions = Religion::all();
        return view('masters.religions.index', compact('religions'));
    }

    public function create()
    {
        return view('masters.religions.create');
    }

    public function store(Request $request)
    {
        $request->validate(['religion_name' => 'required']);
        Religion::create($request->all());
        return redirect()->route('religions.index');
    }

    public function edit(Religion $religion)
    {
        return view('masters.religions.edit', compact('religion'));
    }

    public function update(Request $request, Religion $religion)
    {
        $request->validate(['religion_name' => 'required']);
        $religion->update($request->all());
        return redirect()->route('religions.index');
    }

    public function destroy(Religion $religion)
    {
        $religion->delete();
        return redirect()->route('religions.index');
    }
}
