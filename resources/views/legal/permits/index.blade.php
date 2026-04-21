@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">
<h2 class="text-2xl font-semibold">Perizinan</h2>

<div class="flex gap-2">

<a href="{{ route('legal.permits.create') }}"
class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
+ Tambah Izin
</a>

</div>
</div>


{{-- SEARCH + FILTER --}}
<form method="GET" class="mb-4 flex gap-3 items-center">

<input type="text"
name="search"
value="{{ request('search') }}"
placeholder="Cari nama / nomor izin..."
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

<button class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
Filter
</button>

</form>



<div class="overflow-x-auto bg-white shadow rounded-lg">

<table class="min-w-full text-sm">

<thead class="bg-gray-800 text-white">
<tr>

<th class="px-4 py-3">No</th>
<th class="px-4 py-3">Nama Izin</th>
<th class="px-4 py-3">Nomor</th>
<th class="px-4 py-3">Instansi</th>
<th class="px-4 py-3">Terbit</th>
<th class="px-4 py-3">Berakhir</th>
<th class="px-4 py-3 text-center">Sisa Hari</th>
<th class="px-4 py-3 text-center">Status</th>
<th class="px-4 py-3 text-center">File</th>
<th class="px-4 py-3 text-center">Aksi</th>

</tr>
</thead>


<tbody class="divide-y">

@forelse($permits as $permit)

@php

$rowColor = match($permit->status) {

'Expired' => 'bg-red-50',
'H-30' => 'bg-yellow-50',
default => ''

};

@endphp


<tr class="{{ $rowColor }} hover:bg-gray-50">

<td class="px-4 py-2">
{{ $permits->firstItem() + $loop->index }}
</td>

<td class="px-4 py-2 max-w-xs truncate">
{{ $permit->nama_izin }}
</td>

<td class="px-4 py-2">
{{ $permit->nomor_izin ?? '-' }}
</td>

<td class="px-4 py-2">
{{ $permit->instansi_penerbit ?? '-' }}
</td>

<td class="px-4 py-2 whitespace-nowrap">
{{ $permit->tanggal_terbit
? \Carbon\Carbon::parse($permit->tanggal_terbit)->format('d M Y')
: '-' }}
</td>

<td class="px-4 py-2 whitespace-nowrap">
{{ $permit->tanggal_berakhir
? \Carbon\Carbon::parse($permit->tanggal_berakhir)->format('d M Y')
: '-' }}
</td>

<td class="px-4 py-2 text-center">
{{ $permit->sisa_hari_text }}
</td>

<td class="px-4 py-2 text-center">

@php

$badge = match($permit->status) {

'Expired' => 'bg-red-500',
'H-30' => 'bg-yellow-400 text-black',
default => 'bg-green-500'

};

@endphp

<span class="px-2 py-1 text-xs text-white rounded {{ $badge }}">
{{ $permit->status }}
</span>

</td>


<td class="px-4 py-2 text-center">

@if($permit->file)

<a href="{{ asset('storage/'.$permit->file) }}"
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

<a href="{{ route('legal.permits.edit',$permit->id) }}"
class="px-3 py-1 bg-yellow-400 rounded text-sm hover:bg-yellow-500">
Edit
</a>

<form action="{{ route('legal.permits.destroy',$permit->id) }}"
method="POST"
onsubmit="return confirm('Hapus izin ini?')">

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
<td colspan="10" class="text-center py-6 text-gray-500">
Belum ada data perizinan
</td>
</tr>

@endforelse

</tbody>

</table>

</div>



<div class="mt-4">
{{ $permits->links() }}
</div>

@endsection