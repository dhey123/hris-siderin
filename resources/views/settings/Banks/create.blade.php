@extends('layouts.app')

@section('content')
<div class="max-w-xl bg-white shadow rounded p-6">
    <h1 class="text-xl font-bold mb-6">Tambah Bank</h1>

    <form action="{{ route('settings.banks.store') }}" method="POST">
        @csrf

        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Nama Bank
            </label>
            <input
                type="text"
                name="bank_name"
                value="{{ old('bank_name') }}"
                required
                class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:ring-green-200 @error('bank_name') border-red-500 @enderror"
            >
            @error('bank_name')
                <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Kode Bank
            </label>
            <input
                type="text"
                name="bank_code"
                value="{{ old('bank_code') }}"
                class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:ring-green-200"
            >
        </div>

        <div class="flex gap-3 pt-2">
            <button
                type="submit"
                class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Simpan
            </button>

            <a href="{{ route('settings.banks.index') }}"
               class="px-5 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
