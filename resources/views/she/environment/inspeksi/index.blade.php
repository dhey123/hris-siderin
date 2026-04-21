@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto bg-white p-6 rounded-xl shadow space-y-4">
 {{-- KEMBALI --}}
    <div>
        <a href="{{ route('she.environment.index') }}"
           class="inline-flex items-center gap-1 px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">
            ← Kembali
        </a>
    </div>
    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">Daftar Inspeksi SHE</h1>
            <p class="text-sm text-gray-500">Semua kategori SHE ditampilkan</p>
        </div>
        

        <a href="{{ route('she.environment.inspeksi.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            + Tambah Inspeksi
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="w-full border border-gray-200 text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2">No</th>
                    <th class="border px-3 py-2">Nomor</th>
                    <th class="border px-3 py-2">Tanggal</th>
                    <th class="border px-3 py-2">Area</th>
                    <th class="border px-3 py-2">Jenis</th>
                    <th class="border px-3 py-2">Kategori</th>
                    <th class="border px-3 py-2">Status</th>
                    <th class="border px-3 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inspections as $insp)
                <tr>
                    <td class="border px-3 py-2 text-center">{{ $loop->iteration }}</td>
                    <td class="border px-3 py-2">{{ $insp->nomor_inspeksi }}</td>
                    <td class="border px-3 py-2">{{ $insp->tanggal->format('d-m-Y') }}</td>
                    <td class="border px-3 py-2">{{ $insp->area }}</td>
                    <td class="border px-3 py-2">{{ $insp->jenis }}</td>
                    <td class="border px-3 py-2">
    @php
        $order = ['Safety', 'Health', 'Environment']; // urutan yang diinginkan
        $categories = $insp->details->pluck('checklist.kategori')->unique();
        $categories = collect($order)->filter(fn($cat) => $categories->contains($cat))->join(', ');
    @endphp
    {{ $categories }}
</td>

                    <td class="border px-3 py-2 text-center">
                        <span class="px-2 py-1 rounded text-white
                            {{ $insp->status == 'Open' ? 'bg-yellow-500' : 'bg-green-600' }}">
                            {{ $insp->status }}
                        </span>
                    </td>
                    <td class="border px-3 py-2 space-x-2 text-center">
                        <a href="{{ route('she.environment.inspeksi.show', $insp->id) }}"
                           class="text-blue-600 hover:underline">Detail</a>

                        <a href="{{ route('she.environment.inspeksi.edit', $insp->id) }}"
                           class="text-orange-500 hover:underline">Edit</a>

                        <form action="{{ route('she.environment.inspeksi.destroy', $insp->id) }}"
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Hapus data?')"
                                class="text-red-600 hover:underline">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4 text-gray-500">
                        Belum ada data inspeksi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
