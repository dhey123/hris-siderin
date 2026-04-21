@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-xl shadow">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Master Audit Checklist</h1>
        <a href="{{ route('settings.audit-checklist.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            + Tambah
        </a>
    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABEL CHECKLIST --}}
    <div class="overflow-x-auto">
        <table class="w-full border text-sm border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2 text-left">Kode</th>
                    <th class="border px-3 py-2 text-left">Kategori</th>
                    <th class="border px-3 py-2 text-left">Item</th>
                    <th class="border px-3 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($checklists as $c)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-3 py-2">{{ $c->kode ?? '-' }}</td>
                        <td class="border px-3 py-2">{{ $c->kategori ?? '-' }}</td>
                        <td class="border px-3 py-2">{{ $c->item ?? '-' }}</td>
                        <td class="border px-3 py-2 space-x-2">
                            <a href="{{ route('settings.audit-checklist.edit', $c->id) }}"
                               class="text-blue-600 hover:underline">Edit</a>

                            <form action="{{ route('settings.audit-checklist.destroy', $c->id) }}"
                                  method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline"
                                        onclick="return confirm('Hapus data checklist ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="border px-3 py-2 text-center" colspan="4">Belum ada data checklist</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection