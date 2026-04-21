@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Pilih Kategori Karyawan</h2>

    <div class="row">
        <!-- Quantum -->
        <div class="col-md-4 mb-3">
            <div class="card p-3">
                <h4>Quantum</h4>
                <a href="{{ route('karyawan.submenu', 'Quantum') }}" class="btn btn-primary mt-2">Lihat</a>
            </div>
        </div>

        <!-- Uniland -->
        <div class="col-md-4 mb-3">
            <div class="card p-3">
                <h4>Uniland</h4>
                <a href="{{ route('karyawan.submenu', 'Uniland') }}" class="btn btn-primary mt-2">Lihat</a>
            </div>
        </div>

        <!-- Borongan -->
        <div class="col-md-4 mb-3">
            <div class="card p-3">
                <h4>Borongan</h4>
                <a href="{{ route('karyawan.submenu', 'Borongan') }}" class="btn btn-primary mt-2">Lihat</a>
            </div>
        </div>
    </div>
</div>
@endsection
