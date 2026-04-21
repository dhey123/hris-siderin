@extends('layouts.app')

@section('content')
<div class="p-6 max-w-xl">

    <h1 class="text-xl font-bold mb-4">Edit Asset</h1>

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc ml-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ga.assets.update', $asset->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- NAMA --}}
        <div class="mb-3">
            <label class="block mb-1">Nama Asset</label>
            <input type="text" name="name"
                value="{{ old('name', $asset->name) }}"
                class="w-full border p-2 rounded" required>
        </div>

        {{-- 🔥 KATEGORI --}}
        <div class="mb-3">
            <label class="block mb-1">Kategori</label>
            <select name="category_id" class="w-full border p-2 rounded" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}"
                        {{ $asset->category_id == $c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- LOKASI --}}
        <div class="mb-3">
            <label class="block mb-1">Lokasi</label>
            <input type="text" name="location"
                value="{{ old('location', $asset->location) }}"
                class="w-full border p-2 rounded">
        </div>

        {{-- KONDISI --}}
        <div class="mb-3">
            <label class="block mb-1">Kondisi</label>
            <select name="condition" class="w-full border p-2 rounded">
                <option value="baik" {{ $asset->condition == 'baik' ? 'selected' : '' }}>Baik</option>
                <option value="rusak" {{ $asset->condition == 'rusak' ? 'selected' : '' }}>Rusak</option>
                <option value="maintenance" {{ $asset->condition == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
            </select>
        </div>

        {{-- TANGGAL --}}
        <div class="mb-3">
            <label class="block mb-1">Tanggal Beli</label>
            <input type="date" name="purchase_date"
                value="{{ old('purchase_date', $asset->purchase_date) }}"
                class="w-full border p-2 rounded">
        </div>

        {{-- HARGA --}}
        <div class="mb-3">
            <label class="block mb-1">Harga</label>
            <input type="number" name="price"
                value="{{ old('price', $asset->price) }}"
                class="w-full border p-2 rounded">
        </div>
        <div class="mb-3">
    <label>Jumlah</label>
    <input type="number" name="quantity" value="{{ $asset->quantity }}" class="w-full border rounded p-2" min="1" 
        required >
</div>

        {{-- DESKRIPSI --}}
        <div class="mb-3">
            <label class="block mb-1">Deskripsi</label>
            <textarea name="description"
                class="w-full border p-2 rounded">{{ old('description', $asset->description) }}</textarea>
        </div>

        {{-- ACTION --}}
        <div class="flex justify-between">
            <a href="{{ route('ga.assets.index') }}"
               class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                Kembali
            </a>

            <button class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                Update
            </button>
        </div>

    </form>

</div>
@endsection