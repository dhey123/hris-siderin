@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">Global Penilaian Risiko</h1>
            <p class="text-sm text-gray-600">
                Menampilkan seluruh hasil penilaian risiko berdasarkan metode matriks kemungkinan (Likelihood) dan dampak (Impact).
            </p>
        </div>

        <a href="{{ route('she.risk.penilaian.export') }}"
           class="bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-700">
            Export PDF
        </a>
    </div>

    {{-- FILTER --}}
    <form method="GET" class="mb-6 bg-white p-4 rounded shadow flex flex-wrap gap-4 items-end">

        <div>
            <label class="text-sm font-medium">Level Risiko</label>
            <select name="level" class="border rounded px-3 py-2 text-sm w-40">
                <option value="">Semua</option>
                <option value="Low" {{ request('level') == 'Low' ? 'selected' : '' }}>Low</option>
                <option value="Medium" {{ request('level') == 'Medium' ? 'selected' : '' }}>Medium</option>
                <option value="High" {{ request('level') == 'High' ? 'selected' : '' }}>High</option>
            </select>
        </div>

        <div>
            <label class="text-sm font-medium">Kategori</label>
            <select name="kategori" class="border rounded px-3 py-2 text-sm w-48">
                <option value="">Semua</option>
                <option value="Safety" {{ request('kategori') == 'Safety' ? 'selected' : '' }}>Safety</option>
                <option value="Health" {{ request('kategori') == 'Health' ? 'selected' : '' }}>Health</option>
                <option value="Environment" {{ request('kategori') == 'Environment' ? 'selected' : '' }}>Environment</option>
                <option value="Bencana Alam" {{ request('kategori') == 'Bencana Alam' ? 'selected' : '' }}>Bencana Alam</option>
                <option value="Tsunami" {{ request('kategori') == 'Tsunami' ? 'selected' : '' }}>Tsunami</option>
                <option value="Gempa" {{ request('kategori') == 'Gempa' ? 'selected' : '' }}>Gempa</option>
            </select>
        </div>

        <div>
            <label class="text-sm font-medium">Dari</label>
            <input type="date" name="from" value="{{ request('from') }}"
                   class="border rounded px-3 py-2 text-sm">
        </div>

        <div>
            <label class="text-sm font-medium">Sampai</label>
            <input type="date" name="to" value="{{ request('to') }}"
                   class="border rounded px-3 py-2 text-sm">
        </div>

        <div class="flex gap-2">
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
                Filter
            </button>

            <a href="{{ route('she.risk.penilaian.global') }}"
               class="bg-gray-400 text-white px-4 py-2 rounded text-sm hover:bg-gray-500">
                Reset
            </a>
        </div>

    </form>

    {{-- TABEL --}}
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">

            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Nama Risiko</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Kategori</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Likelihood</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Impact</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Score</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Level</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Assessed By</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
            @forelse($penilaian as $p)
            <tr class="hover:bg-gray-50">

                <td class="px-4 py-2 text-sm">
                    {{ $p->risk->nama_risiko ?? '-' }}
                </td>

                <td class="px-4 py-2 text-sm">
                    <span class="px-2 py-1 rounded text-xs bg-gray-100">
                        {{ $p->risk->kategori ?? '-' }}
                    </span>
                </td>

                <td class="px-4 py-2 text-sm">{{ $p->likelihood }}</td>
                <td class="px-4 py-2 text-sm">{{ $p->impact }}</td>

                <td class="px-4 py-2 text-sm font-semibold">
                    {{ $p->risk_score }}
                </td>

                <td class="px-4 py-2 text-sm">
                    @if($p->risk_level == 'Low')
                        <span class="px-2 py-1 rounded bg-green-100 text-green-700 text-xs">Low</span>
                    @elseif($p->risk_level == 'Medium')
                        <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-700 text-xs">Medium</span>
                    @else
                        <span class="px-2 py-1 rounded bg-red-100 text-red-700 text-xs">High</span>
                    @endif
                </td>

                <td class="px-4 py-2 text-sm">
                    {{ $p->assessed_by ?? '-' }}
                </td>

                <td class="px-4 py-2 text-sm">
                    {{ $p->assessed_at ? \Carbon\Carbon::parse($p->assessed_at)->format('d M Y H:i') : '-' }}
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                    Belum ada penilaian risiko
                </td>
            </tr>
            @endforelse
            </tbody>

        </table>
    </div>

</div>
@endsection