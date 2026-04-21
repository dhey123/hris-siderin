@extends('layouts.app')

@section('content')
<div class="p-6 max-w-xl">

    <h1 class="text-xl font-bold mb-4">Detail Request</h1>

    <div class="bg-white p-5 rounded-xl shadow space-y-4">

        <div>
            <div class="text-sm text-gray-500">Kode</div>
            <div class="font-medium">{{ $requestItem->request_code }}</div>
        </div>

        <div>
            <div class="text-sm text-gray-500">Barang</div>
            <div>{{ $requestItem->item_name }}</div>
        </div>

        <div>
            <div class="text-sm text-gray-500">Qty</div>
            <div>{{ $requestItem->qty }}</div>
        </div>

        <div>
            <div class="text-sm text-gray-500">Deskripsi</div>
            <div>{{ $requestItem->description ?? '-' }}</div>
        </div>

        <div>
            <div class="text-sm text-gray-500">Status</div>
            <span class="px-2 py-1 text-xs bg-gray-200 rounded">
                {{ ucfirst($requestItem->status) }}
            </span>
        </div>

    </div>

    <div class="mt-4 flex gap-2">
        <a href="{{ route('ga.requests.edit', $requestItem->id) }}"
           class="px-4 py-2 bg-yellow-500 text-white rounded">
            Edit
        </a>

        <a href="{{ route('ga.requests.index') }}"
           class="px-4 py-2 bg-gray-500 text-white rounded">
            Kembali
        </a>
    </div>

</div>
@endsection