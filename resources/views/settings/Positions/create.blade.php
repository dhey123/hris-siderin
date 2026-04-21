@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 max-w-xl">
    <h1 class="text-2xl font-bold mb-4">Tambah Position</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('settings.positions.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block mb-2 font-medium">Nama Position</label>
            <input type="text"
                   name="position_name"
                   value="{{ old('position_name') }}"
                   class="w-full border px-3 py-2 rounded"
                   required>
        </div>

        <div class="flex gap-2">
            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Simpan
            </button>

            <a href="{{ route('settings.positions.index') }}"
               class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection
