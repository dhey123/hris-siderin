@extends('layouts.app')

@section('content')
<div class="p-6 max-w-4xl">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Detail Maintenance</h1>
</div>

     <div class="flex justify-between mt-4">
            <a href="{{ route('ga.maintenance.index') }}"
               class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                Kembali
            </a>

        </div>


    <!-- CARD -->
    <div class="bg-white shadow rounded-xl border p-6 space-y-6">

        <!-- ASSET -->
        <div>
            <div class="text-sm text-gray-500 mb-1">Asset</div>
            <div class="font-semibold text-lg text-gray-800">
                {{ $maintenance->asset->name ?? '-' }}
            </div>
            <div class="text-xs text-gray-400">
                {{ $maintenance->asset->asset_code ?? '-' }}
            </div>
        </div>

        <!-- MASALAH -->
        <div>
            <div class="text-sm text-gray-500 mb-1">Masalah</div>
            <div class="font-medium text-gray-800">
                {{ $maintenance->title }}
            </div>
        </div>

        <!-- DESKRIPSI -->
        <div>
            <div class="text-sm text-gray-500 mb-1">Deskripsi</div>
            <div class="text-gray-700 leading-relaxed">
                {{ $maintenance->description ?? '-' }}
            </div>
        </div>

        <!-- STATUS -->
        <div>
            <div class="text-sm text-gray-500 mb-1">Status</div>

            @if($maintenance->status == 'pending')
                <span class="px-3 py-1 text-sm font-semibold bg-yellow-100 text-yellow-700 rounded-full">
                    Pending
                </span>
            @elseif($maintenance->status == 'process')
                <span class="px-3 py-1 text-sm font-semibold bg-blue-100 text-blue-700 rounded-full">
                    Process
                </span>
            @else
                <span class="px-3 py-1 text-sm font-semibold bg-green-100 text-green-700 rounded-full">
                    Done
                </span>
            @endif
        </div>

        <!-- TANGGAL -->
        <div class="grid md:grid-cols-2 gap-6 pt-4 border-t">

            <div>
                <div class="text-sm text-gray-500 mb-1">Tanggal Lapor</div>
                <div class="font-medium text-gray-800">
                    {{ \Carbon\Carbon::parse($maintenance->report_date)->format('d M Y') }}
                </div>
            </div>

            <div>
                <div class="text-sm text-gray-500 mb-1">Tanggal Selesai</div>
                <div class="font-medium text-gray-800">
                    {{ $maintenance->finish_date 
                        ? \Carbon\Carbon::parse($maintenance->finish_date)->format('d M Y') 
                        : '-' }}
                </div>
            </div>

        </div>

    </div>

    <!-- ACTION -->
    <div class="mt-6 flex gap-3">

        <a href="{{ route('ga.maintenance.edit', $maintenance->id) }}"
           class="px-4 py-2 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600 transition">
            Edit
        </a>

        <form action="{{ route('ga.maintenance.destroy', $maintenance->id) }}" method="POST">
            @csrf
            @method('DELETE')

            <button onclick="return confirm('Yakin hapus data?')"
                class="px-4 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 transition">
                Hapus
            </button>
        </form>

    </div>

</div>
@endsection