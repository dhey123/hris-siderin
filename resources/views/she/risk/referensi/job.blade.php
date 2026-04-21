@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">

    {{-- Judul --}}
    <div class="text-center">
        <h1 class="text-2xl font-bold">Job Description Management SHE & Risiko</h1>
        <p class="text-sm text-gray-500 mt-1">PT Quantum Tosan International</p>
    </div>

    {{-- Tabel Job Description --}}
    <div class="overflow-x-auto mt-6">
        <table class="min-w-full table-auto border border-gray-200 rounded-lg">
            <thead class="bg-green-50">
                <tr>
                    <th class="px-4 py-2 border text-left">Jabatan / Posisi</th>
                    <th class="px-4 py-2 border text-left">Tanggung Jawab Utama</th>
                </tr>
            </thead>
            <tbody>
                <tr class="hover:bg-green-50">
                    <td class="px-4 py-2 border font-semibold">Manajer SHE</td>
                    <td class="px-4 py-2 border">Mengelola seluruh program SHE, melaporkan ke manajemen puncak, memastikan kepatuhan regulasi.</td>
                </tr>
                <tr class="hover:bg-green-50">
                    <td class="px-4 py-2 border font-semibold">Seksi Pencegahan & Pengendalian Risiko</td>
                    <td class="px-4 py-2 border">Identifikasi risiko, implementasi SOP keselamatan, pemantauan kepatuhan.</td>
                </tr>
                <tr class="hover:bg-green-50">
                    <td class="px-4 py-2 border font-semibold">Seksi Audit & Kepatuhan</td>
                    <td class="px-4 py-2 border">Melakukan audit internal, inspeksi rutin, memastikan prosedur dijalankan.</td>
                </tr>
                <tr class="hover:bg-green-50">
                    <td class="px-4 py-2 border font-semibold">Seksi Pelatihan & Sosialisasi</td>
                    <td class="px-4 py-2 border">Menyusun materi pelatihan K3, sosialisasi prosedur keselamatan.</td>
                </tr>
                <tr class="hover:bg-green-50">
                    <td class="px-4 py-2 border font-semibold">Koordinator Tanggap Darurat</td>
                    <td class="px-4 py-2 border">Memimpin tim tanggap darurat, mengkoordinasi evakuasi dan komunikasi saat insiden.</td>
                </tr>
                <tr class="hover:bg-green-50">
                    <td class="px-4 py-2 border font-semibold">Tim Medis Darurat</td>
                    <td class="px-4 py-2 border">Menangani pertolongan pertama dan medis selama insiden.</td>
                </tr>
                <tr class="hover:bg-green-50">
                    <td class="px-4 py-2 border font-semibold">Tim Evakuasi & Keamanan</td>
                    <td class="px-4 py-2 border">Mengatur evakuasi, memastikan area aman, mendukung koordinasi tanggap darurat.</td>
                </tr>
                <tr class="hover:bg-green-50">
                    <td class="px-4 py-2 border font-semibold">Tim Komunikasi Darurat</td>
                    <td class="px-4 py-2 border">Menyebarkan informasi, laporan situasi ke manajemen dan stakeholder.</td>
                </tr>
                <tr class="hover:bg-green-50">
                    <td class="px-4 py-2 border font-semibold">Ketua Panitia K3</td>
                    <td class="px-4 py-2 border">Memimpin Panitia K3, memantau implementasi program keselamatan.</td>
                </tr>
                <tr class="hover:bg-green-50">
                    <td class="px-4 py-2 border font-semibold">Sekretaris Panitia K3</td>
                    <td class="px-4 py-2 border">Administrasi, dokumentasi rapat dan kegiatan K3.</td>
                </tr>
                <tr class="hover:bg-green-50">
                    <td class="px-4 py-2 border font-semibold">Bendahara Panitia K3</td>
                    <td class="px-4 py-2 border">Mengelola anggaran dan pengeluaran Panitia K3.</td>
                </tr>
                <tr class="hover:bg-green-50">
                    <td class="px-4 py-2 border font-semibold">Seksi Pencegahan Kecelakaan</td>
                    <td class="px-4 py-2 border">Menyusun strategi pencegahan, inspeksi peralatan dan area kerja.</td>
                </tr>
                <tr class="hover:bg-green-50">
                    <td class="px-4 py-2 border font-semibold">Seksi Pelatihan K3</td>
                    <td class="px-4 py-2 border">Menyusun jadwal pelatihan, koordinasi peserta dan instruktur.</td>
                </tr>
                <tr class="hover:bg-green-50">
                    <td class="px-4 py-2 border font-semibold">Seksi Audit & Inspeksi K3</td>
                    <td class="px-4 py-2 border">Audit rutin implementasi K3 di lapangan.</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
@endsection