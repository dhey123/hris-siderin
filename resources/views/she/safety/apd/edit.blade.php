@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">Edit APD</h2>

    <form action="{{ route('she.safety.apd.update', $apd->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nama APD --}}
        <div class="mb-3">
            <label class="block mb-1">Nama APD</label>
            <input type="text" 
                   name="nama_apd" 
                   class="w-full border rounded p-2 @error('nama_apd') border-red-500 @enderror" 
                   value="{{ old('nama_apd', $apd->nama_apd) }}" 
                   required>
            @error('nama_apd')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Jenis APD --}}
        <div class="mb-3">
            <label class="block mb-1">Jenis APD</label>
            <input type="text" 
                   name="jenis_apd" 
                   class="w-full border rounded p-2 @error('jenis_apd') border-red-500 @enderror" 
                   value="{{ old('jenis_apd', $apd->jenis_apd) }}" 
                   required>
            @error('jenis_apd')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Department --}}
        <div class="mb-3">
            <label class="block mb-1">Department</label>
            <input type="text" 
                   name="department" 
                   class="w-full border rounded p-2 @error('department') border-red-500 @enderror"
                   value="{{ old('department', $apd->department ?? '') }}"
                   placeholder="Masukkan department"
                   required>
            @error('department')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Stok Awal --}}
        <div class="mb-3">
            <label class="block mb-1">Stok Awal</label>
            <input type="number" 
                   name="stok_awal" 
                   min="0" 
                   class="w-full border rounded p-2 @error('stok_awal') border-red-500 @enderror" 
                   value="{{ old('stok_awal', $apd->stok_awal) }}" 
                   required>
            @error('stok_awal')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-gray-500 text-sm mt-1">Stok saat ini: {{ $apd->stok_saat_ini }}</p>
        </div>

        {{-- Kondisi --}}
        <div class="mb-3">
            <label class="block mb-1">Kondisi</label>
            <select name="kondisi" class="w-full border rounded p-2 @error('kondisi') border-red-500 @enderror">
                <option value="Baik" {{ old('kondisi', $apd->kondisi) == 'Baik' ? 'selected' : '' }}>Baik</option>
                <option value="Rusak" {{ old('kondisi', $apd->kondisi) == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                <option value="Hilang" {{ old('kondisi', $apd->kondisi) == 'Hilang' ? 'selected' : '' }}>Hilang</option>
            </select>
            @error('kondisi')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tanggal Pengadaan --}}
        <div class="mb-3">
            <label class="block mb-1">Tanggal Pengadaan</label>
            <input type="date" 
                   name="tanggal_pengadaan" 
                   class="w-full border rounded p-2 @error('tanggal_pengadaan') border-red-500 @enderror" 
                   value="{{ old('tanggal_pengadaan', $apd->tanggal_pengadaan ? \Carbon\Carbon::parse($apd->tanggal_pengadaan)->format('Y-m-d') : date('Y-m-d')) }}"
                   required>
            @error('tanggal_pengadaan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Keterangan --}}
        <div class="mb-4">
            <label class="block mb-1">Keterangan</label>
            <textarea name="keterangan" 
                      class="w-full border rounded p-2 @error('keterangan') border-red-500 @enderror"
                      rows="3">{{ old('keterangan', $apd->keterangan) }}</textarea>
            @error('keterangan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol --}}
        <div class="flex gap-2">
            <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                Simpan Perubahan
            </button>
            <a href="{{ route('she.safety.apd.list') }}"
               class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400 transition">
                Batal
            </a>
        </div>

    </form>
</div>
@endsection
