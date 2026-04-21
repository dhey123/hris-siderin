@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">

    <h1 class="text-2xl font-bold">Tambah Surat Dokter</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('she.health.surat-dokter.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        {{-- Karyawan autocomplete --}}
        <div x-data="{
            query: '',
            selectedId: null,
            selectedDept: '-',
            selectedPos: '-',
            show: false,
            employees: {{ Js::from($employees) }},
            get filtered() {
                if (!this.show) return [];
                if (this.query === '') return this.employees;
                return this.employees.filter(e =>
                    e.full_name.toLowerCase().includes(this.query.toLowerCase())
                )
            },
            select(emp) {
                this.query = emp.full_name;
                this.selectedId = emp.id;
                this.selectedDept = emp.department_name;
                this.selectedPos = emp.position_name;
                this.show = false;
            },
            reset() {
                this.selectedId = null;
                this.selectedDept = '-';
                this.selectedPos = '-';
            }
        }" x-init="
            // restore old value dari validasi
            @if(old('employee_id'))
                let oldEmp = employees.find(e => e.id == {{ old('employee_id') }});
                if(oldEmp) select(oldEmp);
            @endif
        " class="relative">

            <label class="block text-sm font-medium mb-1">Karyawan</label>
            <input type="text"
                   x-model="query"
                   @focus="show = true"
                   @input="show = true"
                   @keydown.escape="show = false"
                   @keydown.backspace="if(query==='') reset()"
                   placeholder="Ketik nama karyawan..."
                   class="w-full border rounded-lg p-2"
                   autocomplete="off"
                   required>
            
            <input type="hidden" name="employee_id" :value="selectedId">
            <input type="hidden" name="department" :value="selectedDept">
            <input type="hidden" name="position" :value="selectedPos">

            {{-- Dropdown --}}
            <ul x-show="show && filtered.length"
                @click.outside="show = false"
                x-transition
                class="absolute z-20 w-full bg-white border rounded-lg mt-1 max-h-48 overflow-y-auto shadow">
                <template x-for="emp in filtered" :key="emp.id">
                    <li @click="select(emp)"
                        class="px-3 py-2 cursor-pointer hover:bg-green-200 rounded"
                        x-text="emp.full_name"></li>
                </template>
            </ul>

            <p x-show="query && !selectedId" class="text-xs text-red-500 mt-1">
                Pilih karyawan dari daftar
            </p>

            {{-- Kotak Department & Posisi --}}
            <div class="mt-2 space-y-2">
                <div class="border p-2 rounded">
                    <span class="font-medium">Department: </span><span x-text="selectedDept"></span>
                </div>
                <div class="border p-2 rounded">
                    <span class="font-medium">Posisi: </span><span x-text="selectedPos"></span>
                </div>
            </div>
        </div>

        {{-- Tanggal Surat --}}
        <div>
            <label class="block font-medium">Tanggal Surat</label>
            <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat') }}" class="w-full border p-2 rounded">
        </div>

        {{-- Diagnosa --}}
        <div>
            <label class="block font-medium">Diagnosa</label>
            <input type="text" name="diagnosa" value="{{ old('diagnosa') }}" class="w-full border p-2 rounded">
        </div>

        {{-- Hari Istirahat --}}
        <div>
            <label class="block font-medium">Hari Istirahat</label>
            <input type="number" name="hari_istirahat" value="{{ old('hari_istirahat') }}" class="w-full border p-2 rounded">
        </div>

        {{-- Tanggal Mulai & Selesai --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-medium">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" class="w-full border p-2 rounded">
            </div>
            <div>
                <label class="block font-medium">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="w-full border p-2 rounded">
            </div>
        </div>

        {{-- Nama Dokter --}}
        <div>
            <label class="block font-medium">Nama Dokter</label>
            <input type="text" name="nama_dokter" value="{{ old('nama_dokter') }}" class="w-full border p-2 rounded">
        </div>

        {{-- Klinik --}}
        <div>
            <label class="block font-medium">Klinik</label>
            <input type="text" name="klinik" value="{{ old('klinik') }}" class="w-full border p-2 rounded">
        </div>

        {{-- File Surat --}}
        <div>
            <label class="block font-medium">File Surat (PDF/JPG/PNG)</label>
            <input type="file" name="file_surat" class="w-full border p-2 rounded">
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end">
            <a href="{{ route('she.health.surat-dokter.index') }}" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 mr-2">Batal</a>
            <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection
