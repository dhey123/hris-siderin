@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <h1 class="text-2xl font-bold text-gray-800">Dashboard Risiko</h1>

    {{-- ================= SUMMARY CARDS ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

    <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition">
        <p class="text-sm text-gray-500">Total Risiko</p>
        <div class="flex items-center justify-between mt-2">
            <p class="text-3xl font-bold text-gray-800">{{ $total }}</p>
            <i class="fa-solid fa-chart-line text-green-500 text-xl"></i>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-red-500 hover:shadow-lg transition">
        <p class="text-sm text-gray-500">Open</p>
        <div class="flex items-center justify-between mt-2">
            <p class="text-3xl font-bold text-red-600">{{ $open }}</p>
            <i class="fa-solid fa-circle-exclamation text-red-500 text-xl"></i>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-yellow-500 hover:shadow-lg transition">
        <p class="text-sm text-gray-500">In Progress</p>
        <div class="flex items-center justify-between mt-2">
            <p class="text-3xl font-bold text-yellow-600">
                {{ \App\Models\Risk::where('status','In Progress')->count() }}
            </p>
            <i class="fa-solid fa-spinner text-yellow-500 text-xl"></i>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition">
        <p class="text-sm text-gray-500">Closed</p>
        <div class="flex items-center justify-between mt-2">
            <p class="text-3xl font-bold text-blue-600">{{ $closed }}</p>
            <i class="fa-solid fa-circle-check text-blue-500 text-xl"></i>
        </div>
    </div>

</div>

    {{-- ================= CHART AREA ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="font-semibold mb-4">Distribusi Kategori</h2>
            <canvas id="kategoriChart"></canvas>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="font-semibold mb-4">Distribusi Level Risiko</h2>
            <canvas id="levelChart"></canvas>
        </div>

    </div>

    {{-- ================= TOP RISKS ================= --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="font-semibold mb-4">Top 5 Risiko Tertinggi</h2>

        <table class="w-full text-sm border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Nama Risiko</th>
                    <th class="p-2 text-left">Kategori</th>
                    <th class="p-2 text-left">Impact</th>
                    <th class="p-2 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topRisks as $risk)
                <tr class="border-t">
                    <td class="p-2">{{ $risk->nama_risiko }}</td>
                    <td class="p-2">{{ $risk->kategori }}</td>
                    <td class="p-2 font-semibold text-red-600">{{ $risk->impact }}</td>
                    <td class="p-2">{{ $risk->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

{{-- ================= CHART JS ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const kategoriChart = new Chart(document.getElementById('kategoriChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($kategori->keys()) !!},
            datasets: [{
                data: {!! json_encode($kategori->values()) !!},
            }]
        }
    });

    const levelChart = new Chart(document.getElementById('levelChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($level->keys()) !!},
            datasets: [{
                label: 'Jumlah',
                data: {!! json_encode($level->values()) !!}
            }]
        }
    });
</script>

@endsection