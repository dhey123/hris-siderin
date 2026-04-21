@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3">
        <h1 class="text-2xl font-bold">
            General Affair Dashboard
            <span class="text-sm text-gray-500">
                ({{ \Carbon\Carbon::parse($month)->format('F Y') }})
            </span>
        </h1>

        <!-- FILTER -->
        <form method="GET" class="flex gap-2">
            <input type="month" name="month"
                value="{{ $month }}"
                class="border p-2 rounded-lg">

            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                Filter
            </button>
        </form>
    </div>

    <!-- CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="bg-white p-5 rounded-xl shadow">
            <div class="text-gray-500 text-sm">Total Asset</div>
            <div class="text-3xl font-bold">{{ $totalAsset }}</div>
            <div class="text-xs mt-2 text-gray-500">
                Baik: {{ $assetBaik }} |
                Rusak: {{ $assetRusak }} |
                Maintenance: {{ $assetMaintenance }}
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <div class="text-gray-500 text-sm">Maintenance</div>
            <div class="text-3xl font-bold">{{ $totalMaintenance }}</div>
            <div class="text-xs mt-2 text-gray-500">
                Pending: {{ $maintenancePending }} |
                Process: {{ $maintenanceProcess }} |
                Done: {{ $maintenanceDone }}
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <div class="text-gray-500 text-sm">Request</div>
            <div class="text-3xl font-bold">{{ $totalRequest }}</div>
            <div class="text-xs mt-2 text-gray-500">
                Pending: {{ $requestPending }} |
                Approved: {{ $requestApproved }} |
                Rejected: {{ $requestRejected }}
            </div>
        </div>

    </div>

    <!-- CHART -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-white p-5 rounded-xl shadow">
            <h2 class="font-semibold mb-3">Maintenance per Bulan</h2>
            <canvas id="maintenanceChart"></canvas>
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <h2 class="font-semibold mb-3">Request Status</h2>
            <canvas id="requestChart"></canvas>
        </div>

    </div>

    <!-- DETAIL -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-white p-5 rounded-xl shadow">
            <h2 class="font-semibold mb-3">Maintenance Terbaru</h2>

            @forelse($recentMaintenances as $m)
                <div class="border-b py-2 text-sm">
                    <div class="font-medium">{{ $m->asset->name ?? '-' }}</div>
                    <div class="text-gray-500 text-xs">{{ $m->title }}</div>
                </div>
            @empty
                <div class="text-gray-500">Belum ada data</div>
            @endforelse
        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <h2 class="font-semibold mb-3">Request Terbaru</h2>

            @forelse($recentRequests as $r)
                <div class="border-b py-2 text-sm">
                    <div class="font-medium">{{ $r->item_name }}</div>
                    <div class="text-gray-500 text-xs">
                        {{ $r->request_code }} - {{ ucfirst($r->status) }}
                    </div>
                </div>
            @empty
                <div class="text-gray-500">Belum ada data</div>
            @endforelse
        </div>

    </div>

</div>

<!-- CHART SCRIPT (RINGAN) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const maintenanceData = @json($maintenanceChart);
const requestData = @json($requestChart);

// Maintenance Chart
new Chart(document.getElementById('maintenanceChart'), {
    type: 'line',
    data: {
        labels: Object.keys(maintenanceData),
        datasets: [{
            data: Object.values(maintenanceData),
            borderWidth: 2,
            tension: 0.3
        }]
    }
});

// Request Chart
new Chart(document.getElementById('requestChart'), {
    type: 'bar',
    data: {
        labels: Object.keys(requestData),
        datasets: [{
            data: Object.values(requestData),
            borderWidth: 1
        }]
    }
});
</script>

@endsection