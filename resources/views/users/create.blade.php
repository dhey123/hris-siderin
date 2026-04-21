@extends('layouts.app')

@section('content')
<div class="max-w-xl bg-white rounded-xl shadow p-6">

    <h2 class="text-xl font-bold mb-6">Tambah Akun HR</h2>

    <form action="{{ route('users.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        {{-- FOTO --}}
        <div class="mb-4 text-center">
            <img id="preview"
                 src="{{ asset('images/default-avatar.png') }}"
                 class="w-24 h-24 rounded-full mx-auto mb-2 object-cover border">

            <input type="file"
                   name="photo"
                   accept="image/*"
                   onchange="previewImage(event)"
                   class="block w-full text-sm text-gray-600">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Nama</label>
            <input type="text" name="name"
                   class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-green-200"
                   required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Email</label>
            <input type="email" name="email"
                   class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-green-200"
                   required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Password</label>
            <input type="password" name="password"
                   class="w-full border rounded-lg px-4 py-2"
                   required>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
                   class="w-full border rounded-lg px-4 py-2"
                   required>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('users.index') }}"
               class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-100">
                Batal
            </a>

            <button class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold">
                Simpan
            </button>
        </div>
    </form>

</div>

{{-- PREVIEW FOTO --}}
<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (!file) return;

    const img = document.getElementById('preview');
    img.src = URL.createObjectURL(file);
}
</script>
@endsection