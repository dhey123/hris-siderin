@extends('layouts.app')

@section('content')
<h3>Master Education</h3>

<a href="{{ route('education.create') }}" class="btn btn-primary mb-3">+ Tambah</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Education Name</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $row)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $row->education_name }}</td>
            <td>
                <a href="{{ route('education.edit', $row->id) }}" class="btn btn-warning btn-sm">Edit</a>

                <form action="{{ route('education.destroy', $row->id) }}"
                      method="POST"
                      style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm"
                        onclick="return confirm('Hapus data?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
