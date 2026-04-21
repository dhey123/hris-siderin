<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>
@page { margin: 25px; }

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 10px;
}

.judul {
    text-align: center;
    font-size: 14px;
    font-weight: bold;
}

.meta {
    font-size: 10px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid black;
    padding: 4px;
}

th {
    background: #f2f2f2;
    text-align: center;
}

.left {
    text-align: left;
}
</style>
</head>
<body>

{{-- ================= HEADER ISO ================= --}}
<table width="100%">
<tr>
    <td width="20%">
        @if(file_exists(public_path('logo.png')))
            <img src="{{ public_path('logo.png') }}" height="60">
        @endif
    </td>

    <td width="80%" style="text-align:center;">
        <div style="font-size:16px; font-weight:bold;">
            LAPORAN MITIGASI RISIKO
        </div>
        <div style="font-size:12px;">
            SISTEM MANAJEMEN KESELAMATAN & KESEHATAN KERJA
        </div>
    </td>
</tr>
</table>

<br>

<div style="font-size:11px; line-height:1.6;">
    <strong>No. Dokumen:</strong> {{ $noDokumen }} <br>
    <strong>Revisi:</strong> {{ $revisi }} <br>
    <strong>Periode:</strong> {{ $periode }} <br>
    <strong>Tanggal Cetak:</strong> 
    {{ \Carbon\Carbon::parse($tanggalCetak)->format('d M Y') }}
</div>

<hr>
<br>

{{-- ================= RINGKASAN ================= --}}
<table width="50%">
<tr>
    <td>Total Mitigasi</td>
    <td>{{ $mitigasi->count() }}</td>
</tr>
<tr>
    <td>Open</td>
    <td>{{ $mitigasi->where('status','Open')->count() }}</td>
</tr>
<tr>
    <td>On Progress</td>
    <td>{{ $mitigasi->where('status','On Progress')->count() }}</td>
</tr>
<tr>
    <td>Closed</td>
    <td>{{ $mitigasi->where('status','Closed')->count() }}</td>
</tr>
</table>

<br>

{{-- ================= TABEL MITIGASI ================= --}}
<table>
<thead>
<tr>
    <th width="5%">No</th>
    <th width="20%">Risiko</th>
    <th width="25%">Tindakan</th>
    <th width="12%">PIC</th>
    <th width="13%">Deadline</th>
    <th width="12%">Status</th>
    <th width="13%">Efektivitas</th>
</tr>
</thead>
<tbody>
@foreach($mitigasi as $index => $m)
<tr>
    <td align="center">{{ $index + 1 }}</td>
    <td class="left">{{ $m->risk->nama_risiko ?? '-' }}</td>
    <td class="left">{{ $m->tindakan }}</td>
    <td align="center">{{ $m->pic }}</td>
    <td align="center">
        {{ $m->deadline 
            ? \Carbon\Carbon::parse($m->deadline)->format('d M Y') 
            : '-' }}
    </td>
    <td align="center">{{ $m->status }}</td>
    <td align="center">{{ $m->efektivitas ?? '-' }}</td>
</tr>
@endforeach
</tbody>
</table>

<br><br><br>

<div style="width:100%;">

    <div style="float:left; width:45%; text-align:center;">
        Disetujui Oleh,<br><br><br><br>
        (_____________________)<br>
        Manager SHE
    </div>

    <div style="float:right; width:45%; text-align:center;">
        Dibuat Oleh,<br><br><br><br>
        (_____________________)<br>
        Staff SHE
    </div>

</div>

<div style="clear:both;"></div>
</body>
</html>