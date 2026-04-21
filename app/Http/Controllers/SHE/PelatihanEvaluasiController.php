<?php

namespace App\Http\Controllers\SHE;
use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use App\Models\PelatihanEvaluasi;
use Illuminate\Http\Request;

class PelatihanEvaluasiController extends Controller
{
    public function create(Pelatihan $pelatihan)
    {
        // pengaman: hanya boleh evaluasi jika selesai
        if (strtolower($pelatihan->status) !== 'selesai') {
            abort(403, 'Pelatihan belum selesai');
        }

        return view('she.safety.pelatihan.evaluasi.create', compact('pelatihan'));
    }

    public function store(Request $request, Pelatihan $pelatihan)
    {
        $request->validate([
            'nilai'    => 'required|integer|min:0|max:100',
            'catatan'  => 'nullable|string',
        ]);

        PelatihanEvaluasi::create([
            'pelatihan_id' => $pelatihan->id,
            'nilai'        => $request->nilai,
            'catatan'      => $request->catatan,
        ]);

        return redirect()
            ->route('she.safety.pelatihan.show', $pelatihan->id)
            ->with('success', 'Evaluasi berhasil disimpan');
    }
}
