@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">

    <h2 class="text-lg font-semibold mb-4">
        Pakai APD – {{ $apd->nama_apd }}
    </h2>

    <form method="POST"
          action="{{ route('she.safety.apd.logs.store', $apd->id) }}">
        @csrf

        {{-- Tanggal --}}
        <div class="mb-3">
            <label class="block mb-1">Tanggal Pemakaian</label>
            <input type="date"
                   name="tanggal"
                   class="w-full border rounded p-2 @error('tanggal') border-red-500 @enderror"
                   value="{{ old('tanggal', date('Y-m-d')) }}"
                   required>
            @error('tanggal')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Jumlah --}}
        <div class="mb-3">
            <label class="block mb-1">Jumlah Dipakai (Stok Saat Ini: {{ $apd->stok_saat_ini }})</label>
            <input type="number"
                   name="jumlah"
                   min="1"
                   max="{{ $apd->stok_saat_ini }}"
                   class="w-full border rounded p-2 @error('jumlah') border-red-500 @enderror"
                   value="{{ old('jumlah') }}"
                   required>
            @error('jumlah')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
    <label class="block mb-1">Pemakai</label>
    <input type="text"
           name="dipakai_oleh"
           class="w-full border rounded p-2"
           placeholder="Penanggung Jawab">
</div>


        {{-- Keterangan --}}
        <div class="mb-4">
            <label class="block mb-1">Keterangan</label>
            <textarea name="keterangan"
                      rows="3"
                      class="w-full border rounded p-2 @error('keterangan') border-red-500 @enderror"
                      placeholder="Opsional">{{ old('keterangan') }}</textarea>
            @error('keterangan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- BUTTON --}}
        <div class="flex gap-2">
            <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Simpan
            </button>
            <a href="{{ route('she.safety.apd.logs.index', $apd->id) }}"
               class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
                Batal
            </a>
        </div>

    </form>
</div>
@endsection
