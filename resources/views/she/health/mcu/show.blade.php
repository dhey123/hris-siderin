@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold">Detail MCU</h1>
        <p class="text-sm text-gray-500">Data lengkap MCU karyawan</p>
    </div>

    {{-- KEMBALI --}}
    <div>
        <a href="{{ route('she.health.mcu.index') }}"
           class="inline-flex items-center gap-1 px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">
            ← Kembali
        </a>
    </div>

    {{-- DETAIL --}}
    <div class="space-y-4 divide-y divide-gray-200">

        {{-- Karyawan --}}
        <div class="flex justify-between py-2">
            <span class="font-medium text-gray-700">Karyawan</span>
            <span>{{ $mcu->employee?->full_name ?? 'Karyawan tidak ditemukan' }}</span>
        </div>

        {{-- Jenis MCU --}}
        <div class="flex justify-between py-2">
            <span class="font-medium text-gray-700">Jenis MCU</span>
            <span>{{ $mcu->jenis_mcu }}</span>
        </div>

        {{-- Tanggal --}}
        <div class="flex justify-between py-2">
            <span class="font-medium text-gray-700">Tanggal MCU</span>
            <span>{{ \Carbon\Carbon::parse($mcu->tanggal_mcu)->format('d/m/Y') }}</span>
        </div>

        {{-- Hasil --}}
        <div class="flex justify-between py-2 items-center">
            <span class="font-medium text-gray-700">Hasil</span>
            @php
                $classes = match($mcu->hasil) {
                    'Sehat' => 'bg-green-100 text-green-700',
                    'Tidak Sehat' => 'bg-red-100 text-red-700',
                    'Perlu Pemeriksaan Lanjutan' => 'bg-yellow-100 text-yellow-700',
                    default => 'bg-gray-100 text-gray-700'
                };
            @endphp
            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $classes }}">
                {{ $mcu->hasil }}
            </span>
        </div>

        {{-- Klinik --}}
        <div class="flex justify-between py-2">
            <span class="font-medium text-gray-700">Klinik</span>
            <span>{{ $mcu->klinik ?? '-' }}</span>
        </div>

        {{-- Catatan --}}
        <div class="flex justify-between py-2">
            <span class="font-medium text-gray-700">Catatan</span>
            <span>{{ $mcu->catatan ?? '-' }}</span>
        </div>

        {{-- File Hasil --}}
        @if($mcu->file_hasil)
        <div class="flex justify-between py-2">
            <span class="font-medium text-gray-700">File Hasil</span>
            <a href="{{ asset('storage/'.$mcu->file_hasil) }}"
               target="_blank"
               class="text-blue-600 hover:underline">
                Lihat / Download
            </a>
        </div>
        @endif

    </div>

</div>
@endsection
