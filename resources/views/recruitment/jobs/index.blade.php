@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4">Daftar Lowongan</h1>

<a href="{{ route('recruitment.jobs.create') }}"
   class="bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">
    Buat Lowongan Baru
</a>

<table class="w-full border">
    <thead>
        <tr class="bg-gray-100">
            <th class="border px-2 py-1">Judul</th>
            <th class="border px-2 py-1">Departemen</th>
            <th class="border px-2 py-1">Lokasi</th>
            <th class="border px-2 py-1">Pelamar</th>
            <th class="border px-2 py-1">Status</th>
            <th class="border px-2 py-1">Aksi</th>
        </tr>
    </thead>
    <tbody>
       @foreach($jobs as $job)
        <tr
            @if($job->status === 'open')
                onclick="window.location='{{ route('recruitment.jobs.show', $job) }}'"
                class="cursor-pointer hover:bg-gray-50"
            @else
                class="bg-gray-100 opacity-60 cursor-not-allowed"
            @endif
            >

                <td class="border px-2 py-1 font-medium">
                    {{ $job->title }}
                </td>

                <td class="border px-2 py-1">
                    {{ $job->department_name }}
                </td>

                <td class="border px-2 py-1">
                    {{ $job->location_name }}
                </td>


                {{-- 📊 COUNTER PELAMAR --}}
                <td class="border px-2 py-1 text-center">
                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                        {{ $job->applicants_count > 0 ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-600' }}">
                        {{ $job->applicants_count }}
                    </span>
                </td>

                {{-- 🔁 TOGGLE STATUS --}}
                <td class="border px-2 py-1 capitalize">
                    <form action="{{ route('recruitment.jobs.toggle-status', $job) }}"
                          method="POST"
                          onclick="event.stopPropagation()">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="px-2 py-1 rounded text-xs font-semibold
                            {{ $job->status === 'open'
                                ? 'bg-green-100 text-green-700 hover:bg-green-200'
                                : 'bg-red-100 text-red-700 hover:bg-red-200' }}">
                            {{ $job->status }}
                        </button>
                    </form>
                </td>

                {{-- ⛔ AKSI (AMAN) --}}
                <td class="border px-2 py-1" onclick="event.stopPropagation()">
                    <a href="{{ route('recruitment.jobs.show', $job) }}"
                       class="text-blue-600 hover:underline">
                        Detail
                    </a>
                    |
                    <a href="{{ route('recruitment.jobs.edit', $job) }}"
                       class="text-yellow-600 hover:underline">
                        Edit
                    </a>
                    |
                    <form action="{{ route('recruitment.jobs.destroy', $job) }}"
                          method="POST"
                          class="inline"
                          onsubmit="return confirm('Yakin hapus lowongan ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:underline">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $jobs->links() }}
</div>
@endsection
