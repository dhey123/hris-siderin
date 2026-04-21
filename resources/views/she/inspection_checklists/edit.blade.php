@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow space-y-4">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold">Edit Master Checklist</h1>
        <p class="text-sm text-gray-500">Perbarui item checklist inspeksi</p>
    </div>

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('she.inspection-checklists.update',$inspectionChecklist->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- KATEGORI --}}
        <div>
            <label class="block font-medium">Kategori</label>
            <select name="kategori" class="w-full border rounded p-2" required>
                <option value="">-- Pilih --</option>
                @foreach(['Safety','Health','Environment'] as $kat)
                    <option value="{{ $kat }}"
                        {{ $inspectionChecklist->kategori == $kat ? 'selected' : '' }}>
                        {{ $kat }}
                    </option>
                @endforeach
            </select>
        </div>
        {{-- KODE --}}
<div>
    <label class="block font-medium">Kode Checklist</label>
    <input type="text"
           name="kode"
           value="{{ $inspectionChecklist->kode }}"
           class="w-full border rounded p-2"
           required>
</div>

        {{-- AREA --}}
        <div>
            <label class="block font-medium">Area</label>
            <input type="text"
                   name="area"
                   value="{{ $inspectionChecklist->area }}"
                   class="w-full border rounded p-2"
                   required>
        </div>

        {{-- ITEM --}}
        <div>
            <label class="block font-medium">Item Checklist</label>
            <textarea name="item"
                      class="w-full border rounded p-2"
                      rows="3"
                      required>{{ $inspectionChecklist->item }}</textarea>
        </div>

        {{-- STANDAR --}}
        <div>
            <label class="block font-medium">Standar</label>
            <input type="text"
                   name="standar"
                   value="{{ $inspectionChecklist->standar }}"
                   class="w-full border rounded p-2">
        </div>

        {{-- STATUS --}}
        <div class="flex items-center gap-2">
            <input type="checkbox"
                   name="aktif"
                   value="1"
                   {{ $inspectionChecklist->aktif ? 'checked' : '' }}>
            <label>Aktif</label>
        </div>

        {{-- BUTTON --}}
        <div class="flex justify-between">
            <a href="{{ route('she.inspection-checklists.index') }}"
               class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">
                Kembali
            </a>

            <button class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
                Update
            </button>
        </div>

    </form>

</div>
@endsection
