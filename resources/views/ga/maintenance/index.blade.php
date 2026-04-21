@extends('layouts.app')

@section('content')
<div class="p-6">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Maintenance</h1>

        <a href="{{ route('ga.maintenance.create') }}"
           class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            + Lapor Maintenance
        </a>
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-300 text-gray-700">
                <tr>
                    <th class="p-3 text-left">Asset</th>
                    <th class="p-3 text-left">Masalah</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Tanggal</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($maintenances as $m)
                <tr class="border-t hover:bg-gray-50">

                    {{-- ASSET --}}
                    <td class="p-3">
                        <div class="font-medium">
                            {{ $m->asset->name }}
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ $m->asset->asset_code }}
                        </div>
                    </td>

                    {{-- MASALAH --}}
                    <td class="p-3">
                        <div class="font-medium">
                            {{ $m->title }}
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ $m->description }}
                        </div>
                    </td>

                    {{-- STATUS --}}
                    <td class="p-3">
                        @if($m->status == 'pending')
                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">
                                Pending
                            </span>
                        @elseif($m->status == 'process')
                            <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded">
                                Process
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                                Done
                            </span>
                        @endif
                    </td>

                    {{-- TANGGAL --}}
                    <td class="p-3">
                        {{ \Carbon\Carbon::parse($m->report_date)->format('d M Y') }}
                    </td>

                    {{-- AKSI --}}
                    <td class="p-3 text-center space-x-2">
                        <a href="{{ route('ga.maintenance.show', $m->id) }}"
                           class="text-blue-600 hover:underline">
                            Detail
                        </a>

                        <a href="{{ route('ga.maintenance.edit', $m->id) }}"
                           class="text-yellow-600 hover:underline">
                            Edit
                        </a>

                        <form action="{{ route('ga.maintenance.destroy', $m->id) }}"
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin hapus?')"
                                class="text-red-600 hover:underline">
                                Hapus
                            </button>
                        </form>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">
                        Belum ada data maintenance
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $maintenances->links() }}
    </div>

</div>
@endsection