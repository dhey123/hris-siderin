@extends('layouts.app')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Pengajuan Cuti</h1>
        <p class="text-sm text-gray-500">Tambah dan kelola pengajuan cuti karyawan</p>
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 3000)"
             x-show="show"
             x-transition
             class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERROR --}}
    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg shadow">
            {{ session('error') }}
        </div>
    @endif

    {{-- FORM --}}
    <form action="{{ route('cuti.request.store') }}"
          method="POST"
          class="space-y-4"
          x-data="{
            query: '',
            selectedId: null,
            selectedDept: '-',
            selectedPos: '-',
            selectedStatus: '-',
            selectedCompany: '-',
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
                this.selectedStatus = emp.employment_status;
                this.selectedCompany = emp.company_name;
                this.show = false;
            },

            reset() {
                this.query = '';
                this.selectedId = null;
                this.selectedDept = '-';
                this.selectedPos = '-';
                this.selectedStatus = '-';
                this.selectedCompany = '-';
            }
          }"
    >
        @csrf

        {{-- KARYAWAN --}}
        <div class="relative">
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

            {{-- DROPDOWN --}}
            <ul x-show="show && filtered.length"
                @click.outside="show = false"
                x-transition
                class="absolute z-20 w-full bg-white border rounded-lg mt-1 max-h-48 overflow-y-auto shadow">

                <template x-for="emp in filtered" :key="emp.id">
                    <li @click="select(emp)"
                        class="px-3 py-2 cursor-pointer hover:bg-green-200 rounded"
                        x-text="emp.full_name">
                    </li>
                </template>
            </ul>

            <p x-show="query && !selectedId" class="text-xs text-red-500 mt-1">
                Pilih karyawan dari daftar
            </p>

            {{-- INFO BOX --}}
            <div class="mt-3 space-y-2 text-sm">

                <div class="border p-2 rounded">
                    <span class="font-medium">Department:</span>
                    <span x-text="selectedDept"></span>
                </div>

                <div class="border p-2 rounded">
                    <span class="font-medium">Posisi:</span>
                    <span x-text="selectedPos"></span>
                </div>

                <div class="border p-2 rounded">
                    <span class="font-medium">Status:</span>
                    <span x-text="selectedStatus"></span>
                </div>

                <div class="border p-2 rounded">
                    <span class="font-medium">Company:</span>
                    <span x-text="selectedCompany"></span>
                </div>

            </div>
        </div>

        {{-- JENIS CUTI --}}
        <div>
            <label class="block text-sm font-medium">Jenis Cuti</label>
            <select name="leave_type_id" class="w-full border rounded p-2" required>
                @foreach($types as $type)
                    <option value="{{ $type->id }}">
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- TANGGAL --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Tanggal Mulai</label>
                <input type="date" name="start_date" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium">Tanggal Selesai</label>
                <input type="date" name="end_date" class="w-full border rounded p-2" required>
            </div>
        </div>

        {{-- ALASAN --}}
        <div>
            <label class="block text-sm font-medium">Alasan</label>
            <textarea name="reason" class="w-full border rounded p-2"></textarea>
        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end gap-2">

            <button type="button"
                    @click="reset()"
                    class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                Reset
            </button>

            <button type="submit"
                    :disabled="!selectedId"
                    class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 disabled:opacity-50">
                Simpan Pengajuan
            </button>

        </div>

    </form>
</div>
@endsection