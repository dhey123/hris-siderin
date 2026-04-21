@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Edit Location</h4>

    <form method="POST" action="{{ route('locations.update', $location->id) }}">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Location Name</label>
            <input type="text" name="location_name" class="form-control" value="{{ $location->location_name }}" required>
        </div>

        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
