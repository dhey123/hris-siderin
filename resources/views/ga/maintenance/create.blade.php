@extends('layouts.app')

@section('content')
<div class="p-6 max-w-xl">

    <h1 class="text-xl font-bold mb-4">Lapor Maintenance</h1>

     <div class="flex justify-between mt-4">
            <a href="{{ route('ga.maintenance.index') }}"
               class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                Kembali
            </a>
        </div>


    <form action="{{ route('ga.maintenance.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Asset</label>
            <select name="asset_id" class="w-full border p-2 rounded">
                @foreach($assets as $asset)
                    <option value="{{ $asset->id }}">
                        {{ $asset->asset_code }} - {{ $asset->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="title" class="w-full border p-2 rounded">
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="w-full border p-2 rounded"></textarea>
        </div>

        <button class="px-4 py-2 bg-green-600 text-white rounded">
            Simpan
        </button>

    </form>

</div>
@endsection