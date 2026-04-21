@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">

    <h1 class="text-2xl font-bold">Detail Surat Dokter</h1>

    <div class="space-y-3 divide-y divide-gray-200">

        <div class="flex justify-between py-2">
            <span class="font-medium">Karyawan:</span>
            <span>{{ $suratDokter->employee?->full_name ?? '-' }}</span>
        </div>

        <div class="flex justify-between py-2">
            <span class="font-medium">Departemen:</span>
            <span>{{ $suratDokter->employee?->department?->department_name ?? '-' }}</span>
        </div>

        <div class="flex justify-between py-2">
            <span class="font-medium">Posisi:</span>
            <span>{{ $suratDokter->employee?->position?->position_name ?? '-' }}</span>
        </div>

        <div class="flex justify-between py-2">
            <span class="font-medium">Tanggal Surat:</span>
            <span>{{ $suratDokter->tanggal_surat?->format('d/m/Y') ?? '-' }}</span>
        </div>

        <div class="flex justify-between py-2">
            <span class="font-medium">Diagnosa:</span>
            <span>{{ $suratDokter->diagnosa ?? '-' }}</span>
        </div>

        <div class="flex justify-between py-2">
            <span class="font-medium">Hari Istirahat:</span>
            <span>{{ $suratDokter->hari_istirahat }}</span>
        </div>

        <div class="flex justify-between py-2">
            <span class="font-medium">Tanggal Mulai:</span>
            <span>{{ $suratDokter->tanggal_mulai?->format('d/m/Y') ?? '-' }}</span>
        </div>

        <div class="flex justify-between py-2">
            <span class="font-medium">Tanggal Selesai:</span>
            <span>{{ $suratDokter->tanggal_selesai?->format('d/m/Y') ?? '-' }}</span>
        </div>

        <div class="flex justify-between py-2">
            <span class="font-medium">Nama Dokter:</span>
            <span>{{ $suratDokter->nama_dokter ?? '-' }}</span>
        </div>

        <div class="flex justify-between py-2">
            <span class="font-medium">Klinik:</span>
            <span>{{ $suratDokter->klinik ?? '-' }}</span>
        </div>

        @if($suratDokter->file_surat)
        <div class="flex justify-between py-2">
            <span class="font-medium">File Surat:</span>
            <a href="{{ asset('storage/' . $suratDokter->file_surat) }}" target="_blank" class="text-blue-600 hover:underline">
                Lihat / Download
            </a>
        </div>
        @endif
    </div>

    <div class="mt-4 flex gap-2">
        <a href="{{ route('she.health.surat-dokter.index') }}" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">Kembali</a>
        <a href="{{ route('she.health.surat-dokter.edit', $suratDokter) }}" class="px-4 py-2 rounded bg-yellow-600 text-white hover:bg-yellow-700">Edit</a>
    </div>

</div>
@endsection
