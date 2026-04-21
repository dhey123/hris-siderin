@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow space-y-4">

<h1 class="text-xl font-bold">Edit Inspeksi</h1>

<form action="{{ route('she.environment.inspeksi.update',$inspection->id) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- HEADER --}}
    <div class="grid grid-cols-2 gap-4 mb-4">

        <div>
            <label>Tanggal</label>
            <input type="date" name="tanggal"
                value="{{ $inspection->tanggal->format('Y-m-d') }}"
                class="w-full border rounded p-2">
        </div>

        <div>
            <label>Area</label>
            <input type="text" name="area"
                value="{{ $inspection->area }}"
                class="w-full border rounded p-2">
        </div>

        <div>
            <label>Jenis</label>
            <input type="text" name="jenis"
                value="{{ $inspection->jenis }}"
                class="w-full border rounded p-2">
        </div>

        <div>
            <label>Status</label>
            <select name="status" class="w-full border rounded p-2">
                <option value="Open" {{ $inspection->status=='Open'?'selected':'' }}>Open</option>
                <option value="Closed" {{ $inspection->status=='Closed'?'selected':'' }}>Closed</option>
            </select>
        </div>

    </div>

    <hr>

    {{-- DETAIL CHECKLIST --}}
    <h2 class="font-semibold mb-2">Checklist</h2>

    <table class="w-full border" id="itemsTable">
        <tr class="bg-gray-100">
            <th class="border p-2">Item</th>
            <th class="border p-2">Standar</th>
            <th class="border p-2">Hasil</th>
            <th class="border p-2">Keterangan</th>
        </tr>

        @foreach($checklists as $check)
            @php
                $detail = $inspection->details->firstWhere('checklist_id', $check->id);
            @endphp
            <tr>
                {{-- hidden field supaya controller tahu checklist id --}}
                <input type="hidden" name="inspection_checklist_id[]" value="{{ $check->id }}">

                <td class="border p-2">{{ $check->item }}</td>
                <td class="border p-2">{{ $check->standar }}</td>
                <td class="border p-2">
                    <select name="hasil[{{ $check->id }}]" class="w-full border p-1">
                        <option value="OK" {{ $detail && $detail->hasil=='OK' ? 'selected' : '' }}>OK</option>
                        <option value="NG" {{ $detail && $detail->hasil=='NG' ? 'selected' : '' }}>NG</option>
                    </select>
                </td>
                <td class="border p-2">
                    <input type="text" name="keterangan_item[{{ $check->id }}]"
                        value="{{ $detail->keterangan ?? '' }}"
                        class="w-full border p-1">
                </td>
            </tr>
        @endforeach
    </table>

    <hr class="my-4">

    <label>Catatan Tambahan</label>
    <textarea name="keterangan"
        class="w-full border rounded p-2 mb-4">{{ $inspection->keterangan }}</textarea>

    <div class="flex gap-2">
        <a href="{{ route('she.environment.inspeksi.index') }}"
           class="px-4 py-2 bg-gray-300 rounded">
            Kembali
        </a>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
            Update
        </button>
    </div>

</form>
</div>
@endsection
