@extends('layouts.app')

@section('content')

<div class="p-6 max-w-xl mx-auto space-y-6">

<h1 class="text-2xl font-bold">
Edit Hubungan Industrial
</h1>

<form action="{{ route('labour.relations.update',$relation->id) }}" 
method="POST" 
enctype="multipart/form-data"
class="space-y-4">

@csrf
@method('PUT')

{{-- JUDUL --}}
<div>
<label class="block text-sm font-medium mb-1">
Judul
</label>

<input type="text"
name="judul"
value="{{ $relation->judul }}"
class="w-full border rounded px-3 py-2"
required>
</div>


{{-- JENIS --}}
<div>
<label class="block text-sm font-medium mb-1">
Jenis
</label>

<select name="jenis"
class="w-full border rounded px-3 py-2">

<option value="PP"
{{ $relation->jenis == 'PP' ? 'selected' : '' }}>
PP
</option>

<option value="Meeting"
{{ $relation->jenis == 'Meeting' ? 'selected' : '' }}>
Meeting
</option>

<option value="Sosialisasi"
{{ $relation->jenis == 'Sosialisasi' ? 'selected' : '' }}>
Sosialisasi
</option>

</select>
</div>


{{-- TANGGAL --}}
<div>
<label class="block text-sm font-medium mb-1">
Tanggal
</label>

<input type="date"
name="tanggal"
value="{{ $relation->tanggal }}"
class="w-full border rounded px-3 py-2"
required>
</div>


{{-- FILE --}}
<div>

<label class="block text-sm font-medium mb-1">
Upload Dokumen
</label>

<input type="file"
name="file_dokumen"
class="w-full border rounded px-3 py-2">

@if($relation->file_dokumen)

<p class="text-sm mt-2">
File saat ini :
<a href="{{ asset('storage/'.$relation->file_dokumen) }}"
class="text-green-600">
Download
</a>
</p>

@endif

</div>


{{-- STATUS --}}
<div>
<label class="block text-sm font-medium mb-1">
Status
</label>

<select name="status"
class="w-full border rounded px-3 py-2">

<option value="Draft"
{{ $relation->status == 'Draft' ? 'selected' : '' }}>
Draft
</option>

<option value="Proses"
{{ $relation->status == 'Proses' ? 'selected' : '' }}>
Proses
</option>

<option value="Selesai"
{{ $relation->status == 'Selesai' ? 'selected' : '' }}>
Selesai
</option>

</select>

</div>


{{-- KETERANGAN --}}
<div>

<label class="block text-sm font-medium mb-1">
Keterangan
</label>

<textarea name="keterangan"
rows="4"
class="w-full border rounded px-3 py-2">{{ $relation->keterangan }}</textarea>

</div>


{{-- BUTTON --}}
<div class="flex gap-3">

<button
class="bg-blue-600 text-white px-4 py-2 rounded">
Update
</button>

<a href="{{ route('labour.relations.index') }}"
class="bg-gray-400 text-white px-4 py-2 rounded">
Batal
</a>

</div>

</form>

</div>

@endsection