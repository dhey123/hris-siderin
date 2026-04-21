@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto bg-white p-5 rounded-lg shadow-sm space-y-4">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-xl font-semibold text-gray-800">
                Master Checklist Inspeksi
            </h1>
            <p class="text-sm text-gray-500">
                Kelola item checklist Safety, Health, Environment, Risiko
            </p>
        </div>

        <a href="{{ route('she.inspection-checklists.create') }}"
           class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700 text-sm">
            + Tambah Checklist
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="bg-gray-100 border border-gray-300 text-gray-700 px-3 py-2 rounded text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="overflow-x-auto border rounded">

        <table class="min-w-full text-sm text-black-800 border-collapse">

            <thead class="bg-blue-50 border-b">
                <tr>
                    <th class="border px-2 py-2 text-center w-12">No</th>
                    <th class="border px-2 py-2">Kategori</th>
                    <th class="border px-2 py-2">Area</th>
                    <th class="border px-2 py-2">Kode</th>
                    <th class="border px-2 py-2">Item</th>
                    <th class="border px-2 py-2">Standar</th>
                    <th class="border px-2 py-2 text-center">Status</th>
                    <th class="border px-2 py-2 text-center w-28">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @forelse($checklists as $i => $row)
                <tr class="hover:bg-gray-50">

                    <td class="border px-2 py-1 text-center">
                        {{ $i+1 }}
                    </td>

                    <td class="border px-2 py-1">
                        {{ $row->kategori }}
                    </td>

                    <td class="border px-2 py-1">
                        {{ $row->area }}
                    </td>

                    <td class="border px-2 py-1">
                        {{ $row->kode ?? '-' }}
                    </td>

                    <td class="border px-2 py-1">
                        {{ $row->item }}
                    </td>

                    <td class="border px-2 py-1">
                        {{ $row->standar ?? '-' }}
                    </td>

                    <td class="border px-2 py-1 text-center">
                        {{ $row->aktif ? 'Aktif' : 'Nonaktif' }}
                    </td>

                    <td class="border px-2 py-1 text-center flex justify-center gap-2">

    {{-- EDIT --}}
    <a href="{{ route('she.inspection-checklists.edit',$row->id) }}"
       title="Edit"
       class="text-gray-700 hover:text-blue-600">

        {{-- ICON PENCIL --}}
        <svg xmlns="http://www.w3.org/2000/svg" 
             class="w-5 h-5" 
             fill="none" 
             viewBox="0 0 24 24" 
             stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.12 2.12 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
        </svg>
    </a>

    {{-- DELETE --}}
    <form action="{{ route('she.inspection-checklists.destroy',$row->id) }}"
          method="POST"
          onsubmit="return confirm('Yakin hapus data ini?')">
        @csrf
        @method('DELETE')

        <button type="submit"
                title="Hapus"
                class="text-gray-700 hover:text-red-600">

            {{-- ICON TRASH --}}
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
            </svg>
        </button>
    </form>

</td>


                </tr>
            @empty
                <tr>
                    <td colspan="8" class="border px-3 py-4 text-center text-gray-500">
                        Data belum tersedia
                    </td>
                </tr>
            @endforelse
            </tbody>

        </table>

    </div>

</div>
@endsection
