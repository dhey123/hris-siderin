<?php

namespace App\Http\Controllers\SHE;
use App\Http\Controllers\Controller;
use App\Models\Mcu;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class McuController extends Controller
{
    /**
     * List MCU
     */
    public function index()
    {
        // JANGAN select / groupBy
        // Biar ID MCU tetep ada buat route model binding
        $mcus = Mcu::with([
    'employee.company',
    'employee.department',
    'employee.position'
])->latest('tanggal_mcu')->get();

        return view('she.health.mcu.index', compact('mcus'));
    }

    /**
     * Form tambah MCU
     */
    public function create()
    {
        $employees = Employee::orderBy('full_name')->get();
        return view('she.health.mcu.create', compact('employees'));
    }

    /**
     * Simpan MCU
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'jenis_mcu'   => 'required|string',
            'tanggal_mcu' => 'required|date',
            'hasil'       => 'required|string',
            'klinik'      => 'nullable|string',
            'catatan'     => 'nullable|string',
            'file_hasil'  => 'nullable|mimes:pdf|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file_hasil')) {
            $filePath = $request->file('file_hasil')->store('mcu', 'public');
        }

        Mcu::create([
            'employee_id' => $request->employee_id,
            'jenis_mcu'   => $request->jenis_mcu,
            'tanggal_mcu' => $request->tanggal_mcu,
            'hasil'       => $request->hasil,
            'klinik'      => $request->klinik,
            'catatan'     => $request->catatan,
            'file_hasil'  => $filePath,
        ]);

        return redirect()
            ->route('she.health.mcu.index')
            ->with('success', 'Data MCU berhasil disimpan');
    }
    public function show($id)
{
    $mcu = Mcu::with('employee')->findOrFail($id);

    return view('she.health.mcu.show', compact('mcu'));
}


}    
