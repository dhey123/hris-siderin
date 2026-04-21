@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-xl font-bold">Status Kerja</h1>
    <a href="{{ route('settings.employment_status.create') }}"
       class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
        + Tambah Status Kerja
    </a>
</div>

<div class="overflow-x-auto bg-white shadow rounded">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">No</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Status Kerja</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($employmentStatuses as $index => $status)
                <tr>
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">{{ $status->status_name }}</td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('settings.employment_status.edit', $status) }}"
                           class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</a>
                        <form action="{{ route('settings.employment_status.destroy', $status) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Yakin mau hapus?')"
                                class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-4 py-2 text-center text-gray-500">Belum ada Status Kerja</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
