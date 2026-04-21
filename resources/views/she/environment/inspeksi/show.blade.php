@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow space-y-4">

   <div class="flex justify-between items-center">
    <a href="{{ route('she.environment.inspeksi.index') }}"
       class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded text-sm">
        Kembali
    </a>

    <a href="{{ route('she.environment.inspeksi.pdf', $inspection->id) }}"
       class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm">
        Download PDF
    </a>
</div>


         {{-- HEADER --}}
    <div class="relative flex items-center mb-4">
    <div class="mx-auto text-center">
        <h1 class="text-xl font-bold">DETAIL INSPEKSI</h1>
        <p class="text-sm text-black-500">PT Quantum Tosan International</p>
    </div>

    </div>
    
    {{-- HEADER INFO --}}
    <hr>
    <div class="grid grid-cols-2 gap-x-6 gap-y-2 text-sm">
        <div><b>Nomor</b> : {{ $inspection->nomor_inspeksi }}</div>
        <div class="text-right"><b>Tanggal</b> : {{ $inspection->tanggal->format('d-m-Y') }}</div>

        <div><b>Area</b> : {{ $inspection->area }}</div>
        <div class="text-right"><b>Jenis</b> : {{ $inspection->jenis }}</div>

        <div><b>Status</b> : {{ $inspection->status }}</div>
        <div class="text-right"><b>Inspector</b> : {{ $inspection->user->name ?? '-' }}</div>
    </div>

    <hr>

    {{-- DETAIL --}}
    <h2 class="font-semibold">Checklist Inspeksi</h2>

    <div class="overflow-x-auto">
        <table class="w-full border border-gray-300 text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-2 py-2">No</th>
                    <th class="border px-2 py-2">Kategori</th>
                    <th class="border px-2 py-2">Kode</th>
                    <th class="border px-2 py-2">Item</th>
                    <th class="border px-2 py-2">Standar</th>
                    <th class="border px-2 py-2 text-center">Hasil</th>
                    <th class="border px-2 py-2">Keterangan</th>
                </tr>
            </thead>

            <tbody>
                @foreach($inspection->details as $i => $d)
                <tr class="hover:bg-gray-50">
                    <td class="border px-2 py-2 text-center">{{ $i+1 }}</td>
                    <td class="border px-2 py-2">{{ $d->checklist->kategori }}</td>
                    <td class="border px-2 py-2">{{ $d->checklist->kode }}</td>
                    <td class="border px-2 py-2">{{ $d->checklist->item }}</td>
                    <td class="border px-2 py-2">{{ $d->checklist->standar }}</td>

                    {{-- HASIL --}}
                    <td class="border px-2 py-2 text-center">
                        @if($d->hasil == 'OK')
                            <span class="bg-green-600 text-white px-2 py-1 rounded text-xs">
                                ✔ OK (Sesuai)
                            </span>
                        @else
                            <span class="bg-red-600 text-white px-2 py-1 rounded text-xs">
                                ✖ NG (Tidak Sesuai)
                            </span>
                        @endif
                    </td>

                    {{-- KETERANGAN --}}
                    <td class="border px-2 py-2">
                        {{ $d->keterangan ?? '-' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- CATATAN --}}
    @if($inspection->keterangan)
    <hr>
    <div class="text-sm">
        <b>Catatan :</b>
        <p>{{ $inspection->keterangan }}</p>
    </div>
    @endif

</div>
@endsection
