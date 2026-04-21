@extends('layouts.app')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Riwayat Pemakaian APD
            </h1>
            <p class="text-sm text-gray-500">
                {{ $apd->nama_apd }} – {{ $apd->jenis_apd }}
            </p>
        </div>

        <a href="{{ route('she.safety.apd.logs.create', $apd->id) }}"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
            + Pakai APD
        </a>
    </div>

    {{-- KEMBALI --}}
    <a href="{{ route('she.safety.apd.list') }}"
       class="inline-block px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
        ← Kembali ke Daftar APD
    </a>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow border overflow-x-auto mt-4">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Stok Awal</th>
                    <th class="px-4 py-3">Jumlah Dipakai</th>
                    <th class="px-4 py-3">Stok Akhir</th>
                    <th class="px-4 py-3">Penanggung Jawab</th>
                    <th class="px-4 py-3">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($log->tanggal)->format('d-m-Y') }}</td>
                        <td class="px-4 py-2">{{ $log->stok_awal ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $log->jumlah }}</td>
                        <td class="px-4 py-2">{{ $log->stok_akhir ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $log->dipakai_oleh ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $log->keterangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-400">
                            Belum ada riwayat pemakaian
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
