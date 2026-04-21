<?php

namespace App\Http\Controllers\GA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Category;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AssetExport;
//use App\Imports\AssetImport;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('assets')->get();

        $query = Asset::query();

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $assets = $query->with('category')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('ga.asset.index', compact('assets', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('ga.asset.create', compact('categories'));
    }

    public function store(Request $request)
    {
      
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        $category = Category::findOrFail($request->category_id);

        $asset = new Asset();

        // 🔥 FIX: pakai generator resmi (tidak pakai rand lagi)
        $asset->asset_code = $this->generateAssetCode($request->category_id);

        $asset->name = $request->name;
        $asset->category_id = $request->category_id;
        $asset->location = $request->location;
        $asset->condition = $request->condition;
        $asset->purchase_date = $request->purchase_date;
        $asset->price = $request->price;
        $asset->description = $request->description;

        // 🔥 TYPE FIX (STABLE)
        if ($category->name === 'Properti') {
            $asset->type = 'fixed';
        } else {
            $asset->type = 'stock';
        }

        $asset->quantity = $request->quantity;

        $asset->save();

        return redirect()->route('ga.assets.index')
            ->with('success', 'Asset berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $asset = Asset::with('category')->findOrFail($id);
        return view('ga.asset.show', compact('asset'));
    }

    public function edit(string $id)
    {
        $asset = Asset::findOrFail($id);
        $categories = Category::all();

        return view('ga.asset.edit', compact('asset', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $asset = Asset::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:ga_categories,id',
            'condition' => 'required|in:baik,rusak,maintenance',
            'quantity' => 'required|integer|min:1',
        ]);

        $category = Category::findOrFail($request->category_id);

        // 🔥 TYPE UPDATE FIX (IMPORTANT)
        $type = $category->name === 'Properti' ? 'fixed' : 'stock';

        $asset->update([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
            'location' => $request->location,
            'condition' => $request->condition,
            'purchase_date' => $request->purchase_date,
            'price' => $request->price,
            'description' => $request->description,
            'type' => $type,
        ]);

        return redirect()->route('ga.assets.index')
            ->with('success', 'Asset berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $asset = Asset::findOrFail($id);
        $asset->delete();

        return redirect()->route('ga.assets.index')
            ->with('success', 'Asset berhasil dihapus');
    }

    // =========================
    // STOCK IN
    // =========================
    public function stockIn($id)
    {
        $asset = Asset::findOrFail($id);
        return view('ga.asset.stock_in', compact('asset'));
    }

    public function storeStockIn(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1'
        ]);

        $asset = Asset::findOrFail($id);

        if ($asset->type === 'fixed') {
            return back()->with('error', 'Fixed asset (tanah/bangunan) tidak bisa stock in');
        }

        $asset->quantity += $request->qty;
        $asset->save();

        return redirect()->route('ga.assets.show', $id)
            ->with('success', 'Stok berhasil ditambah');
    }

    // =========================
    // STOCK OUT
    // =========================
    public function stockOut($id)
    {
        $asset = Asset::findOrFail($id);
        return view('ga.asset.stock_out', compact('asset'));
    }

    public function storeStockOut(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1'
        ]);

        $asset = Asset::findOrFail($id);

        if ($asset->type === 'fixed') {
            return back()->with('error', 'Fixed asset (tanah/bangunan) tidak bisa stock out');
        }

        if ($request->qty > $asset->quantity) {
            return back()->with('error', 'Stok tidak cukup');
        }

        $asset->quantity -= $request->qty;
        $asset->save();

        return redirect()->route('ga.assets.show', $id)
            ->with('success', 'Stok berhasil dikurangi');
    }

    // =========================
    // EXPORT IMPORT
    // =========================
    //public function export()
    //{
      //  return Excel::download(new AssetExport, 'data-asset.xlsx');
    //}

   // public function import(Request $request)
    //{
      //  $request->validate([
       //     'file' => 'required|mimes:xlsx,xls'
        //]);

        //Excel::import(new AssetImport, $request->file('file'));

        //return back()->with('success', 'Import berhasil');
    //}

    // =========================
    // CODE GENERATOR (CLEAN FIXED)
    // =========================
    private function generateAssetCode($categoryId)
    {
        $category = Category::findOrFail($categoryId);

        $prefix = $category->code;

        $last = Asset::where('asset_code', 'like', "GA-$prefix-%")
            ->orderBy('id', 'desc')
            ->first();

        $number = 1;

        if ($last) {
            $parts = explode('-', $last->asset_code);
            $number = (int) end($parts) + 1;
        }

        return 'GA-' . $prefix . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}