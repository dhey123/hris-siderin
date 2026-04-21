@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3 class="fw-bold mb-3">Add Employment Status</h3>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('employment_statuses.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Status Name</label>
                    <input type="text" name="status_name" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Description (Optional)</label>
                    <textarea name="description" rows="3" class="form-control"></textarea>
                </div>

                <button class="btn btn-primary">Save</button>
                <a href="{{ route('employment_statuses.index') }}" class="btn btn-secondary">Cancel</a>

            </form>

        </div>
    </div>

</div>
@endsection
