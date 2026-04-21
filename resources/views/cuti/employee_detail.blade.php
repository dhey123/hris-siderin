@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">

    {{-- HEADER + BACK BUTTON --}}
    <div class="flex items-center justify-between mb-4">

        <h1 class="text-2xl font-bold">
            Detail Cuti Karyawan
        </h1>

        <a href="{{ route('cuti.balance') }}"
           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 text-sm">
            ← Kembali
        </a>

    </div>

    {{-- INFO KARYAWAN --}}
    <div class="bg-white shadow rounded-lg p-4 mb-6">
        <p class="text-lg font-semibold">
            Nama: {{ $employee->full_name }}
        </p>
    </div>

    {{-- HISTORY CUTI --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">

        <table class="min-w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border">Jenis Cuti</th>
                    <th class="py-2 px-4 border">Tanggal</th>
                    <th class="py-2 px-4 border">Alasan</th>
                    <th class="py-2 px-4 border">Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($history as $item)
                    <tr class="hover:bg-gray-50">

                        <td class="py-2 px-4 border">
                            {{ $item->leaveType->name }}
                        </td>

                        <td class="py-2 px-4 border">
                            {{ $item->start_date }} - {{ $item->end_date }}
                        </td>

                        <td class="py-2 px-4 border">
                            {{ $item->reason }}
                        </td>

                        <td class="py-2 px-4 border">
                            <span class="px-2 py-1 rounded text-white text-xs
                                {{ $item->status == 'Approved' ? 'bg-green-500' :
                                   ($item->status == 'Rejected' ? 'bg-red-500' : 'bg-yellow-500') }}">
                                {{ $item->status }}
                            </span>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-400">
                            Belum ada riwayat cuti
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

</div>
@endsection