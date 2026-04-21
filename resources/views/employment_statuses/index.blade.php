@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h3 class="fw-bold">Employment Status</h3>
        <a href="{{ route('employment_statuses.create') }}" class="btn btn-primary">+ Add Status</a>
    </div>

    <form method="GET" action="{{ route('employment_statuses.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control"
                placeholder="Search..."
                value="{{ $search }}">
            <button class="btn btn-secondary">Search</button>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Status Name</th>
                        <th>Description</th>
                        <th class="text-center" style="width: 20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($statuses as $s)
                        <tr>
                            <td>{{ $s->status_name }}</td>
                            <td>{{ $s->description ?? '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('employment_statuses.edit', $s->id) }}" 
                                   class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('employment_statuses.destroy', $s->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Hapus status ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-3">No data found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3 px-3">
                {{ $statuses->links() }}
            </div>
        </div>
    </div>

</div>
@endsection
