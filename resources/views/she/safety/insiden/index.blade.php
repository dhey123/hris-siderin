@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    {{-- BACK --}}
    <div>
        <a href="{{ route('she.safety.index') }}"
           class="text-sm text-gray-600 hover:text-blue-600">
            ⬅ Kembali
        </a>
    </div>

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Kecelakaan Kerja</h1>
        <p class="text-sm text-gray-500">Catatan & laporan Kecelakaan keselamatan kerja</p>
    </div>
    <form action="{{ route('she.safety.insiden.pdf.all') }}" method="GET" class="flex gap-2 mb-4">
    <input type="date" name="start_date" class="border rounded px-2">
    <input type="date" name="end_date" class="border rounded px-2">

    <button class="bg-green-600 text-white px-4 py-2 rounded">
        Cetak Laporan
    </button>
</form>


    {{-- TAB --}}
    <div class="flex border-b">
        <button
            class="px-4 py-2 border-b-2 font-semibold text-sm border-blue-600 text-blue-600">
            📊 Daftar Kecelakaan Kerja
        </button>

        <a href="{{ route('she.safety.insiden.create') }}"
           class="px-4 py-2 border-b-2 font-semibold text-sm
                  border-transparent text-gray-500 hover:text-gray-700">
            ➕ Tambah Insiden
        </a>
    </div>

    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border p-4">
            <p class="text-xs text-gray-500">Total Kecelakaan Kerja</p>
            <p class="text-2xl font-bold">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-xl border p-4">
            <p class="text-xs text-gray-500">Terkirim</p>
            <p class="text-2xl font-bold text-blue-600">{{ $stats['terkirim'] }}</p>
        </div>
        <div class="bg-white rounded-xl border p-4">
            <p class="text-xs text-gray-500">Ditangani</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['ditangani'] }}</p>
        </div>
        <div class="bg-white rounded-xl border p-4">
            <p class="text-xs text-gray-500">Selesai</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['selesai'] }}</p>
        </div>
    </div>

    {{-- GRAFIK STATUS --}}
    <div class="bg-white rounded-xl border p-6">
        <h2 class="font-semibold mb-4">Grafik Status Insiden</h2>
        <div class="relative h-[220px]">
            <canvas id="incidentChart"></canvas>
        </div>
    </div>

    {{-- GRAFIK TAHUNAN --}}
    <div class="bg-white rounded-xl border p-6">
        <h2 class="font-semibold mb-4">Grafik Insiden per Tahun</h2>
        <div class="relative h-[220px]">
            <canvas id="yearlyChart"></canvas>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl border p-4">
        <h2 class="font-semibold mb-4">Daftar Kecelakaan Kerja</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse">
                <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3 text-center">Tanggal</th>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Perusahaan</th>
                        <th class="px-4 py-3 text-left">Department</th>
                        <th class="px-4 py-3 text-left">Lokasi</th>
                        <th class="px-4 py-3 text-center">Keparahan</th>
                        <th class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y text-sm">
                @forelse($incidents as $i)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-center">
                            {{ \Carbon\Carbon::parse($i->incident_date)->format('d-m-Y') }}
                        </td>

                        <td class="px-4 py-3 font-medium">
                            <a href="{{ route('she.safety.insiden.show',$i->id) }}"
                               class="text-blue-600 hover:underline">
                                {{ $i->nama_karyawan ?? $i->employee->full_name }}
                            </a>
                        </td>

                        <td class="px-4 py-3">
                            {{ $i->employee->company->company_name ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $i->department ?? $i->employee->department->department_name ?? '-' }}
                        </td>

                        <td class="px-4 py-3">{{ $i->location }}</td>

                        <td class="px-4 py-3 text-center">
                            <span class="px-3 py-1 rounded-full text-xs
                            {{ $i->severity=='fatal'?'bg-red-100 text-red-700':
                               ($i->severity=='berat'?'bg-orange-100 text-orange-700':
                               ($i->severity=='sedang'?'bg-yellow-100 text-yellow-700':
                               'bg-green-100 text-green-700')) }}">
                               {{ ucfirst($i->severity) }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-center">
                            <span class="px-3 py-1 rounded-full text-xs
                            {{ $i->status=='terkirim'?'bg-gray-100 text-gray-700':
                               ($i->status=='ditangani'?'bg-yellow-100 text-yellow-700':
                               'bg-green-100 text-green-700') }}">
                               {{ ucfirst($i->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-400">
                            Belum ada data insiden
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- SCRIPT --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// ================= STATUS CHART =================
new Chart(document.getElementById('incidentChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($chart['labels']) !!},
        datasets: [{
            data: {!! json_encode($chart['data']) !!},
            borderRadius: 6,
            barThickness: 22
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins:{ legend:{display:false}},
        scales:{ x:{ beginAtZero:true, ticks:{stepSize:1}}}
    }
});

// ================= YEARLY CHART =================
const yearlyLabels = {!! json_encode($yearly->pluck('year')) !!};
const yearlyData   = {!! json_encode($yearly->pluck('total')) !!};

new Chart(document.getElementById('yearlyChart'), {
    type: 'line',
    data: {
        labels: yearlyLabels,
        datasets: [{
            label: 'Jumlah Insiden',
            data: yearlyData,
            borderColor: '#22c55e',
            backgroundColor: 'rgba(34,197,94,0.2)',
            tension: 0.4,
            fill: true
        }]
    },
    options:{
        responsive:true
    }
});
</script>

@endsection
