@extends('layouts.app')

@section('content')
<div class="max-w-xl bg-white rounded-xl shadow p-6">

    <h2 class="text-xl font-bold mb-6">Edit Profil</h2>

    @if(session('success'))
        <div class="mb-4 text-green-700 bg-green-100 px-4 py-2 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- FOTO --}}
        <div class="mb-4 text-center">
            <img
                src="{{ $user->photo
                        ? asset('storage/'.$user->photo)
                        : asset('default-avatar.png') }}"
                class="w-24 h-24 rounded-full mx-auto mb-2 object-cover border">

            <input type="file"
                   name="photo"
                   accept="image/*"
                   class="block w-full text-sm text-gray-600">
        </div>

        {{-- NAMA --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Nama</label>
            <input type="text"
                   name="name"
                   value="{{ $user->name }}"
                   class="w-full border rounded-lg px-4 py-2"
                   required>
        </div>

        {{-- PASSWORD --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">
                Password Baru (opsional)
            </label>
            <input type="password"
                   name="password"
                   class="w-full border rounded-lg px-4 py-2">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-1">
                Konfirmasi Password
            </label>
            <input type="password"
                   name="password_confirmation"
                   class="w-full border rounded-lg px-4 py-2">
        </div>

        <div class="flex justify-end">
            <button
                class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold">
                Simpan
            </button>
        </div>

    </form>

</div>
@endsection
