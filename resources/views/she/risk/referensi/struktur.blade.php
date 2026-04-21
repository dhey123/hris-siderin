@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">

    {{-- Judul --}}
    <div class="text-center py-4 bg-white shadow">
        <h1 class="text-2xl font-bold">Struktur Organisasi Management SHE & Risiko</h1>
        <p class="text-sm text-gray-500 mt-1">PT Quantum Tosan International</p>
    </div>

    {{-- Background lebar penuh --}}
    <div class="w-full bg-green-50 py-8">
        <div class="flex justify-center">
            <img src="{{ asset('images/struktur_she_risiko.png') }}" alt="Struktur SHE" width="600">
        </div>
    </div>

    {{-- Catatan / Keterangan --}}
    <div class="mt-4 p-4 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 max-w-4xl mx-auto rounded">
        <p>Catatan: Struktur ini sudah menggabungkan Tim Tanggap Darurat dan Panitia K3 dalam manajemen SHE.</p>
    </div>

</div>
@endsection