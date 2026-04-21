@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto">

    <h2 class="text-2xl font-bold text-gray-700 mb-4">
        Edit Anggota Keluarga — {{ $employee->name }}
    </h2>

    <form action="{{ route('family.update', [$employee->id, $family->id]) }}"
          method="POST"
          class="bg-white p-6 rounded shadow">

        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Nama</label>
            <input type="text" name="name"
                   value="{{ $family->name }}"
                   class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Hubungan</label>
            <select name="relationship"
                    class="w-full border rounded px-3 py-2">
                <option value="wife" {{ $family->relationship=='wife'?'selected':'' }}>Istri</option>
                <option value="husband" {{ $family->relationship=='husband'?'selected':'' }}>Suami</option>
                <option value="child" {{ $family->relationship=='child'?'selected':'' }}>Anak</option>
                <option value="parent" {{ $family->relationship=='parent'?'selected':'' }}>Orang Tua</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Tanggal Lahir</label>
            <input type="date" name="birth_date"
                   value="{{ $family->birth_date }}"
                   class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium text-gray-700">Tanggungan</label>
            <select name="is_dependent"
                    class="w-full border rounded px-3 py-2">
                <option value="1" {{ $family->is_dependent ? 'selected' : '' }}>Ya</option>
                <option value="0" {{ !$family->is_dependent ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>

        <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Update
        </button>

        <a href="{{ route('family.index', $employee->id) }}"
           class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
            Kembali
        </a>

    </form>

</div>
@endsection
