@extends('layouts.app')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
        {{-- Kembali --}}
        <a href="{{ route('she.safety.index') }}"
           class="inline-flex items-center px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
            ← Kembali
        </a>
</div>

   {{-- HEADER --}}
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">

    {{-- LEFT : TITLE --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Jadwal Pelatihan
        </h1>
    </div>
    


    {{-- RIGHT : ACTION BUTTONS --}}
    <div class="flex flex-wrap gap-3">

        {{-- Tambah --}}
        <a href="{{ route('she.safety.pelatihan.create') }}"
           class="inline-flex items-center px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white transition">
            + Tambah Pelatihan
        </a>

        {{-- Cetak --}}
        <a href="{{ route('she.safety.pelatihan.print') }}"
           class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition">
            🖨 Cetak Laporan
        </a>

        
    </div>
</div>
</div>

    {{-- TABLE --}}
<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-gray-700">
            
            {{-- HEADER --}}
            <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500 border-b">
                <tr>
                    <th class="px-4 py-3 text-left">Pelatihan</th>
                    <th class="px-4 py-3 text-left">Tanggal</th>
                    <th class="px-4 py-3 text-left">Durasi</th>
                    <th class="px-4 py-3 text-left">Dept</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
            @forelse($pelatihans as $pelatihan)

                @php
                    $lastReschedule = $pelatihan->reschedules->last();
                    $tanggalAktif = $lastReschedule
                        ? \Carbon\Carbon::parse($lastReschedule->tanggal_baru)
                        : \Carbon\Carbon::parse($pelatihan->tanggal);

                    $statusColor = match($pelatihan->status) {
                        'Selesai' => 'bg-gray-100 text-gray-600',
                        'Reschedule' => 'bg-yellow-100 text-yellow-700',
                        default => 'bg-green-100 text-green-700'
                    };
                @endphp

                <tr class="hover:bg-gray-50 transition">

                    {{-- NAMA --}}
                    <td class="px-4 py-3">
                        <a href="{{ route('she.safety.pelatihan.show', $pelatihan->id) }}"
                           class="font-semibold text-gray-800 hover:text-blue-600">
                            {{ $pelatihan->nama_pelatihan }}
                        </a>

                        <div class="text-xs text-gray-400 mt-1">
                            {{ $pelatihan->penyelenggara ?? '-' }}
                        </div>

                        @if($pelatihan->reschedules->count())
                            <div class="text-[11px] text-yellow-600 mt-1">
                                {{ $pelatihan->reschedules->count() }}x reschedule
                            </div>
                        @endif
                    </td>

                    {{-- TANGGAL --}}
                    <td class="px-4 py-3 font-medium text-gray-800">
                        {{ $tanggalAktif->format('d M Y') }}
                    </td>

                    {{-- DURASI --}}
                    <td class="px-4 py-3">
                        {{ $pelatihan->durasi }}
                    </td>

                    {{-- DEPT --}}
                    <td class="px-4 py-3">
                        {{ $pelatihan->department ?? '-' }}
                    </td>

                    {{-- STATUS --}}
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                            {{ $pelatihan->status }}
                        </span>
                    </td>

                    {{-- AKSI --}}
                    <td class="px-4 py-3">
                        <div class="flex justify-center items-center gap-2 text-base">

                            <a href="{{ route('she.safety.pelatihan.edit', $pelatihan->id) }}"
                               title="Edit"
                               class="hover:scale-110 transition">
                                ✏️
                            </a>

                            @if($pelatihan->status !== 'Selesai')
                                <button
                                    onclick="openRescheduleModal({{ $pelatihan->id }})"
                                    title="Reschedule"
                                    class="hover:scale-110 transition">
                                    🔁
                                </button>
                            @endif

                            <form action="{{ route('she.safety.pelatihan.destroy', $pelatihan->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin hapus pelatihan ini?')">
                                @csrf
                                @method('DELETE')
                                <button title="Hapus"
                                        class="hover:scale-110 transition">
                                    🗑️
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>

            @empty
                <tr>
                    <td colspan="6" class="text-center py-10 text-gray-400">
                        Belum ada jadwal pelatihan
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL RESCHEDULE --}}
<div id="rescheduleModal"
     class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg w-full max-w-md p-5">
        <h2 class="text-lg font-semibold mb-4">Reschedule Pelatihan</h2>

        <form id="rescheduleForm" method="POST">
            @csrf

            <div class="mb-3">
                <label class="text-sm font-medium">Tanggal Baru</label>
                <input type="date" name="tanggal_baru"
                       class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="text-sm font-medium">Alasan Reschedule</label>
                <textarea name="alasan"
                          class="w-full border rounded p-2"
                          rows="3"
                          required></textarea>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button"
                        onclick="closeRescheduleModal()"
                        class="px-4 py-2 bg-gray-200 rounded">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openRescheduleModal(id) {
    const form = document.getElementById('rescheduleForm');
    form.action = "{{ url('she/safety/pelatihan') }}/" + id + "/reschedule";

    document.getElementById('rescheduleModal').classList.remove('hidden');
    document.getElementById('rescheduleModal').classList.add('flex');
}

function closeRescheduleModal() {
    document.getElementById('rescheduleModal').classList.add('hidden');
    document.getElementById('rescheduleModal').classList.remove('flex');
}
</script>
@endsection
