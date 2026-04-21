@extends('layouts.app')

@section('content')
<div class="p-6 max-w-xl">

    <h1 class="text-xl font-bold mb-4">Edit Request</h1>

    <form action="{{ route('ga.requests.update', $requestItem->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- NAMA --}}
        <div class="mb-3">
            <label class="block mb-1">Nama Barang</label>
            <input type="text" name="item_name"
                   value="{{ old('item_name', $requestItem->item_name) }}"
                   class="w-full border p-2 rounded">
        </div>

        {{-- QTY --}}
        <div class="mb-3">
            <label class="block mb-1">Qty</label>
            <input type="number" name="qty"
                   value="{{ old('qty', $requestItem->qty) }}"
                   class="w-full border p-2 rounded">
        </div>

        {{-- 🔥 STATUS (DITAMBAH PROCESS) --}}
        <div class="mb-3">
            <label class="block mb-1">Status</label>
            <select name="status" class="w-full border p-2 rounded">
                <option value="pending" {{ $requestItem->status == 'pending' ? 'selected' : '' }}>Tunda</option>
                <option value="approved" {{ $requestItem->status == 'approved' ? 'selected' : '' }}>Setujui</option>
                <option value="process" {{ $requestItem->status == 'process' ? 'selected' : '' }}>Process</option>
                <option value="done" {{ $requestItem->status == 'done' ? 'selected' : '' }}>Selesai</option>
                <option value="rejected" {{ $requestItem->status == 'rejected' ? 'selected' : '' }}>Tolak</option>
            </select>
        </div>

        {{-- 🔥 SOURCE (BARU) --}}
        <div class="mb-3">
            <label class="block mb-1">Sumber Barang</label>
            <select name="source" class="w-full border p-2 rounded">
                <option value="">-- Pilih Sumber --</option>
                <option value="warehouse" {{ $requestItem->source == 'warehouse' ? 'selected' : '' }}>
                    Warehouse / Produksi
                </option>
                <option value="purchase" {{ $requestItem->source == 'purchase' ? 'selected' : '' }}>
                    Purchase / Beli
                </option>
            </select>
        </div>

        {{-- ACTION --}}
        <div class="flex justify-between">
            <a href="{{ route('ga.requests.index') }}"
               class="px-4 py-2 bg-gray-500 text-white rounded">
                Kembali
            </a>

            <button class="px-4 py-2 bg-yellow-500 text-white rounded">
                Update
            </button>
        </div>

    </form>

</div>
@endsection