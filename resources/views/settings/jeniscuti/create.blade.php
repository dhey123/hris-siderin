@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">Tambah Jenis Cuti / Izin</h1>

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('settings.jeniscuti.store') }}" method="POST" class="space-y-4">
        @csrf

        {{-- NAMA --}}
        <div>
            <label class="block font-semibold mb-1">Nama</label>
            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   class="w-full border rounded px-3 py-2"
                   placeholder="Contoh: Cuti Tahunan"
                   required>
        </div>

        {{-- KATEGORI --}}
        <div>
            <label class="block font-semibold mb-1">Kategori</label>
            <select name="category" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Pilih --</option>
                <option value="cuti" {{ old('category')=='cuti' ? 'selected' : '' }}>Cuti</option>
                <option value="izin" {{ old('category')=='izin' ? 'selected' : '' }}>Izin</option>
            </select>
        </div>

        {{-- KUOTA --}}
        <div>
            <label class="block font-semibold mb-1">
                Kuota (hari)
                <span class="text-sm text-gray-500">(kosongkan jika izin)</span>
            </label>
            <input type="number"
                   name="default_quota"
                   value="{{ old('default_quota') }}"
                   class="w-full border rounded px-3 py-2"
                   placeholder="Contoh: 12">
        </div>

        {{-- DIBAYAR --}}
        <div class="flex items-center gap-2">
            <input type="checkbox"
                   name="is_paid"
                   value="1"
                   {{ old('is_paid', 1) ? 'checked' : '' }}>
            <label>Dibayar</label>
        </div>

        {{-- STATUS --}}
        <div class="flex items-center gap-2">
            <input type="checkbox"
                   name="is_active"
                   value="1"
                   {{ old('is_active', 1) ? 'checked' : '' }}>
            <label>Aktif</label>
        </div>

        {{-- ACTION --}}
        <div class="flex gap-3 pt-4">
            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Simpan
            </button>

            <a href="{{ route('settings.jeniscuti.index') }}"
               class="bg-gray-300 px-4 py-2 rounded">
                Batal
            </a>
        </div>

    </form>
</div>
@endsection
