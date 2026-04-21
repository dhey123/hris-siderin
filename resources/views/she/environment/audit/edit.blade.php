@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">

    <h1 class="text-2xl font-bold">Edit Audit - {{ $audit->kode_audit }}</h1>

    {{-- ERROR VALIDATION --}}
    @if ($errors->any())
        <div class="bg-red-100 p-4 rounded text-red-700">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM UTAMA + CHECKLIST --}}
    <form action="{{ route('she.environment.audit.update', $audit->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- ================= AUDIT UTAMA ================= --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold text-gray-700">Kode Audit</label>
                <input type="text" name="kode_audit" value="{{ old('kode_audit', $audit->kode_audit) }}"
                       class="w-full border rounded p-2 mt-1" required>
            </div>
            <div>
                <label class="block font-semibold text-gray-700">Jenis Audit</label>
                <input type="text" name="jenis_audit" value="{{ old('jenis_audit', $audit->jenis_audit) }}"
                       class="w-full border rounded p-2 mt-1" required>
            </div>
            <div>
                <label class="block font-semibold text-gray-700">Area</label>
                <input type="text" name="area" value="{{ old('area', $audit->area) }}"
                       class="w-full border rounded p-2 mt-1" required>
            </div>
            <div>
                <label class="block font-semibold text-gray-700">Tanggal Audit</label>
                <input type="date" name="tanggal_audit"
                       value="{{ old('tanggal_audit', \Carbon\Carbon::parse($audit->tanggal_audit)->format('Y-m-d')) }}"
                       class="w-full border rounded p-2 mt-1" required>
            </div>
            <div>
                <label class="block font-semibold text-gray-700">Status</label>
                <select name="status" class="w-full border rounded p-2 mt-1" required>
                    <option value="draft" {{ old('status', $audit->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="selesai" {{ old('status', $audit->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="followup" {{ old('status', $audit->status) == 'followup' ? 'selected' : '' }}>Follow Up</option>
                </select>
            </div>
            <div>
                <label class="block font-semibold text-gray-700">Auditor</label>
                <input type="text" name="auditor" value="{{ old('auditor', $audit->auditor) }}"
                       class="w-full border rounded p-2 mt-1">
            </div>
        </div>

        {{-- ================= CHECKLIST ================= --}}
        <h2 class="text-xl font-semibold mt-6">Checklist Audit</h2>
        <table class="w-full border border-gray-300 text-sm mt-2">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">Item</th>
                    <th class="border p-2">Hasil</th>
                    <th class="border p-2">Temuan</th>
                    <th class="border p-2">Tindak Lanjut</th>
                    <th class="border p-2">Target</th>
                </tr>
            </thead>
            <tbody>
                @foreach($audit->details as $detail)
                <tr>
                    <td class="border p-2">
                        <div class="font-semibold">{{ $detail->checklist->item }}</div>
                        <div class="text-xs text-gray-500">Standar: {{ $detail->checklist->standar }}</div>
                    </td>
                    <td class="border p-2">
                        <select name="hasil[{{ $detail->id }}]" class="border p-1 w-full rounded">
                            <option value="">- Pilih -</option>
                            <option value="sesuai" {{ $detail->hasil == 'sesuai' ? 'selected' : '' }}>Sesuai</option>
                            <option value="tidak_sesuai" {{ $detail->hasil == 'tidak_sesuai' ? 'selected' : '' }}>Tidak Sesuai</option>
                            <option value="observasi" {{ $detail->hasil == 'observasi' ? 'selected' : '' }}>Observasi</option>
                        </select>
                    </td>
                    <td class="border p-2">
                        <textarea name="temuan[{{ $detail->id }}]" class="border w-full p-1 rounded" rows="2">{{ $detail->temuan }}</textarea>
                    </td>
                    <td class="border p-2">
                        <textarea name="tindak_lanjut[{{ $detail->id }}]" class="border w-full p-1 rounded" rows="2">{{ $detail->tindak_lanjut }}</textarea>
                    </td>
                    <td class="border p-2">
                        <input type="date" name="target_selesai[{{ $detail->id }}]"
                               value="{{ $detail->target_selesai ? \Carbon\Carbon::parse($detail->target_selesai)->format('Y-m-d') : '' }}"
                               class="border p-1 w-full rounded">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- BUTTON SUBMIT --}}
        <div class="mt-6 flex justify-end space-x-2">
            <a href="{{ route('she.environment.audit.index') }}"
               class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">Batal</a>
            <button type="submit"
                    class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                Simpan Semua
            </button>
        </div>
    </form>

</div>
@endsection