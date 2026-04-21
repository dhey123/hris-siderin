@extends('layouts.app')

@section('content')
<div class="mx-auto space-y-6">

    <!-- DATE HEADER -->
    <div class="bg-white border rounded-2xl px-4 py-3 shadow-sm flex justify-between items-center"
         x-data="{ now: new Date(), update() { this.now = new Date() } }"
         x-init="setInterval(() => update(), 1000)">

        <div>
            <div class="text-sm font-semibold text-gray-700"
                 x-text="now.toLocaleDateString('id-ID', { weekday:'short', day:'numeric', month:'short', year:'numeric' })">
            </div>
            <div class="text-xs text-gray-500">HR Dashboard</div>
        </div>

        <div class="text-sm font-mono text-gray-600"
             x-text="now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second:'2-digit' })">
        </div>
    </div>

    <h1 class="text-xl font-bold text-gray-800">
        Dashboard HRIS
    </h1>

    {{-- ================= KPI ================= --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">

        <div class="bg-white p-4 rounded-2xl shadow-sm border">
            <p class="text-xs text-gray-500">Total Karyawan</p>
            <p class="text-xl font-bold text-gray-800">{{ $total_employee ?? 0 }}</p>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border">
            <p class="text-xs text-gray-500">Staff</p>
            <p class="text-xl font-bold text-green-600">{{ $staff ?? 0 }}</p>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border">
            <p class="text-xs text-gray-500">Produksi</p>
            <p class="text-xl font-bold text-blue-600">{{ $produksi ?? 0 }}</p>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border">
            <p class="text-xs text-gray-500">Borongan</p>
            <p class="text-xl font-bold text-yellow-600">{{ $borongan ?? 0 }}</p>
        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border">
            <p class="text-xs text-gray-500">Nonaktif</p>
            <p class="text-xl font-bold text-gray-500">{{ $resign ?? 0 }}</p>
        </div>

    </div>

    {{-- 📄 KONTRAK --}}
    <div class="bg-white rounded-2xl shadow-sm border p-5">

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-sm font-semibold text-gray-700">
                Kontrak Karyawan
            </h3>
            <span class="text-xs text-gray-400">≤30 hari & expired</span>
        </div>

            <div class="bg-red-50 p-3 rounded-xl border">
                <p class="text-xs text-red-600">Akan Berakhir</p>
                <p class="text-lg font-bold text-red-700">{{ $kontrak_habis ?? 0 }}</p>
            </div>
    </div>

   {{-- ================= MAIN GRID ================= --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">

    <!-- ================= LEFT ================= -->
    <div class="md:col-span-2 flex flex-col">

        {{-- 🔔 RECRUITMENT ALERT --}}
        <div class="bg-white rounded-2xl shadow-sm border p-5 space-y-5 flex-1">

            <div class="flex justify-between items-center">
                <h3 class="text-sm font-semibold text-gray-700">
                    Recruitment Alerts ({{ count($interviewToday ?? []) }})
                </h3>
                <span class="text-xs text-gray-400">Realtime</span>
            </div>

            {{-- TODAY --}}
            <div>
                <p class="text-xs font-semibold text-purple-600 mb-2 uppercase tracking-wide">
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
                            {{ \Carbon\Carbon::parse($applicant->interview_date)->translatedFormat('H:i') }}
                        </span>
                    </div>
                @empty
                    <p class="text-xs text-gray-400">Tidak ada</p>
                @endforelse
            </div>

            {{-- BESOK --}}
            <div>
                <p class="text-xs font-semibold text-blue-600 mb-2 uppercase tracking-wide">
                    Besok
                </p>

                @forelse($interviewTomorrow ?? [] as $applicant)
                    <div class="flex justify-between items-center py-2 border-b last:border-none">
                        <span class="text-sm text-gray-700">
                            {{ $applicant->name }}
                        </span>

                        <span class="text-xs text-gray-500">
                            {{ \Carbon\Carbon::parse($applicant->interview_date)->translatedFormat('d M • H:i') }}
                        </span>
                    </div>
                @empty
                    <p class="text-xs text-gray-400">Tidak ada</p>
                @endforelse
            </div>

            {{-- FOLLOW UP --}}
            <div>
                <p class="text-xs font-semibold text-red-600 mb-2 uppercase tracking-wide">
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

    <!-- ================= RIGHT ================= -->
    <div class="flex flex-col gap-4 h-full">

        {{-- SUMMARY --}}
        <div class="bg-white rounded-2xl shadow-sm border p-4 flex-1">
            <h3 class="text-sm font-semibold text-gray-600 mb-3 uppercase">
                Ringkasan
            </h3>

            <ul class="text-sm space-y-2">
                <li>Total: <strong>{{ $total_employee ?? 0 }}</strong></li>
                <li>Staff: <strong class="text-green-600">{{ $staff ?? 0 }}</strong></li>
                <li>Produksi: <strong class="text-blue-600">{{ $produksi ?? 0 }}</strong></li>
                <li>Borongan: <strong class="text-yellow-600">{{ $borongan ?? 0 }}</strong></li>
                <li>Nonaktif: <strong class="text-gray-500">{{ $resign ?? 0 }}</strong></li>
            </ul>
        </div>

        {{-- QUICK ACTION --}}
        <div class="bg-white rounded-2xl shadow-sm border p-4 flex-1">
            <h3 class="text-sm font-semibold text-gray-600 mb-3 uppercase">
                Quick Action
            </h3>

            <div class="flex flex-col gap-2 text-sm">

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
@endsection