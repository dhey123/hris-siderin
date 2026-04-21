@extends('layouts.app')

@section('content')
<div class="p-8 space-y-8">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Dokumen Legal</h1>
            <p class="text-sm text-gray-500 mt-1">
                Master Data Dokumen Perusahaan
            </p>
        </div>

        <a href="{{ route('legal.documents.create') }}"
           class="px-6 py-3 bg-green-600 text-white rounded-xl shadow hover:bg-green-700 transition">
            + Tambah Dokumen
        </a>
    </div>


    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl">
            {{ session('success') }}
        </div>
    @endif


    {{-- FILTER --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <form method="GET" class="flex flex-col md:flex-row gap-4 items-center">

            <input type="text" 
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari nama dokumen..."
                   class="flex-1 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-green-500 focus:outline-none">

            <select name="status"
                    class="px-4 py-3 border rounded-xl focus:ring-2 focus:ring-green-500 focus:outline-none">
                <option value="">Semua Status</option>
                <option value="Aktif" {{ request('status')=='Aktif'?'selected':'' }}>Aktif</option>
                <option value="Hampir Habis" {{ request('status')=='Hampir Habis'?'selected':'' }}>H-30</option>
                <option value="Expired" {{ request('status')=='Expired'?'selected':'' }}>Expired</option>
            </select>

            <button class="px-6 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition">
                Filter
            </button>

        </form>
    </div>


    {{-- TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="min-w-full text-sm">

            <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-6 py-4 text-left">Dokumen</th>
                    <th class="px-6 py-4 text-left">Kategori</th>
                    <th class="px-6 py-4 text-left">Vendor</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-left">Berlaku Sampai</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($documents as $doc)
                    <tr class="hover:bg-gray-50 transition">

                        {{-- Nama Dokumen --}}
                        <td class="px-6 py-5">
                            <div class="font-semibold text-gray-800">
                                {{ $doc->nama_dokumen }}
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                {{ $doc->nomor_dokumen ?? '-' }}
                            </div>
                        </td>

                        {{-- Kategori --}}
                        <td class="px-6 py-5 text-gray-700">
                            {{ $doc->kategori }}
                        </td>

                        {{-- Vendor --}}
                        <td class="px-6 py-5 text-gray-700">
                            {{ $doc->vendor->nama_vendor ?? '-' }}
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-5">
                            @php
                                $color = match($doc->status) {
                                    'Aktif' => 'bg-green-100 text-green-700',
                                    'Hampir Habis' => 'bg-yellow-100 text-yellow-700',
                                    'Expired' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp

                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $color }}">
                                {{ $doc->status }}
                            </span>
                        </td>

                        {{-- Tanggal Berakhir --}}
                        <td class="px-6 py-5 text-gray-700">
                            {{ $doc->tanggal_berakhir 
                                ? \Carbon\Carbon::parse($doc->tanggal_berakhir)->format('d M Y') 
                                : '-' }}
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-5 text-center space-x-2">

                            @if($doc->file_path)
                                <a href="{{ asset('storage/'.$doc->file_path) }}"
                                   target="_blank"
                                   class="px-3 py-1 text-xs bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                                    View
                                </a>
                            @endif

                            <a href="{{ route('legal.documents.edit',$doc->id) }}"
                               class="px-3 py-1 text-xs bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                                Edit
                            </a>

                            <form action="{{ route('legal.documents.destroy',$doc->id) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Yakin hapus dokumen ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 text-xs bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                    Hapus
                                </button>
                            </form>

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            Belum ada dokumen tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>


    {{-- PAGINATION --}}
    <div>
        {{ $documents->withQueryString()->links() }}
    </div>

</div>
@endsection