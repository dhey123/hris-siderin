@extends('layouts.public')

@section('content')
<div class="container mx-auto py-6">

    <h1 class="text-2xl font-bold mb-4">Lowongan Tersedia</h1>

    @if(session('success'))
        <div class="p-3 mb-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($jobs->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
            @foreach($jobs as $job)
                <div class="border p-4 rounded shadow hover:shadow-lg transition">
                    <h2 class="font-semibold text-lg">{{ $job->title }}</h2>
                    <p class="text-sm text-gray-600">{{ $job->department ?? '-' }}</p>
                    <p class="text-sm text-gray-600">{{ $job->location ?? '-' }}</p>
                    <p class="text-sm mt-2">
                        Status: 
                        <span class="{{ $job->status == 'open' ? 'text-green-600' : 'text-red-600' }}">
                            {{ ucfirst($job->status) }}
                        </span>
                    </p>
                    @if($job->status == 'open')
                        <a href="{{ route('career.apply', $job->id) }}" 
                           class="mt-2 inline-block px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                           Lamar
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">Belum ada lowongan tersedia.</p>
    @endif

</div>
@endsection
