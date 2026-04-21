@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">
{{-- 🔥 ALERT IMPORT --}}
    @if(session('error_list'))
    <div class="bg-red-100 text-red-700 p-4 rounded-lg shadow">
        <strong>Import Gagal:</strong>
        <ul class="list-disc ml-5 mt-2 text-sm">
            @foreach(session('error_list') as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-lg shadow">
        {{ session('success') }}
    </div>
    @endif

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

        <!-- TITLE -->
        <div>
            <h1 class="text-2xl font-bold text-gray-800">BPJS Management</h1>
            <p class="text-sm text-gray-500">Monitoring pembayaran BPJS karyawan</p>
        </div>

        <!-- FILTER -->
        <form method="GET" class="flex flex-wrap items-center gap-2">
            <input type="text" name="search" value="{{ $search ?? '' }}"
                placeholder="Cari nama / NIK..."
                class="border rounded px-3 py-1 text-sm w-52 focus:ring-2 focus:ring-green-500">

            <select name="bulan" class="border rounded px-2 py-1 text-sm">
                @for($i=1; $i<=12; $i++)
                    <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                    </option>
                @endfor
            </select>

            <select name="tahun" class="border rounded px-2 py-1 text-sm">
                @for($y=date('Y'); $y>=2023; $y--)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>

            <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm shadow">
                Filter
            </button>
        </form>
    </div>

    <!-- ACTION TOP -->
    <div class="flex flex-wrap items-center justify-between gap-2">

        <div class="flex gap-2">
            <!-- EXPORT -->
            <a href="{{ route('labour.bpjs.export', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm shadow">
                Export Excel
            </a>

            <!-- TEMPLATE -->
            <a href="{{ route('labour.bpjs.template') }}"
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded text-sm shadow">
                Download Template
            </a>

            <!-- IMPORT -->
            <form action="{{ route('labour.bpjs.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" id="fileInput" class="hidden" required
    onchange="this.form.submit()">

                <button type="button"
    onclick="document.getElementById('fileInput').click()">
    ⬆ Import Excel
</button>

<span id="loading" class="hidden text-sm text-gray-500">Uploading...</span>

<script>
document.getElementById('fileInput').addEventListener('change', function() {
    document.getElementById('loading').classList.remove('hidden');
});
</script>
            </form>
        </div>

        <!-- BULK ACTION (KANAN) -->
        <div class="flex gap-2">
            <button id="markLunas"
                class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded text-sm shadow">
                Tandai Lunas
            </button>

            <button id="markBelum"
                class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm shadow">
                Tandai Belum
            </button>
        </div>

    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-xl shadow overflow-auto">
        <table class="w-full text-sm">

            <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                <tr>
                    <th class="p-3 text-left">Nama</th>
                    <th class="p-3 text-left">NIK</th>
                    <th class="p-3 text-left">Department</th>
                    <th class="p-3 text-center">BPJS Kesehatan</th>
                    <th class="p-3 text-center">BPJS TK</th>
                    <th class="p-3 text-center">Status</th>
                    <th class="p-3 text-center">Aksi</th>
                    <th class="p-3 text-center">
                        <input type="checkbox" id="checkAll">
                    </th>
                </tr>
            </thead>

            <tbody>
            @forelse($data as $item)

            @php
                $isBorongan = $item->employee->isBorongan();
            @endphp

            <tr class="border-t hover:bg-gray-50 transition">

                <!-- NAMA -->
                <td class="p-3">
                    <div class="font-medium text-gray-800">
                        {{ $item->employee->full_name }}
                    </div>
                    @if($isBorongan)
                        <span class="text-[11px] text-gray-400">Borongan</span>
                    @endif
                </td>

                <!-- NIK -->
                <td class="p-3 text-gray-600">
                    {{ $item->employee->nik }}
                </td>

                <!-- COMPANY -->
                <td class="p-3">
                    {{ $item->employee->company->company_name ?? '-' }}
                </td>

                <!-- BPJS KESEHATAN -->
                <td class="p-3 text-center">
                    @if($isBorongan)
                        <span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-500 font-semibold">
                            Mandiri
                        </span>
                    @else
                        <div class="flex flex-col items-center">
                            <span class="{{ $item->bpjs_kesehatan == 'paid' ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' }}">
                                {{ $item->bpjs_kesehatan == 'paid' ? 'Lunas' : 'Belum' }}
                            </span>
                            <span class="text-xs text-gray-500">
                                {{ $item->tanggal_bayar_kesehatan 
                                    ? \Carbon\Carbon::parse($item->tanggal_bayar_kesehatan)->format('d M Y') 
                                    : '-' }}
                            </span>
                        </div>
                    @endif
                </td>

                <!-- BPJS TK -->
                <td class="p-3 text-center">
                    <div class="flex flex-col items-center">
                        <span class="{{ $item->bpjs_ketenagakerjaan == 'paid' ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold' }}">
                            {{ $item->bpjs_ketenagakerjaan == 'paid' ? 'Lunas' : 'Belum' }}
                        </span>
                        <span class="text-xs text-gray-500">
                            {{ $item->tanggal_bayar_ketenagakerjaan 
                                ? \Carbon\Carbon::parse($item->tanggal_bayar_ketenagakerjaan)->format('d M Y') 
                                : '-' }}
                        </span>
                    </div>
                </td>

                <!-- STATUS -->
                <td class="p-3 text-center">
                    <span class="px-2 py-1 text-xs rounded 
                        {{ ($item->bpjs_kesehatan == 'paid' && $item->bpjs_ketenagakerjaan == 'paid') 
                            ? 'bg-green-100 text-green-700' 
                            : 'bg-red-100 text-red-700' }}">
                        {{ ($item->bpjs_kesehatan == 'paid' && $item->bpjs_ketenagakerjaan == 'paid') 
                            ? 'Lunas' 
                            : 'Belum' }}
                    </span>
                </td>

                <!-- AKSI -->
                <td class="p-3 text-center">
                    <a href="{{ route('labour.bpjs.show', $item->id) }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs shadow">
                        Detail
                    </a>
                </td>

                <!-- CHECKBOX (KANAN) -->
                <td class="p-3 text-center">
                    <input type="checkbox" class="rowCheckbox" value="{{ $item->id }}">
                </td>

            </tr>

            @empty
            <tr>
                <td colspan="8" class="text-center p-6 text-gray-500">
                    Tidak ada data BPJS
                </td>
            </tr>
            @endforelse
            </tbody>

        </table>
    </div>

</div>

<!-- SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const checkAll = document.getElementById('checkAll');

    checkAll?.addEventListener('click', function () {
        document.querySelectorAll('.rowCheckbox').forEach(cb => {
            cb.checked = this.checked;
        });
    });

    function bulkUpdate(status) {

        let ids = Array.from(document.querySelectorAll('.rowCheckbox:checked'))
                      .map(el => el.value);

        if (!ids.length) {
            alert('Pilih data dulu!');
            return;
        }

        const formData = new FormData();
        ids.forEach(id => formData.append('ids[]', id));
        formData.append('status', status);

        fetch('{{ route("labour.bpjs.bulk") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            if (!res.success) {
                alert('Gagal update!');
                return;
            }
            location.reload();
        })
        .catch(() => alert('Server error!'));
    }

    document.getElementById('markLunas')
        ?.addEventListener('click', () => bulkUpdate('paid'));

    document.getElementById('markBelum')
        ?.addEventListener('click', () => bulkUpdate('unpaid'));
});
</script>

@endsection