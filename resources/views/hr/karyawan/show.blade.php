@extends('layouts.app')

@section('content')
@php
    use Illuminate\Support\Facades\Storage;


    $status = $employee->exit_date ? 'Inactive' : 'Active';

    $isExpired = $employee->tanggal_akhir_kontrak 
        && \Carbon\Carbon::parse($employee->tanggal_akhir_kontrak)->isPast();
@endphp

<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800">Detail Karyawan</h1>
    
    <div class="flex space-x-2">
        <a href="{{ route('hr.data_karyawan') }}"
           class="px-4 py-2 bg-gray-500 text-white rounded-xl hover:bg-gray-600">
           Kembali
        </a>

        <a href="{{ route('hr.data_karyawan.print', $employee->id) }}"
           target="_blank"
           class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700">
            Download PDF
        </a>

        <button onclick="openModal()"
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm">
            ⚙️ Action Kontrak
        </button>

        {{-- ✅ Paklaring hanya kalau Inactive --}}
        @if($status === 'Inactive')
            <button class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm">
                📄 Paklaring
            </button>
        @else
            <button class="px-4 py-2 bg-gray-400 text-white rounded-lg text-sm cursor-not-allowed">
                📄 Paklaring
            </button>
        @endif
    </div>
</div>
{{-- HISTORY --}}
<div class="bg-gray-50 p-4 rounded-xl mt-4">
    <h3 class="font-semibold text-lg mb-3">Riwayat Karyawan</h3>

    @if($employee->histories->count())
        <ol class="border-l-2 border-gray-300 ml-3 space-y-4">
            @foreach($employee->histories as $history)
                <li class="ml-4">
                    <div class="text-sm font-semibold">
                        {{ $history->type }} - {{ $history->status }}
                    </div>
                    <div class="text-xs text-gray-500">
                        {{ \Carbon\Carbon::parse($history->start_date)->format('d M Y') }}
                        @if($history->end_date)
                            - {{ \Carbon\Carbon::parse($history->end_date)->format('d M Y') }}
                        @endif
                    </div>
                    <div class="text-xs text-gray-600">
                        {{ $history->notes }}
                    </div>
                </li>
            @endforeach
        </ol>
    @else
        <p class="text-sm text-gray-500">Belum ada history</p>
    @endif
