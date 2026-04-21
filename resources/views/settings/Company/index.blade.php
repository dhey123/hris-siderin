@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Perusahaan</h1>

    {{-- Alert sukses --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form Tambah Perusahaan --}}
    <form action="{{ route('settingS.companies.store') }}" method="POST" class="mb-4 flex gap-2">
        @csrf
        <input type="text" name="company_name" placeholder="Nama Perusahaan" class="border rounded px-2 py-1" required>
        <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Tambah</button>
    </form>

    {{-- Daftar Perusahaan --}}
    <table class="table-auto w-full border-collapse border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2 text-left">#</th>
                <th class="border px-4 py-2 text-left">Nama Perusahaan</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($companies as $index => $company)
                <tr>
                    <td class="border px-4 py-2">{{ $index + 1 }}</td>
                    <td class="border px-4 py-2">{{ $company->company_name }}</td>
                    <td class="border px-4 py-2 flex gap-2 justify-center">
                        <a href="{{ route('settings.companies.edit', $company->id) }}" class="bg-yellow-400 px-2 py-1 rounded text-white">Edit</a>
                        <form action="{{ route('settings.companies.destroy', $company->id) }}" method="POST" onsubmit="return confirm('Hapus perusahaan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 px-2 py-1 rounded text-white">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
