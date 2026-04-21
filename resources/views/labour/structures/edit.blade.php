@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

<h1 class="text-2xl font-bold text-gray-800">
Edit Struktur Industrial
</h1>

<div class="bg-white p-6 rounded shadow">

<form action="{{ route('labour.structures.update',$structure->id) }}" method="POST">
@csrf
@method('PUT')

<div class="grid grid-cols-2 gap-6">

<div>
<label class="block text-sm font-medium mb-1">Nama</label>
<input type="text" name="nama" value="{{ $structure->nama }}"
class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium mb-1">Jabatan</label>
<input type="text" name="jabatan" value="{{ $structure->jabatan }}"
class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm font-medium mb-1">Pihak</label>

<select name="pihak"
class="w-full border rounded px-3 py-2">

<option value="Perusahaan"
{{ $structure->pihak == 'Perusahaan' ? 'selected' : '' }}>
Perusahaan
</option>

<option value="Serikat Pekerja"
{{ $structure->pihak == 'Serikat Pekerja' ? 'selected' : '' }}>
Serikat Pekerja
</option>

<option value="Mediator"
{{ $structure->pihak == 'Mediator' ? 'selected' : '' }}>
Mediator
</option>

</select>

</div>

<div>
<label class="block text-sm font-medium mb-1">Kontak</label>
<input type="text" name="kontak" value="{{ $structure->kontak }}"
class="w-full border rounded px-3 py-2">
</div>

</div>

<div class="mt-6 flex gap-3">

<button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
Update
</button>

<a href="{{ route('labour.structures.index') }}"
class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
Kembali
</a>

</div>

</form>

</div>

</div>

@endsection