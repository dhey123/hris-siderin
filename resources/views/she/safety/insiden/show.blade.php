@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6" id="printable">

    {{-- HEADER --}}
    <div class="flex justify-between items-center border-b pb-3 mb-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Kecelakaan Kerja</h1>
            <p class="text-sm text-gray-500">Informasi lengkap insiden keselamatan kerja</p>
        </div>

       <a href="{{ route('she.safety.insiden.pdf', $incident->id) }}" 
   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
    📄 Download PDF
</a>


    </div>

    {{-- DETAIL CARD --}}
    <div class="bg-white rounded-xl border shadow-sm p-6 space-y-6">

        {{-- Info Grid --}}
        <div class="grid grid-cols-2 gap-4 text-gray-700">
            <p class="font-semibold">Nama Karyawan:</p>
            <p>{{ $incident->nama_karyawan ?? $incident->employee->full_name ?? '-' }}</p>

            <p class="font-semibold">Department / Bagian:</p>
            <p>{{ $incident->department ?? $incident->employee->department->department_name ?? '-' }}/{{ $incident->bagian ?? $incident->employee->position->position_name ?? '-' }}</p>

            <p class="font-semibold">Tanggal Insiden:</p>
            <p>{{ \Carbon\Carbon::parse($incident->incident_date)->format('d-m-Y') }}</p>

            <p class="font-semibold">Lokasi:</p>
            <p>{{ $incident->location ?? '-' }}</p>

            <p class="font-semibold">Jenis Insiden:</p>
            <p>{{ $incident->incident_type ?? '-' }}</p>

            <p class="font-semibold">Keparahan:</p>
            <p>
                <span class="px-3 py-1 rounded-full text-xs font-semibold
                    {{ $incident->severity === 'fatal'
                        ? 'bg-red-100 text-red-700'
                        : ($incident->severity === 'berat'
                            ? 'bg-orange-100 text-orange-700'
                            : ($incident->severity === 'sedang'
                                ? 'bg-yellow-100 text-yellow-700'
                                : 'bg-green-100 text-green-700')) }}">
                    {{ ucfirst($incident->severity) }}
                </span>
            </p>

            <p class="font-semibold">Deskripsi:</p>
            <p>{{ $incident->description ?? '-' }}</p>

            <p class="font-semibold">Tindakan Awal:</p>
            <p>{{ $incident->action_taken ?? '-' }}</p>

            @if($incident->attachment)
            <p class="font-semibold">Lampiran:</p>
            <p>
                <a href="{{ asset('storage/'.$incident->attachment) }}" target="_blank"
                   class="text-blue-600 underline print:text-black print:no-underline">
                   Lihat File
                </a>
            </p>
            @endif
        </div>

        {{-- STATUS & KETERANGAN --}}
        <div class="border-t pt-4">
            <h2 class="font-semibold text-gray-700 mb-2">Status & Keterangan</h2>
            <div class="flex flex-wrap items-center gap-2">
                <span class="px-3 py-1 rounded-full text-xs font-semibold
                    {{ $incident->status === 'terkirim'
                        ? 'bg-gray-100 text-gray-700'
                        : ($incident->status === 'ditangani'
                            ? 'bg-yellow-100 text-yellow-700'
                            : 'bg-green-100 text-green-700') }}">
                    {{ ucfirst($incident->status) }}
                </span>

                @if($incident->status_note)
                <span class="text-sm text-gray-500 italic">({{ $incident->status_note }})</span>
                @endif
            </div>
        </div>

        {{-- BACK & EDIT BUTTONS --}}
<div class="flex justify-end gap-2 print:hidden mt-4">
    {{-- Tombol Edit --}}
    <a href="{{ route('she.safety.insiden.edit', $incident->id) }}"
       class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
        ✏️ Edit
    </a>

    {{-- Tombol Kembali --}}
    <a href="{{ route('she.safety.insiden.index') }}"
       class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">
        Kembali ke Daftar Insiden
    </a>
</div>


    </div>
</div>

{{-- OPTIONAL: Print CSS --}}
<style>
@media print {
    /* Hide semua kecuali #printable */
    body * {
        visibility: hidden;
    }
    #printable, #printable * {
        visibility: visible;
    }
    #printable {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        font-size: 12pt; /* font print lebih rapi */
        line-height: 1.5;
    }

    /* Hilangkan tombol & elemen yang gak perlu */
    button, .print\:hidden {
        display: none !important;
    }

    a {
        color: black !important;
        text-decoration: none !important;
    }

    /* Optional: border dan shadow card lebih subtle di print */
    .shadow-sm {
        box-shadow: none !important;
    }
    .bg-white {
        background-color: white !important;
    }
}
</style>
@endsection
