@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

<h1 class="text-2xl font-bold">Tambah Hubungan Industrial</h1>

<form action="{{ route('labour.relations.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">

@csrf

<div>
<label class="block">Judul</label>
<input type="text" name="judul" class="w-full border rounded p-2">
</div>

<div>
<label class="block">Jenis</label>
<select name="jenis" class="w-full border rounded p-2">
<option value="PP">PP</option>
<option value="Bipartit">Bipartit</option>
<option value="Meeting">Meeting</option>
<option value="Sosialisasi">Sosialisasi</option>
</select>
</div>

<div>
<label class="block">Tanggal</label>
<input type="date" name="tanggal" class="w-full border rounded p-2">
</div>

<div>
<label class="block">Status</label>
<select name="status" class="w-full border rounded p-2">
<option value="Draft">Draft</option>
<option value="Proses">Proses</option>
<option value="Selesai">Selesai</option>
</select>
</div>

<div>
<label class="block">Keterangan</label>
<textarea name="keterangan" class="w-full border rounded p-2"></textarea>
</div>

<div>

<label class="block font-medium mb-2">
Upload Dokumen
</label>

<div id="drop-area"
class="border-2 border-dashed border-gray-300 rounded p-6 text-center cursor-pointer">

<p class="text-gray-500">
Drag & Drop file disini atau klik untuk upload
</p>

<input 
type="file"
name="file_dokumen"
id="fileInput"
accept=".pdf,.doc,.docx"
class="hidden">

</div>

</div>

<button class="bg-green-600 text-white px-4 py-2 rounded">
Simpan
</button>

</form>
<script>

const dropArea = document.getElementById('drop-area');
const fileInput = document.getElementById('fileInput');

dropArea.addEventListener('click', () => {
fileInput.click();
});

dropArea.addEventListener('dragover', (e) => {
e.preventDefault();
dropArea.classList.add('bg-gray-100');
});

dropArea.addEventListener('dragleave', () => {
dropArea.classList.remove('bg-gray-100');
});

dropArea.addEventListener('drop', (e) => {
e.preventDefault();
fileInput.files = e.dataTransfer.files;
dropArea.classList.remove('bg-gray-100');
});

</script>

</div>

@endsection