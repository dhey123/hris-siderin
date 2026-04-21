@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">

    <h1 class="text-2xl font-bold">
        Tanggap Darurat - {{ $risk->nama_risiko }}
    </h1>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    {{-- JIKA SUDAH ADA RENCANA --}}
    @if($risk->emergencyPlan)

        <div class="bg-green-50 p-5 rounded border space-y-3">
            <div>
                <p class="font-semibold">Rencana Darurat</p>
                <p class="whitespace-pre-line">{{ $risk->emergencyPlan->rencana }}</p>
            </div>

            <div>
                <p class="font-semibold">Contact Person</p>
                <p>{{ $risk->emergencyPlan->contact_person ?? '-' }}</p>
            </div>

            <div>
                <p class="font-semibold">Catatan</p>
                <p class="whitespace-pre-line">{{ $risk->emergencyPlan->catatan ?? '-' }}</p>
            </div>

            <div class="flex gap-3 mt-4">
                <a href="{{ route('she.risk.tanggap-darurat.edit', $risk->id) }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                   Edit
                </a>

                <form action="{{ route('she.risk.tanggap-darurat.destroy', $risk->id) }}"
                      method="POST"
                      onsubmit="return confirm('Yakin hapus rencana ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        Hapus
                    </button>
                </form>
            </div>
        </div>

    {{-- JIKA BELUM ADA --}}
    @else

        <div class="bg-gray-50 p-5 rounded border">
            <h2 class="text-lg font-semibold mb-4">
                Tambah Rencana Tanggap Darurat
            </h2>

            <form action="{{ route('she.risk.tanggap-darurat.store', $risk->id) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block font-medium">Rencana Darurat</label>
                    <textarea name="rencana_darurat"
                              class="w-full border rounded p-2"
                              required>{{ old('rencana_darurat') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Contact Person</label>
                    <input type="text"
                           name="contact_person"
                           value="{{ old('contact_person') }}"
                           class="w-full border rounded p-2">
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Catatan</label>
                    <textarea name="catatan"
                              class="w-full border rounded p-2">{{ old('catatan') }}</textarea>
                </div>

                <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Simpan
                </button>
            </form>
        </div>

    @endif

</div>
@endsection