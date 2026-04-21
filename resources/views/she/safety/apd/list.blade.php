@extends('layouts.app')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">

    {{-- Header --}}
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">

    {{-- Kiri --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Daftar APD</h1>
        <a href="{{ route('she.safety.index') }}"
           class="inline-block mt-2 text-sm text-gray-600 hover:text-gray-800">
            ← Kembali
        </a>
    </div>

    {{-- Kanan --}}
    <div class="flex gap-3">
        <a href="{{ route('she.safety.apd.print') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
            🖨 Cetak
        </a>

        <a href="{{ route('she.safety.apd.create') }}"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition">
            + Tambah APD
        </a>
    </div>

</div>
    
    {{-- RINGKASAN APD --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

    <div class="bg-white border rounded-xl p-4 shadow">
        <p class="text-sm text-gray-500">Total Jenis APD</p>
        <p class="text-2xl font-bold text-gray-800">{{ $total_apd }}</p>
    </div>

    <div class="bg-green-50 border border rounded-xl p-4 shadow">
        <p class="text-sm text-gray-500">Total Stok Awal</p>
        <p class="text-2xl font-bold text-blue-600">{{ $total_stok_awal }}</p>
    </div>

    <div class="bg-yellow-50 border border rounded-xl p-4 shadow">
        <p class="text-sm text-gray-500">Stok Saat Ini</p>
        <p class="text-2xl font-bold text-green-600">{{ $total_stok_saat_ini }}</p>
    </div>

    <div class="bg-purple-50 border border rounded-xl p-4 shadow">
        <p class="text-sm text-gray-500">Total Terpakai</p>
        <p class="text-2xl font-bold text-red-600">{{ $total_terpakai }}</p>
    </div>
</div>


    {{-- Table --}}
    <div class="bg-white rounded-xl shadow border overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3">Nama APD</th>
                    <th class="px-4 py-3">Jenis</th>
                    <th class="px-4 py-3">Department</th>
                    <th class="px-4 py-3">Stok Saat Ini</th>
                    <th class="px-4 py-3">Kondisi</th>
                    <th class="px-4 py-3">Keterangan</th>
                    <th class="px-4 py-3">Tanggal Pengadaan</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($apds as $apd)
                    <tr onclick="window.location='{{ route('she.safety.apd.logs.index', $apd->id) }}'"
                        class="border-b hover:bg-gray-50 cursor-pointer">
                        <td class="px-4 py-2 font-medium text-gray-800">{{ $apd->nama_apd }}</td>
                        <td class="px-4 py-2">{{ $apd->jenis_apd }}</td>
                        <td class="px-4 py-2">{{ $apd->department ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $apd->stok_saat_ini }}</td>
                        <td class="px-4 py-2">{{ $apd->kondisi }}</td>
                        <td class="px-4 py-2">{{ $apd->keterangan ?? '-' }}</td>
                        <td class="px-4 py-2">
                            {{ $apd->tanggal_pengadaan
                                ? \Carbon\Carbon::parse($apd->tanggal_pengadaan)->format('d-m-Y')
                                : '-' }}
                        </td>

                        {{-- Aksi --}}
                        <td class="px-4 py-2 text-center" onclick="event.stopPropagation()">
                            <a href="{{ route('she.safety.apd.logs.create', $apd->id) }}" title="Pakai APD"
                               class="inline-block text-blue-600 hover:text-blue-800 mx-1">🧤</a>
                            <a href="{{ route('she.safety.apd.edit', $apd->id) }}" title="Edit APD"
                               class="inline-block text-yellow-600 hover:text-yellow-800 mx-1">✏️</a>
                            <form action="{{ route('she.safety.apd.destroy', $apd->id) }}" method="POST"
                                  class="inline" onsubmit="return confirm('Yakin ingin menghapus APD ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Hapus APD" class="text-red-600 hover:text-red-800 mx-1">🗑️</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-6 text-gray-400">
                            Belum ada data APD
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
