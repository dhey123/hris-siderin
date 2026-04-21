<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Rencana Tanggap Darurat</title>

<style>

@page {
    margin: 25px 25px;
}

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 11px;
    margin: 0;
}

/* ===== KOP SURAT ===== */
.kop-table {
    width: 100%;
    border-bottom: 2px solid black;
    margin-bottom: 15px;
}

.kop-table td {
    border: none;
}

.judul {
    text-align: center;
    font-weight: bold;
    font-size: 14px;
    margin-top: 10px;
    margin-bottom: 5px;
}

.info {
    margin-bottom: 15px;
    font-size: 11px;
}

/* ===== TABEL DATA ===== */
.table-data {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
}

.table-data th,
.table-data td {
    border: 1px solid black;
    padding: 5px;
    word-wrap: break-word;
}

.table-data th {
    background-color: #eeeeee;
    text-align: center;
    font-weight: bold;
}

.table-data thead {
    display: table-header-group; /* supaya header repeat tiap halaman */
}

/* ===== TANDA TANGAN ===== */
.ttd {
    margin-top: 60px;
    width: 100%;
}

.ttd-left {
    width: 45%;
    float: left;
    text-align: center;
}

.ttd-right {
    width: 45%;
    float: right;
    text-align: center;
}

.clear {
    clear: both;
}

</style>
</head>
<body>

{{-- ================= KOP SURAT ================= --}}
<div style="width:100%; text-align:center; border-bottom:2px solid #000; padding-bottom:10px;">
@if(file_exists(public_path('kop.jpg')))
        <img src="{{ public_path('kop.jpg') }}" style="width:100%;">
    @endif
</div>

<div class="judul">
    LAPORAN RENCANA TANGGAP DARURAT
</div>

<div class="info">
    <strong>Periode:</strong> {{ $periode }} <br>
    <strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->format('d M Y') }}
</div>

{{-- ================= TABEL DATA ================= --}}
<table class="table-data">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="20%">Risiko</th>
            <th width="25%">Rencana Darurat</th>
            <th width="10%">Contact</th>
            <th width="15%">Catatan</th>
            <th width="10%">Dibuat</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $i => $d)
        <tr>
            <td align="center">{{ $i+1 }}</td>
            <td>{{ $d->risk->nama_risiko ?? '-' }}</td>
            <td>{!! nl2br(e($d->rencana)) !!}</td>
            <td>{{ $d->contact_person ?? '-' }}</td>
            <td>{!! nl2br(e($d->catatan ?? '-')) !!}</td>
            <td align="center">
                {{ $d->created_at ? $d->created_at->format('d-m-Y') : '-' }}
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" align="center" style="padding:10px;">
                Tidak ada data
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- ================= TANDA TANGAN ================= --}}
<div class="ttd">
    <div class="ttd-left">
        Disetujui Oleh,<br><br><br><br>
        (_____________________)<br>
        Manager SHE
    </div>

    <div class="ttd-right">
        Dibuat Oleh,<br><br><br><br>
        (_____________________)<br>
        Staff SHE
    </div>
</div>

<div class="clear"></div>

</body>
</html>