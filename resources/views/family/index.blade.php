@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">

    <h2 class="text-2xl font-bold text-gray-700 mb-4">
        Anggota Keluarga — {{ $employee->name }}
    </h2>

    <a href="{{ route('family.create', $employee->id) }}"
       class="px-4 py-2 bg-green-600 text-white rounded shadow hover:bg-green-700">
        + Tambah Anggota Keluarga
    </a>

    @if (session('success'))
        <div class="mt-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if ($family->count() == 0)
        <div class="mt-4 p-4 bg-yellow-100 border rounded text-yellow-800">
            Belum ada anggota keluarga.
        </div>
    @else

    <div class="mt-6 bg-white shadow rounded overflow-hidden">
        <table class="w-full text-left border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 border">Nama</th>
                    <th class="p-3 border">Hubungan</th>
                    <th class="p-3 border">Tanggal Lahir</th>
                    <th class="p-3 border">Tanggungan</th>
                    <th class="p-3 border w-32 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($family as $item)
                <tr class="hover:bg-gray-50">
                    <td class="p-3 border">{{ $item->name }}</td>
                    <td class="p-3 border capitalize">{{ $item->relationship }}</td>

                    {{-- ✔ FIX FORMAT TANGGAL --}}
                    <td class="p-3 border">
                        {{ $item->birth_date ? \Carbon\Carbon::parse($item->birth_date)->format('d-m-Y') : '-' }}
                    </td>

                    <td class="p-3 border">{{ $item->is_dependent ? 'Ya' : 'Tidak' }}</td>

                    <td class="p-3 border flex justify-center gap-2">
                        <a href="{{ route('family.edit', [$employee->id, $item->id]) }}"
                           class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            Edit
                        </a>

                        <form action="{{ route('family.destroy', [$employee->id, $item->id]) }}"
                              method="POST" onsubmit="return confirm('Hapus anggota ini?')">
                            @csrf
                            @method('DELETE')

                            <button class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @endif
</div>
@endsection
