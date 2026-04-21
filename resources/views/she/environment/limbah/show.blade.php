@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow space-y-4">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Detail Limbah</h1>

        <a href="{{ route('she.environment.limbah.index') }}"
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
           Kembali
        </a>
    </div>

    <hr>

    {{-- DATA --}}
    <div class="space-y-3">

        <div><strong>No Dokumen:</strong> {{ $waste->no_dokumen }}</div>

        <div><strong>Tanggal:</strong>
            {{ \Carbon\Carbon::parse($waste->tanggal)->format('d/m/Y') }}
        </div>

        <div><strong>Jenis Limbah:</strong> {{ $waste->jenis_limbah }}</div>

        <div><strong>Nama Limbah:</strong> {{ $waste->nama_limbah }}</div>

        <div><strong>Kategori:</strong> {{ $waste->kategori }}</div>

        <div><strong>Jumlah:</strong> {{ $waste->jumlah }} {{ $waste->satuan }}</div>

        <div><strong>Sumber Limbah:</strong> {{ $waste->sumber_limbah }}</div>

        <div><strong>Tujuan Pengelolaan:</strong> {{ $waste->tujuan_pengelolaan }}</div>

        <div><strong>Lokasi Penyimpanan:</strong> {{ $waste->lokasi_penyimpanan }}</div>

        <div><strong>Status:</strong> {{ $waste->status_pengelolaan }}</div>

        <div><strong>Keterangan:</strong> {{ $waste->keterangan ?? '-' }}</div>

    </div>

</div>
@endsection
