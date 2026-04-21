<?php
namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\FromCollection;

class AssetExport implements FromCollection
{
    public function collection()
    {
        return Asset::with('category')->get()->map(function ($a) {
            return [
                'Kode' => $a->asset_code,
                'Nama' => $a->name,
                'Kategori' => $a->category->name ?? '-',
                'Jumlah' => $a->quantity,
                'Kondisi' => $a->condition,
                'Lokasi' => $a->location,
            ];
        });
    }
}
