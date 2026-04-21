@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

<h1 class="text-2xl font-bold">Edit Hubungan Pemerintah</h1>

<div class="bg-white p-6 rounded shadow">

<form action="{{ route('labour.government.update',$government->id) }}"
method="POST"
enctype="multipart/form-data">

@csrf
@method('PUT')

<div class="grid grid-cols-2 gap-6">

<div>
<label class="block text-sm mb-1">Instansi</label>

<input type="text"
name="instansi"
value="{{ $government->instansi }}"
class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm mb-1">Agenda</label>

<input type="text"
name="agenda"
value="{{ $government->agenda }}"
class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm mb-1">Tanggal</label>

<input type="date"
name="tanggal"
value="{{ $government->tanggal }}"
class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="block text-sm mb-1">Status</label>

<select name="status"
class="w-full border rounded px-3 py-2">

<option value="Terjadwal"
{{ $government->status == 'Terjadwal' ? 'selected' : '' }}>
Terjadwal
</option>

<option value="Proses"
{{ $government->status == 'Proses' ? 'selected' : '' }}>
Proses
</option>

<option value="Selesai"
{{ $government->status == 'Selesai' ? 'selected' : '' }}>
Selesai
</option>

</select>

</div>

<div>
<label class="block text-sm mb-1">Lampiran</label>

<input type="file"
name="lampiran"
class="w-full border rounded px-3 py-2">

@if($government->lampiran)

<p class="text-sm mt-2">

File sekarang :
<a href="{{ asset('storage/'.$government->lampiran) }}"
target="_blank"
class="text-blue-600 underline">

Lihat File

</a>

</p>

@endif

</div>

</div>

<div class="mt-6">

<label class="block text-sm mb-1">Keterangan</label>

<textarea name="keterangan"
class="w-full border rounded px-3 py-2"
rows="4">{{ $government->keterangan }}</textarea>

</div>

<div class="mt-6 flex gap-3">

<button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
Update
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