@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

<h1 class="text-2xl font-bold">Tambah Hubungan Pemerintah</h1>

<div class="bg-white p-6 rounded shadow">

<form action="{{ route('labour.government.store') }}" 
method="POST"
enctype="multipart/form-data">

@csrf

<div class="grid grid-cols-2 gap-6">

<div>
<label class="block text-sm mb-1">Instansi</label>
<input type="text" name="instansi"
class="w-full border rounded px-3 py-2" required>
</div>

<div>
<label class="block text-sm mb-1">Agenda</label>
<input type="text" name="agenda"
class="w-full border rounded px-3 py-2" required>
</div>

<div>
<label class="block text-sm mb-1">Tanggal</label>
<input type="date" name="tanggal"
class="w-full border rounded px-3 py-2" required>
</div>

<div>
<label class="block text-sm mb-1">Status</label>

<select name="status"
class="w-full border rounded px-3 py-2">

<option value="Terjadwal">Terjadwal</option>
<option value="Proses">Proses</option>
<option value="Selesai">Selesai</option>

</select>

</div>

</div>

<div class="mt-4">
<label class="block text-sm font-medium mb-1">Lampiran</label>

<input type="file"
name="lampiran"
class="w-full border rounded px-3 py-2">

<p class="text-xs text-gray-500 mt-1">
Format: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG (Maks 5MB)
</p>
</div>

<div class="mt-6">

<label class="block text-sm mb-1">Keterangan</label>

<textarea name="keterangan"
class="w-full border rounded px-3 py-2"
rows="4"></textarea>

</div>

<div class="mt-6 flex gap-3">

<button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
Simpan
</button>

<a href="{{ route('labour.government.index') }}"
class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
Kembali
</a>

</div>

</form>

</div>

</div>

@endsection