@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

    <h1 class="text-2xl font-bold text-gray-800">
        Tambah Struktur Industrial
    </h1>

    <div class="bg-white p-6 rounded shadow">

        <form action="{{ route('labour.structures.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-2 gap-6">

            <div>
                <label class="block text-sm font-medium mb-1">Nama</label>
                <input type="text" name="nama"
                    class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Jabatan</label>
                <input type="text" name="jabatan"
                    class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Pihak</label>

                <select name="pihak"
                    class="w-full border rounded px-3 py-2">

                    <option value="">-- pilih pihak --</option>
                    <option value="Perusahaan">Perusahaan</option>
                    <option value="Serikat Pekerja">SPSI</option>
                    <option value="Mediator">GSBN</option>

                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Kontak</label>
                <input type="text" name="kontak"
                    class="w-full border rounded px-3 py-2">
            </div>

        </div>

        <div class="mt-6 flex gap-3">

            <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Simpan
            </button>

            <a href="{{ route('labour.structures.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
               Kembali
            </a>

        </div>

        </form>

    </div>

</div>

@endsection