</div>
<div class="bg-white rounded-2xl shadow p-6 space-y-6">

    {{-- ✅ ALERT KONTRAK HABIS (HANYA ACTIVE) --}}
    @if($isExpired && $status === 'Active')
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-xl">
            ⚠️ Kontrak sudah habis, segera lakukan tindakan
        </div>
    @endif

    {{-- HEADER --}}
    <div class="flex items-center space-x-6">

        {{-- FOTO --}}
        <div>
            @if($employee->photo && Storage::disk('public')->exists($employee->photo))
                <img src="{{ asset('storage/'.$employee->photo) }}"
                     class="h-36 w-36 object-cover rounded-xl border">
            @else
                <div class="h-36 w-36 bg-gray-200 flex items-center justify-center rounded-xl border">
                    <span class="text-gray-400">No Image</span>
                </div>
            @endif
        </div>

        {{-- NAMA + STATUS --}}
        <div>
            <h2 class="text-2xl font-bold">{{ $employee->full_name }}</h2>
            <p class="text-gray-500 mt-1">ID Karyawan: {{ $employee->id_karyawan }}</p>

            <div class="mt-2 flex gap-2">
                {{-- STATUS --}}
                <span class="px-3 py-1 text-xs rounded-full
                    @if($status == 'Active') bg-green-100 text-green-700
                    @elseif($status == 'Inactive') bg-yellow-100 text-yellow-700
                    @else bg-red-100 text-red-700 @endif">
                    {{ $status }}
                </span>

                {{-- 🔥 KONTRAK HABIS (CUMA WARNING) --}}
                @if($isExpired && $status === 'Active')
                    <span class="px-3 py-1 text-xs rounded-full bg-red-500 text-white">
                        Kontrak Habis
                    </span>
                @endif
            </div>
        </div>
    </div>

   

    {{-- INFORMASI PRIBADI --}}
    <div class="bg-gray-50 p-4 rounded-xl">
        <h3 class="font-semibold text-lg mb-3">Informasi Pribadi</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <p><b>NIK:</b> {{ $employee->nik ?? '-' }}</p>
            <p><b>NPWP:</b> {{ $employee->npwp ?? '-' }}</p>
            <p><b>BPJS Kesehatan:</b> {{ $employee->bpjs_kes ?? '-' }}</p>
            <p><b>BPJS Ketenagakerjaan:</b> {{ $employee->bpjs_tk ?? '-' }}</p>
            <p><b>TTL:</b> {{ $employee->birth_place ?? '-' }}, {{ optional($employee->birth_date)->format('d-m-Y') ?? '-' }}</p>
            <p><b>Jenis Kelamin:</b> {{ $employee->gender_text }}</p>
            <p><b>Agama:</b> {{ optional($employee->religion)->religion_name ?? '-' }}</p>
            <p><b>Pendidikan:</b> {{ optional($employee->education)->education_level ?? '-' }}</p>
            <p><b>Status Kawin:</b> {{ optional($employee->maritalStatus)->marital_status_name ?? '-' }}</p>
            <p><b>Status Pajak:</b> {{ $employee->status_pajak }}</p>
            <p><b>Golongan Darah:</b> {{ $employee->blood_type ?? '-' }}</p>
            <p><b>Nama Ibu:</b> {{ $employee->mother_name ?? '-' }}</p>
            <p><b>No KK:</b> {{ $employee->kk_number ?? '-' }}</p>
        </div>
    </div>

    {{-- ALAMAT --}}
    <div class="bg-gray-50 p-4 rounded-xl">
        <h3 class="font-semibold text-lg mb-3">Alamat</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <p><b>Alamat KTP:</b> {{ $employee->address_ktp ?? '-' }}</p>
            <p><b>Alamat Domisili:</b> {{ $employee->address_domisili ?? '-' }}</p>
        </div>
    </div>

    {{-- KONTAK --}}
    <div class="bg-gray-50 p-4 rounded-xl">
        <h3 class="font-semibold text-lg mb-3">Kontak</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <p><b>No HP:</b> {{ $employee->phone ?? '-' }}</p>
            <p><b>Email:</b> {{ $employee->email ?? '-' }}</p>
        </div>
    </div>

    {{-- INFO KEPEGAWAIAN --}}
    <div class="bg-gray-50 p-4 rounded-xl">
        <h3 class="font-semibold text-lg mb-3">Info Kepegawaian</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <p><b>Company:</b> {{ optional($employee->company)->company_name ?? '-' }}</p>
            <p><b>Divisi:</b> {{ optional($employee->department)->department_name ?? '-' }}</p>
            <p><b>Posisi:</b> {{ optional($employee->position)->position_name ?? '-' }}</p>
            <p><b>Tipe:</b> {{ optional($employee->employmentType)->type_name ?? '-' }}</p>
            <p><b>Status:</b> {{ optional($employee->employmentStatus)->status_name ?? '-' }}</p>
            <p><b>Rekomendasi:</b> {{ $employee->rekomendasi ?: '-' }}</p>
            <p><b>Tgl Masuk:</b> {{ optional($employee->join_date)->format('d-m-Y') ?? '-' }}</p>
            <p><b>Akhir Kontrak:</b> {{ $employee->tanggal_akhir_kontrak ? \Carbon\Carbon::parse($employee->tanggal_akhir_kontrak)->format('d-m-Y') : '-' }}</p>
            <p><b>Tgl Keluar:</b> {{ $employee->exit_date ? $employee->exit_date->format('d-m-Y') : '-' }}</p>
            <p><b>Alasan Resign:</b> {{ $employee->reason_resign ?? '-' }}</p>
        </div>
    </div>

    {{-- DATA KELUARGA --}}
    <div class="bg-gray-50 p-4 rounded-xl">
        <h3 class="font-semibold text-lg mb-3">Data Keluarga</h3>

        @if($employee->familyMembers->isNotEmpty())
            <table class="w-full text-sm border">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-2 py-1">Nama</th>
                        <th class="border px-2 py-1">Hubungan</th>
                        <th class="border px-2 py-1">Tanggal Lahir</th>
                        <th class="border px-2 py-1">Tanggungan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employee->familyMembers as $family)
                        <tr>
                            <td class="border px-2 py-1">{{ $family->name }}</td>
                            <td class="border px-2 py-1">{{ ucfirst($family->relationship) }}</td>
                            <td class="border px-2 py-1">{{ optional($family->birth_date)->format('d-m-Y') ?? '-' }}</td>
                            <td class="border px-2 py-1 text-center">
                                @if($family->is_dependent)
                                    <span class="bg-green-500 text-white px-2 py-1 rounded text-xs">Ya</span>
                                @else
                                    <span class="bg-gray-400 text-white px-2 py-1 rounded text-xs">Tidak</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500 text-sm">Belum ada data keluarga</p>
        @endif
    </div>

    {{-- BANK --}}
    <div class="bg-gray-50 p-4 rounded-xl">
        <h3 class="font-semibold text-lg mb-3">Bank & Emergency</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <p><b>Bank:</b> {{ optional($employee->bank)->bank_name ?? '-' }}</p>
            <p><b>No Rekening:</b> {{ $employee->bank_account ?? '-' }}</p>
            <p><b>Nama Emergency:</b> {{ $employee->emergency_name ?? '-' }}</p>
            <p><b>Hubungan:</b> {{ $employee->emergency_relation ?? '-' }}</p>
            <p><b>No HP:</b> {{ $employee->emergency_phone ?? '-' }}</p>
        </div>
    </div>

