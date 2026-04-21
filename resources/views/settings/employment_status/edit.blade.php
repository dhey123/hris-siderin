@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-8 bg-white p-6 rounded-xl shadow">
    <h3 class="text-2xl font-bold text-gray-800 mb-4">Edit Status Kerja</h3>

    <form action="{{ route('settings.employment_status.update', $employmentStatus->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="status_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Status Kerja</label>
            <input
                type="text"
                id="status_name"
                name="status_name"
                value="{{ old('status_name', $employmentStatus->status_name) }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                required
            >
            @error('status_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                Update
            </button>
        </div>

         <a href="{{ route('settings.positions.index') }}"
               class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">
                Kembali
            </a>
</div>
    </form>
</div>
@endsection
