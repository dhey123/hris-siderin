@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">
            Detail APK
        </h1>

        <a href="{{ route('she.safety.apk.index') }}"
           class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
            ← Kembali
        </a>
    </div>

    {{-- DETAIL CARD --}}
    <div class="bg-white rounded-xl shadow border p-6 space-y-4">
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Nama Alat</p>
                <p class="font-semibold">{{ $apk->nama_alat }}</p>
            </div>

            <div>
                <p class="text-gray-500">Lokasi</p>
                <p class="font-semibold">{{ $apk->lokasi ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500">Jumlah</p>
                <p class="font-semibold">{{ $apk->jumlah }}</p>
            </div>

            <div>
                <p class="text-gray-500">Penanggung Jawab</p>
                <p class="font-semibold">{{ $apk->owner ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500">Kondisi</p>
                <span class="px-3 py-1 rounded-full text-xs
                    {{ $apk->kondisi === 'Baik' ? 'bg-green-100 text-green-700' :
                       ($apk->kondisi === 'Rusak' ? 'bg-red-100 text-red-700' :
                       'bg-yellow-100 text-yellow-700') }}">
                    {{ $apk->kondisi }}
                </span>
            </div>
            <div>
    <p class="text-gray-500">Tanggal Kadaluarsa</p>
    <p class="font-semibold">
        {{ $apk->expired_date 
            ? \Carbon\Carbon::parse($apk->expired_date)->format('d M Y') 
            : '-' }}
    </p>
</div>

            <div>
                <p class="text-gray-500">Update Terakhir</p>
                <p class="font-semibold">
                    {{ \Carbon\Carbon::parse($apk->tanggal_update)->format('d M Y') }}
                </p>
            </div>
        </div>
    </div>

    {{-- ACTION --}}
    <div class="flex gap-3">
        <a href="{{ route('she.safety.apk.edit', $apk->id) }}"
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            ✏️ Edit APK
        </a>
    </div>

</div>
@endsection
