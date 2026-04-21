@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-xl shadow max-w-xl">

    <h1 class="text-xl font-bold mb-4">Tambah Audit Checklist</h1>

    <form action="{{ route('settings.audit-checklist.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Kode</label>
            <input type="text" name="kode" class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-3">
            <label>Kategori</label>
            <input type="text" name="kategori" class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-3">
            <label>Item</label>
            <textarea name="item" class="w-full border rounded px-3 py-2"></textarea>
        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded">
            Simpan
        </button>
    </form>

</div>
@endsection