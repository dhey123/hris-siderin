@extends('layouts.app')

@section('content')
<h3>Edit Religion</h3>

<form method="POST" action="{{ route('religions.update', $item->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Religion Name</label>
        <input type="text" name="religion_name" value="{{ $item->religion_name }}" class="form-control" required>
    </div>

    <button class="btn btn-primary">Update</button>
</form>
@endsection
