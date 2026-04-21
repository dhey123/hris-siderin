@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3 class="fw-bold mb-3">Edit Employment Status</h3>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('employment_statuses.update', $employment_status->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Status Name</label>
                    <input type="text" name="status_name" class="form-control"
                           value="{{ $employment_status->status_name }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Description (Optional)</label>
                    <textarea name="description" rows="3" class="form-control">{{ $employment_status->description }}</textarea>
                </div>

                <button class="btn btn-primary">Update</button>
                <a href="{{ route('employment_statuses.index') }}" class="btn btn-secondary">Cancel</a>

            </form>

        </div>
    </div>

</div>
@endsection
