@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">{{ isset($pelatihan) ? 'Edit' : 'Tambah' }} Pelatihan</h2>

    <form action="{{ isset($pelatihan) ? route('she.safety.pelatihan.update', $pelatihan->id) : route('she.safety.pelatihan.store') }}" method="POST">
        @csrf
        @if(isset($pelatihan))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label class="block mb-1">Nama Pelatihan</label>
            <input type="text" 
                   name="nama_pelatihan" 
                   class="w-full border rounded p-2 @error('nama_pelatihan') border-red-500 @enderror" 
                   value="{{ old('nama_pelatihan', $pelatihan->nama_pelatihan ?? '') }}" 
                   required>
            @error('nama_pelatihan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Penyelenggara</label>
            <input
                type="text"
                name="penyelenggara"
                placeholder="Internal / Vendor / Nama Lembaga"
                class="w-full border rounded p-2"
                value="{{ old('penyelenggara', $pelatihan->penyelenggara ?? '') }}">
            </div>

        <div class="mb-3">
            <label class="block mb-1">Tanggal</label>
            <input type="date" 
                   name="tanggal" 
                   class="w-full border rounded p-2 @error('tanggal') border-red-500 @enderror" 
                   value="{{ old('tanggal', isset($pelatihan) ? $pelatihan->tanggal->format('Y-m-d') : date('Y-m-d')) }}" 
                   required>
            @error('tanggal')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label class="block mb-1">Durasi</label>
            <input type="text" 
                   name="durasi" 
                   class="w-full border rounded p-2 @error('durasi') border-red-500 @enderror" 
                   value="{{ old('durasi', $pelatihan->durasi ?? '') }}" 
                   required>
            @error('durasi')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label class="block mb-1">Department</label>
            <input type="text" 
                   name="department" 
                   class="w-full border rounded p-2 @error('department') border-red-500 @enderror" 
                   value="{{ old('department', $pelatihan->department ?? '') }}">
            @error('department')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label class="block mb-1">Status</label>
            <select name="status" class="w-full border rounded p-2 @error('status') border-red-500 @enderror">
                @php
                    $statuses = ['Jadwal dibuat','Selesai','Dibatalkan'];
                @endphp
                @foreach($statuses as $status)
                    <option value="{{ $status }}" {{ old('status', $pelatihan->status ?? '') == $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>
            @error('status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1">Keterangan</label>
            <textarea name="keterangan" class="w-full border rounded p-2 @error('keterangan') border-red-500 @enderror">{{ old('keterangan', $pelatihan->keterangan ?? '') }}</textarea>
            @error('keterangan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-2">
            <button class="bg-green-600 text-white px-4 py-2 rounded">
                {{ isset($pelatihan) ? 'Simpan Perubahan' : 'Simpan' }}
            </button>
            <a href="{{ route('she.safety.pelatihan.index') }}" class="bg-gray-300 px-4 py-2 rounded">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
