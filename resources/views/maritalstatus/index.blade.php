@extends('layouts.app')


@section('content')
<h3>Master Marital Status</h3>


<a href="{{ route('marital-statuses.create') }}" class="btn btn-primary mb-3">+ Tambah</a>


<table class="table table-bordered">
<thead>
<tr>
<th>No</th>
<th>Marital Status</th>
<th>Aksi</th>
</tr>
</thead>
<tbody>
@foreach ($data as $row)
<tr>
<td>{{ $loop->iteration }}</td>
<td>{{ $row->marital_status_name }}</td>
<td>
<a href="{{ route('marital-statuses.edit', $row->id) }}" class="btn btn-warning btn-sm">Edit</a>


<form action="{{ route('marital-statuses.destroy', $row->id) }}" method="POST" style="display:inline-block;">
@csrf
@method('DELETE')
<button class="btn btn-danger btn-sm" onclick="return confirm('Hapus data?')">Hapus</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
@endsection