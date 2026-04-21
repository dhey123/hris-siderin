@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Edit Department</h1>

    <!-- Validasi Error -->
    @if($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Edit Department -->
    <form action="{{ route('settings.departments.update', $department->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="department_name" class="block mb-2 font-medium text-gray-700">Nama Department</label>
            <input type="text" name="department_name" id="department_name"
                   class="border px-3 py-2 w-full rounded"
                   value="{{ old('department_name', $department->department_name) }}" 
                   required>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Simpan
            </button>
            <a href="{{ route('settings.departments.index') }}" 
               class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">
               Kembali
            </a>
        </div>
    </form>
</div>
@endsection
