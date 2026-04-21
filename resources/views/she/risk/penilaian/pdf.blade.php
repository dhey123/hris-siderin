<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Penilaian Risiko</title>

<style>

@page {
    margin: 15px 25px 25px 25px;
}

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 11px;
    margin: 0;
    padding: 0;
}

/* ================= HEADER ================= */

.kop {
    width: 100%;
    border-bottom: 2px solid #000;
    padding-bottom: 6px;
    margin-bottom: 10px;
}

.kop img {
    width: 100%;
    max-height: 95px;
    object-fit: contain;
}

.header-info {
    width: 100%;
    border-collapse: collapse;
    margin-top: 5px;
}

.header-info td {
    vertical-align: top;
}

.judul {
    text-align: center;
    font-weight: bold;
    font-size: 15px;
    line-height: 1.4;
}

.meta {
    font-size: 10px;
    text-align: right;
}

/* ================= SECTION ================= */

.section-title {
    font-weight: bold;
    margin-top: 8px;
    margin-bottom: 4px;
}

/* ================= TABLE DATA ================= */

table.data {
    width: 100%;
    border-collapse: collapse;
    margin-top: 5px;
}

table.data th,
table.data td {
    border: 1px solid #000;
    padding: 4px;
}

table.data th {
    background-color: #f0f0f0;
    text-align: center;
    font-weight: bold;
}

/* ================= TTD ================= */

.ttd {
    margin-top: 40px;
    width: 100%;
}

.ttd td {
    text-align: center;
    border: none;
}

/* ================= FOOTER ================= */

.footer {
    position: fixed;
    bottom: 10px;
    left: 0;
    right: 0;
    font-size: 9px;
    text-align: center;
    border-top: 1px solid #ccc;
    padding-top: 3px;
}

</style>
</head>

<body>

{{-- ================= KOP SURAT ================= --}}
<div class="kop">

    @if(file_exists(public_path('kop.jpg')))
        <div style="text-align:center;">
            <img src="{{ public_path('kop.jpg') }}">
        </div>
    @endif

    <table class="header-info">
        <tr>
            <td width="70%" class="judul">
                LAPORAN PENILAIAN RISIKO<br>
                SISTEM MANAJEMEN KESELAMATAN & KESEHATAN KERJA
            </td>
            <td width="30%" class="meta">
                No. Dokumen : {{ $noDokumen ?? 'FR-SHE-001' }} <br>
                Tanggal     : {{ \Carbon\Carbon::parse($tanggalCetak)->format('d M Y') }} <br>
                Halaman     : 1
            </td>
        </tr>
    </table>

</div>

{{-- ================= INFORMASI PERIODE ================= --}}
<div class="section-title">Informasi Periode</div>
Periode :
{{ $periodeAwal ? \Carbon\Carbon::parse($periodeAwal)->format('d M Y') : '-' }}
s/d
{{ $periodeAkhir ? \Carbon\Carbon::parse($periodeAkhir)->format('d M Y') : '-' }}

{{-- ================= TABEL DATA ================= --}}
<table class="data">
<thead>
<tr>
    <th width="4%">No</th>
    <th width="20%">Nama Risiko</th>
    <th width="10%">Kategori</th>
    <th width="8%">Likelihood</th>
    <th width="8%">Impact</th>
    <th width="6%">Score</th>
    <th width="8%">Level</th>
    <th width="12%">Assessed By</th>
    <th width="10%">Tanggal</th>
</tr>
</thead>
<tbody>
@foreach($penilaian as $index => $p)
<tr>
    <td align="center">{{ $index + 1 }}</td>
    <td>{{ $p->risk->nama_risiko ?? '-' }}</td>
    <td>{{ $p->risk->kategori ?? '-' }}</td>
    <td align="center">{{ $p->likelihood }}</td>
    <td align="center">{{ $p->impact }}</td>
    <td align="center">{{ $p->risk_score }}</td>
    <td align="center">{{ $p->risk_level }}</td>
    <td>{{ $p->assessed_by ?? '-' }}</td>
    <td align="center">
        {{ $p->assessed_at ? \Carbon\Carbon::parse($p->assessed_at)->format('d M Y') : '-' }}
    </td>
</tr>
@endforeach
</tbody>
</table>

{{-- ================= TANDA TANGAN ================= --}}
<table class="ttd">
<tr>
    <td>
        Disusun Oleh,<br><br><br><br>
        ___________________________<br>
        SHE Officer
    </td>
    <td>
        Diketahui Oleh,<br><br><br><br>
        ___________________________<br>
        Manager SHE
    </td>
    <td>
        Disetujui Oleh,<br><br><br><br>
        ___________________________<br>
        Direktur
    </td>
</tr>
</table>

<div class="footer">
Dokumen ini bersifat rahasia dan hanya digunakan untuk kepentingan internal perusahaan.
</div>

</body>
</html>