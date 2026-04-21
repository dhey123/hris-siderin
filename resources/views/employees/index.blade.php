@extends('layouts.app')

@section('content')

<h2 class="mb-4">Data Karyawan - {{ ucfirst($company) }} ({{ ucfirst($type) }})</h2>

{{-- ============================== --}}
{{-- CHART AREA --}}
{{-- ============================== --}}
<div class="card mb-4">
    <div class="card-body">
        <h5>Statistik Karyawan</h5>
        <canvas id="employeeChart"></canvas>
    </div>
</div>

<script>
    const ctx = document.getElementById('employeeChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total Karyawan'],
            datasets: [{
                label: 'Jumlah',
                data: [{{ $employees->total() }}],
                borderWidth: 1
            }]
        }
    });
</script>

{{-- ============================== --}}
{{-- SEARCH + FILTER --}}
{{-- ============================== --}}
<div class="card mb-3">
    <div class="card-body d-flex justify-content-between">

        {{-- Search --}}
        <form method="GET" class="d-flex" action="{{ route('hr.data_karyawan.filter', [$company, $type]) }}">
            <input type="text" name="search" class="form-control" placeholder="Cari nama / NIK..."
                   value="{{ request('search') }}">
            <button class="btn btn-primary ms-2">Cari</button>
        </form>

        {{-- Filter Status --}}
        <form method="GET" action="{{ route('hr.data_karyawan.filter', [$company, $type]) }}">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">Semua Status Kerja</option>
                @foreach($statuses as $s)
                    <option value="{{ $s->status_name }}" 
                        {{ request('status') == $s->status_name ? 'selected' : '' }}>
                        {{ $s->status_name }}
                    </option>
                @endforeach
            </select>
        </form>

    </div>
</div>

{{-- ============================== --}}
{{-- TABEL DATA --}}
{{-- ============================== --}}
<div class="card">
    <div class="card-body">

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('hr.data_karyawan.create') }}" class="btn btn-success">
                + Tambah Karyawan
            </a>
        </div>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Divisi</th>
                    <th>Department</th>
                    <th>Status Kerja</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($employees as $e)
                    <tr>
                        <td>{{ $e->id_karyawan }}</td>
                        <td>{{ $e->full_name }}</td>
                        <td>{{ $e->nik }}</td>
                        <td>{{ $e->department->department_name ?? '-' }}</td>
                        <td>{{ $e->company->company_name ?? '-' }}</td>
                        <td>{{ $e->employmentStatus->status_name ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data.</td>
                    </tr>
                @endforelse
            </tbody>

        </table>

        {{-- PAGINATION --}}
        <div class="mt-3">
            {{ $employees->appends(request()->query())->links() }}
        </div>

    </div>
</div>

@endsection
