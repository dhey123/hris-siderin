@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">

    {{-- ================= HEADER + CETAK PDF ================= --}}
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Detail Audit - {{ $audit->kode_audit }}</h1>
        <a href="{{ route('she.environment.audit.pdf', $audit->id) }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
           Cetak PDF
        </a>
    </div>

    {{-- ================= INFO AUDIT ================= --}}
    <div class="grid grid-cols-3 gap-4 text-sm">
        <div><strong>Jenis:</strong> {{ $audit->jenis_audit }}</div>
        <div><strong>Area:</strong> {{ $audit->area }}</div>
        <div><strong>Tanggal:</strong> {{ $audit->tanggal_audit_formatted }}</div>
        <div><strong>Status:</strong> {{ ucfirst($audit->status) }}</div>
        <div><strong>Auditor:</strong> {{ $audit->auditor }}</div>
    </div>

    <hr>

    {{-- ================= CHECKLIST ================= --}}
    <h3 class="font-semibold">Checklist Audit</h3>
    <div class="overflow-x-auto">
        <table class="w-full border border-gray-300 text-sm mt-2">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">Kategori</th> 
                    <th class="border p-2">Item</th>
                    <th class="border p-2">Hasil</th>
                    <th class="border p-2">Temuan</th>
                    <th class="border p-2">Tindak Lanjut</th>
                    <th class="border p-2">Target</th>
                </tr>
            </thead>
            <tbody>
                @forelse($audit->details as $detail)
                <tr>
                    {{-- Kategori --}}
                    <td class="border p-2">{{ $detail->checklist->kategori }}</td>

                    {{-- Item + Standar --}}
                    <td class="border p-2">
                        <div class="font-semibold">{{ $detail->checklist->item }}</div>
                        <div class="text-xs text-gray-500">Standar: {{ $detail->checklist->standar }}</div>
                    </td>

                    {{-- Hasil --}}
                    <td class="border p-2">{{ ucfirst($detail->hasil) }}</td>

                    {{-- Temuan --}}
                    <td class="border p-2">{{ $detail->temuan ?? '-' }}</td>

                    {{-- Tindak Lanjut --}}
                    <td class="border p-2">{{ $detail->tindak_lanjut ?? '-' }}</td>

                    {{-- Target --}}
                    <td class="border p-2">
                        {{ $detail->target_selesai ? \Carbon\Carbon::parse($detail->target_selesai)->format('d/m/Y') : '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center p-4 text-gray-500 font-medium">
                        Belum ada checklist
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ================= BUTTON KEMBALI ================= --}}
    <div class="mt-6 text-right">
        <a href="{{ route('she.environment.audit.index') }}"
           class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">Kembali</a>
    </div>

</div>
@endsection