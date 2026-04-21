@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">Detail Asset</h1>

    <!-- CARD -->
    <div class="bg-white shadow-lg rounded-2xl p-6 space-y-4 border">

        <div class="flex justify-between">
            <span class="text-gray-500">Kode</span>
            <span class="font-semibold">{{ $asset->asset_code }}</span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">Nama</span>
            <span class="font-semibold">{{ $asset->name }}</span>
        </div>

        <div class="flex justify-between items-center">
            <span class="text-gray-500">Kategori</span>
            <span class="px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-700">
                {{ $asset->category->name ?? '-' }}
            </span>
        </div>

        <!-- TYPE -->
        <div class="flex justify-between items-center">
            <span class="text-gray-500">Type</span>

            @if($asset->type === 'fixed')
                <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm">
                    Fixed Asset (Tanah/Bangunan)
                </span>
            @else
                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">
                    Stock Asset
                </span>
            @endif
        </div>

        <div class="flex justify-between items-center">
            <span class="text-gray-500">Kondisi</span>

            @if($asset->condition == 'baik')
                <span class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-700">Baik</span>
            @elseif($asset->condition == 'rusak')
                <span class="px-3 py-1 rounded-full text-sm bg-red-100 text-red-700">Rusak</span>
            @else
                <span class="px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-700">Maintenance</span>
            @endif
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">Lokasi</span>
            <span class="font-medium">{{ $asset->location ?? '-' }}</span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">Tanggal Beli</span>
            <span>{{ $asset->purchase_date ?? '-' }}</span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">Harga</span>
            <span class="font-semibold text-green-600">
                Rp {{ number_format($asset->price, 0, ',', '.') }}
            </span>
        </div>

        <div class="flex justify-between items-center">
            <span class="text-gray-500">Jumlah</span>
            <span class="px-4 py-1 rounded-lg bg-indigo-100 text-indigo-700 font-bold">
                {{ $asset->quantity }}
            </span>
        </div>

        <div>
            <span class="text-gray-500 block mb-1">Deskripsi</span>
            <div class="bg-gray-50 border rounded-lg p-3 text-sm">
                {{ $asset->description ?? '-' }}
            </div>
        </div>

    </div>

    <!-- ACTION -->
    <div class="mt-6 flex justify-between">

        <a href="{{ route('ga.assets.index') }}"
           class="px-4 py-2 bg-gray-500 text-white rounded-lg">
            ← Kembali
        </a>

        <div class="flex gap-2">

            <button onclick="toggleModal('editModal')"
                class="px-4 py-2 bg-yellow-500 text-white rounded-lg">
                Edit
            </button>

            {{-- STOCK ONLY IF STOCK TYPE --}}
            @if($asset->type === 'stock')

                <button onclick="toggleModal('stockInModal')"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg">
                    + Stok
                </button>

                <button onclick="toggleModal('stockOutModal')"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg">
                    - Stok
                </button>

            @else
                <span class="px-3 py-2 text-sm text-red-600 font-semibold">
                    Fixed Asset (No Stock Movement)
                </span>
            @endif

        </div>
    </div>

</div>
@endsection


@section('modals')

<!-- ================= MODAL EDIT ================= -->
<div id="editModal"
class="hidden fixed inset-0 z-[9999] flex items-center justify-center">

    <div class="bg-white p-6 rounded-xl w-full max-w-lg shadow-xl border">

        <h2 class="text-lg font-bold mb-4">Edit Asset</h2>

        <form method="POST" action="{{ route('ga.assets.update', $asset->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="block text-sm">Nama</label>
                <input type="text" name="name" value="{{ $asset->name }}"
                    class="w-full border rounded p-2">
            </div>

            <div class="mb-3">
                <label class="block text-sm">Lokasi</label>
                <input type="text" name="location" value="{{ $asset->location }}"
                    class="w-full border rounded p-2">
            </div>

            <div class="mb-3">
                <label class="block text-sm">Kondisi</label>
                <select name="condition" class="w-full border rounded p-2">
                    <option value="baik" {{ $asset->condition=='baik'?'selected':'' }}>Baik</option>
                    <option value="rusak" {{ $asset->condition=='rusak'?'selected':'' }}>Rusak</option>
                    <option value="maintenance" {{ $asset->condition=='maintenance'?'selected':'' }}>Maintenance</option>
                </select>
            </div>

            {{-- LOCK QUANTITY FOR FIXED --}}
            @if($asset->type === 'stock')
                <div class="mb-3">
                    <label class="block text-sm">Jumlah</label>
                    <input type="number" name="quantity" value="{{ $asset->quantity }}"
                        class="w-full border rounded p-2">
                </div>
            @else
                <div class="mb-3">
                    <label class="block text-sm">Jumlah</label>
                    <input type="number" value="1" disabled
                        class="w-full border rounded p-2 bg-gray-100">
                    <p class="text-xs text-red-500 mt-1">
                        Fixed asset tidak bisa ubah quantity
                    </p>
                </div>
            @endif

            <div class="flex justify-end gap-2 mt-4">
                <button type="button"
                    onclick="toggleModal('editModal')"
                    class="px-4 py-2 bg-gray-400 text-white rounded">
                    Batal
                </button>

                <button class="px-4 py-2 bg-green-600 text-white rounded">
                    Simpan
                </button>
            </div>
        </form>

    </div>
</div>


<!-- STOCK IN -->
<div id="stockInModal" class="hidden fixed inset-0 z-[9999] flex items-center justify-center">
    <div class="bg-white p-6 rounded-xl w-full max-w-md shadow-xl border">

        <h2 class="text-lg font-bold mb-4">Tambah Stok</h2>

        <form method="POST" action="{{ route('ga.assets.stock.in.store', $asset->id) }}">
            @csrf

            <input type="number" name="qty" class="w-full border p-2 mb-3 rounded" required>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="toggleModal('stockInModal')" class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
                <button class="px-4 py-2 bg-green-600 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>


<!-- STOCK OUT -->
<div id="stockOutModal" class="hidden fixed inset-0 z-[9999] flex items-center justify-center">
    <div class="bg-white p-6 rounded-xl w-full max-w-md shadow-xl border">

        <h2 class="text-lg font-bold mb-4">Kurangi Stok</h2>

        <form method="POST" action="{{ route('ga.assets.stock.out.store', $asset->id) }}">
            @csrf

            <input type="number" name="qty" class="w-full border p-2 mb-3 rounded" required>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="toggleModal('stockOutModal')" class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
                <button class="px-4 py-2 bg-red-600 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection


@push('scripts')
<script>
function toggleModal(id) {
    document.getElementById(id).classList.toggle('hidden');
}
</script>
@endpush