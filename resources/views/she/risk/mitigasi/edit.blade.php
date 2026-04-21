@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">

    <h1 class="text-2xl font-bold">
        Edit Mitigasi - {{ $mitigasi->risk->nama_risiko }}
    </h1>

    <form action="{{ route('she.risk.mitigasi.update.global', $mitigasi->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- STATUS --}}
        <div>
            <label class="block font-medium mb-1">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="Planned" {{ $mitigasi->status == 'Planned' ? 'selected' : '' }}>Planned</option>
                <option value="Ongoing" {{ $mitigasi->status == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                <option value="Done" {{ $mitigasi->status == 'Done' ? 'selected' : '' }}>Done</option>
            </select>
        </div>

        {{-- EFEKTIVITAS --}}
        <div>
            <label class="block font-medium mb-1">Efektivitas</label>
            <select name="efektivitas"
                class="w-full border rounded px-3 py-2"
                {{ $mitigasi->status != 'Done' ? 'disabled' : '' }}>
                <option value="">-- Pilih --</option>
                <option value="Efektif" {{ $mitigasi->efektivitas == 'Efektif' ? 'selected' : '' }}>Efektif</option>
                <option value="Kurang Efektif" {{ $mitigasi->efektivitas == 'Kurang Efektif' ? 'selected' : '' }}>Kurang Efektif</option>
                <option value="Tidak Efektif" {{ $mitigasi->efektivitas == 'Tidak Efektif' ? 'selected' : '' }}>Tidak Efektif</option>
            </select>
        </div>

<div class="mb-4">
    <label class="block font-medium mb-1">Lampiran</label>

    {{-- Kalau sudah ada lampiran --}}
    @if($mitigasi->lampiran)
        <div class="mb-2">
            <span class="text-gray-700">Lampiran Saat Ini:</span>
            <a href="{{ asset('storage/' . $mitigasi->lampiran) }}" 
               target="_blank" class="text-blue-600 hover:underline">
               Lihat
            </a>
        </div>
    @endif

    {{-- Input file baru --}}
    <input type="file" name="lampiran" class="border rounded px-2 py-1 w-full">
   
</div>

        <div class="pt-4">
            <button class="bg-green-600 text-white px-4 py-2 rounded">
                Update Mitigasi
            </button>
        </div>

    </form>
</div>
@endsection