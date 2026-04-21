@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <h1 class="text-2xl font-bold text-gray-800">Data Asset</h1>

        <a href="{{ route('ga.assets.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
            + Tambah Asset
        </a>
    </div>

    <!-- SEARCH + ACTION -->
    <div class="flex flex-wrap gap-2 items-center justify-between">

        <!-- SEARCH -->
        <form method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari asset..."
                class="px-3 py-2 border rounded-lg text-sm">

            <button class="px-3 py-2 bg-gray-800 text-white rounded-lg text-sm">
                Cari
            </button>
        </form>

        <!-- ACTION -->
        <div class="flex gap-2">

            <!-- EXPORT -->
            <a href="{{ route('ga.assets.export') }}"
               class="px-3 py-2 bg-green-600 text-white rounded-lg text-sm">
                Export
            </a>

   

        </div>
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="p-3 bg-green-100 text-green-700 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERROR (🔥 FIX TAMBAHAN) --}}
    @if(session('error'))
        <div class="p-3 bg-red-100 text-red-700 rounded-lg shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- FILTER --}}
    @php $cat = request('category'); @endphp

    <div class="flex flex-wrap gap-2">
        <a href="{{ route('ga.assets.index') }}"
           class="px-4 py-1.5 rounded-full text-sm font-medium transition
           {{ !$cat ? 'bg-gray-800 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
            Semua
        </a>

        @foreach($categories as $c)
            <a href="{{ route('ga.assets.index', ['category' => $c->id]) }}"
               class="px-4 py-1.5 rounded-full text-sm font-medium transition
               {{ $cat == $c->id ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
                {{ $c->name }}
            </a>
        @endforeach
    </div>

    <!-- TABLE -->
    <div class="bg-white shadow-md rounded-xl overflow-hidden">
        <table class="w-full text-sm">

            <thead class="bg-gray-800 text-white text-xs uppercase">
                <tr>
                    <th class="p-4 text-left">Kode</th>
                    <th class="p-4 text-left">Nama</th>
                    <th class="p-4 text-left">Kategori</th>
                    <th class="p-4 text-left">Jumlah / Luas</th>
                    <th class="p-4 text-left">Kondisi</th>
                    <th class="p-4 text-left">Lokasi</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse($assets as $asset)
                <tr class="hover:bg-gray-50">

                    <td class="p-4 font-medium">{{ $asset->asset_code }}</td>
                    <td class="p-4">{{ $asset->name }}</td>

                    {{-- KATEGORI --}}
                    <td class="p-4">
                        <span class="px-3 py-1 text-xs rounded
                            {{ $asset->category->name == 'ATK' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $asset->category->name == 'Mesin' ? 'bg-orange-100 text-orange-700' : '' }}
                            {{ $asset->category->name == 'Properti' ? 'bg-green-100 text-green-700' : '' }}">
                            {{ $asset->category->name }}
                        </span>
                    </td>

                    {{-- FIX: NILAI DINAMIS --}}
                    <td class="p-4">
                        @if($asset->type === 'fixed')
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded">
                                {{ $asset->quantity ?? 0 }} m²
                            </span>
                        @else
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded">
                                {{ $asset->quantity }}
                            </span>
                        @endif
                    </td>

                    {{-- KONDISI --}}
                    <td class="p-4 capitalize">
                        {{ $asset->condition }}
                    </td>

                    {{-- FIX NULL SAFE (🔥 TAMBAHAN) --}}
                    <td class="p-4">{{ $asset->location ?? '-' }}</td>

                    {{-- ACTION --}}
                    <td class="p-4 text-center">
                        <div class="flex justify-center gap-2">

                            <a href="{{ route('ga.assets.show', $asset->id) }}"
                               class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded">
                                Detail
                            </a>

                            <a href="{{ route('ga.assets.edit', $asset->id) }}"
                               class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">
                                Edit
                            </a>

                            <form action="{{ route('ga.assets.destroy', $asset->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus asset ini?')">
                                @csrf
                                @method('DELETE')

                                <button class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">
                                    Hapus
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-6 text-center text-gray-400">
                        Belum ada data asset
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="flex justify-end">
        {{ $assets->links() }}
    </div>

</div>

<script>
document.getElementById('fileInput').addEventListener('change', function () {
    if (this.files.length > 0) {
        document.getElementById('importForm').submit();
    }
});
</script>
@endsection