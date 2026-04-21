@extends('layouts.app')

@section('content')
<div class="max-w-xl bg-white rounded-xl shadow p-6">

    <h2 class="text-xl font-bold mb-6">Edit Akun HR</h2>

    <form action="{{ route('users.update', $user) }}" 
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- FOTO --}}
        <div class="mb-4 text-center">
            <img id="preview"
                 src="{{ $user->photo 
                    ? asset('storage/' . $user->photo) 
                    : asset('images/default-avatar.png') }}"
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
                   value="{{ $user->name }}"
                   class="w-full border rounded-lg px-4 py-2"
                   required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">Email</label>
            <input type="email" name="email"
                   value="{{ $user->email }}"
                   class="w-full border rounded-lg px-4 py-2"
                   required>
        </div>

        {{-- PASSWORD --}}
        <div class="mb-4">
    <label class="block text-sm font-semibold mb-1">
        Password Baru <span class="text-xs text-gray-400">(opsional)</span>
    </label>

    <div class="relative">
        <input type="password" name="password" id="password"
               class="w-full h-11 border rounded-lg px-4 pr-10">

        <button type="button"
            onclick="togglePassword('password', this)"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-green-600">
            <i class="fa-solid fa-eye"></i>
        </button>
    </div>
</div>

        <div class="mb-6">
    <label class="block text-sm font-semibold mb-1">Konfirmasi Password</label>

    <div class="relative">
        <input type="password" name="password_confirmation" id="password_confirmation"
               class="w-full h-11 border rounded-lg px-4 pr-10">

        <button type="button"
            onclick="togglePassword('password_confirmation', this)"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-green-600">
            <i class="fa-solid fa-eye"></i>
        </button>
    </div>

</div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('users.index') }}"
               class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-100">
                Batal
            </a>

            <button class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold">
                Update
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

// 👁 toggle password + icon switch
function togglePassword(id, el) {
    const input = document.getElementById(id);
    const icon = el.querySelector('i');

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = "password";
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endsection