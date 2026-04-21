@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-4">
        {{ isset($waste_log) ? 'Edit Log Keluar' : 'Log Keluar' }}: {{ $waste->nama_limbah }}
    </h1>

    <form 
        action="{{ route('she.environment.limbah.keluar.store', $waste->id) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        {{-- ============================= --}}
        {{-- TANGGAL KELUAR --}}
        {{-- ============================= --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Tanggal Keluar</label>
            <input 
                type="date" 
                name="tanggal_keluar" 
                class="w-full border p-2 rounded" 
                value="{{ old('tanggal_keluar', isset($waste_log) ? $waste_log->created_at->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d')) }}"
                required
            >
            @error('tanggal_keluar')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- ============================= --}}
        {{-- JUMLAH KELUAR --}}
        {{-- ============================= --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Jumlah Keluar</label>
            <input 
                type="number" 
                name="jumlah" 
                min="0.01" 
                step="0.01"
                max="{{ $sisa_limbah }}" 
                class="w-full border p-2 rounded" 
                value="{{ old('jumlah', isset($waste_log) ? $waste_log->jumlah : '') }}" 
                required
            >
            <small class="text-gray-500">
                Sisa limbah saat ini: {{ number_format($sisa_limbah,2) }}
            </small>
            @error('jumlah') 
                <p class="text-red-500 text-sm">{{ $message }}</p> 
            @enderror
            @if($sisa_limbah <= 0)
                <p class="text-red-500 text-sm italic mt-1">
                    Sisa limbah 0 — tidak bisa log keluar
                </p>
            @endif
        </div>

        {{-- ============================= --}}
        {{-- TUJUAN PENGELOLAAN --}}
        {{-- ============================= --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Tujuan Pengelolaan</label>
            <input 
                type="text" 
                name="tujuan_pengelolaan" 
                class="w-full border p-2 rounded" 
                placeholder="Contoh: PT ABCD"
                value="{{ old('tujuan_pengelolaan', isset($waste_log) ? $waste_log->tujuan_pengelolaan : '') }}"
                required
            >
            @error('tujuan_pengelolaan')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- ============================= --}}
        {{-- FOTO --}}
        {{-- ============================= --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Foto (opsional)</label>
            @if(isset($waste_log) && $waste_log->foto && file_exists(storage_path('app/public/'.$waste_log->foto)))
                <img src="{{ asset('storage/'.$waste_log->foto) }}" class="w-24 h-24 object-cover rounded mb-2">
            @endif
            <input type="file" name="foto" class="w-full">
            @error('foto') 
                <p class="text-red-500 text-sm">{{ $message }}</p> 
            @enderror
        </div>

        {{-- ============================= --}}
        {{-- KETERANGAN --}}
        {{-- ============================= --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Keterangan</label>
            <textarea 
                name="keterangan" 
                class="w-full border p-2 rounded"
            >{{ old('keterangan', isset($waste_log) ? $waste_log->keterangan : '') }}</textarea>
            @error('keterangan') 
                <p class="text-red-500 text-sm">{{ $message }}</p> 
            @enderror
        </div>

        {{-- ============================= --}}
        {{-- TOMBOL SUBMIT --}}
        {{-- ============================= --}}
        <button type="submit" class="px-4 py-2 {{ isset($waste_log) ? 'bg-indigo-600' : 'bg-blue-600' }} text-white rounded">
            {{ isset($waste_log) ? 'Simpan Perubahan' : 'Simpan Log Keluar' }}
        </button>
        <a href="{{ route('she.environment.limbah.index') }}" class="ml-2 text-gray-600">Batal</a>
    </form>
</div>
@endsection
