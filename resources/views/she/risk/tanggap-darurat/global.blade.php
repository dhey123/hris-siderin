@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">

    <h1 class="text-2xl font-bold mb-4">Global Rencana Tanggap Darurat</h1>
<div>
    <a href="{{ route('she.risk.tanggap-darurat.export') }}"
   class="bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-700">
   Cetak PDF
</a>
</div>
    @if($darurat->isEmpty())
        <div class="bg-yellow-50 border border-yellow-200 p-4 rounded">
            Belum ada data rencana tanggap darurat.
        </div>
    @else
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-gray-700 border border-gray-200 rounded-lg">
            <thead class="bg-gray-100 text-xs uppercase tracking-wider text-gray-600">
                <tr>
                    <th class="px-3 py-2 border">No</th>
                    <th class="px-3 py-2 border">Risiko</th>
                    <th class="px-3 py-2 border">Rencana Darurat</th>
                    <th class="px-3 py-2 border">Contact Person</th>
                    <th class="px-3 py-2 border">Catatan</th>
                    <th class="px-3 py-2 border">Dibuat</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($darurat as $d)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-3 py-2 border text-center">{{ $loop->iteration }}</td>
                    <td class="px-3 py-2 border max-w-xs truncate">{{ $d->risk->nama_risiko ?? '-' }}</td>
            
                    <td class="px-3 py-2 border max-w-sm break-words whitespace-pre-line">{{ $d->rencana }}</td>
                    <td class="px-3 py-2 border max-w-xs break-words">{{ $d->contact_person ?? '-' }}</td>
                    <td class="px-3 py-2 border max-w-sm break-words whitespace-pre-line">{{ $d->catatan ?? '-' }}</td>
                    <td class="px-3 py-2 border text-center">{{ $d->created_at->format('d-m-Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

</div>
@endsection