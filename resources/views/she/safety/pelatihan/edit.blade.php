@extends('layouts.app')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Edit Pelatihan</h1>
        <p class="text-sm text-gray-500">
            Perbarui data jadwal & pelatihan keselamatan kerja
        </p>
    </div>

    {{-- Card Form --}}
    <div class="bg-white rounded-xl shadow border p-6">

        <form action="{{ route('she.safety.pelatihan.update', $pelatihan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Nama Pelatihan --}}
                <div>
                    <label class="block mb-1 font-medium">Nama Pelatihan</label>
                    <input type="text"
                           name="nama_pelatihan"
                           class="w-full border rounded p-2 @error('nama_pelatihan') border-red-500 @enderror"
                           value="{{ old('nama_pelatihan', $pelatihan->nama_pelatihan) }}"
                           required>
                    @error('nama_pelatihan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Penyelenggara</label>
                    <input
                        type="text"
                        name="penyelenggara"
                        placeholder="Internal / Vendor / Nama Lembaga"
                        class="w-full border rounded p-2"
                        value="{{ old('penyelenggara', $pelatihan->penyelenggara ?? '') }}"
                    >
                </div>

                {{-- Tanggal --}}
                <div>
                    <label class="block mb-1 font-medium">Tanggal</label>
                    <input type="date"
                           name="tanggal"
                           class="w-full border rounded p-2 @error('tanggal') border-red-500 @enderror"
                           value="{{ old('tanggal', \Carbon\Carbon::parse($pelatihan->tanggal)->format('Y-m-d')) }}"
                           required>
                    @error('tanggal')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Durasi --}}
                <div>
                    <label class="block mb-1 font-medium">Durasi</label>
                    <input type="text"
                           name="durasi"
                           class="w-full border rounded p-2 @error('durasi') border-red-500 @enderror"
                           value="{{ old('durasi', $pelatihan->durasi) }}"
                           placeholder="Contoh: 2 Jam / 1 Hari"
                           required>
                    @error('durasi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Department --}}
                <div>
                    <label class="block mb-1 font-medium">Department</label>
                    <input type="text"
                           name="department"
                           class="w-full border rounded p-2 @error('department') border-red-500 @enderror"
                           value="{{ old('department', $pelatihan->department) }}"
                           placeholder="Opsional">
                    @error('department')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="block mb-1 font-medium">Status</label>
                    <select name="status"
                            class="w-full border rounded p-2 @error('status') border-red-500 @enderror">
                        @foreach(['Jadwal dibuat','Selesai','Dibatalkan'] as $status)
                            <option value="{{ $status }}"
                                {{ old('status', $pelatihan->status) == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Keterangan --}}
            <div class="mt-6">
                <label class="block mb-1 font-medium">Keterangan</label>
                <textarea name="keterangan"
                          rows="4"
                          class="w-full border rounded p-2 @error('keterangan') border-red-500 @enderror"
                          placeholder="Catatan tambahan terkait pelatihan">{{ old('keterangan', $pelatihan->keterangan) }}</textarea>
                @error('keterangan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Action --}}
            <div class="flex gap-2 mt-6">
                <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded transition">
                    Simpan Perubahan
                </button>
                <a href="{{ route('she.safety.pelatihan.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 px-6 py-2 rounded transition">
                    Batal
                </a>
            </div>

        </form>
    </div>

</div>
@endsection
