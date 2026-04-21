
@extends('layouts.app')

@section('content')

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-2 sm:space-y-0 sm:space-x-2">
    <h1 class="text-2xl font-bold text-gray-800">Data Karyawan</h1>
<div class="flex justify-between items-center mb-4">


        <a href="{{ route('hr.data_karyawan.arsip') }}"
           class="px-4 py-2 bg-red-700 text-black rounded-lg hover:bg-gray-800">
            📜 Arsip Karyawan
        </a>


    </div>

</div>
    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2 w-full sm:w-auto">
        {{-- Tambah Karyawan --}}
        <a href="{{ route('hr.data_karyawan.create') }}"
           class="w-full sm:w-auto px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 text-center">
           + Tambah Karyawan
        </a>

        {{-- Download Template --}}
        <a href="{{ route('data-karyawan.download-template') }}"
   class="w-full sm:w-auto px-4 py-2 bg-gray-500 text-white rounded-xl hover:bg-gray-600 text-center">
    Download Template
</a>
    
{{-- Import Excel --}}
        <form action="{{ route('hr.data_karyawan.import') }}" method="POST" enctype="multipart/form-data" class="relative w-full sm:w-auto">
            @csrf
            <input type="file" name="file" id="excelFile" accept=".xlsx,.xls,.csv" class="hidden" onchange="this.form.submit()">
            <label for="excelFile"
                   class="w-full sm:w-auto block px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 text-center cursor-pointer">
                Import Excel
            </label>
        </form>
        
{{-- Export Filter --}}

<form method="GET" action="{{ route('hr.data_karyawan.exportAll') }}"
      class="flex items-center gap-2">

    <button class="px-4 py-2 bg-yellow-600 text-white rounded-xl hover:bg-yellow-700">
        Export
    </button>
    
    <select name="kategori"
            class="border rounded-lg px-2 py-2 text-sm">
        <option value="">Semua</option>
        <option value="Staff">Staff</option>
        <option value="Produksi">Produksi</option>
        <option value="Borongan">Borongan</option>
    </select>

</form>
        
    </div>
</div>


{{-- ========================= --}}
{{-- TOTAL DATA CLICKABLE --}}
{{-- ========================= --}}
<div class="grid grid-cols-3 gap-4 mb-6">

   
    <a href="{{ route('hr.data_karyawan', ['type' => 'Staff']) }}">
        <div class="bg-white rounded-xl shadow p-4 text-center hover:bg-blue-50 cursor-pointer transition">
            <p class="text-sm text-gray-500">Total Staff</p>
            <p class="text-3xl font-bold text-blue-600">{{ $totalStaff ?? 0 }}</p>
        </div>
    </a>

    <a href="{{ route('hr.data_karyawan', ['type' => 'Produksi']) }}">
        <div class="bg-white rounded-xl shadow p-4 text-center hover:bg-green-50 cursor-pointer transition">
            <p class="text-sm text-gray-500">Total Produksi</p>
            <p class="text-3xl font-bold text-green-600">{{ $totalProduksi ?? 0 }}</p>
        </div>
    </a>

    <a href="{{ route('hr.data_karyawan', ['type' => 'Borongan']) }}">
        <div class="bg-white rounded-xl shadow p-4 text-center hover:bg-orange-50 cursor-pointer transition">
            <p class="text-sm text-gray-500">Total Borongan</p>
            <p class="text-3xl font-bold text-orange-600">{{ $totalBoronganGlobal ?? 0 }}</p>
        </div>
    </a>

</div>



{{-- ========================= --}}
{{-- SEARCH --}}
{{-- ========================= --}}
<form method="GET" action="{{ route('hr.data_karyawan') }}" class="mb-5">
    <div class="flex bg-white shadow rounded-xl overflow-hidden">
        <input
            type="text"
            name="search"
            placeholder="Cari Nama / NIK / ID..."
            class="w-full px-4 py-3 focus:outline-none"
            value="{{ request('search') }}"
        >
        <button type="submit" class="bg-green-600 px-5 text-white hover:bg-green-700">
            <i class="fa fa-search"></i>
        </button>
    </div>
</form>

{{-- ========================= --}}
{{-- FILTER INFO --}}
{{-- ========================= --}}
@if(request('company') || request('type'))
<div class="mb-4 p-3 bg-yellow-100 border-l-4 border-yellow-500 text-sm">
    <b>Filter:</b>
    {{ request('company') ?? 'Semua Perusahaan' }} -
    {{ request('type') ?? 'Semua Tipe' }}
    <a href="{{ route('hr.data_karyawan') }}" class="text-red-600 font-semibold ml-3">
       Tampilkan Semua Data Karyawan
    </a>
</div>
@endif

@if($kontrakHabis->count() > 0)

<div class="bg-yellow-100 border border-yellow-300 text-yellow-800 p-4 rounded mb-4">

