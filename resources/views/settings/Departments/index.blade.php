@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <!-- Judul Halaman -->
    <h1 class="text-2xl font-bold mb-4">Master Departments</h1>

    <!-- Tombol Tambah Department -->
    <a href="{{ route('settings.departments.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
        Tambah Department
    </a>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Departments -->
    <div class="overflow-x-auto">
        <table class="w-full table-auto border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Nama Department</th>
                    <th class="border px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departments as $index => $department)
                    <tr class="hover:bg-gray-50">
                        <!-- Nomor urut -->
                        <td class="border px-4 py-2 text-center">{{ $departments->firstItem() + $index }}</td>

                        <!-- Nama Department -->
                        <td class="border px-4 py-2">{{ $department->department_name }}</td>

                        <!-- Aksi -->
                        <td class="border px-4 py-2 flex gap-2 justify-center">
                            <a href="{{ route('settings.departments.edit', $department->id) }}" 
                               class="bg-yellow-400 hover:bg-yellow-500 px-3 py-1 rounded text-white">
                               Edit
                            </a>

                            <form action="{{ route('settings.departments.destroy', $department->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus?')" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-white">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="border px-4 py-2 text-center text-gray-500">
                            Belum ada department.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination (kalau pakai paginate di controller) -->
    <div class="mt-4">
        {{ $departments->links() }}
    </div>
</div>
@endsection
