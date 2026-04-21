<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.1/cdn.min.js" defer></script>
    
</head>

<body class="bg-gray-100">

<style>
/* Sidebar polish tanpa ngubah struktur */
nav a, nav button {
    border-radius: 0.5rem;
}

nav a:hover, nav button:hover {
    background-color: #f0fdf4;
}

nav .ml-10 a {
    display: block;
    padding: 4px 8px;
    border-radius: 6px;
}

nav .ml-10 a:hover {
    background-color: #ecfdf5;
}

nav .ml-10 p {
    margin-top: 12px;
    margin-bottom: 4px;
    letter-spacing: .05em;
}

nav .ml-10 a.active,
nav a.bg-green-100 {
    font-weight: 600;
}
</style>

{{-- SIDEBAR --}}
<div class="w-64 bg-white shadow-xl h-screen fixed left-0 top-0 border-r flex flex-col">

    {{-- LOGO --}}
    <div class="flex flex-col items-center px-6 py-6 border-b">
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

        {{-- ========================= --}}
        {{-- DATA KARYAWAN SIDEBAR --}}
        {{-- ========================= --}}
        @php
            $openKaryawan = request()->is('hr/data-karyawan*');
        @endphp

        <div x-data="{ open: {{ $openKaryawan ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="flex items-center w-full px-6 py-3 font-medium
                {{ $openKaryawan ? 'text-green-700 bg-green-50' : 'text-gray-700 hover:bg-green-50 hover:text-green-700' }}">
                <i class="fa-solid fa-users mr-3"></i> Data Karyawan
                <i class="fa-solid fa-chevron-down ml-auto transition" :class="open ? 'rotate-180' : ''"></i>
            </button>

            <div x-show="open" x-transition class="ml-8 mt-2 space-y-2 text-sm">

                {{-- QUANTUM --}}
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Quantum</p>
                <a href="{{ route('hr.data_karyawan', ['company'=>'Quantum','type'=>'Staff']) }}"
                   class="block pl-3 border-l-2 {{ request('company')=='Quantum' && request('type')=='Staff' ? 'border-green-600 text-green-700 font-semibold' : 'border-transparent text-gray-600 hover:border-green-400 hover:text-green-700' }}">
                    Staff ({{ $totalQuantumStaff ?? 0 }})
                </a>
                <a href="{{ route('hr.data_karyawan', ['company'=>'Quantum','type'=>'Produksi']) }}"
                   class="block pl-3 border-l-2 {{ request('company')=='Quantum' && request('type')=='Produksi' ? 'border-green-600 text-green-700 font-semibold' : 'border-transparent text-gray-600 hover:border-green-400 hover:text-green-700' }}">
                    Produksi ({{ $totalQuantumProduksi ?? 0 }})
                </a>

                {{-- UNILAND --}}
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mt-3">Uniland</p>
                <a href="{{ route('hr.data_karyawan', ['company'=>'Uniland','type'=>'Staff']) }}"
                   class="block pl-3 border-l-2 {{ request('company')=='Uniland' && request('type')=='Staff' ? 'border-green-600 text-green-700 font-semibold' : 'border-transparent text-gray-600 hover:border-green-400 hover:text-green-700' }}">
                    Staff ({{ $totalUnilandStaff ?? 0 }})
                </a>
                <a href="{{ route('hr.data_karyawan', ['company'=>'Uniland','type'=>'Produksi']) }}"
                   class="block pl-3 border-l-2 {{ request('company')=='Uniland' && request('type')=='Produksi' ? 'border-green-600 text-green-700 font-semibold' : 'border-transparent text-gray-600 hover:border-green-400 hover:text-green-700' }}">
                    Produksi ({{ $totalUnilandProduksi ?? 0 }})
                </a>

                {{-- BORONGAN --}}
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
                class="flex items-center justify-between w-full px-6 py-3 font-medium
                {{ request()->is('cuti*') ? 'bg-green-100 text-green-700' : 'text-gray-700 hover:bg-green-50 hover:text-green-700' }}">
                <div class="flex items-center">
                    <i class="fa-solid fa-calendar-check mr-3"></i> Cuti & Izin
                </div>
                <i class="fa-solid fa-chevron-down text-xs" :class="{ 'rotate-180': open }"></i>
            </button>
            <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                <a href="{{ route('cuti.request') }}"
                   class="block px-4 py-2 rounded
                   {{ request()->is('cuti/request*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-green-50' }}">
                    Pengajuan Cuti
                </a>
                <a href="{{ route('cuti.approval') }}"
                   class="block px-4 py-2 rounded
                   {{ request()->is('cuti/approval*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-green-50' }}">
                    Persetujuan
                </a>
                <a href="{{ route('cuti.history') }}"
                   class="block px-4 py-2 rounded
                   {{ request()->is('cuti/history*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-green-50' }}">
                    Riwayat
                </a>
                <a href="{{ route('cuti.balance') }}"
                   class="block px-4 py-2 rounded
                   {{ request()->is('cuti/balance*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-green-50' }}">
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
                class="flex items-center justify-between w-full px-6 py-3 font-medium
                {{ $openShe ? 'bg-green-100 text-green-700' : 'text-gray-700 hover:bg-green-50 hover:text-green-700' }}">
                <span class="flex items-center">
                    <i class="fa-solid fa-shield-halved mr-3"></i> SHE
                </span>
                <i class="fa-solid fa-chevron-down text-xs transition" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" x-transition class="ml-10 mt-1 space-y-1 text-sm">
                <a href="{{ route('she.safety.index') }}"
                   class="block px-4 py-2 rounded {{ request()->routeIs('she.safety.*') ? 'bg-green-200 font-semibold' : 'hover:bg-green-100' }}">
                    Safety
                </a>
                <a href="{{ route('she.health.index') }}"
                   class="block px-4 py-2 rounded {{ request()->routeIs('she.health.*') ? 'bg-green-200 font-semibold' : 'hover:bg-green-100' }}">
                    Health
                </a>
                <a href="{{ route('she.environment.index') }}"
                   class="block px-4 py-2 rounded {{ request()->routeIs('she.environment.*') ? 'bg-green-200 font-semibold' : 'hover:bg-green-100' }}">
                    Environment
                </a>

                <div x-data="{ openRisk: {{ $openRisk ? 'true' : 'false' }} }">
                    <button @click="openRisk = !openRisk"
                        class="flex items-center justify-between w-full px-4 py-2 rounded
                        {{ $openRisk ? 'bg-green-200 font-semibold' : 'hover:bg-green-100' }}">
                        <span>Management Risiko</span>
                        <i class="fa-solid fa-chevron-down text-xs transition" :class="openRisk ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openRisk" x-transition class="ml-4 mt-1 space-y-1">
                        <a href="{{ route('she.risk.index') }}"
                           class="block px-3 py-2 rounded {{ request()->routeIs('she.risk.index') ? 'bg-green-300 font-semibold' : 'hover:bg-green-100' }}">
                            Identifikasi Risiko
                        </a>
                        <a href="{{ route('she.risk.penilaian') }}"
                           class="block px-3 py-2 rounded {{ request()->routeIs('she.risk.penilaian') ? 'bg-green-300 font-semibold' : 'hover:bg-green-100' }}">
                            Penilaian Risiko
                        </a>
                        <a href="{{ route('she.risk.mitigasi') }}"
                           class="block px-3 py-2 rounded {{ request()->routeIs('she.risk.mitigasi') ? 'bg-green-300 font-semibold' : 'hover:bg-green-100' }}">
                            Mitigasi / Pengendalian
                        </a>
                        <a href="{{ route('she.risk.tanggap') }}"
                           class="block px-3 py-2 rounded {{ request()->routeIs('she.risk.tanggap') ? 'bg-green-300 font-semibold' : 'hover:bg-green-100' }}">
                            Tanggap Darurat
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- LEGAL --}}
        <a href="{{ route('legal.index') }}"
           class="flex items-center px-6 py-3 font-medium
           {{ request()->is('legal*') ? 'bg-green-100 text-green-700' : 'text-gray-700 hover:bg-green-50 hover:text-green-700' }}">
            <i class="fa-solid fa-scale-balanced mr-3"></i> Legal
        </a>

        {{-- LABOUR --}}
        <a href="{{ route('labour.index') }}"
           class="flex items-center px-6 py-3 font-medium
           {{ request()->is('labour*') ? 'bg-green-100 text-green-700' : 'text-gray-700 hover:bg-green-50 hover:text-green-700' }}">
            <i class="fa-solid fa-landmark mr-3"></i> Labour & Government
        </a>

        {{-- GENERAL AFFAIR --}}
        <a href="{{ route('ga.index') }}"
           class="flex items-center px-6 py-3 font-medium
           {{ request()->is('ga*') ? 'bg-green-100 text-green-700' : 'text-gray-700 hover:bg-green-50 hover:text-green-700' }}">
            <i class="fa-solid fa-building mr-3"></i> General Affair
        </a>

        {{-- PENGATURAN STICKY BAWAH --}}
        <div class="mt-auto sticky bottom-0 bg-white border-t" x-data="{ openSetting: false, openMaster: false }">
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
                            Department
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
                           class="flex items-center px-4 py-2 text-sm hover:bg-gray-100">
                            Checklist Inspeksi
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </nav>
</div>

{{-- MAIN CONTENT --}}
<div class="ml-64 min-h-screen">
    {{-- HEADER --}}
    @auth
    <div class="bg-white shadow-sm px-8 py-4 flex justify-end items-center border-b">
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center gap-3 focus:outline-none">
                <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('images/default-avatar.png') }}"
                     class="w-10 h-10 rounded-full object-cover border" alt="User Photo">
                <div class="text-right leading-tight hidden sm:block">
                    <p class="font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                </div>
                <i class="fa-solid fa-chevron-down text-gray-400 text-xs"></i>
            </button>

            <div x-show="open" @click.outside="open = false" x-transition class="absolute right-0 mt-3 w-44 bg-white rounded-lg shadow-lg border overflow-hidden z-50">
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

    {{-- PAGE CONTENT --}}
    <div class="p-8">
        @yield('content')
    </div>

</div>
</body>
</html>
