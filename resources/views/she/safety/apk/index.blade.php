@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">
            APK (Alat Pelindung Keselamatan)
        </h1>

        <div class="flex justify-end gap-2">
            <a href="{{ route('she.safety.apk.pdf') }}"
               target="_blank"
               class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                🖨 Cetak Laporan
            </a>

            <a href="{{ route('she.safety.apk.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                + Tambah APK
            </a>
        </div>
    </div>

    {{-- KEMBALI --}}
    <div>
        <a href="{{ route('she.safety.index') }}"
           class="inline-flex items-center gap-1 px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">
            ← Kembali
        </a>
    </div>

    {{-- SUMMARY CARD --}}
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

        <div class="bg-white border rounded-xl p-4 text-center">
            <p class="text-gray-500 text-sm">Total APK</p>
            <p class="text-2xl font-bold">{{ $total }}</p>
        </div>

        <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">
            <p class="text-green-700 text-sm">Kondisi Baik</p>
            <p class="text-2xl font-bold text-green-700">{{ $baik }}</p>
        </div>

        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-center">
            <p class="text-yellow-700 text-sm">Perlu Maintenance</p>
            <p class="text-2xl font-bold text-yellow-700">{{ $maintenance }}</p>
        </div>

        <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center">
            <p class="text-red-700 text-sm">Rusak</p>
            <p class="text-2xl font-bold text-red-700">{{ $rusak }}</p>
        </div>

        <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center">
            <p class="text-red-700 text-sm">Expired</p>
            <p class="text-2xl font-bold text-red-700">{{ $expired }}</p>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow border overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3 text-left">Nama Alat</th>
                    <th class="px-4 py-3">Lokasi</th>
                    <th class="px-4 py-3 text-center">Jumlah</th>
                    <th class="px-4 py-3 text-center">Kondisi</th>
                    <th class="px-4 py-3">Penanggung Jawab</th>
                    <th class="px-4 py-3 text-center">Tanggal Update</th>
                    <th class="px-4 py-3 text-center">Kadaluarsa</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($apks as $apk)
                <tr class="border-b hover:bg-gray-50">

                    {{-- NAMA --}}
                    <td class="px-4 py-2 font-medium">
                        <a href="{{ route('she.safety.apk.show', $apk->id) }}"
                           class="text-blue-600 hover:underline">
                            {{ $apk->nama_alat }}
                        </a>
                    </td>

                    {{-- LOKASI --}}
                    <td class="px-4 py-2">
                        {{ $apk->lokasi ?? '-' }}
                    </td>

                    {{-- JUMLAH --}}
                    <td class="px-4 py-2 text-center">
                        {{ $apk->jumlah }}
                    </td>

                    {{-- KONDISI --}}
                    <td class="px-4 py-2 text-center">
                        @php
                            $badge = match($apk->kondisi) {
                                'Baik' => 'bg-green-100 text-green-700',
                                'Rusak' => 'bg-red-100 text-red-700',
                                default => 'bg-yellow-100 text-yellow-700',
                            };
                        @endphp

                        <span class="px-2 py-1 rounded-full text-xs {{ $badge }}">
                            {{ $apk->kondisi }}
                        </span>
                    </td>

                    {{-- OWNER --}}
                    <td class="px-4 py-2">
                        {{ $apk->owner ?? '-' }}
                    </td>

                    {{-- UPDATE --}}
                    <td class="px-4 py-2 text-center">
                        {{ \Carbon\Carbon::parse($apk->tanggal_update)->format('d M Y') }}
                    </td>

                    {{-- EXPIRED --}}
                    <td class="px-4 py-2 text-center">
                        @if($apk->expired_date)

                            {{ \Carbon\Carbon::parse($apk->expired_date)->format('d M Y') }}

                            <div class="text-xs mt-1">

                                @if($apk->status_expired == 'expired')

                                    <span class="text-red-600 font-semibold">
                                        Expired
                                    </span>

                                @elseif($apk->status_expired == 'warning')

                                    <span class="text-yellow-600 font-semibold">
                                        Hampir Expired ({{ ceil($apk->sisa_hari ?? 0) }} hari lagi)
                                    </span>

                                @else

                                    <span class="text-green-600">
                                        Aktif
                                    </span>

                                @endif

                            </div>

                        @else
                            -
                        @endif
                    </td>

                    {{-- AKSI --}}
                    <td class="px-4 py-2 text-center">
                        <div class="flex justify-center gap-3">
                            <a href="{{ route('she.safety.apk.edit', $apk->id) }}">✏️</a>

                            <form action="{{ route('she.safety.apk.destroy', $apk->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin hapus?')">🗑️</button>
                            </form>
                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-6 text-gray-400">
                        Belum ada data APK
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>

{{-- ============================= --}}
{{-- 🔔 POPUP ALERT + SOUND --}}
{{-- ============================= --}}

@if($expired > 0)

<script>
document.addEventListener("DOMContentLoaded", function(){

    alert("⚠️ PERINGATAN!\n\nTerdapat {{ $expired }} APK yang sudah expired.\nSilakan segera lakukan pengecekan.");

    function playAlarm(){

        const ctx = new (window.AudioContext || window.webkitAudioContext)();

        const oscillator = ctx.createOscillator();
        oscillator.type = "sine";
        oscillator.frequency.setValueAtTime(880, ctx.currentTime);

        oscillator.connect(ctx.destination);
        oscillator.start();

        setTimeout(()=>{
            oscillator.stop();
        },500);

    }

    playAlarm();

});
</script>

@endif

@endsection