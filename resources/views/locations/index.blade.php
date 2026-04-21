@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Location List</h4>

    <a href="{{ route('locations.create') }}" class="btn btn-primary mb-3">Tambah Location</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Location Name</th>
                <th width="150">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($locations as $loc)
            <tr>
                <td>{{ $loc->location_name }}</td>
                <td>
                    <a href="{{ route('locations.edit', $loc->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('locations.destroy', $loc->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $locations->links() }}
</div>
@endsection
