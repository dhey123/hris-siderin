@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow p-6">

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-800">Manajemen HR</h2>

        <a href="{{ route('users.create') }}"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
            + Tambah HR
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg">
            <thead class="bg-gray-100 text-gray-700 text-sm">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Foto</th> {{-- 🔥 tambahan --}}
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700">
                @forelse($users as $user)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>

                        {{-- FOTO --}}
                        <td class="px-4 py-3">
                            <img src="{{ $user->photo 
                                ? asset('storage/' . $user->photo) 
                                : asset('images/default-avatar.png') }}"
                                class="w-10 h-10 rounded-full object-cover border">
                        </td>

                        <td class="px-4 py-3 font-medium">{{ $user->name }}</td>
                        <td class="px-4 py-3">{{ $user->email }}</td>

                        <td class="px-4 py-3 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-center space-x-2">
                            <a href="{{ route('users.edit', $user) }}"
                               class="inline-block px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded text-xs">
                                Edit
                            </a>

                            <form action="{{ route('users.toggle', $user) }}"
                                  method="POST"
                                  class="inline">
                                @csrf
                                @method('PATCH')
                                <button class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded text-xs">
                                    {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>

                            <form action="{{ route('users.destroy', $user) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Yakin hapus akun HR ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded text-xs">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                            Belum ada akun HR
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection