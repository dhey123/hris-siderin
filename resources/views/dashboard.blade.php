@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- ================= HEADER ================= --}}
<div class="flex justify-between items-center">

    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Dashboard HRIS
        </h1>
        <p class="text-sm text-gray-500">
            Overview data karyawan & aktivitas HR
        </p>
    </div>

    <!-- DATE -->
    <div class="text-right"
         x-data="{ now: new Date(), tick() { this.now = new Date() } }"
         x-init="setInterval(() => tick(), 60000)">

        <div class="text-xs text-gray-500"
             x-text="now.toLocaleDateString('id-ID', {
                weekday:'short', day:'numeric', month:'short'
             })">
        </div>

        <div class="text-sm font-semibold text-gray-700"
             x-text="now.toLocaleTimeString('id-ID', {
                hour:'2-digit', minute:'2-digit'
             })">
        </div>

    </div>

</div>
    {{-- ================= KPI ================= --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">

        @php
            $kpis = [
                ['label' => 'Total Karyawan', 'value' => $total_employee ?? 0, 'color' => 'text-gray-800'],
                ['label' => 'Staff', 'value' => $staff ?? 0, 'color' => 'text-green-600'],
                ['label' => 'Produksi', 'value' => $produksi ?? 0, 'color' => 'text-blue-600'],
                ['label' => 'Borongan', 'value' => $borongan ?? 0, 'color' => 'text-yellow-600'],
                ['label' => 'Nonaktif', 'value' => $resign ?? 0, 'color' => 'text-gray-500'],
            ];
        @endphp

        @foreach($kpis as $kpi)
            <div class="bg-white p-4 rounded-2xl shadow-sm border">
                <p class="text-xs text-gray-500">{{ $kpi['label'] }}</p>
                <p class="text-xl font-bold {{ $kpi['color'] }}">
                    {{ $kpi['value'] }}
                </p>
            </div>
        @endforeach
    </div>

    {{-- ================= KONTRAK ================= --}}
    <div class="bg-white rounded-2xl shadow-sm border p-5">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-sm font-semibold text-gray-700">
                Kontrak Karyawan
            </h3>
            <span class="text-xs text-gray-400">≤30 hari & expired</span>
        </div>

        <div class="bg-red-50 p-3 rounded-xl border">
            <p class="text-xs text-red-600">Akan Berakhir</p>
            <p class="text-lg font-bold text-red-700">
                {{ $kontrak_habis ?? 0 }}
            </p>
        </div>
    </div>

   {{-- ================= MAIN GRID (3 KOLOM SEJARAH) ================= --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">

    {{-- ================= KOLOM 1: RECRUITMENT ================= --}}
    <div class="bg-white rounded-2xl shadow-sm border p-5 flex flex-col h-full">

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-sm font-semibold text-gray-700">
                Recruitment Alerts ({{ count($interviewToday ?? []) }})
            </h3>
            <span class="text-xs text-gray-400">Realtime</span>
        </div>

        <div class="space-y-4 flex-1 overflow-auto">

            {{-- TODAY --}}
            <div>
                <p class="text-xs font-semibold text-purple-600 mb-2 uppercase">
                    Hari Ini
                </p>

                @forelse($interviewToday ?? [] as $applicant)
                    <div class="flex justify-between items-center py-2 border-b last:border-none">
                        <div>
                            <p class="text-sm font-medium text-gray-800">
                                {{ $applicant->name }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $applicant->position }}
                            </p>
                        </div>

                        <span class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded">
                            {{ \Carbon\Carbon::parse($applicant->interview_date)->format('H:i') }}
                        </span>
                    </div>
                @empty
                    <p class="text-xs text-gray-400">Tidak ada</p>
                @endforelse
            </div>

            {{-- TOMORROW --}}
            <div>
                <p class="text-xs font-semibold text-blue-600 mb-2 uppercase">
                    Besok
                </p>

                @forelse($interviewTomorrow ?? [] as $applicant)
                    <div class="flex justify-between items-center py-2 border-b last:border-none">
                        <span class="text-sm text-gray-700">
                            {{ $applicant->name }}
                        </span>

                        <span class="text-xs text-gray-500">
                            {{ \Carbon\Carbon::parse($applicant->interview_date)->format('d M • H:i') }}
                        </span>
                    </div>
                @empty
                    <p class="text-xs text-gray-400">Tidak ada</p>
                @endforelse
            </div>

            {{-- FOLLOW UP --}}
            <div>
                <p class="text-xs font-semibold text-red-600 mb-2 uppercase">
                    Follow Up
                </p>

                @forelse($overdue ?? [] as $applicant)
                    <div class="flex justify-between items-center py-2 border-b last:border-none">
                        <span class="text-sm text-gray-700">
                            {{ $applicant->name }}
                        </span>

                        <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded">
                            {{ $applicant->created_at->diffForHumans() }}
                        </span>
                    </div>
                @empty
                    <p class="text-xs text-gray-400">Aman 👍</p>
                @endforelse
            </div>

        </div>
    </div>

    {{-- ================= KOLOM 2: SUMMARY ================= --}}
    <div class="bg-white rounded-2xl shadow-sm border p-5 flex flex-col h-full">

        <h3 class="text-sm font-semibold text-gray-600 mb-4 uppercase">
            Ringkasan
        </h3>

        <ul class="text-sm space-y-3 flex-1">
            <li class="flex justify-between">
                <span>Total</span>
                <strong>{{ $total_employee ?? 0 }}</strong>
            </li>

            <li class="flex justify-between">
                <span>Staff</span>
                <strong class="text-green-600">{{ $staff ?? 0 }}</strong>
            </li>

            <li class="flex justify-between">
                <span>Produksi</span>
                <strong class="text-blue-600">{{ $produksi ?? 0 }}</strong>
            </li>

            <li class="flex justify-between">
                <span>Borongan</span>
                <strong class="text-yellow-600">{{ $borongan ?? 0 }}</strong>
            </li>

            <li class="flex justify-between">
                <span>Nonaktif</span>
                <strong class="text-gray-500">{{ $resign ?? 0 }}</strong>
            </li>
        </ul>

    </div>

    {{-- ================= KOLOM 3: QUICK ACTION ================= --}}
    <div class="bg-white rounded-2xl shadow-sm border p-5 flex flex-col h-full">

        <h3 class="text-sm font-semibold text-gray-600 mb-4 uppercase">
            Quick Action
        </h3>

        <div class="flex flex-col gap-2 text-sm flex-1">

            <a href="{{ route('recruitment.offline.create') }}"
               class="bg-blue-500 text-white px-3 py-2 rounded text-center hover:bg-blue-600">
                + Tambah Kandidat
            </a>

            <a href="{{ route('recruitment.applicants.index') }}"
               class="bg-purple-500 text-white px-3 py-2 rounded text-center hover:bg-purple-600">
                Lihat Pelamar
            </a>

            <a href="{{ route('recruitment.jobs.create') }}"
               class="bg-green-500 text-white px-3 py-2 rounded text-center hover:bg-green-600">
                + Buat Lowongan
            </a>

            <a href="#"
               class="bg-orange-500 text-white px-3 py-2 rounded text-center hover:bg-orange-600">
                Perpanjang Kontrak
            </a>

            <a href="#"
               class="bg-gray-700 text-white px-3 py-2 rounded text-center hover:bg-gray-800">
                Data Karyawan
            </a>

        </div>

    </div>

</div>
</div>
</div>
@endsection