<?php

namespace App\Http\Controllers\SHE;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Pelatihan;
use App\Models\PelatihanReschedule;

class PelatihanRescheduleController extends Controller
{
    public function store(Request $request, $pelatihanId)
    {
        $pelatihan = Pelatihan::findOrFail($pelatihanId);

        $request->validate([
            'tanggal_baru' => 'required|date|after_or_equal:'.$pelatihan->tanggal,
            'alasan'       => 'required|string|max:255',
        ]);

        // simpan reschedule
        $pelatihan->reschedules()->create([
            'tanggal_lama' => $pelatihan->tanggal,
            'tanggal_baru' => $request->tanggal_baru,
            'alasan'       => $request->alasan,
        ]);

        // update tanggal & status
        $pelatihan->update([
            'tanggal' => $request->tanggal_baru,
            'status'  => 'Reschedule',
        ]);

        return redirect()->back()->with('success', 'Reschedule berhasil disimpan!');
    }
}
