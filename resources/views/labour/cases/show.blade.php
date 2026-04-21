@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

<h1 class="text-2xl font-bold">Detail Kasus Karyawan</h1>

<div class="bg-white shadow rounded p-6 space-y-4">

<div class="grid grid-cols-2 gap-6">

<div>
<label class="text-sm text-gray-500">Nama Karyawan</label>
<p class="font-semibold">
{{ $case->employee->full_name ?? '-' }}
</p>
</div>

<div>
<label class="text-sm text-gray-500">Company</label>
<p class="font-semibold">
{{ $case->employee->company->company_name ?? '-' }}
</p>
</div>

<div>
<label class="text-sm text-gray-500">Department</label>
<p class="font-semibold">
{{ $case->employee->department->department_name ?? '-' }}
</p>
</div>

<div>
<label class="text-sm text-gray-500">Jenis Kasus</label>
<p class="font-semibold">
{{ $case->jenis_kasus }}
</p>
</div>

<div>
<label class="text-sm text-gray-500">Tanggal Kasus</label>
<p class="font-semibold">
{{ \Carbon\Carbon::parse($case->tanggal)->format('d-m-Y') }}
</p>
</div>

<div>
<label class="text-sm text-gray-500">Status</label>

@if($case->status == 'Open')

<span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
Open
</span>

@elseif($case->status == 'Proses')

<span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
Proses
</span>

@else

<span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
Selesai
</span>

@endif

</div>

</div>

<div>
<label class="text-sm text-gray-500">Kronologi Kasus</label>

<div class="border rounded p-4 bg-gray-50 mt-1">
{{ $case->kronologi ?? '-' }}
</div>

</div>

<div class="flex gap-3 pt-4">

<a href="{{ route('labour.cases.edit',$case->id) }}"
class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
Edit
</a>

<a href="{{ route('labour.cases.index') }}"
class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
Kembali
</a>

</div>

</div>

</div>

@endsection