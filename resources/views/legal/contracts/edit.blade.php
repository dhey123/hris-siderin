@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-8">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Edit Kontrak & Perjanjian</h2>
        <a href="{{ route('legal.contracts.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
            Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('legal.contracts.update', $contract->id) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded p-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block text-gray-700 font-medium mb-1">Nomor Kontrak</label>
                <input type="text" name="nomor_kontrak" value="{{ old('nomor_kontrak', $contract->nomor_kontrak) }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Nama Kontrak</label>
                <input type="text" name="nama_kontrak" value="{{ old('nama_kontrak', $contract->nama_kontrak) }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Vendor</label>
                <select name="vendor_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Pilih Vendor --</option>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->id }}" {{ (old('vendor_id', $contract->vendor_id) == $vendor->id) ? 'selected' : '' }}>
                            {{ $vendor->nama_vendor }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Jenis</label>
                <select name="jenis_kontrak_id" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">-- Pilih Jenis Kontrak --</option>
                            @foreach($jenisList as $jenis)
                            <option value="{{ $jenis->id }}"
                            {{ old('jenis_kontrak_id', $contract->jenis_kontrak_id) == $jenis->id ? 'selected' : '' }}>
                            {{ $jenis->nama_jenis }}
                            </option>
                            @endforeach

                            </select>
                                        </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Nilai Kontrak</label>
                <input type="number" step="0.01" name="nilai_kontrak" value="{{ old('nilai_kontrak', $contract->nilai_kontrak) }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $contract->tanggal_mulai) }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Tanggal Berakhir</label>
                <input type="date" name="tanggal_berakhir" value="{{ old('tanggal_berakhir', $contract->tanggal_berakhir) }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="md:col-span-2">
                <label class="block text-gray-700 font-medium mb-1">File Kontrak (PDF/Doc)</label>
                <input type="file" name="file_path"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                @if($contract->file_path)
                    <p class="text-sm text-gray-500 mt-1">File saat ini: <a href="{{ asset('storage/'.$contract->file_path) }}" target="_blank" class="underline text-blue-600">{{ $contract->file_path }}</a></p>
                @endif
            </div>

        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('legal.contracts.index') }}" class="px-4 py-2 border rounded hover:bg-gray-100 transition">Batal</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-medium rounded hover:bg-blue-700 transition">Update</button>
        </div>

    </form>

</div>
@endsection