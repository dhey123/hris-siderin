@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">

    <h1 class="text-2xl font-bold">Buat Audit Internal</h1>

    <form action="{{ route('she.environment.audit.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-2 gap-4">

            <div>
                <label class="block text-sm">Jenis Audit</label>
                <select name="jenis_audit" class="w-full border p-2 rounded">
                    <option value="Internal">Internal</option>
                </select>
            </div>

            <div>
                <label class="block text-sm">Area</label>
                <input type="text" name="area" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="block text-sm">Tanggal Audit</label>
                <input type="date" name="tanggal_audit" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="block text-sm">Catatan</label>
                <textarea name="catatan" class="w-full border p-2 rounded"></textarea>
            </div>

        </div>

        <div class="mt-6">
            <button class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                Simpan & Generate Checklist
            </button>
        </div>

    </form>

</div>
@endsection