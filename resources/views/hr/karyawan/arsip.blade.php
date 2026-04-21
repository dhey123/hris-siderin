@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Arsip Karyawan</h1>

    <a href="{{ route('hr.data_karyawan') }}"
       class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
        ← Kembali ke Data Aktif
    </a>
</div>

{{-- SEARCH --}}
<form method="GET" class="mb-4">
    <input type="text"
           name="search"
           value="{{ request('search') }}"
           placeholder="Cari nama / ID..."
           class="border p-2 rounded w-full focus:ring focus:ring-blue-200">
</form>

<div class="bg-white shadow rounded-xl overflow-auto">
    <table class="w-full text-sm text-center">
        <thead class="bg-red-600 text-white">
            <tr>
                <th class="p-2">ID</th>
                <th>Nama</th>
                <th>Company</th>
                <th>Department</th>
                <th>Posisi</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
        @forelse($employees as $emp)
            <tr 
                data-href="{{ route('hr.data_karyawan.show', $emp->id) }}"
                class="border-b hover:bg-gray-100 cursor-pointer transition duration-150"
            >
                <td class="p-2">{{ $emp->id_karyawan }}</td>

                <td class="font-medium text-gray-700">
                    {{ $emp->full_name }}
                </td>

                <td>{{ $emp->company->company_name ?? '-' }}</td>
                <td>{{ $emp->department->department_name ?? '-' }}</td>
                <td>{{ $emp->position->position_name ?? '-' }}</td>

                <td>
                    <span class="px-2 py-1 text-xs rounded
                        @if($emp->status == 'Inactive') bg-gray-300 text-gray-800
                        @elseif($emp->status == 'Resign') bg-red-100 text-red-700
                        @elseif($emp->status == 'PHK') bg-red-200 text-red-800
                        @else bg-gray-200
                        @endif
                    ">
                        {{ $emp->status }}
                    </span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="p-4 text-gray-500">
                    Tidak ada data arsip
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $employees->links() }}
</div>

{{-- CLICKABLE ROW SCRIPT --}}
<script>
document.querySelectorAll("tr[data-href]").forEach(row => {
    row.addEventListener("click", () => {
        window.location = row.dataset.href;
    });
});
</script>

@endsection