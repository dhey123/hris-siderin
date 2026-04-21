@extends('layouts.app')

@section('content')
<h3>Tambah Status Kerja</h3>

<form action="{{ route('settings.employment_status.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>Nama Status Kerja</label>
        <input type="text" name="status_name" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Simpan</button>
</form>
@endsection
