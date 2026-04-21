@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 space-y-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Sisa Cuti Karyawan</h1>

        <form method="GET" action="{{ route('cuti.export') }}">

    <input type="hidden" name="year" value="{{ $year }}">

    <button type="submit"
            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        Export Excel
    </button>

    <div class="mb-4">
    <a href="{{ route('cuti.balance') }}"
       class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
        ← Kembali
    </a>
</div>

</form>

    </div>

    {{-- FILTER --}}
    <form method="GET" class="flex items-center gap-3">
        <label class="text-sm text-gray-600">Tahun:</label>

        <input type="number"
               name="year"
               value="{{ $year }}"
               class="border px-3 py-2 rounded w-32 focus:ring focus:ring-blue-200">

        <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Filter
        </button>
    </form>

    {{-- SUMMARY --}}
    @php
        $low = $balances->filter(fn($b) => ($b->quota - $b->used) <= 2 && ($b->quota - $b->used) > 0)->count();
        $empty = $balances->filter(fn($b) => ($b->quota - $b->used) <= 0)->count();
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-yellow-100 border border-yellow-300 p-4 rounded-lg shadow-sm">
            <p class="text-sm text-gray-600">Hampir Habis</p>
            <p class="text-2xl font-bold text-yellow-700">{{ $low }}</p>
            <p class="text-xs text-gray-500">karyawan</p>
        </div>

        <div class="bg-red-100 border border-red-300 p-4 rounded-lg shadow-sm">
            <p class="text-sm text-gray-600">Cuti Habis</p>
            <p class="text-2xl font-bold text-red-700">{{ $empty }}</p>
            <p class="text-xs text-gray-500">karyawan</p>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full border text-sm">
            <thead class="bg-gray-300 text-gray-700">
                <tr>
                    <th class="py-3 px-4 border text-left">Karyawan</th>
                    <th class="py-3 px-4 border text-center">Total Cuti</th>
                    <th class="py-3 px-4 border text-center">Cuti Terpakai</th>
                    <th class="py-3 px-4 border text-center">Sisa Cuti</th>
                    <th class="py-2 px-4 border text-cente">Alasan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($balances as $bal)
                    @php
                        $remaining = $bal->quota - $bal->used;
                    @endphp

                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4 border font-medium">
    <a href="{{ route('cuti.employee.detail', $bal->employee->id) }}"
       class="text-blue-600 hover:underline">
        {{ $bal->employee->full_name }}
    </a>
</td>

                        <td class="py-3 px-4 border text-center">
                            {{ $bal->quota }}
                        </td>

                        <td class="py-3 px-4 border text-center">
                            {{ $bal->used }}
                        </td>

                        <td class="py-3 px-4 border text-center font-semibold
                            {{ $remaining <= 0 ? 'text-red-600' : ($remaining <= 2 ? 'text-yellow-600' : 'text-green-600') }}">
                            
                            {{ $remaining }} hari
                        </td>
                        <td class="py-3 px-4 border" text-center font-semibold
                        >{{ $bal->reason }}</td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-400">
                            Belum ada data cuti di tahun ini
                        </td>
                        
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection