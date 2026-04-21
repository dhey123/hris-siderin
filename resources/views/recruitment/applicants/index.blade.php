@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Daftar Pelamar</h1>

        <a href="{{ route('recruitment.offline.create') }}"
           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-sm">
            + Tambah Lamaran Offline
        </a>
    </div>

     {{-- TAB --}}
    <div class="flex gap-2 mb-4">
    <a href="{{ route('recruitment.applicants.index') }}"
       class="px-3 py-2 rounded {{ request('tab') == null ? 'bg-blue-600 text-white' : 'bg-gray-100' }}">
        Semua
    </a>

    <a href="{{ route('recruitment.applicants.index', ['tab' => 'online']) }}"
       class="px-3 py-2 rounded {{ request('tab') == 'online' ? 'bg-blue-600 text-white' : 'bg-gray-100' }}">
        Online
    </a>

    <a href="{{ route('recruitment.applicants.index', ['tab' => 'offline']) }}"
       class="px-3 py-2 rounded {{ request('tab') == 'offline' ? 'bg-blue-600 text-white' : 'bg-gray-100' }}">
        Offline
    </a>
</div>


    {{-- FILTER --}}
    <form method="GET"
          action="{{ route('recruitment.applicants.index') }}"
          class="mb-4 flex flex-wrap gap-3 items-end bg-white p-4 rounded shadow-sm">

        <div>
            <label class="text-xs text-gray-600">Status</label>
            <select name="status" class="border rounded px-3 py-2 text-sm">
                <option value="">Semua</option>
                <option value="pending"  {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status')=='approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>

        <div>
            <label class="text-xs text-gray-600">Blacklist</label>
            <select name="blacklist" class="border rounded px-3 py-2 text-sm">
                <option value="">Semua</option>
                <option value="1" {{ request('blacklist')==='1' ? 'selected' : '' }}>Blacklist</option>
                <option value="0" {{ request('blacklist')==='0' ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>

        <button class="bg-blue-500 text-white px-4 py-2 rounded text-sm">
            Filter
        </button>

        @if(request()->query())
            <a href="{{ route('recruitment.applicants.index') }}"
               class="text-sm text-gray-500 underline">
                Reset
            </a>
        @endif
    </form>

    {{-- ALERT --}}
@if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="mb-4 flex flex-wrap gap-3">
    <a href="{{ route('recruitment.applicants.index', array_merge(request()->query(), ['status'=>'pending'])) }}"
       class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded text-sm hover:opacity-80">
        Pending: {{ $totalPending }}
    </a>
    <a href="{{ route('recruitment.applicants.index', array_merge(request()->query(), ['status'=>'approved'])) }}"
       class="px-3 py-1 bg-green-100 text-green-800 rounded text-sm hover:opacity-80">
        Approved: {{ $totalApproved }}
    </a>
    <a href="{{ route('recruitment.applicants.index', array_merge(request()->query(), ['status'=>'rejected'])) }}"
       class="px-3 py-1 bg-red-100 text-red-800 rounded text-sm hover:opacity-80">
        Rejected: {{ $totalRejected }}
    </a>
    <a href="{{ route('recruitment.applicants.index', array_merge(request()->query(), ['blacklist'=>1])) }}"
       class="px-3 py-1 bg-gray-100 text-gray-800 rounded text-sm hover:opacity-80">
        Blacklist: {{ $totalBlacklist }}
    </a>
</div>

</div>

{{-- TABLE --}}
<div class="overflow-x-auto bg-white rounded shadow">
    <table class="min-w-full border border-purple-200 text-sm">
        <thead class="sticky top-0 bg-purple-100 z-10">
            <tr class="text-left">
                <th class="px-4 py-3 border-b">Pelamar</th>
                <th class="px-4 py-3 border-b">Lowongan</th>
                <th class="px-4 py-3 border-b">Proses</th>
                <th class="px-4 py-3 border-b">Catatan</th>
                <th class="px-4 py-3 border-b">Apply</th>
                <th class="px-4 py-3 border-b">CV</th>
                <th class="px-4 py-3 border-b">Rekomendasi</th>
                <th class="px-4 py-3 border-b text-center">Blacklist</th>
                <th class="px-4 py-3 border-b text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
        @forelse($applicants as $applicant)
        
            @php
                $stage = $applicant->latestNote->stage ?? null;
                $stageColor = match($stage) {
                    'screening'  => 'bg-blue-100 text-blue-700',
                    'interview'  => 'bg-purple-100 text-purple-700',
                    'psikotes'   => 'bg-indigo-100 text-indigo-700',
                    'test_kerja' => 'bg-orange-100 text-orange-700',
                    'mcu'        => 'bg-teal-100 text-teal-700',
                    'komitmen'   => 'bg-green-100 text-green-700',
                    default      => 'bg-gray-100 text-gray-600',
                };
            @endphp

            <tr onclick="window.location='{{ route('recruitment.applicants.show', $applicant->id) }}'"
    class="cursor-pointer text-sm
        {{ $applicant->status === 'rejected' ? 'bg-red-200 hover:bg-red-300' : '' }}
        {{ $applicant->status === 'approved' ? 'bg-green-200 hover:bg-green-300' : '' }}
        {{ $applicant->status === 'pending' && !$applicant->is_blacklisted ? 'hover:bg-gray-100' : '' }}
        {{ $applicant->is_blacklisted ? 'bg-red-50 hover:bg-red-100' : '' }}">

                {{-- PELAMAR --}}
                <td class="px-4 py-3 border-b">
                    <div class="font-semibold">{{ $applicant->name }}</div>
                    <div class="text-xs text-gray-500">{{ $applicant->email }}</div>
                    <div class="text-xs text-gray-500">{{ $applicant->phone ?? '-' }}</div>
                    <div class="text-xs text-gray-400">
                        NIK: {{ $applicant->nik ?? '-' }}
                    </div>
                </td>

                {{-- LOWONGAN --}}
                <td class="px-4 py-3 border-b">
                    {{ $applicant->job->title ?? '-' }}
                </td>

                {{-- PROSES --}}
                <td class="px-4 py-3 border-b space-y-1">
                    @if($stage)
                        <span class="inline-block px-2 py-1 rounded text-xs {{ $stageColor }}">
                            {{ ucfirst(str_replace('_',' ', $stage)) }}
                        </span>
                    @endif

                    <div>
                        @if($applicant->status === 'pending')
                            <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">Pending</span>
                        @elseif($applicant->status === 'approved')
                            <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Approved</span>
                        @else
                            <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-800">Rejected</span>
                        @endif
                    </div>
                </td>

                {{-- CATATAN --}}
                <td class="px-4 py-3 border-b max-w-xs">
                    <span title="{{ $applicant->latestNote->note ?? '' }}">
                        {{ \Illuminate\Support\Str::limit($applicant->latestNote->note ?? '-', 35) }}
                    </span>
                </td>

                {{-- APPLY --}}
                <td class="px-4 py-3 border-b">
                    {{ $applicant->created_at->format('d M Y') }}
                </td>

                {{-- CV --}}
                <td class="px-4 py-3 border-b">
                    @if($applicant->cv)
                        <a href="{{ route('recruitment.applicants.download-cv', $applicant->id) }}"
                           class="text-blue-600 hover:underline">
                            Download
                        </a>
                    @else
                        -
                    @endif
                </td>

               {{-- REKOMENDASI --}}
<td class="px-4 py-3 border-b">
    {{-- ONLINE --}}
    @if($applicant->application_type === 'online')
        <span class="inline-block px-2 py-1 text-xs font-semibold rounded bg-blue-100 text-blue-700">
            Online
        </span>

    {{-- OFFLINE + REFERRAL --}}
    @elseif($applicant->referralsMerged && $applicant->referralsMerged->count() > 0)
        @foreach($applicant->referralsMerged as $ref)
            @if(!empty($ref['name']) && $ref['name'] !== '-')
                <div class="mb-1">
                    <div class="font-medium">{{ $ref['name'] }}</div>
                    <div class="text-xs text-gray-500">
                        {{ ucfirst($ref['relation'] ?? 'Internal') }}
                    </div>
                </div>
            @endif
        @endforeach

        {{-- Kalau referralsMerged ada tapi semuanya kosong --}}
        @if(
            collect($applicant->referralsMerged)
                ->where('name', '!=', '-')
                ->whereNotNull('name')
                ->count() === 0
        )
            <span class="text-gray-600">Internal</span>
        @endif

    {{-- OFFLINE TANPA REFERRAL --}}
    @else
        <span class="text-gray-600">Internal</span>
    @endif
</td>


                {{-- BLACKLIST --}}
                <td class="px-4 py-3 border-b text-center">
                    <form action="{{ route('recruitment.applicants.blacklist', $applicant->id) }}"
                          method="POST"
                          onsubmit="return confirm('Ubah status blacklist pelamar ini?')">
                        @csrf
                        @method('PATCH')

                        <input type="checkbox"
                               onchange="this.form.submit()"
                               {{ $applicant->is_blacklisted ? 'checked' : '' }}
                               class="w-4 h-4 text-red-600 rounded">
                    </form>
                </td>

                {{-- AKSI --}}
                <td class="px-4 py-3 border-b text-center">
                    <a href="{{ route('recruitment.applicants.show', $applicant->id) }}"
                       class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600">
                        Detail
                    </a>
                </td>
            </tr>

        @empty
            <tr>
                <td colspan="9" class="px-4 py-6 text-center text-gray-500">
                    Belum ada pelamar
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

{{-- PAGINATION --}}
<div class="mt-4">
    {{ $applicants->links() }}
</div>

</div>
@endsection
