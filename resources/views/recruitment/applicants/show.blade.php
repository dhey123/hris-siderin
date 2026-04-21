@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Detail Pelamar</h2>
    <a href="{{ route('recruitment.applicants.index') }}"
       class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 text-sm">
        Kembali
    </a>
</div>

{{-- INFO PELAMAR --}}
<div class="grid grid-cols-2 gap-4 mb-6">
    <div>
        <p><strong>Nama:</strong> {{ $applicant->name }}</p>
        <p><strong>Nik:</strong> {{ $applicant->nik }}</p>
        <p><strong>Email:</strong> {{ $applicant->email }}</p>
        <p><strong>No. HP:</strong> {{ $applicant->phone ?? '-' }}</p>
    </div>
    <div>
        <p><strong>Posisi:</strong> {{ $applicant->position ?? '-' }}</p>
        <p><strong>Status:</strong>
            @php
                $statusColor = match($applicant->status) {
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'approved' => 'bg-green-100 text-green-800',
                    'rejected' => 'bg-red-100 text-red-800',
                    default => 'bg-gray-100 text-gray-700',
                };
            @endphp
            <span class="px-2 py-1 rounded text-xs {{ $statusColor }}">
                {{ ucfirst($applicant->status) }}
            </span>
        </p>

        @if($applicant->cv)
            <p>
                <strong>CV:</strong>
                <a href="{{ route('recruitment.applicants.download-cv', $applicant->id) }}"
                   target="_blank"
                   class="text-blue-600 hover:underline">
                    Download
                </a>
            </p>
        @endif
    </div>
</div>

{{-- FORM UBAH TAHAPAN --}}
<h3 class="text-lg font-bold mb-2">Ubah Tahapan</h3>
<form action="{{ route('recruitment.applicants.update-stage', $applicant->id) }}"
      method="POST"
      class="flex flex-col md:flex-row md:items-center space-y-2 md:space-y-0 md:space-x-2 mb-6">
    @csrf
    @method('PUT')

    <select name="stage" class="border rounded px-2 py-1">
        @foreach(['screening','interview','psikotes','test_kerja','mcu','komitmen'] as $stageOption)
            <option value="{{ $stageOption }}"
                {{ $applicant->latestNote->stage === $stageOption ? 'selected' : '' }}>
                {{ ucfirst(str_replace('_',' ',$stageOption)) }}
            </option>
        @endforeach
    </select>

    <input type="text"
           name="note"
           placeholder="Catatan (opsional)"
           class="border rounded px-2 py-1 flex-1">

    <button type="submit"
            class="bg-green-500 text-white px-4 py-1 rounded hover:bg-green-600">
        Update Tahapan
    </button>
</form>

{{-- FORM UBAH STATUS --}}
<h3 class="text-lg font-bold mb-2">Ubah Status</h3>
<form action="{{ route('recruitment.applicants.update-status', $applicant->id) }}"
      method="POST"
      class="flex flex-col md:flex-row md:items-center space-y-2 md:space-y-0 md:space-x-2 mb-6">
    @csrf
    @method('PUT')

    <select name="status" class="border rounded px-2 py-1" required>
        @foreach(['pending','approved','rejected'] as $statusOption)
            <option value="{{ $statusOption }}"
                {{ $applicant->status === $statusOption ? 'selected' : '' }}>
                {{ ucfirst($statusOption) }}
            </option>
        @endforeach
    </select>

    <button type="submit"
            class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600">
        Update Status
    </button>
</form>

{{-- TOMBOL JADIKAN KARYAWAN --}}
@if(
    $applicant->status === 'approved'
    && !$applicant->is_blacklisted
    && !$applicant->employee
)
    <div class="mb-6">
        <a href="{{ route('employees.createFromApplicant', $applicant->id) }}"
           class="inline-block bg-green-600 text-white px-5 py-2 rounded hover:bg-green-700 text-sm">
            Jadikan Karyawan
        </a>
    </div>
@endif

{{-- BLACKLIST --}}
@if(!$applicant->is_blacklisted)
<form action="{{ route('recruitment.applicants.blacklist', $applicant->id) }}" method="POST">
    @csrf
    @method('PATCH')

    <label class="block text-sm font-medium mb-1">
        Alasan Blacklist
    </label>

    <textarea name="blacklist_reason"
              class="w-full border rounded p-2 text-sm"
              placeholder="Contoh: Pernah mangkir, data palsu, dll"></textarea>

    <button class="mt-2 bg-red-600 text-white px-4 py-2 rounded text-sm">
        Blacklist Pelamar
    </button>
</form>
@else
<div class="bg-red-50 border border-red-200 p-3 rounded">
    <p class="text-sm text-red-700 font-semibold">Pelamar diblacklist</p>
    <p class="text-xs text-gray-600">
        Alasan: {{ $applicant->blacklist_reason ?? '-' }}
    </p>
</div>
@endif

{{-- RIWAYAT NOTE --}}
<h3 class="text-lg font-bold mb-2">Riwayat Tahapan / Catatan</h3>
<ul class="mt-2 border rounded p-2">
    @foreach($applicant->notes as $note)
        @php
            $noteStageColor = match($note->stage) {
                'screening' => 'bg-blue-100 text-blue-700',
                'interview' => 'bg-purple-100 text-purple-700',
                'psikotes' => 'bg-indigo-100 text-indigo-700',
                'test_kerja' => 'bg-orange-100 text-orange-700',
                'mcu' => 'bg-teal-100 text-teal-700',
                'komitmen' => 'bg-green-100 text-green-700',
                default => 'bg-gray-100 text-gray-700',
            };
        @endphp

        <li class="border-b last:border-b-0 py-1 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <span class="px-2 py-1 rounded text-xs {{ $noteStageColor }}">
                    {{ ucfirst(str_replace('_',' ',$note->stage)) }}
                </span>
                @if($note->user) oleh {{ $note->user->name }} @endif
                - {{ $note->note ?? '-' }}
            </div>
            <span class="text-gray-500 text-sm">
                {{ $note->created_at->format('d M Y H:i') }}
            </span>
        </li>
    @endforeach
</ul>
@endsection
