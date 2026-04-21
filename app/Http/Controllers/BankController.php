<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $bank = Bank::all();
        return view('masters.bank.index', compact('bank'));
    }

    public function create()
    {
        return view('masters.bank.create');
    }

    public function store(Request $request)
    {
        $request->validate(['bank_name' => 'required']);
        Bank::create($request->all());
        return redirect()->route('bank.index');
    }

    public function edit(Bank $bank)
    {
        return view('masters.bank.edit', compact('bank'));
    }

    public function update(Request $request, Bank $bank)
    {
        $request->validate(['bank_name' => 'required']);
        $bank->update($request->all());
        return redirect()->route('bank.index');
    }

    public function destroy(Bank $bank)
    {
        $bank->delete();
        return redirect()->route('bank.index');
    }
}
