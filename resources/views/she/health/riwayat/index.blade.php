@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Riwayat Kesehatan Karyawan
            </h1>
            <p class="text-sm text-gray-500">
                Ringkasan MCU dan Surat Dokter
            </p>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('she.health.index') }}"
               class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">
                ← Reset
            </a>

            <a href="{{ route('she.health.riwayat.export') }}"
               class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700">
                Export Excel
            </a>
        </div>
    </div>

    {{-- ================= FILTER ================= --}}
    <form method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">

        {{-- SEARCH --}}
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nik / nama / dept / posisi..."
            class="border rounded-lg px-3 py-2">

        {{-- COMPANY --}}
        <select name="company" class="border rounded-lg px-3 py-2">
            <option value="">Semua Department</option>
            @foreach($companies as $c)
                <option value="{{ $c->id }}"
                    {{ request('company') == $c->id ? 'selected' : '' }}>
                    {{ $c->company_name }}
                </option>
            @endforeach
        </select>

        {{-- DEPARTMENT --}}
        <select name="department" class="border rounded-lg px-3 py-2">
            <option value="">Semua Divisi</option>
            @foreach($departments as $d)
                <option value="{{ $d->id }}"
                    {{ request('department') == $d->id ? 'selected' : '' }}>
                    {{ $d->department_name }}
                </option>
            @endforeach
        </select>

        {{-- STATUS --}}
        <select name="status" class="border rounded-lg px-3 py-2">
            <option value="">Semua Status</option>
            <option value="sehat" {{ request('status') == 'sehat' ? 'selected' : '' }}>Sehat</option>
            <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
            <option value="belum_mcu" {{ request('status') == 'belum_mcu' ? 'selected' : '' }}>Belum MCU</option>
        </select>

        <button class="bg-blue-600 text-white rounded-lg px-4 py-2 col-span-full sm:col-span-1">
            Filter
        </button>

    </form>

    {{-- ================= TABLE ================= --}}
    <div class="bg-white rounded-2xl shadow border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse">

                <thead class="bg-gray-100 text-sm">
                    <tr>
                        <th class="border px-3 py-2">Nik</th>
                        <th class="border px-3 py-2">Perusahaan</th>
                        <th class="border px-3 py-2">Nama</th>
                        <th class="border px-3 py-2">Dept</th>
                        <th class="border px-3 py-2">Posisi</th>
                        <th class="border px-3 py-2 text-center">MCU</th>
                        <th class="border px-3 py-2 text-center">Jenis</th>
                        <th class="border px-3 py-2 text-center">Surat</th>
                        <th class="border px-3 py-2 text-center">Hari</th>
                        <th class="border px-3 py-2 text-center">Status</th>
                    </tr>
                </thead>

                <tbody class="text-sm">
                    @forelse($employees as $emp)

                        @php
                            $lastMcu = $emp->mcus->first();
                        @endphp

                        <tr>
                            <td class="border px-3 py-2">{{ $emp->nik }}</td>
                            <td class="border px-3 py-2">{{ $emp->company->company_name ?? '-' }}</td>
                            <td class="border px-3 py-2 font-semibold">{{ $emp->full_name }}</td>
                            <td class="border px-3 py-2">{{ $emp->department->department_name ?? '-' }}</td>
                            <td class="border px-3 py-2">{{ $emp->position->position_name ?? '-' }}</td>

                            <td class="border px-3 py-2 text-center">
                                {{ $lastMcu ? \Carbon\Carbon::parse($lastMcu->tanggal_mcu)->format('d-m-Y') : '-' }}
                            </td>

                            <td class="border px-3 py-2 text-center">
                                {{ $lastMcu->jenis_mcu ?? '-' }}
                            </td>

                            <td class="border px-3 py-2 text-center">
                                {{ $emp->suratDokters->count() }}
                            </td>

                            <td class="border px-3 py-2 text-center">
                                {{ $emp->suratDokters->sum('hari_istirahat') }}
                            </td>

                            <td class="border px-3 py-2 text-center">
                                @if($emp->suratDokters->count() > 0)
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded">Sakit</span>
                                @elseif($emp->mcus->count() == 0)
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded">Belum MCU</span>
                                @else
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded">Sehat</span>
                                @endif
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                Tidak ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="p-4">
            {{ $employees->links() }}
        </div>

    </div>

</div>
@endsection