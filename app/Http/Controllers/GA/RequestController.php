<?php

namespace App\Http\Controllers\GA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestItem;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = RequestItem::latest()->paginate(10);

        return view('ga.request.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ga.request.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_name'   => 'required|string|max:255',
            'qty'         => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        // 🔥 Generate Request Code (AMAN)
        $last = RequestItem::latest()->first();

        $number = 1;

        if ($last && $last->request_code) {
            // ambil angka dari REQ-0001
            $lastNumber = (int) str_replace('REQ-', '', $last->request_code);
            $number = $lastNumber + 1;
        }

        $code = 'REQ-' . str_pad($number, 4, '0', STR_PAD_LEFT);

        RequestItem::create([
            'request_code' => $code,
            'item_name'    => $request->item_name,
            'qty'          => $request->qty,
            'description'  => $request->description,
            'status'       => 'pending',
            'request_date' => now(),
        ]);

        return redirect()->route('ga.requests.index')
            ->with('success', 'Request berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $requestItem = RequestItem::findOrFail($id);

        return view('ga.request.show', compact('requestItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $requestItem = RequestItem::findOrFail($id);

        return view('ga.request.edit', compact('requestItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $requestItem = RequestItem::findOrFail($id);

        $request->validate([
            'item_name'   => 'required|string|max:255',
            'qty'         => 'required|integer|min:1',
            'description' => 'nullable|string',
            'status'      => 'required|in:pending,approved,rejected,done',
        ]);

        $requestItem->update([
            'item_name'   => $request->item_name,
            'qty'         => $request->qty,
            'description' => $request->description,
            'status'      => $request->status,
        ]);

        return redirect()->route('ga.requests.index')
            ->with('success', 'Request berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $requestItem = RequestItem::findOrFail($id);
        $requestItem->delete();

        return redirect()->route('ga.requests.index')
            ->with('success', 'Request berhasil dihapus');
    }
}