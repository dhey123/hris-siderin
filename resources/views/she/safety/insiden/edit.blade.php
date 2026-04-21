@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Edit Status Insiden</h1>

    </div>

    {{-- CARD DETAIL --}}
    <div class="bg-white rounded-xl border shadow-sm p-6 space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <p class="font-semibold text-gray-700">Nama Karyawan:</p>
            <p>{{ $incident->nama_karyawan ?? $incident->employee->full_name ?? '-' }}</p>

            <p class="font-semibold text-gray-700">Department / Bagian:</p>
            <p>{{ $incident->department ?? $incident->employee->department->department_name ?? '-' }}/{{ $incident->bagian ?? $incident->employee->position->position_name ?? '-' }}</p>

            <p class="font-semibold text-gray-700">Tanggal Insiden:</p>
            <p>{{ \Carbon\Carbon::parse($incident->incident_date)->format('d-m-Y') }}</p>

            <p class="font-semibold text-gray-700">Lokasi:</p>
            <p>{{ $incident->location ?? '-' }}</p>

            <p class="font-semibold text-gray-700">Jenis Insiden:</p>
            <p>{{ $incident->incident_type ?? '-' }}</p>

            <p class="font-semibold text-gray-700">Keparahan:</p>
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

            <p class="font-semibold text-gray-700">Deskripsi:</p>
            <p>{{ $incident->description ?? '-' }}</p>

            <p class="font-semibold text-gray-700">Tindakan Awal:</p>
            <p>{{ $incident->action_taken ?? '-' }}</p>

            @if($incident->attachment)
            <p class="font-semibold text-gray-700">Lampiran:</p>
            <p>
                <a href="{{ asset('storage/'.$incident->attachment) }}" target="_blank"
                   class="text-blue-600 underline print:text-black print:no-underline">
                   Lihat File
                </a>
            </p>
            @endif
        </div>

        {{-- FORM UPDATE STATUS & KETERANGAN --}}
        <div class="border-t pt-4 print:hidden">
            <h2 class="font-semibold text-gray-800 mb-2">Update Status & Keterangan</h2>
            <form action="{{ route('she.safety.insiden.update', $incident->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="border rounded-lg p-2 w-full text-sm">
                        <option value="terkirim" {{ $incident->status === 'terkirim' ? 'selected' : '' }}>Terkirim</option>
                        <option value="ditangani" {{ $incident->status === 'ditangani' ? 'selected' : '' }}>Ditangani</option>
                        <option value="selesai" {{ $incident->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan / Catatan</label>
                    <input type="text"
                           name="status_note"
                           value="{{ $incident->status_note ?? '' }}"
                           placeholder="Misal: Klinik A / RS B"
                           class="border rounded-lg p-2 w-full text-sm">
                </div>

                 <div class="flex justify-between mt-4">
                <a href="{{ route('she.safety.insiden.index') }}"
                   class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300 transition text-gray-800">
                   ⬅ Kembali ke Daftar Insiden
                </a>

                <button type="submit"
                        class="bg-blue-600 px-4 py-2 rounded-lg hover:bg-blue-700 transition text-white">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>

    </div>

    </div>

</div>
@endsection
