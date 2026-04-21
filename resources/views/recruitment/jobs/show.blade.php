@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4">{{ $job->title }}</h1>

<p><strong>Departemen:</strong> {{ $job->department }}</p>
<p><strong>Lokasi:</strong> {{ $job->location }}</p>
<p><strong>Status:</strong> {{ ucfirst($job->status) }}</p>
<p><strong>Deskripsi:</strong></p>
<p>{{ $job->description }}</p>

<a href="{{ route('recruitment.jobs.index') }}" class="text-blue-600 mt-4 inline-block">Kembali</a>
@endsection
