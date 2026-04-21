@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">
    <h1 class="text-2xl font-bold mb-6">Global Mitigasi Risiko</h1>
<a href="{{ route('she.risk.mitigasi.export') }}"
   class="bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-700">
   Cetak PDF
</a>
    {{-- Form Tambah Mitigasi --}}
    <div class="bg-gray-50 p-6 rounded shadow mb-8">
        <h2 class="text-lg font-semibold mb-4">Tambah Mitigasi Baru</h2>
        <form action="{{ route('she.risk.mitigasi.store.global') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            <div>
                <label class="block font-medium mb-1">Risiko</label>
                <select name="risk_id" required class="border rounded w-full p-2">
                    <option value="">-- Pilih Risiko --</option>
                    @foreach($risks as $r)
                        <option value="{{ $r->id }}">{{ $r->nama_risiko }} ({{ $r->kategori }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-medium mb-1">Tindakan Mitigasi</label>
                <input type="text" name="tindakan" class="border rounded w-full p-2" required>
            </div>

            <div>
                <label class="block font-medium mb-1">PIC</label>
                <input type="text" name="pic" class="border rounded w-full p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Deadline</label>
                <input type="date" name="deadline" class="border rounded w-full p-2">
            </div>

            <div>
                <label class="block font-medium mb-1">Status</label>
                <select name="status" class="border rounded w-full p-2" required>
                    <option value="Planned">Planned</option>
                    <option value="Ongoing">Ongoing</option>
                    <option value="Done">Done</option>
                </select>
            </div>
            <div>
            <label class="block font-medium mb-1">Efektivitas</label>
            <select name="efektivitas" class="border rounded w-full p-2">
                <option value="">-- Pilih --</option>
                <option value="Efektif">Efektif</option>
                <option value="Cukup Efektif">Cukup Efektif</option>
                <option value="Tidak Efektif">Tidak Efektif</option>
            </select>
        </div>
        <div>
                <label class="block font-medium mb-1">Upload Dokumen</label>
                <input type="file" name="lampiran" 
                    class="border rounded w-full p-2">
                <small class="text-gray-500">PDF / Word / Excel / JPG (Max 2MB)</small>
            </div>

            <div class="flex items-end">
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                    Simpan Mitigasi
                </button>
            </div>
        </form>
    </div>

    {{-- Tabel List Mitigasi --}}
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Risiko</th>
                    <th class="px-4 py-2 border">Tindakan Mitigasi</th>
                    <th class="px-4 py-2 border">PIC</th>
                    <th class="px-4 py-2 border">Deadline</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Efektivitas</th>
                    <th class="px-4 py-2 border">Lampiran</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mitigasi as $m)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border">{{ $m->risk->nama_risiko ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $m->tindakan }}</td>
                    <td class="px-4 py-2 border">{{ $m->pic ?? '-' }}</td>
                    <td class="px-4 py-2 border">
                        {{ $m->deadline ? \Carbon\Carbon::parse($m->deadline)->format('d M Y') : '-' }}
                    </td>
                    <td class="px-4 py-2 border">{{ $m->status }}</td>
                    <td class="px-4 py-2 border">{{ $m->efektivitas}}</td>
                    <td class="px-4 py-2 border text-center">
                        @if($m->lampiran)
                            <a href="{{ asset('storage/' . $m->lampiran) }}" 
                            target="_blank"
                            class="text-blue-600 hover:underline">
                            Lihat
                            </a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
    <a href="{{ route('she.risk.mitigasi.edit.global', $m->id) }}"
   class="text-blue-600">Edit</a>
</td>
                </tr>
                @empty
                <tr>
                    <td class="px-4 py-2 border text-center" colspan="6">Belum ada mitigasi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection