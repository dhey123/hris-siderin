@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 bg-white rounded-xl shadow space-y-4">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Surat Dokter</h1>
        <a href="{{ route('she.health.surat-dokter.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 flex items-center gap-1">
            Tambah
        </a>
    </div>

    {{-- Kembali --}}
    <div>
        <a href="{{ route('she.health.index') }}"
           class="inline-flex items-center gap-1 px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">
            ← Kembali
        </a>
    </div>

    {{-- Notif --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabel --}}
    <div class="overflow-x-auto">
        <table class="w-full border-collapse text-sm">
            <thead class="bg-gray-100 uppercase text-gray-600 text-xs">
                <tr>
                    <th class="border px-3 py-2 text-center">No</th>
                    <th class="border px-3 py-2 text-left">NIK</th>
                    <th class="border px-3 py-2 text-left">Nama</th>
                    <th class="border px-3 py-2 text-left">Department</th>
                    <th class="border px-3 py-2 text-left">Divisi</th>
                    <th class="border px-3 py-2 text-left">Posisi</th>
                    <th class="border px-3 py-2 text-left">Tanggal Surat</th>
                    <th class="border px-3 py-2 text-center">Hari Istirahat</th>
                    <th class="border px-3 py-2 text-left">Nama Dokter</th>
                    <th class="border px-3 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($suratDokters as $item)
                    <tr class="hover:bg-gray-50">

                        {{-- Nomor --}}
                        <td class="border px-3 py-2 text-center">
                            {{ $loop->iteration + ($suratDokters->currentPage() - 1) * $suratDokters->perPage() }}
                        </td>

                        {{-- NIK --}}
                        <td class="border px-3 py-2">
                            {{ $item->employee->nik ?? '-' }}
                        </td>

                        {{-- Nama --}}
                        <td class="border px-3 py-2">
                            {{ $item->employee->full_name ?? '-' }}
                        </td>

                        {{-- Perusahaan --}}
                        <td class="border px-3 py-2">
                            {{ $item->employee->company->company_name ?? '-' }}
                        </td>

                        {{-- Department --}}
                        <td class="border px-3 py-2">
                            {{ $item->employee->department->department_name ?? '-' }}
                        </td>

                        {{-- Posisi --}}
                        <td class="border px-3 py-2">
                            {{ $item->employee->position->position_name ?? '-' }}
                        </td>

                        {{-- Tanggal --}}
                        <td class="border px-3 py-2">
                            {{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d/m/Y') }}
                        </td>

                        {{-- Hari --}}
                        <td class="border px-3 py-2 text-center">
                            {{ $item->hari_istirahat }}
                        </td>

                        {{-- Dokter --}}
                        <td class="border px-3 py-2">
                            {{ $item->nama_dokter ?? '-' }}
                        </td>

                        {{-- Aksi --}}
                        <td class="border px-3 py-2 text-center flex justify-center gap-2">

                            <a href="{{ route('she.health.surat-dokter.show', $item) }}"
                               class="text-green-600 hover:text-green-800">
                                Detail
                            </a>

                            <a href="{{ route('she.health.surat-dokter.edit', $item) }}"
                               class="text-yellow-500 hover:text-yellow-700">
                                Edit
                            </a>

                            <form action="{{ route('she.health.surat-dokter.destroy', $item) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus surat dokter ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-800">
                                    Hapus
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10"
                            class="border px-3 py-6 text-center text-gray-400">
                            Belum ada surat dokter
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $suratDokters->links() }}
    </div>

</div>
@endsection