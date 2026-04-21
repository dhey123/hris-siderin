@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">

    @php
        $isBorongan = $data->employee->isBorongan();
    @endphp

    <!-- HEADER -->
    <div class="flex justify-between items-center">
        <h1 class="text-xl font-bold">Detail BPJS</h1>

        <a href="{{ route('labour.bpjs.index') }}"
           class="text-sm text-gray-600 hover:underline">
           ← Kembali
        </a>
    </div>

    <!-- CARD -->
    <div class="bg-white rounded-xl shadow p-6 space-y-6">

        <!-- DATA KARYAWAN -->
        <div>
            <h2 class="font-semibold text-gray-700 mb-2">Data Karyawan</h2>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>Nama: <b>{{ $data->employee->full_name }}</b></div>
                <div>NIK: {{ $data->employee->nik }}</div>
                <div>Company: {{ $data->employee->company->company_name ?? '-' }}</div>
                <div>Department: {{ $data->employee->department->department_name ?? '-' }}</div>
                <div>Posisi: {{ $data->employee->position->position_name ?? '-' }}</div>
            </div>
        </div>

        <!-- STATUS BPJS -->
        <div class="grid grid-cols-2 gap-6">

            <!-- KESEHATAN -->
            <div class="border rounded-lg p-4">
                <h3 class="font-semibold mb-2">BPJS Kesehatan</h3>

                <div class="text-sm">
                    Status:
                    @if($isBorongan)
                        <span class="text-gray-500 font-semibold">Mandiri</span>
                    @else
                        <span class="{{ $data->bpjs_kesehatan == 'paid' ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' }}">
                            {{ $data->bpjs_kesehatan == 'paid' ? 'Lunas' : 'Belum' }}
                        </span>
                    @endif
                </div>

                <div class="text-sm text-gray-500">
                    Tanggal:
                    @if($isBorongan)
                        -
                    @else
                        {{ $data->tanggal_bayar_kesehatan 
                            ? \Carbon\Carbon::parse($data->tanggal_bayar_kesehatan)->format('d M Y') 
                            : '-' }}
                    @endif
                </div>

                @if($isBorongan)
                    <div class="text-xs text-gray-400 mt-2">
                        Ditanggung pribadi (tidak dikelola perusahaan)
                    </div>
                @endif
            </div>

            <!-- TK -->
            <div class="border rounded-lg p-4">
                <h3 class="font-semibold mb-2">BPJS Ketenagakerjaan</h3>

                <div class="text-sm">
                    Status:
                    <span class="{{ $data->bpjs_ketenagakerjaan == 'paid' ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' }}">
                        {{ $data->bpjs_ketenagakerjaan == 'paid' ? 'Lunas' : 'Belum' }}
                    </span>
                </div>

                <div class="text-sm text-gray-500">
                    Tanggal:
                    {{ $data->tanggal_bayar_ketenagakerjaan 
                        ? \Carbon\Carbon::parse($data->tanggal_bayar_ketenagakerjaan)->format('d M Y') 
                        : '-' }}
                </div>
            </div>

        </div>

        <!-- FORM UPDATE -->
        <div>
            <h2 class="font-semibold text-gray-700 mb-3">Update Status</h2>

            <form action="{{ route('labour.bpjs.update', $data->id) }}" method="POST" class="flex gap-3 items-center">
                @csrf
                @method('PUT')

                {{-- BPJS KESEHATAN (HANYA STAFF) --}}
                @if(!$isBorongan)
                <select name="bpjs_kesehatan" class="border rounded px-3 py-2 text-sm">
                    <option value="paid" {{ $data->bpjs_kesehatan == 'paid' ? 'selected' : '' }}>Kes Lunas</option>
                    <option value="unpaid" {{ $data->bpjs_kesehatan == 'unpaid' ? 'selected' : '' }}>Kes Belum</option>
                </select>
                @endif

                {{-- BPJS TK (SEMUA) --}}
                <select name="bpjs_ketenagakerjaan" class="border rounded px-3 py-2 text-sm">
                    <option value="paid" {{ $data->bpjs_ketenagakerjaan == 'paid' ? 'selected' : '' }}>TK Lunas</option>
                    <option value="unpaid" {{ $data->bpjs_ketenagakerjaan == 'unpaid' ? 'selected' : '' }}>TK Belum</option>
                </select>

                <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">
                    Simpan Perubahan
                </button>
            </form>
        </div>

    </div>

</div>
@endsection