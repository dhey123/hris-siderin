@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Approval Pengajuan Cuti</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-4 rounded shadow overflow-x-auto">
        <table class="min-w-full border rounded">
            <thead class="bg-gray-100 sticky top-0 z-10">
                <tr>
                    <th class="py-2 px-4 border">Karyawan</th>
                    <th class="py-2 px-4 border">Department</th>
                    <th class="py-2 px-4 border">Bagian</th>
                    <th class="py-2 px-4 border">Jenis Cuti</th>
                    <th class="py-2 px-4 border">Tanggal</th>
                    <th class="py-2 px-4 border">Alasan</th>
                    <th class="py-2 px-4 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leaveRequests as $req)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border">
                            <div class="font-medium">{{ $req->employee->full_name }}</div>
                        </td>
                        <td class="py-2 px-4 border">{{ $req->employee->department->department_name ?? '-' }}</td>
                        <td class="py-2 px-4 border">{{ $req->employee->position->position_name ?? '-' }}</td>
                        <td class="py-2 px-4 border">{{ $req->leaveType->name }}</td>
                        <td class="py-2 px-4 border">
                            {{ \Carbon\Carbon::parse($req->start_date)->format('d M Y') }} - 
                            {{ \Carbon\Carbon::parse($req->end_date)->format('d M Y') }}
                        </td>
                        <td class="py-2 px-4 border">{{ $req->reason }}</td>
                        <td class="py-2 px-4 border flex gap-2">
                            <form action="{{ route('cuti.approve', $req->id) }}" method="POST">
                                @csrf
                                <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Approve</button>
                            </form>
                            <form action="{{ route('cuti.reject', $req->id) }}" method="POST">
                                @csrf
                                <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Reject</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">
                            Tidak ada request cuti pending
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
