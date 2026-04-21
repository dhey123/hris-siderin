<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- VITE (Tailwind & Bootstrap dari local build) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- FONT AWESOME --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    {{-- ALPINE JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.1/cdn.min.js" defer></script>
</head>

<body class="bg-gray-100">

<style>
/* ===== SIDEBAR SECTIONING ===== */

/* Menu utama background */
nav {
    background: #f9fafb; /* soft gray */
}

/* Header tetap putih */
.sidebar-header {
    background: #ffffff;
}

/* Menu utama area */
.sidebar-main {
    background: #f0fdf4; /* very soft green */
}

/* Pengaturan area */
.sidebar-settings {
    background: #f3f4f6; /* light gray */
}

/* Hover & active polish */
nav a, nav button {
    border-radius: 0.6rem;
    transition: all 0.2s ease;
}

nav a:hover, nav button:hover {
    background-color: #dcfce7;
}

nav .ml-10 a {
    display: block;
    padding: 6px 10px;
    border-radius: 8px;
}

nav .ml-10 a:hover {
    background-color: #d1fae5;
}

nav .ml-10 p {
    margin-top: 14px;
    margin-bottom: 6px;
    letter-spacing: .08em;
}

nav .ml-10 a.active,
nav a.bg-green-100 {
    font-weight: 600;
}
</style>


{{-- SIDEBAR --}}
<div class="w-64 h-screen fixed left-0 top-0 flex flex-col text-white
    bg-gradient-to-b from-green-900 via-green-800 to-green-950 shadow-2xl">



    {{-- LOGO --}}
    <div class="sidebar-header flex flex-col items-center px-6 py-6 border-b">
        <p class="font-bold text-xl text-green-700 text-center">HRIS</p>
        <img src="{{ asset('logo.png') }}" class="h-14 w-auto mt-1 mb-2 object-contain">
    </div>

    <nav class="mt-4 flex-1 overflow-y-auto flex flex-col">

        {{-- DASHBOARD --}}
        <a href="{{ route('dashboard') }}"
           class="flex items-center px-6 py-3 font-medium
           {{ request()->is('dashboard') ? 'bg-green-100 text-green-700' : 'text-gray-700 hover:bg-green-50 hover:text-green-700' }}">
            <i class="fa-solid fa-gauge mr-3"></i> Dashboard
        </a>

        {{-- ADMIN ONLY --}}
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('users.index') }}"
                   class="flex items-center px-6 py-3 font-medium
                   {{ request()->is('users*') ? 'bg-green-100 text-green-700' : 'text-gray-700 hover:bg-green-50 hover:text-green-700' }}">
                    <i class="fa-solid fa-user-gear mr-3"></i> Manajemen HR
                </a>
            @endif
        @endauth

        {{-- DATA KARYAWAN --}}
        @php $openKaryawan = request()->is('hr/data-karyawan*'); @endphp

        <div x-data="{ open: {{ $openKaryawan ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="flex items-center w-full px-6 py-3 font-medium
                {{ $openKaryawan ? 'text-green-700 bg-green-50' : 'text-gray-700 hover:bg-green-50 hover:text-green-700' }}">
                <i class="fa-solid fa-users mr-3"></i> Data Karyawan
                <i class="fa-solid fa-chevron-down ml-auto transition" :class="open ? 'rotate-180' : ''"></i>
            </button>

            <div x-show="open" x-transition class="ml-8 mt-2 space-y-2 text-sm">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Quantum</p>

                <a href="{{ route('hr.data_karyawan', ['company'=>'Quantum','type'=>'Staff']) }}"
                   class="block pl-3 border-l-2 {{ request('company')=='Quantum' && request('type')=='Staff' ? 'border-green-600 text-green-700 font-semibold' : 'border-transparent text-gray-600 hover:border-green-400 hover:text-green-700' }}">
                    Staff ({{ $totalQuantumStaff ?? 0 }})
                </a>

                <a href="{{ route('hr.data_karyawan', ['company'=>'Quantum','type'=>'Produksi']) }}"
                   class="block pl-3 border-l-2 {{ request('company')=='Quantum' && request('type')=='Produksi' ? 'border-green-600 text-green-700 font-semibold' : 'border-transparent text-gray-600 hover:border-green-400 hover:text-green-700' }}">
                    Produksi ({{ $totalQuantumProduksi ?? 0 }})
                </a>

                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mt-3">Uniland</p>

                <a href="{{ route('hr.data_karyawan', ['company'=>'Uniland','type'=>'Staff']) }}"
                   class="block pl-3 border-l-2 {{ request('company')=='Uniland' && request('type')=='Staff' ? 'border-green-600 text-green-700 font-semibold' : 'border-transparent text-gray-600 hover:border-green-400 hover:text-green-700' }}">
                    Staff ({{ $totalUnilandStaff ?? 0 }})
                </a>

                <a href="{{ route('hr.data_karyawan', ['company'=>'Uniland','type'=>'Produksi']) }}"
                   class="block pl-3 border-l-2 {{ request('company')=='Uniland' && request('type')=='Produksi' ? 'border-green-600 text-green-700 font-semibold' : 'border-transparent text-gray-600 hover:border-green-400 hover:text-green-700' }}">
                    Produksi ({{ $totalUnilandProduksi ?? 0 }})
                </a>

                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mt-3">Borongan</p>

                <a href="{{ route('hr.data_karyawan', ['type'=>'Borongan']) }}"
                   class="block pl-3 border-l-2 {{ request('type')=='Borongan' ? 'border-green-600 text-green-700 font-semibold' : 'border-transparent text-gray-600 hover:border-green-400 hover:text-green-700' }}">
                    Borongan ({{ $totalBoronganSidebar ?? 0 }})
                </a>
            </div>
        </div>

        {{-- RECRUITMENT --}}
        <div x-data="{ open: {{ request()->is('recruitment*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-6 py-3 font-medium
                {{ request()->is('recruitment*') ? 'bg-green-100 text-green-700' : 'text-gray-700 hover:bg-green-50 hover:text-green-700' }}">
                <span class="flex items-center">
                    <i class="fa-solid fa-briefcase mr-3"></i> Recruitment
                </span>
                <i class="fa-solid fa-chevron-down text-xs"></i>
            </button>
            <div x-show="open" x-transition class="ml-10 mt-1 space-y-1">
                <a href="{{ route('recruitment.jobs.index') }}"
                   class="block px-4 py-2 rounded
                   {{ request()->is('recruitment/jobs*') ? 'bg-green-200 text-black' : 'text-black hover:bg-green-100' }}">
                    Loker
                </a>
                <a href="{{ route('recruitment.applicants.index') }}"
                   class="block px-4 py-2 rounded
                   {{ request()->is('recruitment/applicants*') ? 'bg-green-200 text-black' : 'text-black hover:bg-green-100' }}">
                    Lamaran
                </a>
                <a href="{{ route('recruitment.offline.create') }}"
                   class="block px-4 py-2 rounded
                   {{ request()->is('recruitment/offline*') ? 'bg-green-200 text-black' : 'text-black hover:bg-green-100' }}">
                    Input Lamaran Offline
                </a>
            </div>
        </div>

       {{-- CUTI & IZIN --}}
