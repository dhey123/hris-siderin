@extends('layouts.app')

@section('content')
<h3>Edit Bank</h3>

<form method="POST" action="{{ route('bank.update', $item->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Bank Name</label>
        <input type="text" name="bank_name" value="{{ $item->bank_name }}" class="form-control" required>
    </div>

    <button class="btn btn-primary">Update</button>
</form>
@endsection
