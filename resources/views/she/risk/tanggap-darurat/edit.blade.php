@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow">

<h1 class="text-2xl font-bold mb-6">
    Edit Tanggap Darurat - {{ $risk->nama_risiko }}
</h1>

<form action="{{ route('she.risk.tanggap-darurat.update', $risk->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label class="block font-medium">Rencana Darurat</label>
        <textarea name="rencana_darurat"
                  class="w-full border rounded p-2"
                  required>{{ old('rencana_darurat', $risk->emergencyPlan->rencana) }}</textarea>
    </div>

    <div class="mb-4">
        <label class="block font-medium">Contact Person</label>
        <input type="text"
               name="contact_person"
               value="{{ old('contact_person', $risk->emergencyPlan->contact_person) }}"
               class="w-full border rounded p-2">
    </div>

    <div class="mb-4">
        <label class="block font-medium">Catatan</label>
        <textarea name="catatan"
                  class="w-full border rounded p-2">{{ old('catatan', $risk->emergencyPlan->catatan) }}</textarea>
    </div>

    <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        Update
    </button>

</form>

</div>
@endsection