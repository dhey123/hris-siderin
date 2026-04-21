<?php

namespace App\Http\Controllers\Legal;

use App\Http\Controllers\Controller;

use App\Models\LegalVendor;
use Illuminate\Http\Request;

class LegalVendorController extends Controller
{
    public function index(Request $request)
    {
        $query = LegalVendor::query();

        // 🔎 Search
        if ($request->filled('search')) {
            $query->where('nama_vendor', 'like', '%' . $request->search . '%');
        }

        // 📄 Data vendor
        $vendors = $query->latest()->paginate(10);

        // 📊 Statistik
        $totalVendor = LegalVendor::count();
        $vendorAktif = LegalVendor::where('status', 'Aktif')->count();

        return view('legal.vendors.index', compact(
            'vendors',
            'totalVendor',
            'vendorAktif'
        ));
    }

    public function create()
    {
        return view('legal.vendors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_vendor'   => 'required|string|max:255',
            'jenis_vendor'  => 'nullable|string|max:255',
            'npwp'          => 'nullable|string|max:255',
            'alamat'        => 'nullable|string',
            'email'         => 'nullable|email|max:255',
            'kontak_person' => 'nullable|string|max:255',
            'no_telp'       => 'nullable|string|max:50',
            'status'        => 'nullable|in:Aktif,Nonaktif',
        ]);

        LegalVendor::create($validated);

        return redirect()->route('legal.vendors.index')
            ->with('success', 'Vendor berhasil ditambahkan.');
    }

    public function edit(LegalVendor $vendor)
    {
        return view('legal.vendors.edit', compact('vendor'));
    }

    public function update(Request $request, LegalVendor $vendor)
    {
        $validated = $request->validate([
            'nama_vendor'   => 'required|string|max:255',
            'jenis_vendor'  => 'nullable|string|max:255',
            'npwp'          => 'nullable|string|max:255',
            'alamat'        => 'nullable|string',
            'email'         => 'nullable|email|max:255',
            'kontak_person' => 'nullable|string|max:255',
            'no_telp'       => 'nullable|string|max:50',
            'status'        => 'nullable|in:Aktif,Nonaktif',
        ]);

        $vendor->update($validated);

        return redirect()->route('legal.vendors.index')
            ->with('success', 'Vendor berhasil diperbarui.');
    }

    public function destroy(LegalVendor $vendor)
    {
        $vendor->delete();

        return redirect()->route('legal.vendors.index')
            ->with('success', 'Vendor berhasil dihapus.');
    }
}