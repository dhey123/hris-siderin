<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Kontrak</title>

<style>
body{
    font-family: DejaVu Sans, sans-serif;
    font-size:12px;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

th, td{
    border:1px solid #000;
    padding:6px;
    text-align:left;
}

th{
    background:#f2f2f2;
}

.title{
    text-align:center;
    font-size:18px;
    font-weight:bold;
}

.subtitle{
    text-align:center;
    font-size:12px;
}
</style>

</head>
<body>

<div class="title">
LAPORAN KONTRAK & PERJANJIAN
</div>

<div class="subtitle">
Tanggal Cetak : {{ now()->format('d M Y') }}
</div>

<table>

<thead>
<tr>
<th>No</th>
<th>Nomor Kontrak</th>
<th>Nama Kontrak</th>
<th>Vendor</th>
<th>Tanggal Mulai</th>
<th>Tanggal Berakhir</th>
<th>Sisa Hari</th>
<th>Status</th>
</tr>
</thead>

<tbody>

@foreach($contracts as $i => $contract)

<tr>

<td>{{ $i+1 }}</td>

<td>{{ $contract->nomor_kontrak }}</td>

<td>{{ $contract->nama_kontrak }}</td>

<td>{{ $contract->vendor->nama_vendor ?? '-' }}</td>

<td>
{{ $contract->tanggal_mulai ? \Carbon\Carbon::parse($contract->tanggal_mulai)->format('d M Y') : '-' }}
</td>

<td>
{{ $contract->tanggal_berakhir ? \Carbon\Carbon::parse($contract->tanggal_berakhir)->format('d M Y') : '-' }}
</td>

<td>{{ $contract->sisa_hari }}</td>

<td>{{ $contract->status }}</td>

</tr>

@endforeach

</tbody>

</table>

</body>
</html>