@extends('layouts.app')

@section('content')
<div class="space-y-6">

   

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Health</h1>
        <p class="text-sm text-gray-500">
            Modul Kesehatan Kerja & K3
        </p>
    </div>

    {{-- CARD GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- MCU --}}
        <a href="{{ route('she.health.mcu.index') }}"
           class="group bg-white rounded-xl shadow hover:shadow-lg p-6 border transition transform hover:-translate-y-1">

            <div class="flex items-center gap-4">
                <div class="bg-red-100 text-red-600 p-3 rounded-lg">
                    <i class="fa-solid fa-stethoscope text-xl"></i>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-red-600">
                        MCU
                    </h3>
                    <p class="text-sm text-gray-500">
                        Medical Checkup
                    </p>
                </div>
            </div>
        </a>

{{-- Kesehatan --}}
        <a href="{{ route('she.health.surat-dokter.index') }}"
        class="group bg-white rounded-xl shadow p-6 border hover:opacity-90 transition">

            <div class="flex items-center gap-4">
                <div class="bg-blue-100 text-blue-600 p-3 rounded-lg">
                    <i class="fa-solid fa-file-medical text-xl"></i>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-800">
                        Surat Dokter
                    </h3>
                    <p class="text-sm text-gray-500">
                        Kelola surat dokter & cuti sakit
                    </p>
                </div>
            </div>
        </a>


        {{-- Riwayat --}}
        <a href="{{ route('she.health.riwayat.index') }}"
           class="group bg-white rounded-xl shadow p-6 border">

            <div class="flex items-center gap-4">
                <div class="bg-green-100 text-green-600 p-3 rounded-lg">
                    <i class="fa-solid fa-file-lines text-xl"></i>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-800">
                        Laporan / Riwayat
                    </h3>
                    <p class="text-sm text-gray-500">
                        Riwayat Kesehatan
                    </p>
                </div>
            </div>
        </a>

    </div>

</div>
@endsection
