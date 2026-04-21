@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

    <!-- HEADER -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">
            🏛 Labour & Government Dashboard
        </h1>
    </div>

    <!-- STATISTIC CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 mt-4">

        <!-- Struktur Industrial -->
        <div class="bg-gradient-to-r from-blue-100 to-blue-200 rounded-lg shadow p-4 flex items-center gap-3 border-l-4 border-blue-500 hover:shadow-lg transition">
            <span class="text-3xl">🏢</span>
            <div>
                <p class="text-sm text-gray-500">Struktur Industrial</p>
                <p class="text-2xl font-bold text-gray-800">{{ $structures ?? 0 }}</p>
            </div>
        </div>

        <!-- Hubungan Industrial -->
        <div class="bg-gradient-to-r from-green-100 to-green-200 rounded-lg shadow p-4 flex items-center gap-3 border-l-4 border-green-500 hover:shadow-lg transition">
            <span class="text-3xl">📊</span>
            <div>
                <p class="text-sm text-gray-500">Hubungan Industrial</p>
                <p class="text-2xl font-bold text-gray-800">{{ $relations ?? 0 }}</p>
            </div>
        </div>

        <!-- Kasus Karyawan -->
        <div class="bg-gradient-to-r from-yellow-100 to-yellow-200 rounded-lg shadow p-4 flex items-center gap-3 border-l-4 border-yellow-500 hover:shadow-lg transition">
            <span class="text-3xl">⚖</span>
            <div>
                <p class="text-sm text-gray-500">Kasus Karyawan</p>
                <p class="text-2xl font-bold text-gray-800">{{ $cases ?? 0 }}</p>
            </div>
        </div>

        <!-- Hubungan Pemerintah -->
        <div class="bg-gradient-to-r from-red-100 to-red-200 rounded-lg shadow p-4 flex items-center gap-3 border-l-4 border-red-500 hover:shadow-lg transition">
            <span class="text-3xl">🏛</span>
            <div>
                <p class="text-sm text-gray-500">Hubungan Pemerintah</p>
                <p class="text-2xl font-bold text-gray-800">{{ $governments ?? 0 }}</p>
            </div>
        </div>

        <!-- Kasus Pending -->
        <div class="bg-gradient-to-r from-indigo-100 to-indigo-200 rounded-lg shadow p-4 flex items-center gap-3 border-l-4 border-indigo-500 hover:shadow-lg transition">
            <span class="text-3xl">⏳</span>
            <div>
                <p class="text-sm text-gray-500">Kasus Pending</p>
                <p class="text-2xl font-bold text-gray-800">{{ $casesPending ?? 0 }}</p>
            </div>
        </div>

        <!-- Agenda Mendatang -->
        <div class="bg-gradient-to-r from-purple-100 to-purple-200 rounded-lg shadow p-4 flex items-center gap-3 border-l-4 border-purple-500 hover:shadow-lg transition">
            <span class="text-3xl">📝</span>
            <div>
                <p class="text-sm text-gray-500">Agenda Mendatang (1 Minggu)</p>
                <p class="text-2xl font-bold text-gray-800">{{ $upcomingAgenda ?? 0 }}</p>
            </div>
        </div>

    </div>

    <!-- AKTIVITAS TERBARU -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

        <!-- Kasus Karyawan Terbaru -->
        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="font-semibold text-gray-700 mb-3">⚖ Kasus Karyawan Terbaru</h2>
            @if(isset($latestCases) && count($latestCases))
                <div class="space-y-2">
                    @foreach($latestCases as $case)
                        <div class="bg-gray-50 p-3 rounded-lg flex justify-between items-center border-l-4 
                            @if($case->status == 'Pending') border-red-500
                            @elseif($case->status == 'Ongoing') border-yellow-500
                            @else border-green-500 @endif
                            hover:shadow-md transition">
                            <div>
                                <p class="font-semibold">{{ $case->structure->nama ?? $case->nama_karyawan }}</p>
                                <p class="text-sm text-gray-500">{{ $case->jenis_kasus }}</p>
                            </div>
                            <span class="px-2 py-1 rounded-full 
                                @if($case->status == 'Pending') bg-red-100 text-red-700
                                @elseif($case->status == 'Ongoing') bg-yellow-100 text-yellow-700
                                @else bg-green-100 text-green-700 @endif
                                text-sm font-semibold">
                                {{ $case->status }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 text-sm">Belum ada kasus terbaru.</p>
            @endif
        </div>

        <!-- Agenda Pemerintah Terbaru -->
        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="font-semibold text-gray-700 mb-3">🏛 Agenda Pemerintah Terbaru</h2>
            @if(isset($latestGovernment) && count($latestGovernment))
                <div class="space-y-2">
                    @foreach($latestGovernment as $gov)
                        <div class="bg-gray-50 p-3 rounded-lg flex justify-between items-center border-l-4 
                            border-blue-500 hover:shadow-md transition">
                            <div>
                                <p class="font-semibold">{{ $gov->structure->nama ?? $gov->instansi }}</p>
                                <p class="text-sm text-gray-500">{{ $gov->agenda }}</p>
                            </div>
                            <span class="px-2 py-1 rounded-full bg-indigo-100 text-indigo-700 text-sm font-semibold">
                                {{ \Carbon\Carbon::parse($gov->tanggal)->format('d-m-Y') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 text-sm">Belum ada agenda terbaru.</p>
            @endif
        </div>

    </div>

</div>

@endsection