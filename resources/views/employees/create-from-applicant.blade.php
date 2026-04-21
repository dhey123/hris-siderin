@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(session('info'))
        <div class="bg-blue-100 text-blue-700 px-4 py-2 rounded mb-4">
            {{ session('info') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Convert Pelamar → Karyawan</h1>

        <a href="{{ route('recruitment.applicants.show', $applicant->id) }}"
           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 text-sm">
            Kembali
        </a>
    </div>

    <form action="{{ route('employees.storeFromApplicant', $applicant->id) }}"
          method="POST"
          class="bg-white shadow rounded p-6 space-y-6">
        @csrf

        {{-- ================= DATA PELAMAR ================= --}}
        <div>
            <h3 class="font-semibold mb-3">Data Pelamar</h3>
            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="text-sm">Nama Lengkap</label>
                    <input type="text" name="full_name" 
                           value="{{ old('full_name', $applicant->name) }}" 
                           class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
                </div>

                <div>
                    <label class="text-sm">NIK</label>
                    <input type="text" name="nik" 
                           value="{{ old('nik', $applicant->nik ?? '') }}" 
                           class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label class="text-sm">Email</label>
                    <input type="email" name="email" 
                           value="{{ old('email', $applicant->email) }}" 
                           class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
                </div>

                <div>
                    <label class="text-sm">No. HP</label>
                    <input type="text" name="phone" 
                           value="{{ old('phone', $applicant->phone) }}" 
                           class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
                </div>

                <div>
                    <label class="text-sm">Tempat Lahir</label>
                    <input type="text" name="birth_place" 
                           value="{{ old('birth_place', $applicant->birth_place ?? '') }}" 
                           class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label class="text-sm">Tanggal Lahir</label>
                    <input type="date" name="birth_date" 
                           value="{{ old('birth_date', $applicant->birth_date?->format('Y-m-d') ?? '') }}" 
                           class="w-full border rounded px-3 py-2">
                </div>

            </div>
        </div>

        {{-- ================= DATA KEPEGAWAIAN ================= --}}
        <div>
            <h3 class="font-semibold mb-3">Data Kepegawaian</h3>
            <div class="grid grid-cols-3 gap-4">

                {{-- Perusahaan --}}
                <div>
                    <label class="text-sm">Perusahaan</label>
                    <select name="company_id" class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Pilih --</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->company_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Jenis Pekerjaan --}}
                <div>
                    <label class="text-sm">Jenis Pekerjaan</label>
                    <select name="employment_type" class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Pilih --</option>
                        @foreach($types as $type)
                            <option value="{{ $type->type_name }}" {{ old('employment_type') == $type->type_name ? 'selected' : '' }}>
                                {{ $type->type_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Posisi --}}
                <div>
                    <label class="text-sm">Posisi</label>
                    <select name="position_id" class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Pilih --</option>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                {{ $position->position_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Departemen --}}
                <div>
                    <label class="text-sm">Departemen</label>
                    <select name="department_id" class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Pilih --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->department_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tanggal Masuk --}}
                <div>
                    <label class="text-sm">Tanggal Masuk</label>
                    <input type="date" name="join_date" 
                           value="{{ old('join_date', now()->toDateString()) }}" 
                           class="w-full border rounded px-3 py-2" required>
                </div>

                {{-- Status Karyawan --}}
                <div>
                    <label class="text-sm">Status Karyawan</label>
                    <input type="text" class="w-full border rounded px-3 py-2 bg-gray-100" value="Active" readonly>
                </div>

            </div>
        </div>

        {{-- ================= ACTION ================= --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('recruitment.applicants.show', $applicant->id) }}" 
               class="px-4 py-2 bg-gray-400 text-white rounded">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Simpan & Jadikan Karyawan
            </button>
        </div>

    </form>
</div>
@endsection
