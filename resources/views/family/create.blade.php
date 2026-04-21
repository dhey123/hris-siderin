@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto">

    <h2 class="text-2xl font-bold text-gray-700 mb-4">
        Tambah Anggota Keluarga — {{ $employee->name }}
    </h2>

    <form action="{{ route('family.store', $employee->id) }}" method="POST"
          class="bg-white p-6 rounded shadow">

        @csrf

        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Nama</label>
            <input type="text" name="name"
                   class="w-full border rounded px-3 py-2 focus:ring focus:border-green-500"
                   required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Hubungan</label>
            <select name="relationship"
                    class="w-full border rounded px-3 py-2"
                    required>
                <option value="">-- Pilih --</option>
                <option value="wife">Istri</option>
                <option value="husband">Suami</option>
                <option value="child">Anak</option>
                <option value="parent">Orang Tua</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Tanggal Lahir</label>
            <input type="date" name="birth_date"
                   class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Tanggungan</label>
            <select name="is_dependent"
                    class="w-full border rounded px-3 py-2"
                    required>
                <option value="1">Ya</option>
                <option value="0">Tidak</option>
            </select>
        </div>

        <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            Simpan
        </button>

        <a href="{{ route('family.index', $employee->id) }}"
           class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
            Kembali
        </a>

    </form>

</div>
@endsection
