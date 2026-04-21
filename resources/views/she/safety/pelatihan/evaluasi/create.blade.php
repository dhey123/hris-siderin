@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-xl shadow p-6">

    <h1 class="text-xl font-bold mb-4">
        Evaluasi Pelatihan
    </h1>

    <p class="text-sm text-gray-500 mb-6">
        {{ $pelatihan->nama_pelatihan }}
    </p>

    <form method="POST"
          action="{{ route('she.safety.pelatihan.evaluasi.store', $pelatihan->id) }}">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium">Nilai (0–100)</label>
            <input type="number" name="nilai"
                   class="w-full border rounded p-2"
                   min="0" max="100" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">Catatan</label>
            <textarea name="catatan"
                      class="w-full border rounded p-2"
                      rows="4"></textarea>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('she.safety.pelatihan.show', $pelatihan->id) }}"
               class="px-4 py-2 bg-gray-200 rounded">
                Batal
            </a>

            <button class="px-4 py-2 bg-green-600 text-white rounded">
                Simpan Evaluasi
            </button>
        </div>
    </form>
</div>
@endsection
