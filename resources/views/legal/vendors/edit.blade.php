@extends('layouts.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Edit Vendor
        </h1>
        <p class="text-sm text-gray-500">
            Legal Management / Master Data
        </p>
    </div>

    {{-- Error --}}
    @if ($errors->any())
    <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded">
        <ul class="list-disc ml-5 text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Card Form --}}
    <div class="bg-white rounded-xl shadow p-6">

        <form action="{{ route('legal.vendors.update',$vendor->id) }}" method="POST" class="space-y-6">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Nama Vendor --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Nama Vendor *
                    </label>

                    <input type="text"
                           name="nama_vendor"
                           value="{{ old('nama_vendor',$vendor->nama_vendor) }}"
                           class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200"
                           required>
                </div>


                {{-- Jenis Vendor --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Jenis Vendor
                    </label>

                    <input type="text"
                           name="jenis_vendor"
                           value="{{ old('jenis_vendor',$vendor->jenis_vendor) }}"
                           class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200">
                </div>


                {{-- NPWP --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        NPWP
                    </label>

                    <input type="text"
                           name="npwp"
                           value="{{ old('npwp',$vendor->npwp) }}"
                           class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200">
                </div>


                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Email
                    </label>

                    <input type="email"
                           name="email"
                           value="{{ old('email',$vendor->email) }}"
                           class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200">
                </div>


                {{-- No Telp --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        No Telepon
                    </label>

                    <input type="text"
                           name="no_telp"
                           value="{{ old('no_telp',$vendor->no_telp) }}"
                           class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200">
                </div>


                {{-- Kontak Person --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Kontak Person
                    </label>

                    <input type="text"
                           name="kontak_person"
                           value="{{ old('kontak_person',$vendor->kontak_person) }}"
                           class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200">
                </div>


                {{-- Alamat --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">
                        Alamat
                    </label>

                    <textarea name="alamat"
                              rows="3"
                              class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200">{{ old('alamat',$vendor->alamat) }}</textarea>
                </div>


                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Status
                    </label>

                    <select name="status"
                            class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200">

                        <option value="Aktif" {{ $vendor->status == 'Aktif' ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="Nonaktif" {{ $vendor->status == 'Nonaktif' ? 'selected' : '' }}>
                            Nonaktif
                        </option>

                    </select>
                </div>

            </div>


            {{-- Buttons --}}
            <div class="flex justify-end gap-3 pt-4 border-t">

                <a href="{{ route('legal.vendors.index') }}"
                   class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                    Batal
                </a>

                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                    Update
                </button>

            </div>

        </form>

    </div>

</div>
@endsection