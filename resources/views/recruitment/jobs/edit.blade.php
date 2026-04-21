@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4">{{ isset($job) ? 'Edit Lowongan' : 'Buat Lowongan Baru' }}</h1>

<form action="{{ isset($job) ? route('recruitment.jobs.update', $job) : route('recruitment.jobs.store') }}" method="POST">
    @csrf
    @if(isset($job)) @method('PUT') @endif

    <label>Judul</label>
    <input type="text" name="title" value="{{ $job->title ?? '' }}" required class="w-full border mb-2 px-2 py-1">

    <label>Deskripsi</label>
    <textarea name="description" class="w-full border mb-2 px-2 py-1">{{ $job->description ?? '' }}</textarea>

    <label>Departemen</label>
    <input type="text" name="department" value="{{ $job->department ?? '' }}" class="w-full border mb-2 px-2 py-1">

    <label>Lokasi</label>
    <input type="text" name="location" value="{{ $job->location ?? '' }}" class="w-full border mb-2 px-2 py-1">

    <label>Status</label>
    <select name="status" class="w-full border mb-2 px-2 py-1">
        <option value="open" {{ (isset($job) && $job->status == 'open') ? 'selected' : '' }}>Open</option>
        <option value="closed" {{ (isset($job) && $job->status == 'closed') ? 'selected' : '' }}>Closed</option>
    </select>

    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded mt-2">
        {{ isset($job) ? 'Update' : 'Simpan' }}
    </button>
</form>
@endsection
