@extends('layouts.app')

@section('content')
<div class="p-6">

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Compliance
        </h1>
        <p class="text-sm text-gray-500">
            Monitoring sertifikasi dan regulasi perusahaan
        </p>
    </div>

    <a href="{{ route('legal.compliance.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
       + Tambah Compliance
    </a>
</div>

<div class="bg-white shadow-sm rounded-xl border overflow-x-auto">

<table class="min-w-full text-sm">

<thead class="bg-blue-50 text-gray-600">
<tr>
<th class="px-4 py-3 text-left">Nama Compliance</th>
<th class="px-4 py-3 text-left">Nomor</th>
<th class="px-4 py-3 text-left">Tanggal Terbit</th>
<th class="px-4 py-3 text-left">Tanggal Berakhir</th>
<th class="px-4 py-3 text-left">Status</th>
<th class="px-4 py-3 text-left">Sisa Hari</th>
<th class="px-4 py-3 text-center">Aksi</th>
</tr>
</thead>

<tbody class="divide-y">

@forelse($compliances as $c)

<tr class="hover:bg-gray-50">

<td class="px-4 py-3">
{{ $c->nama_compliance }}
</td>

<td class="px-4 py-3">
{{ $c->nomor ?? '-' }}
</td>

<td class="px-4 py-3 whitespace-nowrap">
{{ $c->tanggal_terbit 
    ? \Carbon\Carbon::parse($c->tanggal_terbit)->format('d M Y') 
    : '-' }}
</td>

<td class="px-4 py-3 whitespace-nowrap">
{{ $c->tanggal_berakhir 
    ? \Carbon\Carbon::parse($c->tanggal_berakhir)->format('d M Y') 
    : '-' }}
</td>

<td class="px-4 py-3">

<span class="px-2 py-1 text-xs rounded {{ $c->status_color }}">
    {{ $c->status }}
</span>

</td>
<td class="px-4 py-3">
{{ $c->sisa_hari_text }}
</td>

<td class="px-4 py-3 text-center flex gap-2 justify-center">

<a href="{{ route('legal.compliance.edit',$c->id) }}"
class="text-blue-600 hover:underline">
Edit
</a>

<form action="{{ route('legal.compliance.destroy',$c->id) }}"
method="POST"
onsubmit="return confirm('Hapus data?')">

@csrf
@method('DELETE')

<button class="text-red-600 hover:underline">
Hapus
</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="6" class="text-center py-6 text-gray-400">
Belum ada data compliance
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

<div class="mt-4">
{{ $compliances->links() }}
</div>

</div>
@endsection