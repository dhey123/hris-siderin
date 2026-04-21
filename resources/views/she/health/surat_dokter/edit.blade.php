@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">

    <h1 class="text-2xl font-bold">Edit Surat Dokter</h1>

    {{-- Error Validation --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('she.health.surat-dokter.update', $suratDokter->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        {{-- Karyawan --}}
        <div>
            <label class="block font-medium">Karyawan</label>
            <select name="employee_id" class="w-full border p-2 rounded" required>
                <option value="">-- Pilih Karyawan --</option>
                @foreach($employees as $emp)
                    {{-- Jika $employees array pakai $emp['id'], jika collection pakai $emp->id --}}
                    <option value="{{ is_array($emp) ? $emp['id'] : $emp->id }}"
                        {{ $suratDokter->employee_id == (is_array($emp) ? $emp['id'] : $emp->id) ? 'selected' : '' }}>
                        {{ is_array($emp) ? $emp['full_name'] : $emp->full_name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tanggal Surat --}}
        <div>
            <label class="block font-medium">Tanggal Surat</label>
            <input type="date" name="tanggal_surat" value="{{ $suratDokter->tanggal_surat->format('Y-m-d') }}" class="w-full border p-2 rounded" required>
        </div>

        {{-- Diagnosa --}}
        <div>
            <label class="block font-medium">Diagnosa</label>
            <input type="text" name="diagnosa" value="{{ $suratDokter->diagnosa }}" class="w-full border p-2 rounded" required>
        </div>

        {{-- Hari Istirahat --}}
        <div>
            <label class="block font-medium">Hari Istirahat</label>
            <input type="number" name="hari_istirahat" value="{{ $suratDokter->hari_istirahat }}" class="w-full border p-2 rounded" required>
        </div>

        {{-- Tanggal Mulai & Selesai --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-medium">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" value="{{ $suratDokter->tanggal_mulai->format('Y-m-d') }}" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block font-medium">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" value="{{ $suratDokter->tanggal_selesai->format('Y-m-d') }}" class="w-full border p-2 rounded" required>
            </div>
        </div>

        {{-- Nama Dokter --}}
        <div>
            <label class="block font-medium">Nama Dokter</label>
            <input type="text" name="nama_dokter" value="{{ $suratDokter->nama_dokter }}" class="w-full border p-2 rounded" required>
        </div>

        {{-- Klinik --}}
        <div>
            <label class="block font-medium">Klinik</label>
            <input type="text" name="klinik" value="{{ $suratDokter->klinik }}" class="w-full border p-2 rounded" required>
        </div>

        {{-- File Surat --}}
        <div>
            <label class="block font-medium">File Surat (PDF/JPG/PNG)</label>
            @if($suratDokter->file_surat)
                <p class="mb-2">
                    <a href="{{ asset('storage/' . $suratDokter->file_surat) }}" target="_blank" class="text-blue-600 hover:underline">
                        Lihat File Lama
                    </a>
                </p>
            @endif
            <input type="file" name="file_surat" class="w-full border p-2 rounded">
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end">
            <a href="{{ route('she.health.surat-dokter.index') }}" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 mr-2">Batal</a>
            <button type="submit" class="px-4 py-2 rounded bg-yellow-600 text-white hover:bg-yellow-700">Update</button>
        </div>
    </form>
</div>
@endsection
