@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Pilih Jenis {{ $company }}</h2>

    <div class="row">

        @if($company != 'Borongan')
            <!-- Staff (hanya untuk Quantum & Uniland) -->
            <div class="col-md-4 mb-3">
                <div class="card p-3">
                    <h4>Staff</h4>
                    <a href="{{ route('karyawan.list', ['company' => $company, 'type' => 'Staff']) }}" class="btn btn-success mt-2">Lihat Data</a>
                </div>
            </div>
        @endif

        <!-- Produksi untuk semua kecuali Staff Borongan -->
        <div class="col-md-4 mb-3">
            <div class="card p-3">
                <h4>Produksi</h4>
                <a href="{{ route('karyawan.list', ['company' => $company, 'type' => 'Produksi']) }}" class="btn btn-success mt-2">Lihat Data</a>
            </div>
        </div>

    </div>
</div>
@endsection
