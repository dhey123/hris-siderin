@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

<h1 class="text-2xl font-bold">Edit Kasus Karyawan</h1>

<div class="bg-white shadow rounded p-6">

<form action="{{ route('labour.cases.update',$case->id) }}" method="POST">

@csrf
@method('PUT')

<div class="grid grid-cols-2 gap-6">

<div>
<label class="text-sm">Nama Karyawan</label>

<input type="text"
value="{{ $case->employee->full_name }}"
class="w-full border rounded px-3 py-2 bg-gray-100"
readonly>

</div>

<div>
<label class="text-sm">Jenis Kasus</label>

<select name="jenis_kasus"
class="w-full border rounded px-3 py-2">

<option value="SP1" {{ $case->jenis_kasus == 'SP1' ? 'selected' : '' }}>SP1</option>
<option value="SP2" {{ $case->jenis_kasus == 'SP2' ? 'selected' : '' }}>SP2</option>
<option value="SP3" {{ $case->jenis_kasus == 'SP3' ? 'selected' : '' }}>SP3</option>
<option value="Mediasi" {{ $case->jenis_kasus == 'Mediasi' ? 'selected' : '' }}>Mediasi</option>
<option value="PHK" {{ $case->jenis_kasus == 'PHK' ? 'selected' : '' }}>PHK</option>

</select>

</div>

<div>
<label class="text-sm">Tanggal</label>

<input type="date"
name="tanggal"
value="{{ $case->tanggal }}"
class="w-full border rounded px-3 py-2">

</div>

<div>
<label class="text-sm">Status</label>

<select name="status"
class="w-full border rounded px-3 py-2">

<option value="Open" {{ $case->status == 'Open' ? 'selected' : '' }}>Open</option>
<option value="Proses" {{ $case->status == 'Proses' ? 'selected' : '' }}>Proses</option>
<option value="Selesai" {{ $case->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>

</select>

</div>

</div>

<div class="mt-6">

<label class="text-sm">Kronologi Kasus</label>

<textarea name="kronologi"
class="w-full border rounded px-3 py-2">{{ $case->kronologi }}</textarea>

</div>

<div class="mt-6 flex gap-3">

<button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
Update
</button>

<a href="{{ route('labour.cases.index') }}"
class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
Kembali
</a>

</div>

</form>

</div>

</div>

@endsection