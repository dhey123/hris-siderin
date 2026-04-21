@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">

    <h1 class="text-2xl font-bold mb-6">{{ isset($employee) ? 'Edit' : 'Tambah' }} Karyawan</h1>

    <form action="{{ isset($employee) ? route('hr.data_karyawan.update', $employee->id) : route('hr.data_karyawan.store') }}" 
          method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($employee))
            @method('PUT')
        @endif

        {{-- ================= PERSONAL INFO ================= --}}
        <div class="bg-white shadow rounded-lg p-6 space-y-4">
            <h2 class="font-semibold text-lg border-b pb-2 mb-4">Info Pribadi</h2>


            <div>
    <label class="block text-sm font-medium text-gray-700">
        ID Karyawan
    </label>

    <input type="text" 
       name="id_karyawan"
       value="{{ old('id_karyawan', '') }}"
       class="mt-1 block w-full rounded border-gray-300 shadow-sm">

    <small class="text-gray-500">
        Kosongkan jika belum ada nomor absen
    </small>
</div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="full_name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $employee->full_name ?? '') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                </div>

               <div class="flex flex-col">

    <label class="block text-sm font-medium text-gray-700 flex items-center gap-2">
        {{-- ICON CAMERA --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h4l2-2h6l2 2h4v12H3V7z"/>
        </svg>
        Foto Karyawan
    </label>

    <input type="file" name="photo" id="photo" class="mt-1 block w-full">

    {{-- INFO UPLOAD RULE --}}
    <small class="text-gray-500 mt-1">
        Maksimal ukuran foto 2MB (jpg, jpeg, png)
    </small>

    {{-- PREVIEW FOTO LAMA --}}
    @if(isset($employee) && $employee->photo)
        <img src="{{ asset('storage/'.$employee->photo) }}"
             class="mt-2 h-32 w-32 object-cover rounded shadow">
    @endif

</div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik', $employee->nik ?? '') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
                </div>

                <div>
                    <label for="birth_place" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                    <input type="text" name="birth_place" id="birth_place" value="{{ old('birth_place', $employee->birth_place ?? '') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
                </div>

                <div>
                    <label for="birth_date" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', isset($employee->birth_date) ? $employee->birth_date->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
                </div>

                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                    <select name="gender" id="gender" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div>
                    <label for="blood_type" class="block text-sm font-medium text-gray-700">Golongan Darah</label>
                    <select name="blood_type" id="blood_type" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
                        <option value="">Pilih Golongan Darah</option>
                        @foreach(['A','B','AB','O'] as $type)
                            <option value="{{ $type }}" {{ old('blood_type', $employee->blood_type ?? '') == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="religion_id" class="block text-sm font-medium text-gray-700">Agama</label>
                    <select name="religion_id" id="religion_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
                        <option value="">Pilih Agama</option>
                        @foreach($religions as $religion)
                            <option value="{{ $religion->id }}" {{ old('religion_id', $employee->religion_id ?? '') == $religion->id ? 'selected' : '' }}>
                                {{ $religion->religion_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="education_id" class="block text-sm font-medium text-gray-700">Pendidikan</label>
                    <select name="education_id" id="education_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        <option value="">Pilih Pendidikan</option>
                        @foreach($educations as $edu)
                            <option value="{{ $edu->id }}" {{ old('education_id', $employee->education_id ?? '') == $edu->id ? 'selected' : '' }}>
                                {{ $edu->education_level }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="kk_number" class="block text-sm font-medium text-gray-700">No. KK</label>
                    <input type="text" name="kk_number" id="kk_number" value="{{ old('kk_number', $employee->kk_number ?? '') }}"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                </div>

          <div>
    <label for="bpjs_kes" class="block text-sm font-medium text-gray-700">BPJS Kesehatan</label>
    <input type="text" name="bpjs_kes" id="bpjs_kes" 
        value="{{ old('bpjs_kes', $employee->bpjs_kes ?? '') }}" 
        class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
</div>

<div>
    <label for="bpjs_tk" class="block text-sm font-medium text-gray-700">BPJS Ketenagakerjaan</label>
    <input type="text" name="bpjs_tk" id="bpjs_tk" 
        value="{{ old('bpjs_tk', $employee->bpjs_tk ?? '') }}" 
        class="mt-1 block w-full rounded border-gray-300 shadow-sm">
</div>


                <div>
                    <label for="mother_name" class="block text-sm font-medium text-gray-700">Nama Ibu Kandung</label>
                    <input type="text" name="mother_name" id="mother_name" value="{{ old('mother_name', $employee->mother_name ?? '') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
                </div>

        <div>
    <label for="npwp" class="block text-sm font-medium text-gray-700">NPWP</label>
    <input type="text" name="npwp" id="npwp" 
        value="{{ old('npwp', $employee->npwp ?? '') }}" 
        class="mt-1 block w-full rounded border-gray-300 shadow-sm" required >
</div>

                <div>
                    <label for="marital_status_id" class="block text-sm font-medium text-gray-700">Status Perkawinan</label>
                    <select name="marital_status_id" id="marital_status_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        <option value="">Pilih Status</option>
                        @foreach($marital_statuses as $status)
                            <option value="{{ $status->id }}" {{ old('marital_status_id', $employee->marital_status_id ?? '') == $status->id ? 'selected' : '' }}>
                                {{ $status->marital_status_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>



        {{-- ================= CONTACT INFO ================= --}}
        <div class="bg-white shadow rounded-lg p-6 space-y-4">
            <h2 class="font-semibold text-lg border-b pb-2 mb-4">Kontak</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">No HP</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $employee->phone ?? '') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $employee->email ?? '') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                </div>

                <div>
                    <label for="address_ktp" class="block text-sm font-medium text-gray-700">Alamat KTP</label>
                    <input type="text" name="address_ktp" id="address_ktp" value="{{ old('address_ktp', $employee->address_ktp ?? '') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                </div>

                <div>
                    <label for="address_domisili" class="block text-sm font-medium text-gray-700">Alamat Domisili</label>
                    <input type="text" name="address_domisili" id="address_domisili" value="{{ old('address_domisili', $employee->address_domisili ?? '') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                </div>
            </div>
        </div>

        {{-- ================= EMPLOYMENT INFO ================= --}}
        <div class="bg-white shadow rounded-lg p-6 space-y-4">
            <h2 class="font-semibold text-lg border-b pb-2 mb-4">Info Kepegawaian</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="company_id" class="block text-sm font-medium text-gray-700">Department</label>
                    <select name="company_id" id="company_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        <option value="">Pilih Departement</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ old('company_id', $employee->company_id ?? '') == $company->id ? 'selected' : '' }}>
                                {{ $company->company_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="department_id" class="block text-sm font-medium text-gray-700">Divisi</label>
                    <select name="department_id" id="department_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        <option value="">Pilih Divisi</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id', $employee->department_id ?? '') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->department_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="position_id" class="block text-sm font-medium text-gray-700">Posisi</label>
                    <select name="position_id" id="position_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        <option value="">Pilih Posisi</option>
                        @foreach($positions as $pos)
                            <option value="{{ $pos->id }}" {{ old('position_id', $employee->position_id ?? '') == $pos->id ? 'selected' : '' }}>
                                {{ $pos->position_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="employment_type_id" class="block text-sm font-medium text-gray-700">Tipe Karyawan</label>
                    <select name="employment_type_id" id="employment_type_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        <option value="">Pilih Tipe</option>
                        @foreach($employment_types as $type)
                            <option value="{{ $type->id }}" {{ old('employment_type_id', $employee->employment_type_id ?? '') == $type->id ? 'selected' : '' }}>
                                {{ $type->type_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="employment_status_id" class="block text-sm font-medium text-gray-700">Status Kerja</label>
                    <select name="employment_status_id" id="employment_status_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        <option value="">Pilih Status</option>
                        @foreach($employment_statuses as $status)
                            <option value="{{ $status->id }}" {{ old('employment_status_id', $employee->employment_status_id ?? '') == $status->id ? 'selected' : '' }}>
                                {{ $status->status_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="join_date" class="block text-sm font-medium text-gray-700">Tanggal Masuk</label>
                    <input type="date" name="join_date" id="join_date" value="{{ old('join_date', isset($employee->join_date) ? $employee->join_date->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                </div>
                <div><label class="block text-sm font-medium text-gray-700">Tanggal Berakhir Kontrak</label>
                 <input type="date"name="tanggal_akhir_kontrak" class="mt-1 block w-full border-gray-300 rounded">
                <p class="text-xs text-gray-500 mt-1">Kosongkan jika karyawan tetap </p>
                </div>
       
                <div>
                    <label for="rekomendasi" class="block text-sm font-medium text-gray-700">Rekomendasi</label>
                    <input type="text" name="rekomendasi" id="rekomendasi" value="{{ old('rekomendasi', $employee->rekomendasi ?? '') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                </div>

                <div>
                    <label for="exit_date" class="block text-sm font-medium text-gray-700">Tanggal Keluar</label>
                    <input type="date" name="exit_date" id="exit_date" value="{{ old('exit_date', isset($employee->exit_date) ? $employee->exit_date->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                </div>

                <div class="col-span-2">
                    <label for="reason_resign" class="block text-sm font-medium text-gray-700">Alasan Resign</label>
                    <textarea name="reason_resign" id="reason_resign" rows="2" class="mt-1 block w-full rounded border-gray-300 shadow-sm">{{ old('reason_resign', $employee->reason_resign ?? '') }}</textarea>
                </div>
            </div>
        </div>

        {{-- ================= BANK & EMERGENCY ================= --}}
        <div class="bg-white shadow rounded-lg p-6 space-y-4">
            <h2 class="font-semibold text-lg border-b pb-2 mb-4">Bank & Emergency Contact</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="bank_id" class="block text-sm font-medium text-gray-700">Bank</label>
                    <select name="bank_id" id="bank_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        <option value="">Pilih Bank</option>
                        @foreach($banks as $bank)
                            <option value="{{ $bank->id }}" {{ old('bank_id', $employee->bank_id ?? '') == $bank->id ? 'selected' : '' }}>
                                {{ $bank->bank_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="bank_account" class="block text-sm font-medium text-gray-700">No Rekening</label>
                    <input type="text" name="bank_account" id="bank_account" value="{{ old('bank_account', $employee->bank_account ?? '') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                </div>

                <div>
                    <label for="emergency_name" class="block text-sm font-medium text-gray-700">Nama Emergency</label>
                    <input type="text" name="emergency_name" id="emergency_name" value="{{ old('emergency_name', $employee->emergency_name ?? '') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                </div>

                <div>
                    <label for="emergency_relation" class="block text-sm font-medium text-gray-700">Hubungan Emergency</label>
                    <input type="text" name="emergency_relation" id="emergency_relation" value="{{ old('emergency_relation', $employee->emergency_relation ?? '') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                </div>

                <div>
                    <label for="emergency_phone" class="block text-sm font-medium text-gray-700">No HP Emergency</label>
                    <input type="text" name="emergency_phone" id="emergency_phone" value="{{ old('emergency_phone', $employee->emergency_phone ?? '') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                </div>
            </div>
        </div>

        {{-- ================= FAMILY MEMBERS ================= --}}
        <div class="bg-white shadow rounded-lg p-6 space-y-4">
            <h2 class="font-semibold text-lg border-b pb-2 mb-4">Data Keluarga</h2>
            <div id="family-members-wrapper">
                @if(isset($employee) && $employee->familyMembers->count() > 0)
                    @foreach($employee->familyMembers as $i => $fm)
                        <div class="grid grid-cols-4 gap-4 mb-4 family-member-item">
                            <input type="hidden" name="family_id[]" value="{{ $fm->id }}">
                            <div>
                                <label class="block text-sm">Nama</label>
                                <input type="text" name="family_name[]" value="{{ $fm->name }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                            </div>
                            <div>
                    <label class="block text-sm">Hubungan</label>
                     <select name="family_relation[]" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
                            <option value="">- Pilih Hubungan -</option>
                            <option value="anak" {{ $fm->relationship == 'anak' ? 'selected' : '' }}>Anak</option>
                            <option value="istri" {{ $fm->relationship == 'istri' ? 'selected' : '' }}>Istri</option>
                            <option value="suami" {{ $fm->relationship == 'suami' ? 'selected' : '' }}>Suami</option>
                            <option value="orang_tua" {{ $fm->relationship == 'orang_tua' ? 'selected' : '' }}>Orang Tua</option>
                            <option value="kakak" {{ $fm->relationship == 'kakak' ? 'selected' : '' }}>Kakak</option>
                            <option value="adik" {{ $fm->relationship == 'adik' ? 'selected' : '' }}>Adik</option>
                        </select>
                                </div>

                            <div>
                                <label class="block text-sm">Tanggal Lahir</label>
                                <input type="date" name="family_birth_date[]" value="{{ $fm->birth_date }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                            </div>
                            <div class="flex items-end space-x-2">
                                <label class="block text-sm invisible">Hapus</label>
                                <button type="button" onclick="this.closest('.family-member-item').remove()" class="px-2 py-1 bg-red-600 text-white rounded">Hapus</button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <button type="button" onclick="addFamilyMember()" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">+ Tambah Anggota Keluarga</button>
        </div>

        <div>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>

{{-- ================= FAMILY JS ================= --}}
<script>
function addFamilyMember() {
    const wrapper = document.getElementById('family-members-wrapper');
    const html = `
    <div class="grid grid-cols-4 gap-4 mb-4 family-member-item">
        <div>
            <label class="block text-sm">Nama</label>
            <input type="text" name="family_name[]" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
        </div>
       <div>
            <label class="block text-sm">Hubungan</label>
            <select name="family_relation[]" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
                <option value="">- Pilih Hubungan -</option>
                    <option value="anak">Anak</option>
                    <option value="istri">Istri</option>
                    <option value="suami">Suami</option>
                    <option value="orang_tua">Orang Tua</option>
                    <option value="kakak">Kakak</option>
                    <option value="adik">Adik</option>
            </select>
        </div>
        <div>
            <label class="block text-sm">Tanggal Lahir</label>
            <input type="date" name="family_birth_date[]" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
        </div>
        <div>
    <label>Tanggungan</label>
    <select name="family_is_dependent[]" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
        <option value="0">Tidak</option>
        <option value="1">Ya</option>
    </select>
</div>
        <div class="flex items-end space-x-2">
            <label class="block text-sm invisible">Hapus</label>
            <button type="button" onclick="this.closest('.family-member-item').remove()" class="px-2 py-1 bg-red-600 text-white rounded">Hapus</button>
        </div>
    </div>`;
    wrapper.insertAdjacentHTML('beforeend', html);
}
</script>

@endsection
