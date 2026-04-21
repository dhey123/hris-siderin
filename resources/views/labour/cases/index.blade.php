@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

<!-- HEADER -->
<div class="flex justify-between items-center">
<h1 class="text-2xl font-bold">Kasus Karyawan</h1>

<a href="{{ route('labour.cases.create') }}"
class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
+ Tambah Kasus
</a>
</div>

<!-- STATISTIK -->
<div class="grid grid-cols-4 gap-4">

<div class="bg-white shadow rounded p-4">
<p class="text-sm text-gray-500">Total Kasus</p>
<p class="text-2xl font-bold">{{ $cases->count() }}</p>
</div>

<div class="bg-white shadow rounded p-4">
<p class="text-sm text-gray-500">Open</p>
<p class="text-2xl font-bold text-red-600">
{{ $cases->where('status','Open')->count() }}
</p>
</div>

<div class="bg-white shadow rounded p-4">
<p class="text-sm text-gray-500">Proses</p>
<p class="text-2xl font-bold text-yellow-600">
{{ $cases->where('status','Proses')->count() }}
</p>
</div>

<div class="bg-white shadow rounded p-4">
<p class="text-sm text-gray-500">Selesai</p>
<p class="text-2xl font-bold text-green-600">
{{ $cases->where('status','Selesai')->count() }}
</p>
</div>

</div>

<!-- SEARCH + FILTER -->
<div class="bg-white shadow rounded p-4 flex gap-4">

<input type="text"
id="searchInput"
placeholder="Cari nama karyawan..."
class="border rounded px-3 py-2 w-1/3">

<select id="filterKasus"
class="border rounded px-3 py-2">

<option value="">Semua Kasus</option>
<option value="SP1">SP1</option>
<option value="SP2">SP2</option>
<option value="SP3">SP3</option>
<option value="Mediasi">Mediasi</option>
<option value="PHK">PHK</option>

</select>

</div>

<!-- TABLE -->
<div class="bg-white shadow rounded overflow-hidden">

<table class="w-full text-sm">

<thead class="bg-gray-100">
<tr>
<th class="p-3 text-left">Nama Karyawan</th>
<th class="p-3 text-left">Company</th>
<th class="p-3 text-left">Department</th>
<th class="p-3 text-left">Jenis Kasus</th>
<th class="p-3 text-left">Tanggal</th>
<th class="p-3 text-left">Status</th>
<th class="p-3 text-left">Aksi</th>
</tr>
</thead>

<tbody id="caseTable">

@forelse($cases as $item)

<tr class="border-t caseRow">

<td class="p-3 employeeName">
{{ $item->employee->full_name ?? '-' }}
</td>

<td class="p-3">
{{ $item->employee->company->company_name ?? '-' }}
</td>

<td class="p-3">
{{ $item->employee->department->department_name ?? '-' }}
</td>

<td class="p-3 jenisKasus">
{{ $item->jenis_kasus }}
</td>

<td class="p-3">
{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
</td>

<td class="p-3">

@if($item->status == 'Open')

<span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
Open
</span>

@elseif($item->status == 'Proses')

<span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
Proses
</span>

@else

<span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
Selesai
</span>

@endif

</td>

<td class="p-3 flex gap-3">

<a href="{{ route('labour.cases.show',$item->id) }}"
class="text-green-600 hover:underline">
Detail
</a>

<a href="{{ route('labour.cases.edit',$item->id) }}"
class="text-blue-600 hover:underline">
Edit
</a>

<form action="{{ route('labour.cases.destroy',$item->id) }}" method="POST">
@csrf
@method('DELETE')

<button onclick="return confirm('Hapus kasus ini?')"
class="text-red-600 hover:underline">
Hapus
</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="7" class="p-6 text-center text-gray-500">
Belum ada kasus
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

<!-- PAGINATION -->
<div>
{{ $cases->links() }}
</div>

</div>

<script>

let searchInput = document.getElementById("searchInput");
let filterKasus = document.getElementById("filterKasus");

searchInput.addEventListener("keyup", filterTable);
filterKasus.addEventListener("change", filterTable);

function filterTable(){

let keyword = searchInput.value.toLowerCase();
let kasus = filterKasus.value.toLowerCase();

let rows = document.querySelectorAll(".caseRow");

rows.forEach(row => {

let name = row.querySelector(".employeeName").innerText.toLowerCase();
let jenis = row.querySelector(".jenisKasus").innerText.toLowerCase();

let matchName = name.includes(keyword);
let matchKasus = kasus === "" || jenis === kasus;

if(matchName && matchKasus){
row.style.display = "";
}else{
row.style.display = "none";
}

});

}

</script>

@endsection