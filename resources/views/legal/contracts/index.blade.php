@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
<h2 class="text-2xl font-semibold">Kontrak & Perjanjian</h2>

<div class="flex gap-2">

<a href="{{ route('legal.contracts.create') }}"
class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
+ Tambah Kontrak
</a>

<a href="{{ route('legal.contracts.export.pdf') }}"
class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
Export PDF
</a>

<a href="{{ route('legal.contracts.export.excel') }}"
class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
Export Excel
</a>

</div>
</div>


{{-- FILTER + SEARCH --}}
<form method="GET" class="mb-4 flex gap-3 items-center">

<input type="text"
name="search"
value="{{ request('search') }}"
placeholder="Cari nomor / nama kontrak..."
class="border px-3 py-2 rounded w-64">

<select name="status"
class="border px-3 py-2 rounded">

<option value="">Semua Status</option>

<option value="aktif"
{{ request('status')=='aktif'?'selected':'' }}>
Aktif
</option>

<option value="soon"
{{ request('status')=='soon'?'selected':'' }}>
H-30
</option>

<option value="expired"
{{ request('status')=='expired'?'selected':'' }}>
Expired
</option>

</select>

<button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
Filter
</button>

</form>


<div class="overflow-x-auto bg-white shadow rounded-lg">

<table class="min-w-full text-sm text-left">

<thead class="bg-gray-800 text-white">
<tr>

<th class="px-4 py-3 whitespace-nowrap">No</th>
<th class="px-4 py-3 whitespace-nowrap">Nomor</th>
<th class="px-4 py-3">Nama Kontrak</th>
<th class="px-4 py-3 whitespace-nowrap">Vendor</th>
<th class="px-4 py-3 whitespace-nowrap">Jenis</th>
<th class="px-4 py-3 whitespace-nowrap">Mulai</th>
<th class="px-4 py-3 whitespace-nowrap">Berakhir</th>
<th class="px-4 py-3 whitespace-nowrap text-center">Sisa</th>
<th class="px-4 py-3 whitespace-nowrap text-center">Status</th>
<th class="px-4 py-3 whitespace-nowrap text-center">File</th>
<th class="px-4 py-3 whitespace-nowrap text-center">Aksi</th>

</tr>
</thead>


<tbody class="divide-y">

@forelse($contracts as $item)

@php

$rowColor = match($item->status) {
'Expired' => 'bg-red-50',
'H-30' => 'bg-yellow-50',
default => ''
};

@endphp


<tr class="{{ $rowColor }} hover:bg-gray-50">

<td class="px-4 py-2 whitespace-nowrap">
{{ $contracts->firstItem() + $loop->index }}
</td>

<td class="px-4 py-2 whitespace-nowrap">
{{ $item->nomor_kontrak }}
</td>

<td class="px-4 py-2 max-w-xs truncate">
{{ $item->nama_kontrak }}
</td>

<td class="px-4 py-2 whitespace-nowrap">
{{ $item->vendor->nama_vendor ?? '-' }}
</td>

<td class="px-4 py-2 whitespace-nowrap">
{{ $item->jenis->nama_jenis ?? '-' }}
</td>

<td class="px-4 py-2 whitespace-nowrap">
{{ $item->tanggal_mulai
? \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y')
: '-' }}
</td>

<td class="px-4 py-2 whitespace-nowrap">
{{ $item->tanggal_berakhir
? \Carbon\Carbon::parse($item->tanggal_berakhir)->format('d M Y')
: '-' }}
</td>

<td class="px-4 py-2 text-center whitespace-nowrap">
{{ $item->sisa_hari }}
</td>

<td class="px-4 py-2 text-center">

@php

$badge = match($item->status) {
'Expired' => 'bg-red-500',
'H-30' => 'bg-yellow-400 text-black',
default => 'bg-green-500'
};

@endphp

<span class="px-2 py-1 text-xs text-white rounded {{ $badge }}">
{{ $item->status }}
</span>

</td>

<td class="px-4 py-2 text-center whitespace-nowrap">

@if($item->file_path)

<a href="{{ asset('storage/'.$item->file_path) }}"
target="_blank"
class="text-blue-600 hover:underline">
Download
</a>

@else
-
@endif

</td>


<td class="px-4 py-2">

<div class="flex justify-center gap-2">

<a href="{{ route('legal.contracts.edit',$item->id) }}"
class="px-3 py-1 bg-yellow-400 rounded text-sm hover:bg-yellow-500">
Edit
</a>

<form action="{{ route('legal.contracts.destroy',$item->id) }}"
method="POST"
onsubmit="return confirm('Hapus kontrak?')">

@csrf
@method('DELETE')

<button class="px-3 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600">
Hapus
</button>

</form>

</div>

</td>

</tr>

@empty

<tr>
<td colspan="11" class="text-center py-6 text-gray-500">
Belum ada data kontrak
</td>
</tr>

@endforelse

</tbody>

</table>

</div>


<div class="mt-4">
{{ $contracts->links() }}
</div>

@endsection