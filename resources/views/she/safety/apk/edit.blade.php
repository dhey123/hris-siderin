@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow">

    {{-- HEADER --}}
    <h1 class="text-2xl font-bold mb-6">
        Edit APK (Alat Pelindung Keselamatan)
    </h1>

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM --}}
    <form action="{{ route('she.safety.apk.update', $apk->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- NAMA ALAT --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Nama Alat</label>
            <input type="text"
                   name="nama_alat"
                   value="{{ old('nama_alat', $apk->nama_alat) }}"
                   class="w-full border px-3 py-2 rounded"
                   required>
        </div>

        {{-- LOKASI --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Lokasi</label>
            <input type="text"
                   name="lokasi"
                   value="{{ old('lokasi', $apk->lokasi) }}"
                   class="w-full border px-3 py-2 rounded">
        </div>

        {{-- JUMLAH --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Jumlah</label>
            <input type="number"
                   name="jumlah"
                   min="1"
                   value="{{ old('jumlah', $apk->jumlah) }}"
                   class="w-full border px-3 py-2 rounded"
                   required>
        </div>

        {{-- KONDISI --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Kondisi</label>
            <select name="kondisi"
                    class="w-full border px-3 py-2 rounded"
                    required>
                <option value="Baik" @selected(old('kondisi', $apk->kondisi) == 'Baik')>Baik</option>
                <option value="Rusak" @selected(old('kondisi', $apk->kondisi) == 'Rusak')>Rusak</option>
                <option value="Perlu Maintenance" @selected(old('kondisi', $apk->kondisi) == 'Perlu Maintenance')>
                    Perlu Maintenance
                </option>
            </select>
        </div>

        {{-- OWNER --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Owner / PIC</label>
            <input type="text"
                   name="owner"
                   value="{{ old('owner', $apk->owner) }}"
                   class="w-full border px-3 py-2 rounded">
        </div>

        {{-- TANGGAL UPDATE --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Tanggal Update</label>
            <input type="date"
                   name="tanggal_update"
                   value="{{ old('tanggal_update', optional($apk->tanggal_update)->format('Y-m-d')) }}"
                   class="w-full border px-3 py-2 rounded">
        </div>

        {{-- KADALUARSA --}}
        <div class="mb-6">
            <label class="block mb-1 font-medium">Tanggal Kadaluarsa (Opsional)</label>
            <input type="date"
                   name="expired_date"
                   value="{{ old('expired_date', optional($apk->expired_date)->format('Y-m-d')) }}"
                   class="w-full border px-3 py-2 rounded">
        </div>

        {{-- BUTTON --}}
        <div class="flex gap-2">
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Simpan
            </button>

            <a href="{{ route('she.safety.apk.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Batal
            </a>
        </div>

    </form>

</div>
@endsection
