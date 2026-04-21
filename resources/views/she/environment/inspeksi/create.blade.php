@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto bg-white p-8 rounded-2xl shadow-lg space-y-6">

    {{-- ================= ERROR ALERT ================= --}}
    @if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg">
        <div class="font-semibold mb-2">Terjadi kesalahan:</div>
        <ul class="list-disc list-inside text-sm space-y-1">
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- ================= HEADER ================= --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Tambah Inspeksi
        </h1>
        <p class="text-sm text-gray-500">
            Silakan isi data inspeksi dan checklist di bawah ini
        </p>
    </div>

    <form action="{{ route('she.environment.inspeksi.store') }}" method="POST">
    @csrf

    {{-- ================= FORM HEADER ================= --}}
    <div class="grid md:grid-cols-3 gap-6">

        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
                Tanggal
            </label>
            <input type="date" 
                   name="tanggal"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                   required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
                Area
            </label>
            <input type="text" 
                   name="area"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                   placeholder="Contoh: Gudang Produksi"
                   required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
                Jenis Inspeksi
            </label>
            <input type="text" 
                   name="jenis"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                   placeholder="Contoh: Rutin / Bulanan"
                   required>
        </div>

    </div>

    {{-- ================= TABLE ================= --}}
    <div class="mt-8">
        <h2 class="text-lg font-semibold text-gray-700 mb-3">
            Checklist Inspeksi
        </h2>

        <div class="overflow-x-auto border border-gray-200 rounded-xl">
            <table class="min-w-full text-sm text-gray-700">

                <thead class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-3 py-3 text-center w-12">No</th>
                        <th class="px-3 py-3 w-16">Kode</th>
                        <th class="px-3 py-3 w-32">Kategori</th>
                        <th class="px-3 py-3 w-64">Item</th>
                        <th class="px-3 py-3 w-64">Standar</th>
                        <th class="px-3 py-3 text-center w-32">Hasil</th>
                        <th class="px-3 py-3 w-56">Keterangan</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">

                @foreach($checklists as $i => $check)
                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-3 py-3 text-center font-medium">
                            {{ $i+1 }}
                        </td>

                        <td class="px-3 py-3 font-semibold text-gray-600">
                            {{ $check->kode }}
                        </td>

                        <td class="px-3 py-3">
                            {{ $check->kategori }}
                        </td>

                        <td class="px-3 py-3">
                            {{ $check->item }}
                        </td>

                        <td class="px-3 py-3 text-gray-600">
                            {{ $check->standar }}
                        </td>

                        {{-- RADIO OK / NG --}}
                        <td class="px-3 py-3 text-center">
                            <div class="flex justify-center gap-6">

                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio"
                                           name="hasil[{{ $check->id }}]"
                                           value="OK"
                                           class="text-green-600 focus:ring-green-500">
                                    <span class="text-green-600 font-medium">OK</span>
                                </label>

                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio"
                                           name="hasil[{{ $check->id }}]"
                                           value="NG"
                                           class="text-red-600 focus:ring-red-500">
                                    <span class="text-red-600 font-medium">NO</span>
                                </label>

                            </div>
                        </td>

                        <td class="px-3 py-3">
                            <input type="text"
                                   name="keterangan[{{ $check->id }}]"
                                   class="w-full border border-gray-300 rounded-lg px-2 py-1 focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm"
                                   placeholder="Tambahkan keterangan jika perlu">
                        </td>

                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>

    {{-- ================= CATATAN ================= --}}
    <div class="mt-6">
        <label class="block text-sm font-medium text-gray-600 mb-1">
            Catatan Tambahan
        </label>
        <textarea name="catatan"
                  rows="3"
                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                  placeholder="Tambahkan catatan umum jika diperlukan..."></textarea>
    </div>

    {{-- ================= BUTTON ================= --}}
    <div class="flex justify-end gap-3 mt-6">

        <a href="{{ route('she.environment.inspeksi.index') }}"
           class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
            Kembali
        </a>

        <button type="submit"
                class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md transition">
            Simpan Inspeksi
        </button>

    </div>

    </form>
</div>
@endsection