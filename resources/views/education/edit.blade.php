@extends('layouts.app')

@section('content')
<h3>Edit Education</h3>

<form method="POST" action="{{ route('education.update', $item->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Education Name</label>
        <input type="text" name="education_name" value="{{ $item->education_name }}" class="form-control" required>
    </div>

    <button class="btn btn-primary">Update</button>
</form>
@endsection
