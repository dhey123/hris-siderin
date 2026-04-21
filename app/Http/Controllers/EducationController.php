<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        $education = Education::all();
        return view('masters.education.index', compact('education'));
    }

    public function create()
    {
        return view('masters.education.create');
    }

    public function store(Request $request)
    {
        $request->validate(['education_name' => 'required']);
        Education::create($request->all());
        return redirect()->route('education.index');
    }

    public function edit(Education $education)
    {
        return view('masters.education.edit', compact('education'));
    }

    public function update(Request $request, Education $education)
    {
        $request->validate(['education_name' => 'required']);
        $education->update($request->all());
        return redirect()->route('education.index');
    }

    public function destroy(Education $education)
    {
        $education->delete();
        return redirect()->route('education.index');
    }
}
