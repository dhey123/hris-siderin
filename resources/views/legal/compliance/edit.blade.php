@extends('layouts.app')

@section('content')
<div class="p-6">

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        Edit Compliance
    </h1>
    <p class="text-sm text-gray-500">
        Perbarui data compliance perusahaan
    </p>
</div>

<div class="bg-white border rounded-xl shadow-sm p-6">

<form action="{{ route('legal.compliance.update',$compliance->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

<!-- Nama -->
<div>
<label class="text-sm text-gray-600">Nama Compliance</label>
<input type="text"
       name="nama_compliance"
       value="{{ $compliance->nama_compliance }}"
       class="w-full mt-1 border rounded-lg px-3 py-2"
       required>
</div>

<!-- Nomor -->
<div>
<label class="text-sm text-gray-600">Nomor</label>
<input type="text"
       name="nomor"
       value="{{ $compliance->nomor }}"
       class="w-full mt-1 border rounded-lg px-3 py-2">
</div>

<!-- Tanggal Terbit -->
<div>
<label class="text-sm text-gray-600">Tanggal Terbit</label>
<input type="date"
       name="tanggal_terbit"
       value="{{ $compliance->tanggal_terbit }}"
       class="w-full mt-1 border rounded-lg px-3 py-2">
</div>

<!-- Tanggal Berakhir -->
<div>
<label class="text-sm text-gray-600">Tanggal Berakhir</label>
<input type="date"
       name="tanggal_berakhir"
       value="{{ $compliance->tanggal_berakhir }}"
       class="w-full mt-1 border rounded-lg px-3 py-2">
</div>

<!-- File -->
<div class="md:col-span-2">
<label class="text-sm text-gray-600">Upload File Baru</label>
<input type="file"
       name="file"
       class="w-full mt-1 border rounded-lg px-3 py-2">

@if($compliance->file_path)
<div class="mt-2 text-sm">
    File saat ini:
    <a href="{{ asset('storage/'.$compliance->file_path) }}"
       target="_blank"
       class="text-blue-600 underline">
       Lihat File
    </a>
</div>
@endif
</div>

</div>

<div class="flex gap-3 mt-6">

<a href="{{ route('legal.compliance.index') }}"
   class="px-4 py-2 bg-gray-200 rounded-lg text-sm">
   Batal
</a>

<button class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700">
    Update
</button>

</div>

</form>

</div>
</div>
@endsection