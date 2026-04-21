@extends('layouts.app')


@section('content')
<h3>Tambah Marital Status</h3>


<div class="card p-4 mt-3">
<form action="{{ route('marital-statuses.store') }}" method="POST">
@csrf


<div class="mb-3">
<label class="form-label">Nama Status</label>
<input type="text" name="marital_status_name" class="form-control" required>
</div>


<button type="submit" class="btn btn-success">Simpan</button>
<a href="{{ route('marital-statuses.index') }}" class="btn btn-secondary">Kembali</a>
</form>
</div>
@endsection