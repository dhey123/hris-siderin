@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Tambah Location</h4>

    <form method="POST" action="{{ route('locations.store') }}">
        @csrf

        <div class="mb-3">
            <label>Location Name</label>
            <input type="text" name="location_name" class="form-control" required>
        </div>

        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
