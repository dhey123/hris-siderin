@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 bg-white rounded-xl shadow space-y-6">

    {{-- Judul --}}
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Penilaian Risiko: {{ $risk->nama_risiko }}</h1>
        <span class="px-3 py-1 rounded-full bg-gray-200 text-gray-700 font-medium">{{ $risk->kategori }}</span>
    </div>

    {{-- Form Penilaian --}}
    <div class="bg-gray-50 p-6 rounded shadow">
        <h2 class="text-lg font-semibold mb-4">Tambah Penilaian Baru</h2>
        <form action="{{ route('she.risk.penilaian.store', $risk->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @csrf

            <div>
                <label class="block font-medium mb-1">Kemungkinan</label>
                <select name="likelihood" class="border rounded w-full p-2" required>
                    <option value="">-- Pilih --</option>
                    <option value="Low">Rendah</option>
                    <option value="Medium">Sedang</option>
                    <option value="High">Tinggi</option>
                </select>
            </div>

            <div>
                <label class="block font-medium mb-1">Dampak</label>
                <select name="impact" class="border rounded w-full p-2" required>
                    <option value="">-- Pilih --</option>
                    <option value="Minor">Kecil</option>
                    <option value="Major">Besar</option>
                    <option value="Critical">Kritis</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                    Simpan Penilaian
                </button>
            </div>
        </form>
    </div>

    {{-- Riwayat Penilaian --}}
    <div class="overflow-x-auto bg-white rounded shadow">
        <h2 class="text-lg font-semibold p-4 border-b">Riwayat Penilaian</h2>
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2 border-b">Tanggal</th>
                    <th class="px-4 py-2 border-b">Kemungkinan</th>
                    <th class="px-4 py-2 border-b">Dampak</th>
                    <th class="px-4 py-2 border-b">Skor</th>
                    <th class="px-4 py-2 border-b">Level Risiko</th>
                    <th class="px-4 py-2 border-b">Penilai</th>
                </tr>
            </thead>
            <tbody>
                @forelse($risk->assessments as $a)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border-b">{{ $a->assessed_at->format('d M Y H:i') }}</td>
                    <td class="px-4 py-2 border-b">
                        @switch($a->likelihood)
                            @case('Low') Rendah @break
                            @case('Medium') Sedang @break
                            @case('High') Tinggi @break
                        @endswitch
                    </td>
                    <td class="px-4 py-2 border-b">
                        @switch($a->impact)
                            @case('Minor') Kecil @break
                            @case('Major') Besar @break
                            @case('Critical') Kritis @break
                        @endswitch
                    </td>
                    <td class="px-4 py-2 border-b">{{ $a->risk_score }}</td>
                    <td class="px-4 py-2 border-b">
                        @php
                            $colors = [
                                'Low' => 'bg-green-100 text-green-800',
                                'Medium' => 'bg-yellow-100 text-yellow-800',
                                'High' => 'bg-red-100 text-red-800'
                            ];
                            $labels = [
                                'Low' => 'Rendah',
                                'Medium' => 'Sedang',
                                'High' => 'Tinggi'
                            ];
                        @endphp
                        <span class="px-2 py-1 rounded {{ $colors[$a->risk_level] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $labels[$a->risk_level] ?? $a->risk_level }}
                        </span>
                    </td>
                    <td class="px-4 py-2 border-b">{{ $a->assessed_by }}</td>
                </tr>
                @empty
                <tr>
                    <td class="px-4 py-2 border-b text-center" colspan="6">Belum ada penilaian</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection