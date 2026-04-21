@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">
            Struktur Industrial
        </h1>

        <a href="{{ route('labour.structures.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            + Tambah Data
        </a>
    </div>


    <div class="bg-white shadow rounded-lg overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="p-3 text-left">Nama</th>
                    <th class="p-3 text-left">Jabatan</th>
                    <th class="p-3 text-left">Pihak</th>
                    <th class="p-3 text-left">Kontak</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($structures as $item)

                <tr class="border-t">
                    <td class="p-3">{{ $item->nama }}</td>
                    <td class="p-3">{{ $item->jabatan }}</td>
                    <td class="p-3">{{ $item->pihak }}</td>
                    <td class="p-3">{{ $item->kontak }}</td>

                    <td class="p-3 flex gap-3">

                            <a href="{{ route('labour.structures.edit',$item->id) }}"
                            class="text-blue-600 hover:underline">
                            Edit
                            </a>

                            <form action="{{ route('labour.structures.destroy',$item->id) }}" method="POST"
                            onsubmit="return confirm('Yakin hapus data ini?')">

                            @csrf
                            @method('DELETE')

                            <button class="text-red-600 hover:underline">
                            Hapus
                            </button>

                            </form>

                            </td>

                </tr>

                @empty

                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500">
                        Belum ada data
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection