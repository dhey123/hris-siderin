@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3 class="fw-bold mb-3">Add Employment Type</h3>

    <form action="{{ route('employment_types.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Type Name</label>
            <input type="text" name="type_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <button class="btn btn-primary">Save</button>
        <a href="{{ route('employment_types.index') }}" class="btn btn-secondary">Back</a>
    </form>

</div>
@endsection
