@extends('layouts.app')

@section('content')
<div class="flex justify-end space-x-2">
    <a href="{{ route('hr.data_karyawan') }}"
       class="px-4 py-2 bg-gray-500 text-white rounded-xl hover:bg-gray-600">
       Kembali
    </a>
</div>
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Edit Data Karyawan</h1>
    @if ($errors->any())
        <div class="mb-4 rounded-xl bg-red-50 border border-red-300 p-4">
            <ul class="list-disc list-inside text-red-600 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('hr.data_karyawan.update', $employee->id) }}" method="POST" enctype="multipart/form-data" id="employeeForm"  novalidate>
        @csrf
        @method('PUT')

        {{-- ================== TAB CONTENT ================== --}}
        <div class="space-y-6">
{{-- TAB 1: Personal --}}
             <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-lg font-bold mb-4">Personal</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label>ID Karyawan</label>
                        <div class="col-span-2">
    <input type="text" 
       name="id_karyawan"
       value="{{ old('id_karyawan', $employee->id_karyawan) }}"
       class="w-full border p-2 rounded"
       placeholder="Masukkan nomor absen (opsional)">
</div> 
<small class="text-gray-500">
    Kosongkan jika belum ada nomor absen
</small>
                    </div>

                    <div class="col-span-2">
    <label>Foto</label>

    <input type="file" 
           name="photo" 
           accept="image/*"
           class="w-full border bg-white p-2 rounded" 
           onchange="previewImage(event)">

    <small class="text-gray-500">
        Maksimal ukuran 2MB (JPG, JPEG, PNG)
    </small>

    @if($employee->photo)
        <img id="previewPhoto" src="{{ asset('storage/'.$employee->photo) }}" class="h-24 mt-2 rounded">
    @else
        <img id="previewPhoto" class="h-24 mt-2 hidden rounded">
    @endif
</div>

                    <div>
                        <label>Nama Lengkap</label>
                        <input type="text" name="full_name" value="{{ $employee->full_name }}" class="w-full border p-2 rounded bg-gray-100">
                    </div>
                    <div>
                        <label>NIK</label>
                        <input type="text" name="nik" value="{{ $employee->nik }}" class="w-full border p-2 rounded bg-gray-100">
                    </div>

                    <div>
                        <label>NPWP</label>
                        <input type="text" name="npwp" value="{{ $employee->npwp }}" class="w-full border p-2 rounded bg-gray-100">
                    </div>

                    <div>
                        <label>BPJS Kesehatan</label>
                        <input type="text" name="bpjs_kes" value="{{ $employee->bpjs_kes }}" class="w-full border p-2 rounded bg-gray-100">
                    </div>

                    <div>
                        <label>Nama Ibu Kandung</label>
                         <input type="text" name="mother_name" value="{{ $employee->mother_name }}" class="w-full border p-2 rounded bg-gray-100">
                        </div>

                    <div>
                        <label>Tempat Lahir</label>
                        <input type="text" name="birth_place" value="{{ $employee->birth_place }}" class="w-full border p-2 rounded bg-gray-100">
                    </div>

                    <div>
                        <label>Tanggal Lahir</label>
                        <input type="date" name="birth_date" value="{{ optional($employee->birth_date)->format('Y-m-d') }}" class="w-full border rounded p-2">
                    </div>


                     <div>
                         <label>Jenis Kelamin</label>
                         <select name="gender" readonly class="w-full border p-2 rounded bg-gray-100">
                            <option value="">- Pilih -</option>
                            <option value="L" {{ old('gender', $employee->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender', $employee->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label>Golongan Darah</label>
                        <select name="blood_type" readonly class="w-full border p-2 rounded bg-gray-100">
                            <option value="">- Pilih -</option>
                            <option value="A" {{ $employee->blood_type == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ $employee->blood_type == 'B' ? 'selected' : '' }}>B</option>
                            <option value="AB" {{ $employee->blood_type == 'AB' ? 'selected' : '' }}>AB</option>
                            <option value="O" {{ $employee->blood_type == 'O' ? 'selected' : '' }}>O</option>
                        </select>
                    </div>

                    <div>
                        <label>Agama</label>
                        <select name="religion_id" readonly class="w-full border p-2 rounded bg-gray-100">
                            <option value="">- Pilih -</option>
                            @foreach($religions as $religion)
                                <option value="{{ $religion->id }}" {{ $employee->religion_id == $religion->id ? 'selected' : '' }}>
                                    {{ $religion->religion_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                     <div>
                        <label>BPJS Ketenagakerjaan</label>
                        <input type="text" name="bpjs_tk" value="{{ $employee->bpjs_tk }}" class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <label>Status Perkawinan</label>
                        <select name="marital_status_id" class="w-full border p-2 rounded">
                            <option value="">- Pilih -</option>
                            @foreach($marital_statuses as $ms)
                                <option value="{{ $ms->id }}" {{ $employee->marital_status_id == $ms->id ? 'selected' : '' }}>
                                    {{ $ms->marital_status_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label>Pendidikan</label>
                        <select name="education_id" class="w-full border p-2 rounded">
                            <option value="">- Pilih -</option>
                            @foreach($educations as $edu)
                                <option value="{{ $edu->id }}" {{ $employee->education_id == $edu->id ? 'selected' : '' }}>
                                    {{ $edu->education_level }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label>Nomor KK</label>
                        <input type="text" name="kk_number" value="{{ $employee->kk_number }}" class="w-full border p-2 rounded">
                    </div>

                    
                    <div class="col-span-2">
                    <label>Alamat KTP</label>
                        <textarea name="address_ktp" class="w-full border p-2 rounded">{{ $employee->address_ktp }}</textarea>
                    </div>

                    <div class="col-span-2">
                        <label>Alamat Domisili</label>
                        <textarea name="address_domisili" class="w-full border p-2 rounded">{{ $employee->address_domisili }}</textarea>
                    </div>
                </div>

            </div>

            {{-- TAB 2: Kepegawaian --}}
            <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-lg font-bold mb-4">Kepegawaian</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label>Department</label>
                        <select name="company_id" class="w-full border p-2 rounded">
                            @foreach($companies as $c)
                                <option value="{{ $c->id }}" {{ $employee->company_id == $c->id ? 'selected' : '' }}>
                                    {{ $c->company_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label>Divisi</label>
                        <select name="department_id" class="w-full border p-2 rounded">
                            @foreach($departments as $d)
                                <option value="{{ $d->id }}" {{ $employee->department_id == $d->id ? 'selected' : '' }}>
                                    {{ $d->department_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label>Posisi</label>
                        <select name="position_id" class="w-full border p-2 rounded">
                            @foreach($positions as $p)
                                <option value="{{ $p->id }}" {{ $employee->position_id == $p->id ? 'selected' : '' }}>
                                    {{ $p->position_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label>Tipe Karyawan</label>
                        <select name="employment_type_id" class="w-full border p-2 rounded">
                            @foreach($employment_types as $et)
                                <option value="{{ $et->id }}" {{ $employee->employment_type_id == $et->id ? 'selected' : '' }}>
                                    {{ $et->type_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label>Status Kerja</label>
                        <select name="employment_status_id" class="w-full border p-2 rounded">
                            @foreach($employment_statuses as $es)
                                <option value="{{ $es->id }}" {{ $employee->employment_status_id == $es->id ? 'selected' : '' }}>
                                    {{ $es->status_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
    <label class="block text-sm font-medium mb-1">Tanggal Masuk</label>
    @if ($employee->join_date)
        {{-- TAMPILKAN (TERKUNCI) --}}
        <input type="date"
               value="{{ $employee->join_date->format('Y-m-d') }}"
               class="w-full border p-2 rounded bg-gray-100 cursor-not-allowed"
               readonly>

        {{-- KIRIM NILAI LAMA --}}
        <input type="hidden"
               name="join_date"
               value="{{ $employee->join_date->format('Y-m-d') }}">
    @else
        {{-- BOLEH DIISI --}}
        <input type="date"
               name="join_date"
               class="w-full border p-2 rounded">
    @endif
</div>
            <div>
            <label class="block text-sm font-medium text-gray-700">Tanggal Berakhir Kontrak</label>
            <input type="date"name="tanggal_akhir_kontrak"value="{{ $employee->tanggal_akhir_kontrak }}"class="mt-1 block w-full border-gray-300 rounded">
            </div>
                <div>
                    <label for="rekomendasi" class="block text-sm font-medium text-gray-700">Rekomendasi</label>
                    <input type="text" name="rekomendasi" value="{{ old('rekomendasi', $employee->rekomendasi ?? '') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                </div>
                </div>
            </div>

            {{-- TAB 3: Kontak dan Bank --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-lg font-bold mb-4">Kontak & Bank</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label>No HP</label>
                        <input type="text" name="phone" value="{{ $employee->phone }}" class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <label>Email</label>
                        <input type="email" name="email" value="{{ $employee->email }}" class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <label>Nama Emergency</label>
                        <input type="text" name="emergency_name" value="{{ $employee->emergency_name }}" class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <label>Hubungan Emergency</label>
                        <input type="text" name="emergency_relation" value="{{ $employee->emergency_relation }}" class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <label>No Emergency</label>
                        <input type="text" name="emergency_phone" value="{{ $employee->emergency_phone }}" class="w-full border p-2 rounded">
                    </div>

                    <div>
                        <label>Bank</label>
                        <select name="bank_id" class="w-full border p-2 rounded">
                            <option value="">- Pilih Bank -</option>
                            @foreach($banks as $b)
                                <option value="{{ $b->id }}" {{ $employee->bank_id == $b->id ? 'selected' : '' }}>
                                    {{ $b->bank_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label>No Rekening</label>
                        <input type="text" name="bank_account" value="{{ $employee->bank_account }}" class="w-full border p-2 rounded">
                    </div>
                </div>
            </div>

 {{-- TAB 4: Keluarga / Tanggungan --}}

            <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-lg font-bold mb-4">Keluarga & Pajak</h3>
                <div id="familyContainer" class="space-y-4">
                    @foreach($employee->familyMembers as $index => $member)
                        <div class="family-member border p-4 rounded relative">
                            <input type="hidden" name="family[{{ $index }}][id]" value="{{ $member->id }}">
                            <input type="hidden" name="family[{{ $index }}][delete]" value="0">
                            <button type="button" class="absolute top-2 right-2 text-red-500" 
                                onclick="markDelete(this)">×</button>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label>Nama</label>
                                    <input type="text" name="family[{{ $index }}][name]" value="{{ $member->name }}" class="w-full border p-2 rounded">
                                </div>
                              <div>
                                    <label>Hubungan</label>
                                        <select name="family[{{ $index }}][relation]" class="w-full border p-2 rounded">
                                            <option value="">- Pilih Hubungan -</option>
                                            <option value="anak" {{ $member->relationship == 'anak' ? 'selected' : '' }}>Anak</option>
                                            <option value="istri" {{ $member->relationship == 'istri' ? 'selected' : '' }}>Istri</option>
                                            <option value="suami" {{ $member->relationship == 'suami' ? 'selected' : '' }}>Suami</option>
                                            <option value="orang_tua" {{ $member->relationship == 'orang_tua' ? 'selected' : '' }}>Orang Tua</option>
                                            <option value="kakak" {{ $member->relationship == 'kakak' ? 'selected' : '' }}>Kakak</option>
                                            <option value="adik" {{ $member->relationship == 'adik' ? 'selected' : '' }}>Adik</option>
                                        </select>
                                </div>
                                  <div>
                <label>Tanggal Lahir</label>
                <input type="date" name="family[{{ $index }}][birth_date]" value="{{ optional($member->birth_date)->format('Y-m-d') }}"class="w-full border rounded p-2">
            </div>
                                <div>
                                    <label>Tanggungan Pajak</label>
                                    <select name="family[{{ $index }}][tax_dependent]" class="w-full border p-2 rounded">
                                        <option value="0" {{ $member->is_dependent == 0 ? 'selected' : '' }}>Tidak</option>
                                        <option value="1" {{ $member->is_dependent == 1 ? 'selected' : '' }}>Ya</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="button" class="btn btn-secondary mt-2" onclick="addFamily()">+ Tambah Anggota</button>
{{-- ================= BUTTON ================= --}}
    <div class="flex justify-end">
        <button type="submit"
            class="px-6 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700">
            Update Data
        </button>
    </div>
            </div>
        </div>
    </form>
</div>

<script>
let currentTab = 1;
let familyIndex = {{ $employee->familyMembers->count() }};

document.addEventListener('DOMContentLoaded', () => { showTab(currentTab); });

function showTab(tabNumber) {
    document.querySelectorAll('.tab-pane').forEach(tab => tab.classList.add('hidden'));
    document.getElementById('tab' + tabNumber).classList.remove('hidden');
    currentTab = tabNumber;
}
function nextTab() { if(currentTab < 5) showTab(currentTab + 1); }
function prevTab() { if(currentTab > 1) showTab(currentTab - 1); }

// Preview Foto
function previewImage(event){
    const file = event.target.files[0];

    if(file){
        // 🔥 VALIDASI SIZE (2MB)
        if(file.size > 2 * 1024 * 1024){
            alert('Ukuran file terlalu besar! Maksimal 2MB');
            event.target.value = '';
            return;
        }

        let img = document.getElementById('previewPhoto');
        img.classList.remove('hidden');
        img.src = URL.createObjectURL(file);
    }
}

// Family Dynamic
function addFamily(){
    const container = document.getElementById('familyContainer');
    const div = document.createElement('div');
    div.classList.add('family-member','border','p-4','rounded','relative');
    div.innerHTML = `
        <input type="hidden" name="family[${familyIndex}][id]" value="">
        <input type="hidden" name="family[${familyIndex}][delete]" value="0">
        <button type="button" class="absolute top-2 right-2 text-red-500" onclick="markDelete(this)">×</button>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label>Nama</label>
                <input type="text" name="family[${familyIndex}][name]" class="w-full border p-2 rounded">
            </div>
            <div>
                <label>Hubungan</label>
                <select name="family[${familyIndex}][relation]" class="w-full border p-2 rounded">
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
            <label>Tanggal Lahir</label>
            <input type="date"name="family[${familyIndex}][birth_date]"class="w-full border rounded p-2">
            </div>

            <div>
                <label>Pekerjaan</label>
                <input type="text" name="family[${familyIndex}][job]" class="w-full border p-2 rounded">
            </div>
            <div>
                <label>Tanggungan Pajak</label>
                <select name="family[${familyIndex}][tax_dependent]" class="w-full border p-2 rounded">
                    <option value="0">Tidak</option>
                    <option value="1">Ya</option>
                </select>
            </div>
        </div>`;
    container.appendChild(div);
    familyIndex++;
}

// hapus
function markDelete(button){
    const wrapper = button.closest('.family-member');

    // set delete = 1
    wrapper.querySelector('input[name$="[delete]"]').value = 1;

    // hide aja, jangan dihapus
    wrapper.classList.add('hidden');
}

</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const resignDate = document.querySelector('input[name="resign_date"]');
    const resignReason = document.querySelector('input[name="resign_reason"]');

    function toggleResignRequirement() {
        if (resignDate.value) {
            resignReason.setAttribute('required', true);
            resignReason.classList.add('border-red-300');
        } else {
            resignReason.removeAttribute('required');
            resignReason.classList.remove('border-red-300');
            resignReason.value = '';
        }
    }

    resignDate.addEventListener('change', toggleResignRequirement);

    // jalankan saat pertama load
    toggleResignRequirement();
});
</script>
@endsection