@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-4">

    <h1 class="text-2xl font-bold mb-6">Edit Identifikasi Risiko</h1>

    <div class="bg-white p-6 rounded shadow">
        <form action="{{ route('she.risk.identifikasi.update', $risk->id) }}"
              method="POST"
              class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium mb-1">Nama Risiko</label>
                <input type="text"
                       name="nama_risiko"
                       value="{{ old('nama_risiko', $risk->nama_risiko) }}"
                       class="border w-full p-2 rounded"
                       required>
            </div>

            <div>
                <label class="block font-medium mb-1">Kategori</label>
                <select name="kategori"
                        class="border w-full p-2 rounded"
                        required>
                    @php
                        $kategoriList = [
                            'Safety','Health','Environment',
                            'Bencana Alam','Tsunami','Gempa'
                        ];
                    @endphp

                    @foreach($kategoriList as $kategori)
                        <option value="{{ $kategori }}"
                            {{ $risk->kategori == $kategori ? 'selected' : '' }}>
                            {{ $kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-medium mb-1">Deskripsi</label>
                <textarea name="deskripsi"
                          class="border w-full p-2 rounded"
                          rows="3">{{ old('deskripsi', $risk->deskripsi) }}</textarea>
            </div>

            <div>
                <label class="block font-medium mb-1">Tanggal Identifikasi</label>
                <input type="date"
                       name="tanggal_identifikasi"
                       value="{{ old('tanggal_identifikasi', $risk->tanggal_identifikasi) }}"
                       class="border w-full p-2 rounded"
                       required>
            </div>

            <div>
                <label class="block font-medium mb-1">Penanggung Jawab</label>
                <input type="text"
                       name="owner"
                       value="{{ old('owner', $risk->owner) }}"
                       class="border w-full p-2 rounded">
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('she.risk.identifikasi.index') }}"
                   class="px-4 py-2 bg-gray-400 text-white rounded">
                    Batal
                </a>

                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Update
                </button>
            </div>

        </form>
    </div>

</div>
@endsection