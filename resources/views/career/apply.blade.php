@extends('layouts.public')

@section('content')
<div class="container mx-auto py-6 max-w-lg">

    <h1 class="text-2xl font-bold mb-4">Lamar: {{ $job->title }}</h1>

    @if(session('success'))
        <div class="p-3 mb-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('career.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <input type="hidden" name="job_id" value="{{ $job->id }}">

        <div>
            <label class="block font-medium mb-1">
                Nama Lengkap <span class="text-red-500">*</span>
            </label>
            <input type="text" name="name" required
                class="w-full border rounded-lg px-3 py-2"
                placeholder="Nama pelamar">
        </div>

        <div>
    <label class="block text-sm font-medium">NIK</label>
    <input type="text" name="nik"
           value="{{ old('nik') }}"
           class="border rounded px-3 py-2 w-full"
           required
           maxlength="20"
           placeholder="Masukkan NIK">
</div>


        {{-- Email (Opsional) --}}
        <div>
            <label class="block font-medium mb-1">
                Email <span class="text-gray-400">(Opsional)</span>
            </label>
            <input type="email" name="email"
                class="w-full border rounded-lg px-3 py-2"
                placeholder="email@contoh.com">
        </div>

        {{-- No HP --}}
        <div>
            <label class="block font-medium mb-1">No. HP</label>
            <input type="text" name="phone"
                class="w-full border rounded-lg px-3 py-2"
                placeholder="08xxxxxxxx">
        </div>

        {{-- CV --}}
        <div>
            <label class="block font-medium mb-1">
                Upload CV <span class="text-gray-400">(Opsional)</span>
            </label>
            <input type="file" name="cv"
                class="w-full border rounded-lg px-3 py-2">
        </div>

       
        </div>

        {{-- Submit --}}
        <div class="flex justify-end gap-2">
            <a href="{{ route('career.index') }}"
               class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                Kembali
            </a>

            <button type="submit"
                class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Kirim Lamaran
            </button>
        </div>

    </form>
</div>
@endsection
