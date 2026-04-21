@extends('layouts.app')

@section('content')
<div class="p-6 max-w-xl">

    <h1 class="text-xl font-bold mb-4">Request Barang</h1>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc ml-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ga.requests.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="block mb-1">Nama Barang</label>
            <input type="text" name="item_name"
                   value="{{ old('item_name') }}"
                   class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-3">
            <label class="block mb-1">Jumlah</label>
            <input type="number" name="qty"
                   value="{{ old('qty') }}"
                   class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-3">
            <label class="block mb-1">Deskripsi</label>
            <textarea name="description"
                class="w-full border p-2 rounded">{{ old('description') }}</textarea>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('ga.requests.index') }}"
               class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                Kembali
            </a>

            <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Simpan
            </button>
        </div>

    </form>

</div>
@endsection