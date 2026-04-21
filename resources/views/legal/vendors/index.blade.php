@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Master Data Vendor
            </h1>
            <p class="text-sm text-gray-500">
                Legal Management / Master Data
            </p>
        </div>

        <a href="{{ route('legal.vendors.create') }}"
           class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
            + Tambah Vendor
        </a>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-sm text-gray-500">Total Vendor</p>
            <p class="text-2xl font-bold text-gray-800">
                {{ $totalVendor }}
            </p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-sm text-gray-500">Vendor Aktif</p>
            <p class="text-2xl font-bold text-green-600">
                {{ $vendorAktif }}
            </p>
        </div>
    </div>

    {{-- Search --}}
    <div class="bg-white p-4 rounded-xl shadow">
        <form method="GET" class="flex gap-3">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari nama vendor / NPWP..."
                   class="flex-1 px-4 py-2 border rounded-lg">

            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Cari
            </button>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr class="text-left text-gray-600">
                    <th class="px-6 py-3">Vendor</th>
                    <th class="px-6 py-3">Jenis</th>
                    <th class="px-6 py-3">NPWP</th>
                    <th class="px-6 py-3">Alamat</th>
                    <th class="px-6 py-3">Kontak</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse($vendors as $vendor)

                <tr class="hover:bg-gray-50 transition">

                    {{-- Vendor --}}
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-800">
                            {{ $vendor->nama_vendor }}
                        </div>

                        <div class="text-gray-500 text-xs">
                            {{ $vendor->email ?? '-' }}
                        </div>
                    </td>

                    {{-- Jenis --}}
                    <td class="px-6 py-4">
                        {{ $vendor->jenis_vendor ?? '-' }}
                    </td>

                    {{-- NPWP --}}
                    <td class="px-6 py-4 text-gray-700">
                        {{ $vendor->npwp ?? '-' }}
                    </td>

                    {{-- Alamat --}}
                    <td class="px-6 py-4 text-gray-600 text-sm max-w-xs">
                        {{ $vendor->alamat ?? '-' }}
                    </td>

                    {{-- Kontak --}}
                    <td class="px-6 py-4">
                        <div class="font-medium">
                            {{ $vendor->kontak_person ?? '-' }}
                        </div>

                        <div class="text-xs text-gray-500">
                            {{ $vendor->no_telp ?? '-' }}
                        </div>
                    </td>

                    {{-- Status --}}
                    <td class="px-6 py-4">
                        @if($vendor->status == 'Aktif')
                            <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">
                                Aktif
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full">
                                Nonaktif
                            </span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td class="px-6 py-4 text-center space-x-2">

                        <a href="{{ route('legal.vendors.edit', $vendor->id) }}"
                           class="px-3 py-1 text-xs bg-yellow-400 text-white rounded hover:bg-yellow-500 transition">
                            Edit
                        </a>

                        <form action="{{ route('legal.vendors.destroy', $vendor->id) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Yakin hapus vendor ini?')">

                            @csrf
                            @method('DELETE')

                            <button
                                class="px-3 py-1 text-xs bg-red-500 text-white rounded hover:bg-red-600 transition">
                                Hapus
                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="7" class="px-6 py-6 text-center text-gray-500">
                        Belum ada data vendor.
                    </td>
                </tr>

                @endforelse

            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div>
        {{ $vendors->withQueryString()->links() }}
    </div>

</div>
@endsection