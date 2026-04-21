@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-4">

    <h1 class="text-2xl font-bold mb-6">Tambah Identifikasi Risiko</h1>

    <div class="bg-white p-6 rounded shadow">
        <form action="{{ route('she.risk.identifikasi.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block font-medium mb-1">Nama Risiko</label>
                <input type="text"
                       name="nama_risiko"
                       value="{{ old('nama_risiko') }}"
                       class="border w-full p-2 rounded"
                       required>
            </div>

            <div>
                <label class="block font-medium mb-1">Kategori</label>
                <select name="kategori"
                        class="border w-full p-2 rounded"
                        required>
                    <option value="">Pilih Kategori</option>
                    <option value="Safety">Safety</option>
                    <option value="Health">Health</option>
                    <option value="Environment">Environment</option>
                    <option value="Bencana Alam">Bencana Alam</option>
                    <option value="Tsunami">Tsunami</option>
                    <option value="Gempa">Gempa</option>
                </select>
            </div>

            <div>
                <label class="block font-medium mb-1">Deskripsi</label>
                <textarea name="deskripsi"
                          class="border w-full p-2 rounded"
                          rows="3">{{ old('deskripsi') }}</textarea>
            </div>

            <div>
                <label class="block font-medium mb-1">Tanggal Identifikasi</label>
                <input type="date"
                       name="tanggal_identifikasi"
                       value="{{ old('tanggal_identifikasi') }}"
                       class="border w-full p-2 rounded"
                       required>
            </div>

            <div>
                <label class="block font-medium mb-1">Penanggung Jawab</label>
                <input type="text"
                       name="owner"
                       value="{{ old('owner') }}"
                       class="border w-full p-2 rounded">
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('she.risk.identifikasi.index') }}"
                   class="px-4 py-2 bg-gray-400 text-white rounded">
                    Batal
                </a>

                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Simpan
                </button>
            </div>

        </form>
    </div>

</div>
@endsection