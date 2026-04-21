@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Data Karyawan</h3>
    <a href="{{ route('employees.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    <form action="{{ route('employees.update', $employee->id) }}" method="POST" id="employeeForm">
        @csrf
        @method('PUT')

        <div class="card p-4">

            <!-- Tab Content -->
            <div class="tab-content">

                <!-- Tab 1: Identitas -->
                <div class="tab-pane active" id="tab1">
                    <h5>Informasi Identitas</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Kode Karyawan</label>
                            <input type="text" name="employee_code" class="form-control" value="{{ $employee->employee_code }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="full_name" class="form-control" value="{{ $employee->full_name }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>NIK / KTP</label>
                            <input type="text" name="nik_ktp" class="form-control" value="{{ $employee->nik_ktp }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $employee->email }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>No HP</label>
                            <input type="text" name="phone" class="form-control" value="{{ $employee->phone }}">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" onclick="nextTab(1)">Next</button>
                    </div>
                </div>

                <!-- Tab 2: Kategori -->
                <div class="tab-pane" id="tab2">
                    <h5>Kategori Department</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Pilih Department</label>
                            <select name="company_type" class="form-control">
                                <option value="Quantum" {{ $employee->company_type == 'Quantum' ? 'selected' : '' }}>Quantum</option>
                                <option value="Uniland" {{ $employee->company_type == 'Uniland' ? 'selected' : '' }}>Uniland</option>
                                <option value="Borongan" {{ $employee->company_type == 'Borongan' ? 'selected' : '' }}>Borongan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Jenis Kerja</label>
                            <select name="employment_type" class="form-control">
                                <option value="Tetap" {{ $employee->employment_type == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                                <option value="Kontrak" {{ $employee->employment_type == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                                <option value="Borongan" {{ $employee->employment_type == 'Borongan' ? 'selected' : '' }}>Borongan</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" onclick="prevTab(2)">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextTab(2)">Next</button>
                    </div>
                </div>

                <!-- Tab 3: Departemen & Posisi -->
                <div class="tab-pane" id="tab3">
                    <h5>Divisi & Posisi</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Divisi</label>
                            <select class="form-control" name="department_id">
                                <option value="">-- Pilih Divisi --</option>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ $employee->department_id == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Posisi</label>
                            <select class="form-control" name="position_id">
                                <option value="">-- Pilih Posisi --</option>
                                @foreach ($positions as $pos)
                                    <option value="{{ $pos->id }}" {{ $employee->position_id == $pos->id ? 'selected' : '' }}>
                                        {{ $pos->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" onclick="prevTab(3)">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextTab(3)">Next</button>
                    </div>
                </div>

                <!-- Tab 4: Informasi Pribadi -->
                <div class="tab-pane" id="tab4">
                    <h5>Informasi Pribadi</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nama Ibu Kandung</label>
                            <input type="text" class="form-control" name="mother_name" value="{{ $employee->mother_name }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>NPWP</label>
                            <input type="text" class="form-control" name="npwp" value="{{ $employee->npwp }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>BPJS Ketenagakerjaan</label>
                            <input type="text" class="form-control" name="bpjs_tk" value="{{ $employee->bpjs_tk }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>BPJS Kesehatan</label>
                            <input type="text" class="form-control" name="bpjs_kes" value="{{ $employee->bpjs_kes }}">
                        </div>
                        <div class="col-12 mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3">{{ $employee->alamat }}</textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" onclick="prevTab(4)">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextTab(4)">Next</button>
                    </div>
                </div>

                <!-- Tab 5: Status -->
                <div class="tab-pane" id="tab5">
                    <h5>Status Karyawan</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="Aktif" {{ $employee->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Nonaktif" {{ $employee->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" onclick="prevTab(5)">Previous</button>
                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    </div>
                </div>

            </div>

        </div>
    </form>
</div>

<!-- Script untuk navigasi tab -->
<script>
    function showTab(tabNumber) {
        document.querySelectorAll('.tab-pane').forEach((tab, index) => {
            tab.classList.remove('active');
        });
        document.getElementById('tab' + tabNumber).classList.add('active');
    }

    function nextTab(current) {
        showTab(current + 1);
    }

    function prevTab(current) {
        showTab(current - 1);
    }
</script>
@endsection
