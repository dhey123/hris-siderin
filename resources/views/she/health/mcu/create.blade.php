@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">

    <h1 class="text-2xl font-bold">Tambah MCU</h1>

    <form action="{{ route('she.health.mcu.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="space-y-4">

            {{-- KARYAWAN AUTOCOMPLETE --}}
            <div
                x-data="{
                    query: '',
                    selectedId: null,
                    show: false,
                    employees: {{ Js::from($employees) }},
                    get filtered() {
                        if (!this.show || this.query.length < 1) return []
                        return this.employees.filter(e =>
                            e.full_name.toLowerCase().includes(this.query.toLowerCase())
                        )
                    },
                    select(emp) {
                        this.query = emp.full_name
                        this.selectedId = emp.id
                        this.show = false
                    }
                }"
                class="relative"
            >
                <label class="block text-sm font-medium mb-1">Karyawan</label>

                <input
                    type="text"
                    x-model="query"
                    @focus="show = true"
                    @keydown.escape="show = false"
                    placeholder="Ketik nama karyawan..."
                    class="w-full border rounded-lg p-2"
                    autocomplete="off"
                    required
                >

                <input type="hidden" name="employee_id" :value="selectedId">

                <ul
                    x-show="show && filtered.length"
                    @click.outside="show = false"
                    x-transition
                    class="absolute z-20 w-full bg-white border rounded-lg mt-1 max-h-48 overflow-y-auto shadow"
                >
                    <template x-for="emp in filtered" :key="emp.id">
                        <li
                            @click="select(emp)"
                            class="px-3 py-2 cursor-pointer hover:bg-green-100"
                            x-text="emp.full_name"
                        ></li>
                    </template>
                </ul>

                <p x-show="query && !selectedId" class="text-xs text-red-500 mt-1">
                    Pilih karyawan dari daftar
                </p>
            </div>

            {{-- JENIS MCU --}}
            <div>
                <label class="block font-medium text-gray-700">Jenis MCU</label>
                <select name="jenis_mcu"
                        class="w-full border px-3 py-2 rounded"
                        required>
                    <option value="">Pilih Jenis MCU</option>
                    <option value="Awal">MCU Awal</option>
                    <option value="Berkala">MCU Berkala</option>
                </select>
            </div>


            {{-- TANGGAL --}}
            <div>
                <label class="block font-medium text-gray-700">Tanggal MCU</label>
                <input type="date" name="tanggal_mcu"
                       class="w-full border px-3 py-2 rounded"
                       required>
            </div>

            {{-- HASIL --}}
            <div>
                <label class="block font-medium text-gray-700">Hasil</label>
                <select name="hasil"
                        class="w-full border px-3 py-2 rounded"
                        required>
                    <option value="">Pilih Hasil</option>
                    <option value="Sehat">Sehat</option>
                    <option value="Tidak Sehat">Tidak Sehat</option>
                    <option value="Perlu Pemeriksaan Lanjutan">Perlu Pemeriksaan Lanjutan</option>
                </select>
            </div>

            {{-- KLINIK --}}
            <div>
                <label class="block font-medium text-gray-700">Klinik</label>
                <input type="text" name="klinik"
                       class="w-full border px-3 py-2 rounded"
                       placeholder="Nama klinik / laboratorium">
            </div>

            {{-- CATATAN --}}
            <div>
                <label class="block font-medium text-gray-700">Catatan</label>
                <textarea name="catatan"
                          class="w-full border px-3 py-2 rounded"
                          placeholder="Catatan tambahan"></textarea>
            </div>

            {{-- FILE --}}
            <div>
                <label class="block font-medium text-gray-700">File Hasil (PDF)</label>
                <input type="file" name="file_hasil"
                       accept="application/pdf"
                       class="w-full">
            </div>

            {{-- ACTION --}}
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('she.health.mcu.index') }}"
                   class="px-4 py-2 rounded border text-gray-600 hover:bg-gray-100 transition">
                    Batal
                </a>

                <button type="submit"
                        :disabled="!selectedId"
                        class="bg-blue-600 text-white px-4 py-2 rounded
                               hover:bg-blue-700 transition disabled:opacity-50">
                    Simpan
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
