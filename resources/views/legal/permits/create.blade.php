@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

<h2 class="text-2xl font-semibold mb-6">Tambah Data Perizinan</h2>

<form action="{{ route('legal.permits.store') }}" 
method="POST" 
enctype="multipart/form-data"
class="bg-white shadow rounded p-6 space-y-4">

@csrf

<div>
<label class="block text-sm font-medium mb-1">Nama Izin</label>
<input type="text" name="nama_izin"
class="w-full border rounded px-3 py-2"
required>
</div>

<div>
<label class="block text-sm font-medium mb-1">Nomor Izin</label>
<input type="text" name="nomor_izin"
class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium mb-1">Instansi Penerbit</label>
<input type="text" name="instansi_penerbit"
class="w-full border rounded px-3 py-2">
</div>

<div class="grid grid-cols-2 gap-4">

<div>
<label class="block text-sm font-medium mb-1">Tanggal Terbit</label>
<input type="date" name="tanggal_terbit"
class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium mb-1">Tanggal Berakhir</label>
<input type="date" name="tanggal_berakhir"
class="w-full border rounded px-3 py-2">
</div>

</div>

<div>
<label class="block text-sm font-medium mb-1">Keterangan</label>
<textarea name="keterangan"
class="w-full border rounded px-3 py-2"></textarea>
</div>

<div>
<label class="block text-sm font-medium mb-1">Upload File</label>
<input type="file" name="file"
class="w-full border rounded px-3 py-2">
</div>

<div class="flex gap-2 pt-4">

<button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
Simpan
</button>

<a href="{{ route('legal.permits.index') }}"
class="bg-gray-400 text-white px-4 py-2 rounded">
Batal
</a>

</div>

</form>

</div>

@endsection