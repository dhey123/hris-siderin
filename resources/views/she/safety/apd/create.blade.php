@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">Tambah APD</h2>

    <form action="{{ route('she.safety.apd.store') }}" method="POST">
        @csrf

        {{-- Nama APD --}}
        <div class="mb-3">
            <label class="block mb-1">Nama APD</label>
            <input type="text" 
                   name="nama_apd" 
                   class="w-full border rounded p-2 @error('nama_apd') border-red-500 @enderror" 
                   value="{{ old('nama_apd') }}" 
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
                   value="{{ old('jenis_apd') }}" 
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
                   value="{{ old('department') }}" 
                   required>
            @error('department')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Stok Awal --}}
        <div class="mb-3">
            <label class="block mb-1">Stok</label>
            <input type="number" 
                   name="stok_awal" 
                   min="0" 
                   class="w-full border rounded p-2 @error('stok_awal') border-red-500 @enderror" 
                   value="{{ old('stok_awal', 0) }}" 
                   required>
            @error('stok_awal')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Kondisi --}}
        <div class="mb-3">
            <label class="block mb-1">Kondisi</label>
            <select name="kondisi" class="w-full border rounded p-2 @error('kondisi') border-red-500 @enderror">
                <option value="Baik" {{ old('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                <option value="Rusak" {{ old('kondisi') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                <option value="Hilang" {{ old('kondisi') == 'Hilang' ? 'selected' : '' }}>Hilang</option>
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
                   value="{{ old('tanggal_pengadaan', date('Y-m-d')) }}" 
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
                      rows="3">{{ old('keterangan') }}</textarea>
            @error('keterangan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        

        {{-- Tombol --}}
        <div class="flex gap-2">
            <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                Simpan
            </button>
            <a href="{{ route('she.safety.apd.list') }}"
               class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400 transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