<div x-data="{ open: {{ request()->is('cuti*') ? 'true' : 'false' }} }">
    <button @click="open = !open"
        class="relative flex items-center justify-between w-full px-6 py-3 font-medium
        {{ request()->is('cuti*') ? 'bg-green-100 text-green-700' : 'text-gray-700 hover:bg-green-50 hover:text-green-700' }}">

        @if(request()->is('cuti*'))
            <span class="absolute left-0 top-0 h-full w-2 bg-green-600 rounded-r-lg"></span>
        @endif

        <div class="flex items-center">
            <i class="fa-solid fa-calendar-check mr-3"></i> Rekap Cuti/Izin
        </div>
        <i class="fa-solid fa-chevron-down text-xs transition"
           :class="{ 'rotate-180': open }"></i>
    </button>

    <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
        <a href="{{ route('cuti.request') }}"
           class="relative block px-4 py-2 rounded
           {{ request()->is('cuti/request*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">
            @if(request()->is('cuti/request*'))
                <span class="absolute left-0 top-0 h-full w-1.5 bg-green-600 rounded-r"></span>
            @endif
            Pengajuan Cuti
        </a>

        <a href="{{ route('cuti.approval') }}"
           class="relative block px-4 py-2 rounded
           {{ request()->is('cuti/approval*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">
            @if(request()->is('cuti/approval*'))
                <span class="absolute left-0 top-0 h-full w-1.5 bg-green-600 rounded-r"></span>
            @endif
            Persetujuan
        </a>

        <a href="{{ route('cuti.history') }}"
           class="relative block px-4 py-2 rounded
           {{ request()->is('cuti/history*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">
            @if(request()->is('cuti/history*'))
                <span class="absolute left-0 top-0 h-full w-1.5 bg-green-600 rounded-r"></span>
            @endif
            Riwayat
        </a>

        <a href="{{ route('cuti.balance') }}"
           class="relative block px-4 py-2 rounded
           {{ request()->is('cuti/balance*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">
            @if(request()->is('cuti/balance*'))
                <span class="absolute left-0 top-0 h-full w-1.5 bg-green-600 rounded-r"></span>
            @endif
            Sisa Cuti
        </a>
    </div>
</div>


{{-- SHE --}}
@php
    $openShe = request()->is('she*');
    $openRisk = request()->is('she/risk*');
@endphp

<div x-data="{ open: {{ $openShe ? 'true' : 'false' }} }">
    <button @click="open = !open"
        class="relative flex items-center justify-between w-full px-6 py-3 font-medium
        {{ $openShe ? 'bg-green-100 text-green-700' : 'text-gray-700 hover:bg-green-50 hover:text-green-700' }}">

        @if($openShe)
            <span class="absolute left-0 top-0 h-full w-2 bg-green-600 rounded-r-lg"></span>
        @endif

        <span class="flex items-center">
            <i class="fa-solid fa-shield-halved mr-3"></i> SHE
        </span>

        <i class="fa-solid fa-chevron-down text-xs transition"
           :class="open ? 'rotate-180' : ''"></i>
    </button>

    <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1 text-sm">

        <a href="{{ route('she.safety.index') }}"
           class="relative block px-4 py-2 rounded
           {{ request()->routeIs('she.safety.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">
            @if(request()->routeIs('she.safety.*'))
                <span class="absolute left-0 top-0 h-full w-1.5 bg-green-600 rounded-r"></span>
            @endif
            Safety
        </a>

        <a href="{{ route('she.health.index') }}"
           class="relative block px-4 py-2 rounded
           {{ request()->routeIs('she.health.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">
            @if(request()->routeIs('she.health.*'))
                <span class="absolute left-0 top-0 h-full w-1.5 bg-green-600 rounded-r"></span>
            @endif
            Health
        </a>

        <a href="{{ route('she.environment.index') }}"
           class="relative block px-4 py-2 rounded
           {{ request()->routeIs('she.environment.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">
            @if(request()->routeIs('she.environment.*'))
                <span class="absolute left-0 top-0 h-full w-1.5 bg-green-600 rounded-r"></span>
            @endif
            Environment
        </a>

{{-- ================= MANAGEMENT RISIKO ================= --}}
<div x-data="{ openRisk: {{ request()->routeIs('she.risk.*') ? 'true' : 'false' }} }">

    <button @click="openRisk = !openRisk"
        class="relative flex items-center justify-between w-full px-4 py-2 rounded
        {{ request()->routeIs('she.risk.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">

        @if(request()->routeIs('she.risk.*'))
            <span class="absolute left-0 top-0 h-full w-1.5 bg-green-600 rounded-r"></span>
        @endif

        <span class="flex items-center">
            <i class="fa-solid fa-triangle-exclamation mr-2 text-pink-500"></i>
            Management Risiko
        </span>

        <i class="fa-solid fa-chevron-down text-xs transition"
           :class="openRisk ? 'rotate-180' : ''"></i>
    </button>

    <div x-show="openRisk" x-collapse class="ml-6 mt-1 space-y-1">

        {{-- DASHBOARD --}}
        <a href="{{ route('she.risk.dashboard') }}"
           class="relative block px-3 py-2 rounded
           {{ request()->routeIs('she.risk.dashboard') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">

            @if(request()->routeIs('she.risk.dashboard'))
                <span class="absolute left-0 top-0 h-full w-1 bg-green-600 rounded-r"></span>
            @endif

            <i class="fa-solid fa-chart-simple mr-2"></i>
            Dashboard Risiko
        </a>

        {{-- IDENTIFIKASI --}}
        <a href="{{ route('she.risk.identifikasi.index') }}"
           class="relative block px-3 py-2 rounded
           {{ request()->routeIs('she.risk.identifikasi.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">

            @if(request()->routeIs('she.risk.identifikasi.*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-green-600 rounded-r"></span>
            @endif

            <i class="fa-solid fa-clipboard-list mr-2"></i>
            Identifikasi Risiko
        </a>

        {{-- GLOBAL PENILAIAN --}}
        <a href="{{ route('she.risk.penilaian.global') }}"
           class="relative block px-3 py-2 rounded
           {{ request()->routeIs('she.risk.penilaian.global') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">

            @if(request()->routeIs('she.risk.penilaian.global'))
                <span class="absolute left-0 top-0 h-full w-1 bg-green-600 rounded-r"></span>
            @endif

            <i class="fa-solid fa-clipboard-check mr-2"></i>
            Penilaian Risiko
        </a>

        {{-- GLOBAL MITIGASI --}}
        <a href="{{ route('she.risk.mitigasi.global') }}"
           class="relative block px-3 py-2 rounded
           {{ request()->routeIs('she.risk.mitigasi.global') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">

            @if(request()->routeIs('she.risk.mitigasi.global'))
                <span class="absolute left-0 top-0 h-full w-1 bg-green-600 rounded-r"></span>
            @endif

            <i class="fa-solid fa-shield-alt mr-2"></i>
            Mitigasi Risiko
        </a>

                {{-- GLOBAL TANGGAP DARURAT --}}
                <a href="{{ route('she.risk.tanggap-darurat.global') }}"
                class="relative block px-3 py-2 rounded
                {{ request()->routeIs('she.risk.tanggap-darurat.global') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">

                    @if(request()->routeIs('she.risk.tanggap-darurat.global'))
                        <span class="absolute left-0 top-0 h-full w-1 bg-green-600 rounded-r"></span>
                    @endif

                    <i class="fa-solid fa-bolt mr-2"></i>
                    Tanggap Darurat
                </a>
                {{-- STRUKTUR ORGANISASI --}}
                <p class="px-3 mt-3 text-xs font-semibold text-gray-400 uppercase">
            Referensi
        </p>
        <a href="{{ route('she.risk.referensi.struktur') }}"
        class="relative block px-3 py-2 rounded
        {{ request()->routeIs('she.risk.referensi.struktur') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">

            @if(request()->routeIs('she.risk.referensi.struktur'))
                <span class="absolute left-0 top-0 h-full w-1 bg-green-600 rounded-r"></span>
            @endif

            <i class="fa-solid fa-sitemap mr-2"></i>
            Struktur Organisasi 
        </a>

        {{-- JOB DESCRIPTION --}}
        <a href="{{ route('she.risk.referensi.job') }}"
        class="relative block px-3 py-2 rounded
        {{ request()->routeIs('she.risk.referensi.job') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">

            @if(request()->routeIs('she.risk.referensi.job'))
                <span class="absolute left-0 top-0 h-full w-1 bg-green-600 rounded-r"></span>
            @endif

            <i class="fa-solid fa-id-badge mr-2"></i>
            Job Description
        </a>
            </div> {{-- END Management Risiko --}}
            </div> 
        </div>
{{-- LEGAL --}}
@php $openLegal = request()->is('legal*'); @endphp

<div x-data="{ openLegal: {{ $openLegal ? 'true' : 'false' }} }">
    <button @click="openLegal = !openLegal"
        class="flex items-center w-full px-6 py-3 font-medium
        {{ $openLegal ? 'text-green-700 bg-green-50' : 'text-gray-700 hover:bg-green-50 hover:text-green-700' }}">
        <i class="fa-solid fa-scale-balanced mr-3"></i> Legal
        <i class="fa-solid fa-chevron-down ml-auto transition" :class="openLegal ? 'rotate-180' : ''"></i>
    </button>

    {{-- Submenu --}}
    <div x-show="openLegal" x-collapse class="ml-6 mt-1 space-y-1">

        {{-- Dashboard --}}
        <a href="{{ route('legal.index') }}"
           class="relative block px-3 py-2 rounded
           {{ request()->routeIs('legal.index') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">
            @if(request()->routeIs('legal.index'))
                <span class="absolute left-0 top-0 h-full w-1 bg-green-600 rounded-r"></span>
            @endif
            <i class="fa-solid fa-house mr-2"></i>
            Dashboard
        </a>

        {{-- Vendor --}}
        <a href="{{ route('legal.vendors.index') }}"
           class="relative block px-3 py-2 rounded
           {{ request()->routeIs('legal.vendors.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">
            @if(request()->routeIs('legal.vendors.*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-green-600 rounded-r"></span>
            @endif
            <i class="fa-solid fa-users mr-2"></i>
            Vendor
        </a>

        {{-- Dokumen --}}
        <a href="{{ route('legal.documents.index') }}"
           class="relative block px-3 py-2 rounded
           {{ request()->routeIs('legal.documents.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">
            @if(request()->routeIs('legal.documents.*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-green-600 rounded-r"></span>
            @endif
            <i class="fa-solid fa-file-alt mr-2"></i>
            Dokumen
        </a>

        {{-- Kontrak & Perjanjian --}}
        <a href="{{ route('legal.contracts.index') }}"
           class="relative block px-3 py-2 rounded
           {{ request()->routeIs('legal.contracts.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">
            @if(request()->routeIs('legal.contracts.*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-green-600 rounded-r"></span>
            @endif
            <i class="fa-solid fa-file-contract mr-2"></i>
            Kontrak & Perjanjian
        </a>

        {{-- Perizinan --}}
        <a href="{{ route('legal.permits.index') }}"
           class="relative block px-3 py-2 rounded
           {{ request()->routeIs('legal.permits.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">
            @if(request()->routeIs('legal.permits.*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-green-600 rounded-r"></span>
            @endif
            <i class="fa-solid fa-check-circle mr-2"></i>
            Perizinan
        </a>

        {{-- Compliance --}}
        <a href="{{ route('legal.compliance.index') }}"
           class="relative block px-3 py-2 rounded
           {{ request()->routeIs('legal.compliance.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">
            @if(request()->routeIs('legal.compliance.*'))
                <span class="absolute left-0 top-0 h-full w-1 bg-green-600 rounded-r"></span>
            @endif
            <i class="fa-solid fa-check-circle mr-2"></i>
            Compliance
        </a>

        {{-- Litigasi (hidden dulu) --}}
        {{-- <a href="{{ route('legal.litigation.index') }}"
           class="relative block px-3 py-2 rounded text-gray-600 hover:bg-green-50">
            <i class="fa-solid fa-gavel mr-2"></i>
            Litigasi
        </a> --}}
    </div>
</div>
        {{-- LABOUR --}}
@php $openLabour = request()->is('labour*'); @endphp

<div x-data="{ openLabour: {{ $openLabour ? 'true' : 'false' }} }">

<button @click="openLabour = !openLabour"
    class="flex items-center w-full px-6 py-3 font-medium
    {{ $openLabour ? 'text-green-700 bg-green-50' : 'text-gray-700 hover:bg-green-50 hover:text-green-700' }}">

    <i class="fa-solid fa-landmark mr-3"></i>
    Labour&Government

    <i class="fa-solid fa-chevron-down ml-auto transition"
       :class="openLabour ? 'rotate-180' : ''"></i>
</button>

<div x-show="openLabour" x-collapse class="ml-6 mt-1 space-y-1">

{{-- Dashboard --}}
<a href="{{ route('labour.index') }}"
class="relative block px-3 py-2 rounded
{{ request()->routeIs('labour.index') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">

@if(request()->routeIs('labour.index'))
<span class="absolute left-0 top-0 h-full w-1 bg-green-600 rounded-r"></span>
@endif

<i class="fa-solid fa-chart-line mr-2"></i>
Dashboard
</a>


{{-- Struktur Industrial --}}
<a href="{{ route('labour.structures.index') }}"
class="relative block px-3 py-2 rounded
{{ request()->routeIs('labour.structures.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">

@if(request()->routeIs('labour.structures.*'))
<span class="absolute left-0 top-0 h-full w-1 bg-green-600 rounded-r"></span>
@endif

<i class="fa-solid fa-sitemap mr-2"></i>
Struktur Industrial
</a>


{{-- Hubungan Industrial --}}
<a href="{{ route('labour.relations.index') }}"
class="relative block px-3 py-2 rounded
{{ request()->routeIs('labour.relations.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">

@if(request()->routeIs('labour.relations.*'))
<span class="absolute left-0 top-0 h-full w-1 bg-green-600 rounded-r"></span>
@endif

<i class="fa-solid fa-handshake mr-2"></i>
Hubungan Industrial
</a>


{{-- Kasus Karyawan --}}
<a href="{{ route('labour.cases.index') }}"
class="relative block px-3 py-2 rounded
{{ request()->routeIs('labour.cases.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">

@if(request()->routeIs('labour.cases.*'))
<span class="absolute left-0 top-0 h-full w-1 bg-green-600 rounded-r"></span>
@endif

<i class="fa-solid fa-user-shield mr-2"></i>
Kasus Karyawan
</a>


{{-- Hubungan Pemerintah --}}
<a href="{{ route('labour.government.index') }}"
class="relative block px-3 py-2 rounded
{{ request()->routeIs('labour.government.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">

@if(request()->routeIs('labour.government.*'))
<span class="absolute left-0 top-0 h-full w-1 bg-green-600 rounded-r"></span>
@endif

<i class="fa-solid fa-building-columns mr-2"></i>
Hubungan Pemerintah
</a>

{{-- BPJS --}}
<a href="{{ route('labour.bpjs.index') }}"
class="relative block px-3 py-2 rounded
{{ request()->routeIs('labour.bpjs.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">

@if(request()->routeIs('labour.bpjs.*'))
<span class="absolute left-0 top-0 h-full w-1 bg-green-600 rounded-r"></span>
@endif

<i class="fa-solid fa-id-card mr-2"></i>
BPJS Management
</a>
</div>
</div>
        {{-- GENERAL AFFAIR --}}
@php $openGa = request()->is('ga*'); @endphp

<div x-data="{ openGa: {{ $openGa ? 'true' : 'false' }} }">

<button @click="openGa = !openGa"
    class="flex items-center w-full px-6 py-3 font-medium
    {{ $openGa ? 'text-green-700 bg-green-50' : 'text-gray-700 hover:bg-green-50 hover:text-green-700' }}">

    <i class="fa-solid fa-building mr-3"></i>
    General Affair

    <i class="fa-solid fa-chevron-down ml-auto transition"
       :class="openGa ? 'rotate-180' : ''"></i>
</button>

<div x-show="openGa" x-collapse class="ml-6 mt-1 space-y-1">

{{-- Dashboard --}}
<a href="{{ route('ga.index') }}"
class="relative block px-3 py-2 rounded
{{ request()->routeIs('ga.index') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">

@if(request()->routeIs('ga.index'))
<span class="absolute left-0 top-0 h-full w-1 bg-green-600 rounded-r"></span>
@endif

<i class="fa-solid fa-chart-line mr-2"></i>
Dashboard
</a>

{{-- Asset --}}
<a href="{{ route('ga.assets.index') }}"
class="relative block px-3 py-2 rounded
{{ request()->routeIs('ga.assets.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">

@if(request()->routeIs('ga.assets.*'))
<span class="absolute left-0 top-0 h-full w-1 bg-green-600 rounded-r"></span>
@endif

<i class="fa-solid fa-box mr-2"></i>
Asset
</a>

{{-- Maintenance --}}
<a href="{{ route('ga.maintenance.index') }}"
class="relative block px-3 py-2 rounded
{{ request()->routeIs('ga.maintenance.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">

@if(request()->routeIs('ga.maintenance.*'))
<span class="absolute left-0 top-0 h-full w-1 bg-green-600 rounded-r"></span>
@endif

<i class="fa-solid fa-screwdriver-wrench mr-2"></i>
Maintenance
</a>

{{-- Request Barang --}}
<a href="{{ route('ga.requests.index') }}"
class="relative block px-3 py-2 rounded
{{ request()->routeIs('ga.requests.*') ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-600 hover:bg-green-50' }}">

@if(request()->routeIs('ga.requests.*'))
<span class="absolute left-0 top-0 h-full w-1 bg-green-600 rounded-r"></span>
@endif

<i class="fa-solid fa-cart-shopping mr-2"></i>
Request Barang
</a>

</div>
</div>
        {{-- PENGATURAN STICKY BAWAH --}}
        <div class="mt-auto sticky bottom-0 bg-white" x-data="{
    openSetting: {{ request()->is('settings*') ? 'true' : 'false' }},
    openMaster: {{ request()->is('settings*') ? 'true' : 'false' }}
}">
            <div class="p-3">
                <button @click="openSetting = !openSetting"
                    class="flex items-center justify-between w-full px-4 py-2 text-gray-600 hover:bg-green-50 rounded">
                    <span class="flex items-center gap-2">
                        ⚙️ <span class="font-semibold">Pengaturan</span>
                    </span>
                    <svg :class="openSetting ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="openSetting" x-transition class="ml-3 mt-2 max-h-64 overflow-y-auto">

                    <button @click="openMaster = !openMaster"
                        class="flex items-center justify-between w-full px-3 py-2 text-sm text-gray-600 hover:bg-green-50 rounded">
                        <span class="font-semibold">Master Data</span>
                        <svg :class="openMaster ? 'rotate-90' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>

                    <div x-show="openMaster" x-transition class="ml-4 mt-2 space-y-1 text-sm">
                        <a href="{{ route('settings.departments.index') }}"
                           class="block px-3 py-2 rounded {{ request()->is('settings/departments*') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-600 hover:bg-green-50' }}">
                            Divisi
                        </a>
                        <a href="{{ route('settings.positions.index') }}"
                           class="block px-3 py-2 rounded {{ request()->is('settings/positions*') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-600 hover:bg-green-50' }}">
                            Posisi / Jabatan
                        </a>
                        <a href="{{ route('cuti.types') }}"
                           class="block px-3 py-2 rounded {{ request()->is('cuti/types*') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-600 hover:bg-green-50' }}">
                            Jenis Cuti / Izin
                        </a>
                        <a href="{{ route('settings.employment_status.index') }}"
                           class="block px-3 py-2 rounded {{ request()->is('settings/employment_status*') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-600 hover:bg-green-50' }}">
                            Status Kerja
                        </a>
                        <a href="{{ route('settings.banks.index') }}"
                           class="block px-3 py-2 rounded {{ request()->is('settings/banks*') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-600 hover:bg-green-50' }}">
                            Bank
                        </a>
                        <a href="{{ route('she.inspection-checklists.index') }}"
                            class="block px-3 py-2 rounded
                            {{ request()->routeIs('she.inspection-checklists.*') ? 'bg-green-50 text-green-700 font-semibold' : 'text-gray-600 hover:bg-green-50' }}">
                                Checklist Inspeksi
                            </a>
                        <a href="{{ route('settings.audit-checklist.index') }}"
                            class="block px-3 py-2 rounded
                            {{ request()->is('settings/audit-checklist*') 
                                    ? 'bg-green-50 text-green-700 font-semibold' 
                                    : 'text-gray-600 hover:bg-green-50' }}">
                                Audit Checklist
                            </a>


                            
                    </div>
                </div>
            </div>
        </div>

    </nav>
</div>
{{-- MAIN CONTENT --}}
<div class="ml-64 min-h-screen">

    @auth
    <div class="bg-white shadow-sm px-8 py-4 flex justify-end items-center">
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center gap-3 focus:outline-none">
                <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('images/default-avatar.png') }}"
                     class="w-10 h-10 rounded-full object-cover border shadow-sm">
                <div class="text-right leading-tight hidden sm:block">
                    <p class="font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                </div>
                <i class="fa-solid fa-chevron-down text-gray-400 text-xs"></i>
            </button>

            <div x-show="open" @click.outside="open = false" x-transition
                 class="absolute right-0 mt-3 w-44 bg-white rounded-lg shadow-lg border overflow-hidden z-50">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="fa-solid fa-user"></i> Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-3 text-sm text-red-600 hover:bg-red-50">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endauth

    @if(session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
             class="fixed top-5 right-5 z-50 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg shadow-md">
            {{ session('success') }}
        </div>
    @endif

    <div class="p-8">
        @yield('content')
    </div>
@yield('modals')
@stack('scripts')
</body>
</html>