@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">

    <h1 class="text-2xl font-bold mb-4">Jenis Cuti / Izin</h1>

    {{-- Tombol tambah baru --}}
    <a href="{{ route('settings.jeniscuti.create') }}"
       class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mb-4 inline-block">
        + Tambah Jenis Cuti
    </a>

    {{-- TABEL --}}
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border rounded shadow">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border text-center">No</th>
                    <th class="py-2 px-4 border">Nama Cuti</th>
                    <th class="py-2 px-4 border">Deskripsi</th>
                    <th class="py-2 px-4 border text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($types as $type)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td class="py-2 px-4 border">
                            {{ $type->name }}
                        </td>

                        <td class="py-2 px-4 border">
                            {{ $type->description }}
                        </td>

                        <td class="py-2 px-4 border">
                            <div class="flex justify-center gap-2">

                                {{-- EDIT --}}
                                <button
                                    type="button"
                                    onclick='openEditModal(@json($type->id), @json($type->name), @json($type->description))'
                                    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">
                                    Edit
                                </button>

                                {{-- DELETE --}}
                                <form action="{{ route('settings.jeniscuti.destroy', $type->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin mau hapus jenis cuti ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-500">
                            Belum ada jenis cuti / izin
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ================= MODAL ================= --}}
<div id="editModal"
     class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50">

    <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6">

        <h2 class="text-xl font-bold mb-4">Edit Jenis Cuti</h2>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="text-sm font-semibold">Nama Cuti</label>
                <input type="text"
                       name="name"
                       id="edit_name"
                       class="w-full border rounded px-3 py-2 mt-1 focus:ring focus:ring-yellow-300">
            </div>

            <div class="mb-3">
                <label class="text-sm font-semibold">Deskripsi</label>
                <textarea name="description"
                          id="edit_description"
                          class="w-full border rounded px-3 py-2 mt-1 focus:ring focus:ring-yellow-300"></textarea>
            </div>

            <div class="flex justify-end gap-2 mt-4">

                <button type="button"
                        onclick="closeEditModal()"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Batal
                </button>

                <button type="submit"
                        class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                    Update
                </button>

            </div>
        </form>

    </div>
</div>

{{-- ================= SCRIPT (FIXED TOTAL) ================= --}}
<script>
function openEditModal(id, name, description) {
    document.getElementById('edit_name').value = name ?? '';
    document.getElementById('edit_description').value = description ?? '';

    let urlTemplate = "{{ route('settings.jeniscuti.update', ':id') }}";
    document.getElementById('editForm').action = urlTemplate.replace(':id', id);

    const modal = document.getElementById('editModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>

@endsection