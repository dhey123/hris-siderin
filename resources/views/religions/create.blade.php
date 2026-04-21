@extends('layouts.app')

@section('content')
<h3>Tambah Religion</h3>

<form method="POST" action="{{ route('religions.store') }}">
    @csrf

    <div class="mb-3">
        <label>Religion Name</label>
        <input type="text" name="religion_name" class="form-control" required>
    </div>

    <button class="btn btn-success">Simpan</button>
</form>
@endsection
