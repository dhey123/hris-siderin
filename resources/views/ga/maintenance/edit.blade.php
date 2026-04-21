@extends('layouts.app')

@section('content')
<div class="p-6 max-w-xl">

    <h1 class="text-2xl font-bold mb-4">Edit Maintenance</h1>

    <form action="{{ route('ga.maintenance.update', $maintenance->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- ASSET --}}
        <div class="mb-3">
            <label class="text-sm">Asset</label>
            <select name="asset_id" class="w-full border p-2 rounded">
                @foreach($assets as $asset)
                    <option value="{{ $asset->id }}"
                        {{ $maintenance->asset_id == $asset->id ? 'selected' : '' }}>
                        {{ $asset->asset_code }} - {{ $asset->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- MASALAH --}}
        <div class="mb-3">
            <label class="text-sm">Masalah</label>
            <input type="text" name="title"
                   value="{{ $maintenance->title }}"
                   class="w-full border p-2 rounded">
        </div>

        {{-- DESKRIPSI --}}
        <div class="mb-3">
            <label class="text-sm">Deskripsi</label>
            <textarea name="description"
                class="w-full border p-2 rounded">{{ $maintenance->description }}</textarea>
        </div>

        {{-- STATUS --}}
        <div class="mb-3">
            <label class="text-sm">Status</label>
            <select name="status" class="w-full border p-2 rounded">
                <option value="pending" {{ $maintenance->status == 'pending' ? 'selected' : '' }}>
                    Tunda
                </option>
                <option value="process" {{ $maintenance->status == 'process' ? 'selected' : '' }}>
                    Process
                </option>
                <option value="done" {{ $maintenance->status == 'done' ? 'selected' : '' }}>
                    Selesai
                </option>
            </select>
        </div>

        <div class="flex justify-between mt-4">
            <a href="{{ route('ga.maintenance.index') }}"
               class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                Kembali
            </a>

            <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Update
            </button>
        </div>

    </form>

</div>
@endsection