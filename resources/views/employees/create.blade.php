@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Tambah Karyawan</h3>

    <form method="POST" action="{{ route('employees.store') }}">
        @csrf

        <div class="mb-3">
            <label>Kode Karyawan</label>
            <input type="text" name="employee_code" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="full_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Department</label>
            <select name="company_type" class="form-control">
                <option value="Quantum">Quantum</option>
                <option value="Uniland">Uniland</option>
                <option value="Borongan">Borongan</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Divisi</label>
            <select name="department_id" class="form-control">
                @foreach($departments as $d)
                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Posisi</label>
            <select name="position_id" class="form-control">
                @foreach($positions as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Simpan</button>
    </form>

</div>
@endsection
