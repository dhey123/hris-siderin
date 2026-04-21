@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Riwayat Cuti</h1>
    
{{-- ================= FILTER CARD ================= --}}
<div class="bg-white shadow-md rounded-xl p-4 mb-6 border border-gray-100">

    <form method="GET" class="flex flex-wrap items-center gap-3">

        {{-- TITLE --}}
        <div class="text-sm font-semibold text-gray-600 mr-2">
            Filter Riwayat:
        </div>

        {{-- SELECT --}}
        <select name="leave_type_id"
                class="border border-gray-300 px-3 py-2 rounded-lg text-sm
                       focus:outline-none focus:ring-2 focus:ring-blue-400">

            <option value="">📂 Semua Jenis Cuti</option>

            @foreach($leaveTypes as $type)
                <option value="{{ $type->id }}"
                    {{ request('leave_type_id') == $type->id ? 'selected' : '' }}>
                    {{ $type->name }}
                </option>
            @endforeach

        </select>

        {{-- BUTTON FILTER --}}
        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm
                       hover:bg-blue-700 transition shadow-sm">
            🔍 Filter
        </button>

        {{-- RESET --}}
        <a href="{{ route('cuti.history') }}"
           class="text-sm text-gray-500 hover:text-red-500 transition">
            Reset
        </a>

    </form>
</div>
    <table class="min-w-full border rounded shadow">
        <thead class="bg-gray-300">
            <tr>
                <th class="py-2 px-4 border">Karyawan</th>
                <th class="py-2 px-4 border">Jenis Cuti</th>
                <th class="py-2 px-4 border">Tanggal</th>
                <th class="py-2 px-4 border">Alasan</th>
                <th class="py-2 px-4 border">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leaveRequests as $req)
                <tr>
                    <td class="py-2 px-4 border">{{ $req->employee->full_name }}</td>
                    <td class="py-2 px-4 border">{{ $req->leaveType->name }}</td>
                    <td class="py-2 px-4 border">{{ \Carbon\Carbon::parse($req->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($req->end_date)->format('d M Y') }}</td>
                    <td class="py-2 px-4 border">{{ $req->reason }}</td>
                    <td class="py-2 px-4 border">{{ $req->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4">Belum ada riwayat cuti</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection


