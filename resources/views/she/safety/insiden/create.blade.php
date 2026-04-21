@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Insiden Kerja</h1>
        <p class="text-sm text-gray-500">Catatan & laporan insiden keselamatan kerja</p>
    </div>

    {{-- NAVIGATION --}}
    <div class="flex border-b mb-4">
        {{-- Link ke halaman index --}}
        <a href="{{ route('she.safety.insiden.index') }}"
           class="px-4 py-2 border-b-2 font-semibold text-sm
                  border-transparent text-gray-500 hover:text-gray-700">
           📊 Daftar Insiden
        </a>

        {{-- Highlight tombol create --}}
        <span class="px-4 py-2 border-b-2 font-semibold text-sm border-blue-600 text-blue-600">
            ➕ Tambah Insiden
        </span>
    </div>

    {{-- FORM ADD INSIDEN --}}
    <div class="bg-white rounded-xl border p-6">

        <form action="{{ route('she.safety.insiden.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Nama Karyawan (autocomplete) --}}
            <div>
                <label class="block text-sm font-medium mb-1">Nama Karyawan</label>
                <input list="employee_list" name="employee_name" id="employee_name"
                       class="w-full border rounded-lg p-2"
                       placeholder="Ketik nama karyawan..."
                       value="{{ old('employee_name') }}">
                
                {{-- Hidden input untuk employee_id --}}
                <input type="hidden" name="employee_id" id="employee_id" value="{{ old('employee_id') }}">

                <datalist id="employee_list">
                    @foreach($employees as $e)
                    <option value="{{ $e->full_name }}"
                            data-id="{{ $e->id }}"
                            data-company="{{ $e->company->company_name ?? '' }}"
                            data-department="{{ $e->department->department_name ?? $e->department ?? '' }}"
                            data-bagian="{{ $e->position->position_name ?? $e->bagian ?? '' }}">
                    @endforeach
                </datalist>
            </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input readonly id="company" name="company"
                    class="border rounded-lg p-2 bg-gray-50"
                    placeholder="Perusahaan" value="{{ old('company') }}">
            </div>

            {{-- Department & Bagian --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input readonly id="department" name="department"
                       class="border rounded-lg p-2 bg-gray-50"
                       placeholder="Department" value="{{ old('department') }}">
                <input readonly id="bagian" name="bagian"
                       class="border rounded-lg p-2 bg-gray-50"
                       placeholder="Bagian" value="{{ old('bagian') }}">
            </div>

            {{-- Tanggal & Lokasi --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="date" name="incident_date"
                       class="border rounded-lg p-2" required
                       value="{{ old('incident_date') }}">
                <input type="text" name="location"
                       class="border rounded-lg p-2"
                       placeholder="Lokasi kejadian"
                       value="{{ old('location') }}">
            </div>

            {{-- Jenis & Keparahan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="incident_type"
                       class="border rounded-lg p-2"
                       placeholder="Jenis insiden" required
                       value="{{ old('incident_type') }}">
                <select name="severity"
                        class="border rounded-lg p-2" required>
                    <option value="">Tingkat Keparahan</option>
                    @foreach(['ringan','sedang','berat','fatal'] as $s)
                        <option value="{{ $s }}" {{ old('severity')==$s?'selected':'' }}>
                            {{ ucfirst($s) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Deskripsi & Tindakan --}}
           <textarea name="description"
                     class="border rounded-lg p-2 w-full min-h-[50px] md:min-h-[80px]"
                     placeholder="Deskripsi insiden">{{ old('description') }}</textarea>

            <textarea name="action_taken"
                     class="border rounded-lg p-2 w-full min-h-[50px] md:min-h-[80px]"
                     placeholder="Tindakan awal">{{ old('action_taken') }}</textarea>

            {{-- Submit --}}
            <div class="flex justify-end">
                <button class="bg-red-600 text-white px-6 py-2 rounded-lg">
                    💾 Simpan Insiden
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('employee_name').addEventListener('input', function() {
    const val = this.value;
    const options = document.querySelectorAll('#employee_list option');
    options.forEach(opt => {
        if(opt.value === val){
            document.getElementById('employee_id').value = opt.dataset.id || '';
            document.getElementById('company').value = opt.dataset.company || '';
            document.getElementById('department').value = opt.dataset.department || '';
            document.getElementById('bagian').value = opt.dataset.bagian || '';
            
        }
    });
});
</script>
@endsection
