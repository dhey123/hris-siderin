@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

<div class="flex justify-between items-center">

<h1 class="text-2xl font-bold">Hubungan Pemerintah</h1>

<a href="{{ route('labour.government.create') }}"
class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
+ Tambah Agenda
</a>

</div>

<div class="bg-white shadow rounded overflow-hidden">

<table class="w-full text-sm">

<thead class="bg-blue-100">

<tr>
<th class="p-3 text-left">Instansi</th>
<th class="p-3 text-left">Agenda</th>
<th class="p-3 text-left">Tanggal</th>
<th class="p-3 text-left">Lampiran</th>
<th class="p-3 text-left">Status</th>
<th class="p-3 text-left">Aksi</th>
</tr>

</thead>

<tbody>

@forelse($governments as $item)

<tr class="border-t">

<td class="p-3">{{ $item->instansi }}</td>
<td class="p-3">{{ $item->agenda }}</td>
<td class="p-3">
{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
</td>
<td class="p-3">

@if($item->lampiran)

<div class="flex gap-2">

<a href="{{ asset('storage/'.$item->lampiran) }}"
target="_blank"
class="text-blue-600 hover:underline">
Lihat
</a>

<a href="{{ asset('storage/'.$item->lampiran) }}"
download
class="text-green-600 hover:underline">
Download
</a>

</div>

@else

-

@endif

</td>
<td class="p-3">{{ $item->status }}</td>

<td class="p-3 flex gap-2">

<a href="{{ route('labour.government.edit',$item->id) }}"
class="text-blue-600 hover:underline">
Edit
</a>

<form action="{{ route('labour.government.destroy',$item->id) }}" method="POST">
@csrf
@method('DELETE')

<button onclick="return confirm('Hapus data ini?')"
class="text-red-600 hover:underline">
Hapus
</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="5" class="p-6 text-center text-gray-500">
Belum ada agenda
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

@endsection