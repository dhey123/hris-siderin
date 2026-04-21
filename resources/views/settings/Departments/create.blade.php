@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Tambah Department</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('settings.departments.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-2">Nama Department</label>
            <input type="text" name="name" class="border px-3 py-2 w-full rounded" value="{{ old('name') }}" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        <a href="{{ route('settings.departments.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded">Kembali</a>
    </form>
</div>
@endsection
