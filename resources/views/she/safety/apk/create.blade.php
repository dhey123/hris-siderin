@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Tambah APK</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('she.safety.apk.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-medium">Nama Alat</label>
            <input type="text" name="nama_alat" value="{{ old('nama_alat') }}" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Lokasi</label>
            <input type="text" name="lokasi" value="{{ old('lokasi') }}" class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Jumlah</label>
            <input type="number" name="jumlah" value="{{ old('jumlah',1) }}" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Kondisi</label>
            <select name="kondisi" class="w-full border px-3 py-2 rounded" required>
                <option value="Baik" @selected(old('kondisi')=='Baik')>Baik</option>
                <option value="Rusak" @selected(old('kondisi')=='Rusak')>Rusak</option>
                <option value="Perlu Maintenance" @selected(old('kondisi')=='Perlu Maintenance')>Perlu Maintenance</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Owner / PIC</label>
            <input type="text" name="owner" value="{{ old('owner') }}" class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Tanggal Update</label>
            <input type="date" name="tanggal_update" value="{{ old('tanggal_update', date('Y-m-d')) }}" class="w-full border px-3 py-2 rounded">
        </div>
        <div>
    <label class="block text-sm font-medium mb-1">
        Tanggal Kadaluarsa (Opsional)
    </label>

    <input type="date"
           name="expired_date"
           value="{{ old('expired_date', $apk->expired_date ?? '') }}"
           class="w-full border rounded-lg px-3 py-2">
</div>


        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        <a href="{{ route('she.safety.apk.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Batal</a>
    </form>
</div>
@endsection
