@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold">Limbah</h1>
        <p class="text-sm text-gray-500">Pengelolaan data limbah perusahaan</p>
    </div>

    {{-- KEMBALI --}}
    <div>
        <a href="{{ route('she.environment.index') }}"
           class="inline-flex items-center gap-1 px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">
            ← Kembali
        </a>
    </div>

    {{-- TAB MENU --}}
    <div class="flex gap-3">
        <a href="{{ route('she.environment.limbah.index',['tab'=>'data']) }}"
           class="px-5 py-2 rounded-lg text-sm font-semibold shadow
           {{ $tab=='data' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            Data Limbah
        </a>

        <a href="{{ route('she.environment.limbah.index',['tab'=>'logbook']) }}"
           class="px-5 py-2 rounded-lg text-sm font-semibold shadow
           {{ $tab=='logbook' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            Logbook Limbah
        </a>
    </div>

    {{-- =============================== --}}
    {{-- TAB DATA LIMBAH --}}
    {{-- =============================== --}}
    @if($tab == 'data')
        <div class="text-center mt-6">
            <h2 class="text-xl font-bold">Data Limbah</h2>
            <p class="text-sm text-gray-500">Daftar pencatatan limbah perusahaan</p>
        </div>

        <a href="{{ route('she.environment.limbah.create') }}"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow">
            + Tambah Data
        </a>

        <div class="overflow-x-auto mt-4">
        <table class="w-full border border-gray-200 text-sm">
            <thead class="bg-gray-100 text-center">
                <tr>
                    <th class="border p-2">No</th>
                    <th class="border p-2">No Dokumen</th>
                    <th class="border p-2">Tanggal</th>
                    <th class="border p-2">Nama</th>
                    <th class="border p-2">Jenis</th>
                    <th class="border p-2">Kategori</th>
                    <th class="border p-2">Jumlah</th>
                    <th class="border p-2">Satuan</th>
                    <th class="border p-2">Sisa</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @forelse($wastes as $waste)
                @php
                    $totalKeluar = $waste->logs->where('tipe_log','Keluar')->sum('jumlah');
                    $sisa = $waste->jumlah - $totalKeluar;
                @endphp

                <tr class="text-center hover:bg-gray-50">
                    <td class="border p-2">{{ $loop->iteration }}</td>
                    <td class="border p-2">{{ $waste->no_dokumen }}</td>
                    <td class="border p-2">{{ \Carbon\Carbon::parse($waste->tanggal)->format('d/m/Y') }}</td>
                    <td class="border p-2">{{ $waste->nama_limbah }}</td>
                    <td class="border p-2">{{ $waste->jenis_limbah }}</td>
                    <td class="border p-2">{{ $waste->kategori }}</td>
                    <td class="border p-2">{{ number_format($waste->jumlah,2) }}</td>
                    <td class="border p-2">{{ $waste->satuan }}</td>
                    <td class="border p-2 font-semibold text-green-700">{{ number_format($sisa,2) }}</td>
                    <td class="border p-2">
                        <span class="px-2 py-1 rounded
                        {{ $sisa > 0 ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                            {{ $sisa > 0 ? 'Disimpan' : 'Selesai' }}
                        </span>
                    </td>

                    {{-- Aksi: Detail + Log Keluar + Hapus --}}
                    <td class="border p-2 flex justify-center gap-1">
                        <!-- Detail -->
                        <a href="{{ route('she.environment.limbah.show',$waste->id) }}"
                           class="bg-blue-500 text-white px-2 py-1 rounded text-xs flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                              <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12H9m0 0l3-3m-3 3l3 3"/>
                            </svg>
                            Detail
                        </a>

                        <!-- Log Keluar -->
                        <a href="{{ route('she.environment.limbah.keluar.create', $waste->id) }}"
                           class="bg-yellow-500 text-white px-2 py-1 rounded text-xs flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                              <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 4v16m8-8H4"/>
                            </svg>
                            Log Keluar
                        </a>

                        <!-- Hapus -->
                        <form action="{{ route('she.environment.limbah.destroy', $waste->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 text-white px-2 py-1 rounded text-xs flex items-center gap-1"
                                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center p-4 text-gray-500">
                        Belum ada data
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        </div>

    @endif

    {{-- =============================== --}}
    {{-- TAB LOGBOOK --}}
    {{-- =============================== --}}
    @if($tab == 'logbook')

        <h2 class="text-2xl font-bold text-center uppercase tracking-wide mt-6">
            LOGBOOK PENCATATAN HARIAN PENGELOLAAN LIMBAH B3
        </h2>
<form method="GET" action="{{ route('she.environment.limbah.export-excel') }}" class="flex gap-2 mb-3">

    <input type="date" name="from" class="border p-2 rounded">
    <input type="date" name="to" class="border p-2 rounded">

    <select name="jenis" class="border p-2 rounded">
        <option value="">Semua Jenis</option>
        <option value="B3">B3</option>
        <option value="Non-B3">Non-B3</option>
    </select>

    <button type="submit"
        class="px-4 py-2 bg-green-600 text-white rounded-lg">
        Export Excel
    </button>

</form>

        </div>

        <div class="overflow-x-auto border rounded-lg shadow-sm mt-4">
        <table class="w-full border-collapse text-sm">
            <thead class="bg-gray-200 text-center font-semibold">
                <tr>
                    <th class="p-2 border">No</th>
                    <th class="p-2 border">No Dokumen</th>
                    <th class="p-2 border">Jenis</th>
                    <th class="p-2 border">Nama Limbah</th>
                    <th class="p-2 border">Tanggal Masuk</th>
                    <th class="p-2 border">Sumber</th>
                    <th class="p-2 border">Jumlah</th>
                    <th class="p-2 border">Maks Simpan</th>
                    <th class="p-2 border">Tanggal Keluar</th>
                    <th class="p-2 border">Jumlah Keluar</th>
                    <th class="p-2 border">Tujuan</th>
                    <th class="p-2 border">Bukti</th>
                    <th class="p-2 border">Sisa</th>
                </tr>
            </thead>

            <tbody>
                @forelse($logs as $i => $log)
                    @php
                        $waste = $log->waste;

                        $totalMasuk = \App\Models\WasteLog::where('waste_id',$log->waste_id)
                            ->where('tipe_log','Masuk')
                            ->sum('jumlah');

                        $totalKeluar = \App\Models\WasteLog::where('waste_id',$log->waste_id)
                            ->where('tipe_log','Keluar')
                            ->sum('jumlah');

                        $sisa = ($waste ? $waste->jumlah : 0) - $totalKeluar;

                        $hari = $waste && $waste->jenis_limbah === 'B3' ? 90 : 180;
                        $maxSimpan = $waste && $waste->tanggal 
                            ? \Carbon\Carbon::parse($waste->tanggal)->addDays($hari)->format('d/m/Y')
                            : '-';
                    @endphp

                    <tr class="text-center border-t hover:bg-gray-50">
                        <td class="p-2">{{ $i+1 }}</td>
                        <td class="p-2">{{ $waste->no_dokumen ?? '-' }}</td>
                        <td class="p-2">{{ $waste->jenis_limbah ?? '-' }}</td>
                        <td class="p-2">{{ $waste->nama_limbah ?? '-' }}</td>
                        <td class="p-2">
                            {{ $waste && $waste->tanggal 
                                ? \Carbon\Carbon::parse($waste->tanggal)->format('d/m/Y') 
                                : '-' 
                            }}
                        </td>
                        <td class="p-2">{{ $waste->sumber_limbah ?? '-' }}</td>
                        <td class="p-2">{{ $waste ? number_format($waste->jumlah,2) : '-' }}</td>
                        <td class="p-2">{{ $maxSimpan }}</td>
                        <td class="p-2">{{ $log->created_at->format('d/m/Y') }}</td>
                        <td class="p-2">{{ number_format($log->jumlah,2) }}</td>
                        <td class="p-2">{{ $waste->tujuan_pengelolaan ?? '-' }}</td>

                        <td class="p-2">
                            @if($log->foto && file_exists(public_path('storage/'.$log->foto)))
                                <a href="{{ asset('storage/'.$log->foto) }}"
                                   target="_blank"
                                   class="text-blue-600 underline">
                                   Lihat
                                </a>
                            @else
                                -
                            @endif
                        </td>

                        <td class="p-2 font-semibold">{{ number_format($sisa,2) }}</td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="13" class="text-center py-4">
                            Belum ada data
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>

    @endif

</div>
@endsection