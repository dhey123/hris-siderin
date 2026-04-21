@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Data Karyawan</h1>

    <a href="{{ route('employee.create') }}"
       class="px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700">
       + Tambah Karyawan
    </a>
</div>


<div class="grid grid-cols-3 gap-6">

    {{-- KIRI --}}
    <div class="col-span-2">

        {{-- SEARCH --}}
        <div class="mb-5">
            <form method="GET">
                <div class="flex bg-white shadow rounded-xl overflow-hidden">
                    <input type="text" name="search" placeholder="Cari Nama / NIK / ID..."
                           class="w-full px-4 py-3 focus:outline-none"
                           value="{{ request('search') }}">

                    <button class="bg-green-600 px-5 text-white hover:bg-green-700">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        {{-- PILIH PERUSAHAAN --}}
        <div class="grid grid-cols-3 gap-4 mb-6">

            <a href="{{ route('hr.quantum') }}"
               class="block text-center p-4 bg-white shadow rounded-xl hover:bg-green-50 border">
                <p class="font-semibold text-lg">Quantum</p>
                <span class="text-sm text-gray-500">Staff & Produksi</span>
            </a>

            <a href="{{ route('hr.uniland') }}"
               class="block text-center p-4 bg-white shadow rounded-xl hover:bg-green-50 border">
                <p class="font-semibold text-lg">Uniland</p>
                <span class="text-sm text-gray-500">Staff & Produksi</span>
            </a>

            <a href="{{ route('hr.borongan') }}"
               class="block text-center p-4 bg-white shadow rounded-xl hover:bg-green-50 border">
                <p class="font-semibold text-lg">Borongan</p>
                <span class="text-sm text-gray-500">Mix Quantum & Uniland</span>
            </a>

        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-xl shadow p-4 overflow-auto">
            <table class="table-auto w-full border-collapse text-sm text-center">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="py-3 border">ID</th>
                        <th class="py-3 border">Nama</th>
                        <th class="py-3 border">Perusahaan</th>
                        <th class="py-3 border">Dept</th>
                        <th class="py-3 border">Posisi</th>
                        <th class="py-3 border">Status</th>
                        <th class="py-3 border">Email</th>
                        <th class="py-3 border">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($employees as $emp)
                    <tr class="hover:bg-gray-100">

                        <td class="py-2 border font-semibold">{{ $emp->id_karyawan }}</td>
                        <td class="py-2 border">{{ $emp->full_name }}</td>

                        <td class="py-2 border">{{ $emp->company->company_name ?? '-' }}</td>
                        <td class="py-2 border">{{ $emp->department->department_name ?? '-' }}</td>
                        <td class="py-2 border">{{ $emp->position->position_name ?? '-' }}</td>
                        <td class="py-2 border">{{ $emp->employmentStatus->status_name ?? '-' }}</td>

                        <td class="py-2 border">{{ $emp->email ?: '-' }}</td>

                        <td class="py-2 border">
                            <div class="flex justify-center gap-2">

                                <a href="{{ route('employee.edit', $emp->id) }}"
                                   class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 text-xs">
                                   Edit
                                </a>

                                <form action="{{ route('employee.destroy', $emp->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs">
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-4 text-gray-500 text-center">
                            Belum ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

    {{-- KANAN --}}
    <div>
        <div class="bg-white rounded-xl shadow p-6 h-full">
            <h2 class="font-bold text-lg mb-4">Grafik Penilaian</h2>
            <div class="h-64 flex items-center justify-center text-gray-400">
                <span>Chart belum ada data</span>
            </div>
        </div>
    </div>

</div>

@endsection
