@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center bg-white p-6 rounded-xl shadow">
        <h1 class="text-2xl font-bold">Dashboard Audit Internal</h1>
        <a href="{{ route('she.environment.audit.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            + Buat Audit
        </a>
    </div>
    {{-- KEMBALI --}}
    <div>
        <a href="{{ route('she.environment.index') }}"
           class="inline-flex items-center gap-1 px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">
            ← Kembali
        </a>
    </div>

    {{-- SUMMARY --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-5 rounded-xl shadow text-center">
            <h2 class="font-semibold">Total Audit</h2>
            <p class="text-2xl font-bold mt-2">{{ $total_audit }}</p>
        </div>
        <div class="bg-white p-5 rounded-xl shadow text-center">
            <h2 class="font-semibold">Audit Selesai</h2>
            <p class="text-2xl font-bold mt-2">{{ $audit_selesai }}</p>
        </div>
        <div class="bg-white p-5 rounded-xl shadow text-center">
            <h2 class="font-semibold">Draft / Follow Up</h2>
            <p class="text-2xl font-bold mt-2">{{ $audit_pending }}</p>
        </div>
    </div>

    {{-- PROGRESS --}}
    <div class="bg-white p-5 rounded-xl shadow">
        <h2 class="font-semibold mb-2">Progress Penyelesaian</h2>
        <div class="w-full bg-gray-200 rounded-full h-4">
            <div class="bg-green-500 h-4 rounded-full"
                 style="width: {{ $progress }}%"></div>
        </div>
        <p class="text-sm mt-2">{{ $progress }}% Audit Selesai</p>
    </div>

    {{-- FILTER --}}

    <div class="bg-white p-5 rounded-xl shadow">
        <form method="GET" class="flex flex-wrap gap-3">
            <input type="text" name="search" placeholder="Cari kode audit..."
                   class="border px-3 py-2 rounded text-sm">

            <select name="status" class="border px-3 py-2 rounded text-sm">
                <option value="">Semua Status</option>
                <option value="draft">Draft</option>
                <option value="selesai">Selesai</option>
                <option value="followup">Follow Up</option>
            </select>

            <button class="bg-blue-600 text-white px-4 py-2 rounded text-sm">
                Filter
            </button>
        </form>

    {{-- TABLE --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-xl font-bold mb-4">Daftar Audit</h2>
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2 text-left">Kode</th>
                        <th class="border p-2 text-left">Area</th>
                        <th class="border p-2 text-left">Tanggal</th>
                        <th class="border p-2 text-left">Skor</th>
                        <th class="border p-2 text-left">Status</th>
                        <th class="border p-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($audits as $audit)
                        <tr>
                            <td class="border p-2">{{ $audit->kode_audit }}</td>
                            <td class="border p-2">{{ $audit->area }}</td>
                            <td class="border p-2">{{ $audit->tanggal_audit_formatted }}</td>
                            <td class="border p-2">
                                <span class="px-2 py-1 rounded text-sm font-semibold
                                    {{ $audit->skor >= 85 ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $audit->skor >= 70 && $audit->skor < 85 ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $audit->skor < 70 ? 'bg-red-100 text-red-700' : '' }}">
                                    {{ $audit->skor }}%
                                </span>
                            </td>
                            <td class="border p-2">
                                <span class="px-2 py-1 rounded-full text-sm font-medium
                                    {{ $audit->status == 'selesai' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $audit->status == 'draft' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $audit->status == 'followup' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ ucfirst($audit->status) }}
                                </span>
                            </td>
                            <td class="border p-2 space-x-2">
                                <a href="{{ route('she.environment.audit.show', $audit->id) }}"
                                   class="text-blue-600 hover:underline">Detail</a>
                                <a href="{{ route('she.environment.audit.edit', $audit->id) }}"
                                   class="text-yellow-600 hover:underline">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center p-4">Belum ada audit</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $audits->links() }}
        </div>
    </div>

    
@endsection