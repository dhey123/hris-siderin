@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Edit Perusahaan</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('settings.companies.update', $company->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block mb-1">Nama Perusahaan</label>
            <input type="text" name="company_name" value="{{ old('company_name', $company->company_name) }}" class="border rounded px-2 py-1 w-full" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Simpan</button>
        <a href="{{ route('settings.companies.index') }}" class="bg-gray-300 px-3 py-1 rounded ml-2">Batal</a>
    </form>
</div>
@endsection
