@extends('layouts.app')

@section('content')
<div class="space-y-6">

   {{-- BREADCRUMB + HEADER --}}
<div class="mb-6">
    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-500 mb-2" aria-label="Breadcrumb">
        <ol class="list-reset flex">
            <li>
                <a href="{{ route('she.safety.index') }}" class="hover:underline font-medium">
                   
                </a>
            </li>
        </ol>
    </nav>

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Safety</h1>
        <p class="text-sm text-gray-500">Modul keselamatan kerja & K3</p>
    </div>
</div>


    {{-- CARD GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- INSIDEN --}}
        <a href="{{ route('she.safety.insiden.index') }}"
           class="group bg-white rounded-xl shadow hover:shadow-lg p-6 border transition">
            <div class="flex items-center gap-4">
                <div class="bg-red-100 text-red-600 p-3 rounded-lg">
                    <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-red-600">Insiden Kerja</h3>
                    <p class="text-sm text-gray-500">Catatan kecelakaan & insiden kerja</p>
                </div>
            </div>
        </a>

        {{-- APD --}}
        <a href="{{ route('she.safety.apd.list') }}"
           class="group bg-white rounded-xl shadow hover:shadow-lg p-6 border transition">
            <div class="flex items-center gap-4">
                <div class="bg-blue-100 text-blue-600 p-3 rounded-lg">
                    <i class="fa-solid fa-helmet-safety text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-blue-600">APD</h3>
                    <p class="text-sm text-gray-500">Alat Pelindung Diri karyawan</p>
                </div>
            </div>
        </a>

        {{-- PELATIHAN --}}
        <a href="{{ route('she.safety.pelatihan.index') }}"
           class="group bg-white rounded-xl shadow hover:shadow-lg p-6 border transition">
            <div class="flex items-center gap-4">
                <div class="bg-green-100 text-green-600 p-3 rounded-lg">
                    <i class="fa-solid fa-chalkboard-user text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-green-600">Pelatihan K3</h3>
                    <p class="text-sm text-gray-500">Riwayat & jadwal pelatihan keselamatan</p>
                </div>
            </div>
        </a>

        {{-- APK --}}
        <a href="{{ route('she.safety.apk.index') }}"
           class="group bg-white rounded-xl shadow hover:shadow-lg p-6 border transition">
            <div class="flex items-center gap-4">
                <div class="bg-blue-100 text-green-600 p-3 rounded-lg">
                    <i class="fa-solid fa-helmet-safety text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-blue-600">APK</h3>
                    <p class="text-sm text-gray-500">Alat Pelindung Keselamatan</p>
                </div>
            </div>
        </a>

    </div>

</div>
@endsection
