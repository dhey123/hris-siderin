@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

<h2 class="text-2xl font-semibold mb-6">Edit Data Perizinan</h2>

<form action="{{ route('legal.permits.update',$permit->id) }}" 
method="POST" 
enctype="multipart/form-data"
class="bg-white shadow rounded p-6 space-y-4">

@csrf
@method('PUT')

<div>
<label class="block text-sm font-medium mb-1">Nama Izin</label>
<input type="text" name="nama_izin"
value="{{ $permit->nama_izin }}"
class="w-full border rounded px-3 py-2"
required>
</div>

<div>
<label class="block text-sm font-medium mb-1">Nomor Izin</label>
<input type="text" name="nomor_izin"
value="{{ $permit->nomor_izin }}"
class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium mb-1">Instansi Penerbit</label>
<input type="text" name="instansi_penerbit"
value="{{ $permit->instansi_penerbit }}"
class="w-full border rounded px-3 py-2">
</div>

<div class="grid grid-cols-2 gap-4">

<div>
<label class="block text-sm font-medium mb-1">Tanggal Terbit</label>
<input type="date" name="tanggal_terbit"
value="{{ $permit->tanggal_terbit }}"
class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium mb-1">Tanggal Berakhir</label>
<input type="date" name="tanggal_berakhir"
value="{{ $permit->tanggal_berakhir }}"
class="w-full border rounded px-3 py-2">
</div>

</div>

<div>
<label class="block text-sm font-medium mb-1">Keterangan</label>
<textarea name="keterangan"
class="w-full border rounded px-3 py-2">{{ $permit->keterangan }}</textarea>
</div>

<div>

@if($permit->file)

<p class="text-sm mb-2">
File saat ini:
<a href="{{ asset('storage/'.$permit->file) }}"
target="_blank"
class="text-blue-600 underline">
Download
</a>
</p>

@endif

<label class="block text-sm font-medium mb-1">Ganti File</label>
<input type="file" name="file"
class="w-full border rounded px-3 py-2">

</div>

<div class="flex gap-2 pt-4">

<button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
Update
</button>

<a href="{{ route('legal.permits.index') }}"
class="bg-gray-400 text-white px-4 py-2 rounded">
Batal
</a>

</div>

</form>

</div>

@endsection