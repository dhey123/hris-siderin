@extends('layouts.app')

@section('title', 'Lamaran Offline')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow">

    <h2 class="text-xl font-semibold mb-6">
        Form Lamaran Offline
    </h2>

    {{-- Alert --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error --}}
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form 
        action="{{ route('recruitment.offline.store') }}" 
        method="POST" 
        enctype="multipart/form-data"
        class="space-y-5"
    >
        @csrf

        {{-- Lowongan --}}
        <div>
            <label class="block font-medium mb-1">Lowongan</label>
            <select name="job_id" required
                class="w-full border rounded-lg px-3 py-2">
                <option value="">Pilih Lowongan</option>
                @foreach ($jobs as $job)
                    <option value="{{ $job->id }}">
                        {{ $job->title }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Nama --}}
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

        {{-- Referral --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium mb-1">
                    Nama Pemberi Rekomendasi
                </label>
                <input type="text" name="referral_name"
                    class="w-full border rounded-lg px-3 py-2"
                    placeholder="Nama karyawan / kerabat">
            </div>

            <div>
                <label class="block font-medium mb-1">
                    Hubungan
                </label>
                <select name="referral_relation"
                    class="w-full border rounded-lg px-3 py-2">
                    <option value="">Pilih</option>
                    <option value="internal">Internal</option>
                    <option value="kerabat">Kerabat</option>
                    <option value="teman">Teman</option>
                    <option value="walk-in">Walk-in</option>
                </select>
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex justify-end gap-2">
            <a href="{{ route('recruitment.applicants.index') }}"
               class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                Batal
            </a>

            <button type="submit"
                class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Simpan Lamaran
            </button>
        </div>

    </form>
</div>
@endsection
