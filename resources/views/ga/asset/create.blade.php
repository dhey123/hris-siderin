@extends('layouts.app')

@section('content')
<div class="p-6 max-w-xl mx-auto">

    <h1 class="text-xl font-bold mb-4">Tambah Asset</h1>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc ml-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ga.assets.store') }}" method="POST">
        @csrf

        {{-- NAMA --}}
        <div class="mb-3">
            <label>Nama Asset</label>
            <input type="text" name="name"
                value="{{ old('name') }}"
                class="w-full border p-2 rounded"
                required>
        </div>

        {{-- KATEGORI --}}
        <div class="mb-3">
            <label>Kategori</label>
            <select name="category_id" id="category" class="w-full border p-2 rounded" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- VALUE (FIX DINAMIS) --}}
        <div class="mb-3">
            <input type="number" name="quantity"
    value="{{ old('quantity') }}"
    class="w-full border p-2 rounded"
    required>
        </div>
        

        {{-- LOKASI --}}
        <div class="mb-3">
            <label>Lokasi</label>
            <input type="text" name="location"
                value="{{ old('location') }}"
                class="w-full border p-2 rounded">
        </div>

        {{-- KONDISI --}}
        <div class="mb-3">
            <label>Kondisi</label>
            <select name="condition" class="w-full border p-2 rounded">
                <option value="baik">Baik</option>
                <option value="rusak">Rusak</option>
                <option value="maintenance">Maintenance</option>
            </select>
        </div>

        {{-- TANGGAL --}}
        <div class="mb-3">
            <label>Tanggal Beli</label>
            <input type="date" name="purchase_date"
                value="{{ old('purchase_date') }}"
                class="w-full border p-2 rounded">
        </div>

        {{-- HARGA --}}
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="price"
                value="{{ old('price') }}"
                class="w-full border p-2 rounded">
        </div>

        {{-- DESKRIPSI --}}
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description"
                class="w-full border p-2 rounded">{{ old('description') }}</textarea>
        </div>

        <div class="flex justify-between mt-6">
            <a href="{{ route('ga.assets.index') }}"
               class="px-4 py-2 bg-gray-500 text-white rounded">
                Kembali
            </a>

            <button class="px-4 py-2 bg-green-600 text-white rounded">
                Simpan
            </button>
        </div>

    </form>
</div>

<script>
document.getElementById('category').addEventListener('change', function () {
    let text = this.options[this.selectedIndex].text;
    let label = document.getElementById('label-value');

    if (text === 'Properti') {
        label.innerText = 'Luas (m²)';
    } else {
        label.innerText = 'Jumlah';
    }
});
</script>
@endsection