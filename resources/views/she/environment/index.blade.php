@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Environment</h1>
        <p class="text-sm text-gray-500">Modul Lingkungan & K3</p>
    </div>

    {{-- ================= MENU MODULE ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- LIMBAH --}}
        <a href="{{ route('she.environment.limbah.index') }}"
           class="group bg-white rounded-xl shadow hover:shadow-lg p-6 border transition">
            <div class="flex items-center gap-4">
                <div class="bg-yellow-100 text-yellow-600 p-3 rounded-lg">
                    <i class="fa-solid fa-recycle text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-yellow-600">
                        Limbah
                    </h3>
                    <p class="text-sm text-gray-500">
                        Pengelolaan Limbah
                    </p>
                </div>
            </div>
        </a>

        {{-- INSPEKSI --}}
        <a href="{{ route('she.environment.inspeksi.index') }}"
           class="group bg-white rounded-xl shadow hover:shadow-lg p-6 border transition">
            <div class="flex items-center gap-4">
                <div class="bg-green-100 text-green-600 p-3 rounded-lg">
                    <i class="fa-solid fa-search text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-green-600">
                        Inspeksi
                    </h3>
                    <p class="text-sm text-gray-500">
                        Inspeksi Lapangan
                    </p>
                </div>
            </div>
        </a>

        {{-- AUDIT --}}
        <a href="{{ route('she.environment.audit.index') }}"
           class="group bg-white rounded-xl shadow hover:shadow-lg p-6 border transition">
            <div class="flex items-center gap-4">
                <div class="bg-blue-100 text-blue-600 p-3 rounded-lg">
                    <i class="fa-solid fa-clipboard-list text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-blue-600">
                        Audit
                    </h3>
                    <p class="text-sm text-gray-500">
                        Audit Lingkungan
                    </p>
                </div>
            </div>
        </a>

    </div>


    {{-- ================= CHART SECTION ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="font-semibold mb-4 text-center">Statistik Limbah</h3>
            <div class="h-56">
                <canvas id="limbahChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="font-semibold mb-4 text-center">Statistik Inspeksi</h3>
            <div class="h-56">
                <canvas id="inspeksiChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="font-semibold mb-4 text-center">Statistik Audit</h3>
            <div class="h-56">
                <canvas id="auditChart"></canvas>
            </div>
        </div>

    </div>
</div>
@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const options = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom' } }
    };

    // ================= LIMBAH =================
    new Chart(document.getElementById('limbahChart'), {
        type: 'doughnut',
        data: {
            labels: ['Disimpan','Selesai'],
            datasets: [{
                data: [
                    {{ $limbahDisimpan ?? 0 }},
                    {{ $limbahSelesai ?? 0 }}
                ],
                backgroundColor: ['#facc15','#f97316','#16a34a']
            }]
        },
        options: options
    });

    // ================= INSPEKSI =================
    new Chart(document.getElementById('inspeksiChart'), {
    type: 'doughnut',
    data: {
        labels: ['Open','Closed'],
        datasets: [{
            data: [
                {{ $inspeksiOpen ?? 0 }},
                {{ $inspeksiClose ?? 0 }}
            ],
            backgroundColor: ['#facc15','#ef4444','#16a34a']
        }]
    },
    options: options
});

    // ================= AUDIT =================
    new Chart(document.getElementById('auditChart'), {
        type: 'doughnut',
        data: {
            labels: ['Draft','Followup','Selesai'],
            datasets: [{
                data: [
                    {{ $auditDraft ?? 0 }},
                    {{ $auditFollowup ?? 0 }},
                    {{ $auditSelesai ?? 0 }}
                ],
                backgroundColor: ['#facc15','#f97316','#16a34a']
            }]
        },
        options: options
    });

});
</script>
@endpush