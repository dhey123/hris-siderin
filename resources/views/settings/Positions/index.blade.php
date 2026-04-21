@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Master Positions</h1>

        <a href="{{ route('settings.positions.create') }}"
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            Tambah Position
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border border-gray-300 rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2 w-16">No</th>
                <th class="border px-4 py-2 text-left">Nama Position</th>
                <th class="border px-4 py-2 w-48">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($positions as $index => $position)
                <tr>
                    <td class="border px-4 py-2 text-center">
                        {{ $positions->firstItem() + $index }}
                    </td>
                    <td class="border px-4 py-2">
                        {{ $position->position_name }}
                    </td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('settings.positions.edit', $position->id) }}"
                           class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                            Edit
                        </a>

                        <form action="{{ route('settings.positions.destroy', $position->id) }}"
                              method="POST"
                              class="inline-block"
                              onsubmit="return confirm('Yakin hapus position ini?')">
                            @csrf
                            @method('DELETE')
                            <button
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center py-4 text-gray-500">
                        Belum ada data position
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $positions->links() }}
    </div>
</div>
@endsection
