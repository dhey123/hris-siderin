@extends('layouts.app')

@section('content')
<div class="p-6 bg-white rounded shadow">

    <h2 class="text-xl font-bold mb-4">Daftar Pelamar</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border border-gray-200 rounded">
        <thead class="bg-gray-100">
            <tr class="text-left">
                <th class="px-4 py-2 border">Nama</th>
                <th class="px-4 py-2 border">Email</th>
                <th class="px-4 py-2 border">Posisi</th>
                <th class="px-4 py-2 border">Status</th>
                <th class="px-4 py-2 border">CV</th>
                <th class="px-4 py-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($applicants as $applicant)
            <tr class="border-t">
                <td class="px-4 py-2">{{ $applicant->name }}</td>
                <td class="px-4 py-2">{{ $applicant->email }}</td>
                <td class="px-4 py-2">{{ $applicant->position_applied ?? '-' }}</td>
                <td class="px-4 py-2 capitalize">{{ $applicant->status }}</td>
                <td class="px-4 py-2">
                    @if($applicant->cv)
                        <a href="{{ asset('storage/' . $applicant->cv) }}" target="_blank"
                           class="text-blue-600 hover:underline">Download CV</a>
                    @else
                        -
                    @endif
                </td>
                <td class="px-4 py-2 flex gap-2">
                    @if($applicant->status != 'accepted')
                        <form action="{{ route('recruitment.updateStatus', $applicant) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="accepted">
                            <button type="submit" class="px-2 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">Approve</button>
                        </form>
                    @endif

                    @if($applicant->status != 'rejected')
                        <form action="{{ route('recruitment.updateStatus', $applicant) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Reject</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $applicants->links() }}
    </div>
</div>
@endsection
