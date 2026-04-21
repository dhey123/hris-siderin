@extends('layouts.app')

@section('content')
<div class="space-y-6">

   

    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">MCU</h1>
            <p class="text-sm text-gray-500">Medical Check Up Karyawan</p>
        </div>

        <a href="{{ route('she.health.mcu.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            + Tambah MCU
        </a>
    </div>
    
    {{-- KEMBALI --}}
    <div>
        <a href="{{ route('she.health.index') }}"
           class="inline-flex items-center gap-1 px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">
            ← Kembali
        </a>
    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto bg-white rounded-xl shadow border">
        <table class="table-auto min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left">NIK</th>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Department</th>
                    <th class="px-4 py-2 text-left">Divisi</th>
                    <th class="px-4 py-2 text-left">Posisi</th>
                    <th class="px-4 py-2 text-left">Jenis</th>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">Hasil</th>
                    <th class="px-4 py-2 text-left">Klinik</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($mcus as $mcu)
                <tr class="hover:bg-gray-50">

    <td class="px-4 py-2">
        <a href="{{ route('she.health.mcu.show', $mcu->id) }}"
           class="text-blue-600 hover:underline font-medium">
        {{ $mcu->employee->nik ?? '-' }}
        </a>
    </td>

    <td class="px-4 py-2">
        
            {{ $mcu->employee->full_name ?? '-' }}
        
    </td>

    <td class="px-4 py-2">
        {{ $mcu->employee->company->company_name ?? '-' }}
    </td>

    <td class="px-4 py-2">
        {{ $mcu->employee->department->department_name ?? '-' }}
    </td>

    <td class="px-4 py-2">
        {{ $mcu->employee->position->position_name ?? '-' }}
    </td>
     <td class="px-4 py-2">
                        {{ ucfirst($mcu->jenis_mcu) }}
                    </td>

                    <td class="px-4 py-2">
                        {{ \Carbon\Carbon::parse($mcu->tanggal_mcu)->format('d/m/Y') }}
                    </td>

                    <td class="px-4 py-2">
                        @php
                            $classes = match($mcu->hasil) {
                                'Sehat' => 'bg-green-100 text-green-700',
                                'Tidak Sehat' => 'bg-red-100 text-red-700',
                                'Perlu Pemeriksaan Lanjutan' => 'bg-yellow-100 text-yellow-700',
                                default => 'bg-gray-100 text-gray-700',
                            };
                        @endphp

                        <span class="px-2 py-1 rounded text-xs {{ $classes }}">
                            {{ $mcu->hasil ?? '-' }}
                        </span>
                    </td>

                    <td class="px-4 py-2">
                        {{ $mcu->klinik ?? '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-6 text-gray-400">
                        Belum ada data MCU
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
