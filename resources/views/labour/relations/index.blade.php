@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

<div class="flex justify-between items-center">
<h1 class="text-2xl font-bold">Hubungan Industrial</h1>

<a href="{{ route('labour.relations.create') }}"
class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
+ Tambah Data
</a>
</div>


{{-- FILTER --}}
<div class="flex gap-2 mb-4">

<a href="{{ route('labour.relations.index') }}"
class="px-3 py-1 rounded bg-gray-200 text-sm">
Semua
</a>

<a href="{{ route('labour.relations.index',['jenis'=>'PP']) }}"
class="px-3 py-1 rounded bg-blue-100 text-sm">
PP
</a>

<a href="{{ route('labour.relations.index',['jenis'=>'Meeting']) }}"
class="px-3 py-1 rounded bg-green-100 text-sm">
Meeting
</a>

<a href="{{ route('labour.relations.index',['jenis'=>'Sosialisasi']) }}"
class="px-3 py-1 rounded bg-yellow-100 text-sm">
Sosialisasi
</a>

</div>


{{-- SEARCH --}}
<form method="GET" class="flex gap-2 mb-4">

<input type="text"
name="search"
placeholder="Cari kegiatan..."
value="{{ request('search') }}"
class="border rounded px-3 py-2 text-sm">

<button
class="bg-blue-600 text-white px-4 py-2 rounded text-sm">
Cari
</button>

</form>


<div class="bg-white shadow rounded overflow-hidden">

<table class="w-full text-sm">

<thead class="bg-purple-100">
<tr>
<th class="p-3 text-left">Judul</th>
<th class="p-3 text-left">Jenis</th>
<th class="p-3 text-left">Tanggal</th>
<th class="p-3 text-left">Bukti</th>
<th class="p-3 text-left">Status</th>
<th class="p-3 text-left">Aksi</th>
</tr>
</thead>

<tbody>

@forelse($relations as $item)

<tr class="border-t">

<td class="p-3">
{{ $item->judul }}
</td>

<td class="p-3">
{{ $item->jenis }}
</td>

<td class="p-3">
{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
</td>


{{-- BUKTI DOKUMEN --}}
<td class="p-3">

@if($item->file_dokumen)

<a href="{{ asset('storage/'.$item->file_dokumen) }}"
target="_blank"
class="text-blue-600 text-sm hover:underline">
Lihat
</a>

@else

<span class="text-gray-400 text-sm">
Tidak ada
</span>

@endif

</td>


{{-- STATUS --}}
<td class="p-3">

@if($item->status == 'Draft')

<span class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs">
Draft
</span>

@elseif($item->status == 'Proses')

<span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded text-xs">
Proses
</span>

@elseif($item->status == 'Selesai')

<span class="bg-green-200 text-green-800 px-2 py-1 rounded text-xs">
Selesai
</span>

@endif

</td>


{{-- AKSI --}}
<td class="p-3 flex gap-3">

<a href="{{ route('labour.relations.edit',$item->id) }}"
class="text-blue-600 hover:underline">
Edit
</a>

<form action="{{ route('labour.relations.destroy',$item->id) }}" method="POST">

@csrf
@method('DELETE')

<button
class="text-red-600 hover:underline"
onclick="return confirm('Yakin hapus data?')">
Hapus
</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="6" class="p-6 text-center text-gray-500">
Belum ada data
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

@endsection