</div>
{{-- MODAL KONTRAK --}}
<div id="modalKontrak" class="fixed inset-0 bg-black/10 hidden items-center justify-center z-50">
   

    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">

        <h2 class="text-lg font-bold mb-4">Aksi Kontrak</h2>

        <form action="{{ route('hr.data_karyawan.action', $employee->id) }}" method="POST">
            @csrf

            {{-- AKSI --}}
            <div class="mb-4">
                <label class="block text-sm mb-1">Aksi</label>
                <select name="action" id="actionSelect"
                    class="w-full border rounded-lg px-3 py-2"
                    onchange="handleActionChange()"
                    required>
                    <option value="">-- Pilih Aksi --</option>
                    <option value="perpanjang">Perpanjang Kontrak</option>
                    <option value="habis">Habis Kontrak</option>
                    <option value="resign">Resign</option>
                    <option value="phk">PHK</option>
                </select>
            </div>

            {{-- PERPANJANG --}}
            <div id="fieldPerpanjang" class="mb-4 hidden">
                <label class="block text-sm mb-1">Tanggal Pembaruan</label>
                <input type="date" name="tanggal_akhir_kontrak"
                    class="w-full border rounded-lg px-3 py-2">
            </div>

            {{-- KELUAR --}}
            <div id="fieldKeluar" class="mb-4 hidden">
                <label class="block text-sm mb-1">Tanggal Keluar</label>
                <input type="date" name="exit_date"
                    class="w-full border rounded-lg px-3 py-2">
            </div>

            {{-- ALASAN --}}
            <div id="fieldReason" class="mb-4 hidden">
                <label class="block text-sm mb-1">Alasan</label>
                <textarea name="reason"
                    class="w-full border rounded-lg px-3 py-2"></textarea>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeModal()"
                    class="px-4 py-2 bg-gray-400 text-white rounded-lg">
                    Batal
                </button>

                <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg">
                    Simpan
                </button>
            </div>
        </form>

    </div>
</div>

<script>
function openModal() {
    document.getElementById('modalKontrak').classList.remove('hidden');
    document.getElementById('modalKontrak').classList.add('flex');
}

function closeModal() {
    document.getElementById('modalKontrak').classList.add('hidden');
    document.getElementById('modalKontrak').classList.remove('flex');
}

// 🔥 DINAMIC FORM
function handleActionChange() {
    let action = document.getElementById('actionSelect').value;

    let perpanjang = document.getElementById('fieldPerpanjang');
    let keluar = document.getElementById('fieldKeluar');
    let reason = document.getElementById('fieldReason');

    // reset semua
    perpanjang.classList.add('hidden');
    keluar.classList.add('hidden');
    reason.classList.add('hidden');

    if (action === 'perpanjang') {
        perpanjang.classList.remove('hidden');
    }

    if (action === 'resign' || action === 'phk') {
        keluar.classList.remove('hidden');
        reason.classList.remove('hidden');
    }

    if (action === 'habis') {
        // gak perlu input apa2
    }
}

</script>
@endsection