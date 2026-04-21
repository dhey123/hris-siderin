@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">APD</h1>
        <p class="text-sm text-gray-500">
            Alat Pelindung Diri untuk keselamatan kerja
        </p>
    </div>

    {{-- CARD GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- Daftar APD --}}
        <a href="{{ route('she.safety.apd.list') }}"
           class="group bg-white rounded-xl shadow hover:shadow-lg p-6 border transition">

            <div class="flex items-center gap-4">
                <div class="bg-blue-100 text-blue-600 p-3 rounded-lg">
                    <i class="fa-solid fa-hard-hat text-xl"></i>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-blue-600">
                        Daftar APD
                    </h3>
                    <p class="text-sm text-gray-500">
                        Semua alat pelindung diri tersedia
                    </p>
                </div>
            </div>
        </a>

        {{-- Tambah APD --}}
        <a href="{{ route('she.safety.apd.create') }}"
           class="group bg-white rounded-xl shadow hover:shadow-lg p-6 border transition">

            <div class="flex items-center gap-4">
                <div class="bg-green-100 text-green-600 p-3 rounded-lg">
                    <i class="fa-solid fa-plus text-xl"></i>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-green-600">
                        Tambah APD
                    </h3>
                    <p class="text-sm text-gray-500">
                        Tambahkan alat pelindung baru
                    </p>
                </div>
            </div>
        </a>

    </div>
</div>
@endsection
