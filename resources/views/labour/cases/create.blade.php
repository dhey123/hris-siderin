@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

<h1 class="text-2xl font-bold">Tambah Kasus Karyawan</h1>

<div class="bg-white p-6 rounded shadow">

<form action="{{ route('labour.cases.store') }}" method="POST">
@csrf

<div class="grid grid-cols-2 gap-6">

<!-- KARYAWAN -->
<div class="relative">

<label class="block text-sm mb-1">Nama Karyawan</label>

<input type="text"
id="employee_search"
placeholder="Ketik nama karyawan..."
autocomplete="off"
class="w-full border rounded px-3 py-2">

<input type="hidden" name="employee_id" id="employee_id">

<ul id="employee_list"
class="absolute left-0 right-0 bg-white border rounded shadow mt-1 hidden max-h-48 overflow-y-auto z-50">
</ul>

</div>

<!-- DEPARTMENT -->
<div>
<label class="block text-sm mb-1">Department</label>

<input type="text" id="department"
class="w-full border rounded px-3 py-2 bg-gray-100"
readonly>
</div>

<!-- COMPANY -->
<div>
<label class="block text-sm mb-1">Company</label>

<input type="text" id="company"
class="w-full border rounded px-3 py-2 bg-gray-100"
readonly>
</div>

<!-- JENIS KASUS -->
<div>
<label class="block text-sm mb-1">Jenis Kasus</label>

<select name="jenis_kasus"
class="w-full border rounded px-3 py-2">

<option value="">Pilih</option>
<option value="SP1">SP1</option>
<option value="SP2">SP2</option>
<option value="SP3">SP3</option>
<option value="Mediasi">Mediasi</option>
<option value="PHK">PHK</option>

</select>

</div>

<!-- TANGGAL -->
<div>
<label class="block text-sm mb-1">Tanggal</label>

<input type="date" name="tanggal"
class="w-full border rounded px-3 py-2">
</div>

<!-- STATUS -->
<div>
<label class="block text-sm mb-1">Status</label>

<select name="status"
class="w-full border rounded px-3 py-2">

<option value="Open">Open</option>
<option value="Proses">Proses</option>
<option value="Selesai">Selesai</option>

</select>

</div>

</div>

<!-- KRONOLOGI -->
<div class="mt-6">

<label class="block text-sm mb-1">Kronologi Kasus</label>

<textarea name="kronologi"
class="w-full border rounded px-3 py-2"></textarea>

</div>

<div class="mt-6 flex gap-3">

<button type="submit"
class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
Simpan
</button>

<a href="{{ route('labour.cases.index') }}"
class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
Kembali
</a>

</div>

</form>

</div>

</div>

<script>

let employees = @json($employees);

let search = document.getElementById("employee_search");
let list = document.getElementById("employee_list");

search.addEventListener("input", function(){

let keyword = this.value.toLowerCase();

list.innerHTML = "";

if(keyword.length < 1){
list.classList.add("hidden");
return;
}

let filtered = employees.filter(emp =>
emp.full_name.toLowerCase().includes(keyword)
);

filtered.slice(0,8).forEach(emp => {

let li = document.createElement("li");

li.className = "px-3 py-2 hover:bg-gray-100 cursor-pointer border-b";

li.innerHTML = `
<div class="font-medium">${emp.full_name}</div>
<div class="text-xs text-gray-500">${emp.department_name ?? '-'} | ${emp.company_name ?? '-'}</div>
`;

li.onclick = function(){

document.getElementById("employee_search").value = emp.full_name;
document.getElementById("employee_id").value = emp.id;

document.getElementById("department").value = emp.department_name ?? "-";
document.getElementById("company").value = emp.company_name ?? "-";

list.classList.add("hidden");

}

list.appendChild(li);

});

if(filtered.length > 0){
list.classList.remove("hidden");
}else{
list.classList.add("hidden");
}

});

document.addEventListener("click", function(e){

if(!search.contains(e.target) && !list.contains(e.target)){
list.classList.add("hidden");
}

});

</script>

@endsection