<b>⚠️ Kontrak Akan Habis</b>

<ul class="mt-2 text-sm">

@foreach($kontrakHabis as $k)
<li class="flex justify-between items-center hover:bg-yellow-200 px-2 py-1 rounded transition">

    <a href="{{ route('hr.data_karyawan.show', $k->id) }}"
       class="font-medium hover:underline">
        {{ $k->full_name }}
    </a>

@if(is_null($k->sisa_hari_kontrak))
    <span class="text-gray-500">Tanggal kontrak tidak tersedia</span>

@elseif($k->sisa_hari_kontrak < 0)
    <span class="text-red-600 font-semibold">
        Kontrak sudah habis
    </span>

@elseif($k->sisa_hari_kontrak == 0)
    <span class="text-orange-600 font-semibold">
        Hari ini
    </span>

@else
    {{ $k->sisa_hari_kontrak }} hari lagi
@endif

</li>
@endforeach

</ul>
</div>

@endif

{{-- ========================= --}}
{{-- TABLE --}}
{{-- ========================= --}}
<div class="bg-white rounded-xl shadow p-4 overflow-auto">
    <table class="table-auto w-full border-collapse text-sm text-center">
        <thead class="bg-green-600 text-white">
            <tr>
                <th class="py-3 border">Foto</th>
                <th class="py-3 border">ID</th>
                <th class="py-3 border">Nama</th>
                <th class="py-3 border">Department</th>
                <th class="py-3 border">Divisi</th>
                <th class="py-3 border">Posisi</th>
                <th class="py-3 border">Tipe</th>
                <th class="py-3 border">Status</th>
                <th class="py-3 border">Rekomendasi</th>
                <th class="py-3 border">Aksi</th>
            </tr>
        </thead>

        <tbody class="text-sm divide-y divide-gray-100">
@forelse ($employees as $emp)
<tr class="hover:bg-gray-50 transition">

    {{-- FOTO --}}
    <td class="py-1 px-2">
        <div class="flex justify-center">
            @if(!empty($emp->photo))
                <img src="{{ asset('storage/'.$emp->photo) }}" class="h-7 w-7 object-cover rounded-full shadow-sm">
            @else
                <div class="h-7 w-7 bg-gray-200 rounded-full flex items-center justify-center shadow-sm">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 2a4 4 0 100 8 4 4 0 000-8zm-7 16a7 7 0 0114 0H3z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            @endif
        </div>
    </td>
    {{-- ID --}}
    <td class="py-3 px-4 text-gray-600 font-medium">
        {{ $emp->id_karyawan ?? '-' }}
    </td>

    {{-- NAMA --}}
    <td class="py-3 px-4">
        <a href="{{ route('hr.data_karyawan.show', $emp->id) }}"
           class="font-semibold text-gray-800 hover:text-green-600 transition">
            {{ $emp->full_name ?? '-' }}
        </a>
    </td>

    {{-- UNIT KERJA --}}
   {{-- COMPANY / DEPARTMENT --}}
<td class="py-3 px-4">
    {{ $emp->company->company_name ?? '-' }}
</td>

<td class="py-3 px-4">
    {{ $emp->department->department_name ?? '-' }}
</td>

{{-- POSISI --}}
<td class="py-3 px-4">
    {{ $emp->position->position_name ?? '-' }}
</td>

{{-- TIPE --}}
<td class="py-3 px-4">
    {{ $emp->employmentType->type_name ?? '-' }}
</td>
      
    {{-- STATUS --}}
<td class="py-3 px-4">
    @if($emp->employmentStatus)
        <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full shadow-sm">
            {{ $emp->employmentStatus->status_name }}
        </span>
    @else
        <span class="text-gray-400">-</span>
    @endif
</td>

{{-- REKOMENDASI --}}
<td class="py-3 px-4 text-sm text-gray-600">
    {{ $emp->rekomendasi ?: '-' }}
</td>

    {{-- AKSI --}}
    <td class="py-3 px-4 space-x-1 whitespace-nowrap">
        <a href="{{ route('hr.data_karyawan.edit', $emp->id) }}"
           class="px-3 py-1 bg-yellow-400 text-white rounded-lg hover:bg-yellow-500 text-xs shadow-sm">
           Edit
        </a>

        <form action="{{ route('hr.data_karyawan.destroy', $emp->id) }}"
              method="POST"
              class="inline"
              onsubmit="return confirm('Yakin ingin menghapus data ini?')">
            @csrf
            @method('DELETE')
            <button class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 text-xs shadow-sm">
                Hapus
            </button>
        </form>
    </td>

</tr>

@empty
<tr>
    <td colspan="7" class="py-8 text-gray-500 text-center">
        Belum ada data / Filter tidak menemukan hasil
    </td>
</tr>
@endforelse
</tbody>
    </table>

    <div class="mt-4">
        {{ $employees->links() }}
    </div>
</div>

@endsection
