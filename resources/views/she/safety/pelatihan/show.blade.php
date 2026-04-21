@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Pelatihan</h1>
            <p class="text-sm text-gray-500">
                Informasi lengkap jadwal pelatihan
            </p>
        </div>
        <div>
            <a href="{{ route('she.safety.pelatihan.print.detail', $pelatihan->id) }}"
   class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-black">
   🖨 Print Detail
</a>
</div>

        @php
            $statusColor = match(strtolower($pelatihan->status)) {
                'reschedule' => 'bg-yellow-100 text-yellow-700',
                'selesai'    => 'bg-gray-200 text-gray-700',
                'dibatalkan' => 'bg-red-100 text-red-700',
                default      => 'bg-green-100 text-green-700',
            };

            $lastReschedule = $pelatihan->reschedules->last();
            $tanggalAktif = $lastReschedule
                ? \Carbon\Carbon::parse($lastReschedule->tanggal_baru)
                : \Carbon\Carbon::parse($pelatihan->tanggal);
        @endphp

        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }}">
            {{ strtoupper($pelatihan->status) }}
        </span>
    </div>

    {{-- DETAIL CARD --}}
    <div class="bg-white rounded-xl shadow border p-6 space-y-6">

        {{-- INFO --}}
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 text-sm">

            <div>
                <p class="text-gray-500">Nama Pelatihan</p>
                <p class="font-semibold text-gray-800">
                    {{ $pelatihan->nama_pelatihan }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Penyelenggara</p>
                <p class="font-medium">{{ $pelatihan->penyelenggara ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500">Department</p>
                <p class="font-medium">{{ $pelatihan->department ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500">Tanggal Aktif</p>
                <p class="font-medium text-blue-700">
                    {{ $tanggalAktif->format('d M Y') }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Durasi</p>
                <p class="font-medium">{{ $pelatihan->durasi ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500">Total Reschedule</p>
                <p class="font-medium">{{ $pelatihan->reschedules->count() }} kali</p>
            </div>

        </div>

        {{-- KETERANGAN --}}
        <div>
            <p class="text-gray-500 text-sm">Keterangan</p>
            <p class="mt-1 text-sm text-gray-700 leading-relaxed">
                {{ $pelatihan->keterangan ?? '-' }}
            </p>
        </div>

        {{-- RIWAYAT RESCHEDULE --}}
        @if($pelatihan->reschedules->count())
        <div class="border-t pt-4">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">
                Riwayat Reschedule
            </h3>

            <div class="space-y-3 text-sm">
                @foreach($pelatihan->reschedules as $i => $item)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <p class="font-semibold mb-1">Reschedule ke-{{ $i + 1 }}</p>
                    <p><strong>Tanggal Lama:</strong> {{ \Carbon\Carbon::parse($item->tanggal_lama)->format('d M Y') }}</p>
                    <p><strong>Tanggal Baru:</strong> {{ \Carbon\Carbon::parse($item->tanggal_baru)->format('d M Y') }}</p>
                    <p class="mt-1"><strong>Alasan:</strong> {{ $item->alasan }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- EVALUASI --}}
        @if(strtolower($pelatihan->status) === 'selesai')
        <div class="border-t pt-4">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">
                Evaluasi Pelatihan
            </h3>

            @if($pelatihan->evaluasi)
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-sm space-y-2">
                    <p><strong>Nilai:</strong> {{ $pelatihan->evaluasi->nilai }}/100</p>
                    <p><strong>Catatan:</strong></p>
                    <p class="text-gray-700">{{ $pelatihan->evaluasi->catatan }}</p>
                </div>
            @else
                <div class="flex justify-between items-center bg-gray-50 border rounded-lg p-4">
                    <p class="text-sm text-gray-600">
                        Evaluasi belum diisi
                    </p>
                    <a href="{{ route('she.safety.pelatihan.evaluasi.create', $pelatihan->id) }}"
                       class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                        + Isi Evaluasi
                    </a>
                </div>
            @endif
        </div>
        @endif

    </div>

    {{-- ACTION --}}
    <div class="flex justify-between items-center">
        <a href="{{ route('she.safety.pelatihan.index') }}"
           class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
            ← Kembali
        </a>

        <div class="flex gap-3">
            <a href="{{ route('she.safety.pelatihan.edit', $pelatihan->id) }}"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                ✏️ Edit
            </a>

            @if(strtolower($pelatihan->status) !== 'selesai')
            <button
                onclick="openRescheduleModal({{ $pelatihan->id }})"
                class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                🔁 Reschedule
            </button>
            @endif
        </div>
    </div>

</div>
@endsection
