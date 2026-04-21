@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow">

    {{-- HEADER --}}
    <div class="mb-6 border-b pb-3">
        <h1 class="text-2xl font-bold">Tambah Data Limbah</h1>
        <p class="text-sm text-gray-500">Form pencatatan limbah perusahaan</p>
    </div>

    {{-- VALIDATION ERROR --}}
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('she.environment.limbah.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        {{-- NO DOKUMEN --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">No Dokumen</label>
            <input type="text" name="no_dokumen"
                value="{{ old('no_dokumen') }}"
                class="w-full border rounded-lg p-2 focus:ring focus:ring-green-200"
                required>
        </div>

        {{-- TANGGAL --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Tanggal Masuk</label>
            <input type="date" name="tanggal"
                value="{{ old('tanggal') }}"
                class="w-full border rounded-lg p-2 focus:ring focus:ring-green-200"
                required>
        </div>

        {{-- JENIS LIMBAH --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Jenis Limbah</label>
            <div class="flex gap-6 mt-1">
                @foreach (['B3','Non-B3'] as $jenis)
                <label class="flex items-center gap-2">
                    <input type="radio" name="jenis_limbah" value="{{ $jenis }}"
                        {{ old('jenis_limbah') == $jenis ? 'checked' : '' }} required>
                    <span>{{ $jenis }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- NAMA LIMBAH --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Nama Limbah</label>
            <input type="text" name="nama_limbah"
                value="{{ old('nama_limbah') }}"
                class="w-full border rounded-lg p-2 focus:ring focus:ring-green-200"
                required>
        </div>

        {{-- KATEGORI --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Kategori</label>
            <div class="flex gap-6 mt-1">
                @foreach (['Padat','Cair','Gas'] as $kategori)
                    <label class="flex items-center gap-2">
                        <input type="radio" name="kategori" value="{{ $kategori }}"
                            {{ old('kategori') == $kategori ? 'checked' : '' }} required>
                        <span>{{ $kategori }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- JUMLAH --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Jumlah</label>
            <input type="number" name="jumlah" min="1" step="0.01"
                value="{{ old('jumlah') }}"
                class="w-full border rounded-lg p-2 focus:ring focus:ring-green-200"
                required>
        </div>

        {{-- SATUAN --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Satuan</label>
            <input type="text" name="satuan"
                value="{{ old('satuan') }}"
                placeholder="kg / liter / drum"
                class="w-full border rounded-lg p-2 focus:ring focus:ring-green-200"
                required>
        </div>

        {{-- SUMBER LIMBAH --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Sumber Limbah</label>
            <input type="text" name="sumber_limbah"
                value="{{ old('sumber_limbah') }}"
                class="w-full border rounded-lg p-2 focus:ring focus:ring-green-200"
                required>
        </div>

        {{-- TUJUAN --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Vendor / Tujuan Pengelolaan</label>
            <input type="text" name="tujuan_pengelolaan"
                value="{{ old('tujuan_pengelolaan') }}"
                placeholder="Contoh: PT Pengelola Limbah Indonesia"
                class="w-full border rounded-lg p-2 focus:ring focus:ring-green-200"
                required>
        </div>

        {{-- LOKASI --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Lokasi Penyimpanan</label>
            <input type="text" name="lokasi_penyimpanan"
                value="{{ old('lokasi_penyimpanan') }}"
                placeholder="Gudang Limbah B3"
                class="w-full border rounded-lg p-2 focus:ring focus:ring-green-200"
                required>
        </div>

        {{-- FOTO --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Foto</label>
            <input type="file" name="foto"
                class="w-full border rounded-lg p-2">
        </div>

        {{-- KETERANGAN --}}
        <div class="mb-6">
            <label class="block mb-1 font-medium">Keterangan</label>
            <textarea name="keterangan" rows="3"
                class="w-full border rounded-lg p-2 focus:ring focus:ring-green-200">{{ old('keterangan') }}</textarea>
        </div>

        {{-- BUTTONS --}}
        <div class="flex justify-end gap-3 mt-4">
            <a href="{{ route('she.environment.limbah.index') }}"
               class="inline-flex items-center px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">
                Batal
            </a>

            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow">
                Simpan Data
            </button>
        </div>

    </form>
</div>
@endsection