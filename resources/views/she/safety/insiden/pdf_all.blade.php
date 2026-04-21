<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
body { font-family: DejaVu Sans; font-size: 12px; }
table { width:100%; border-collapse: collapse; }
th,td { border:1px solid #000; padding:5px; }
th { background:#eee; }
</style>
</head>

<body>

<h2 align="center">LAPORAN INSIDEN KESELAMATAN KERJA</h2>
<p align="center">
Periode: {{ $start }} s/d {{ $end }}
</p>

<p>
Total: {{ $stats['total'] }} |
Terkirim: {{ $stats['terkirim'] }} |
Ditangani: {{ $stats['ditangani'] }} |
Selesai: {{ $stats['selesai'] }}
</p>

<table>
<thead>
<tr>
    <th>No</th>
    <th>Tanggal</th>
    <th>Nama</th>
    <th>Departemen</th>
    <th>Lokasi</th>
    <th>Jenis</th>
    <th>Severity</th>
    <th>Status</th>
</tr>
</thead>
<tbody>
@foreach($incidents as $i => $row)
<tr>
    <td>{{ $i+1 }}</td>
    <td>{{ $row->incident_date }}</td>
    <td>{{ $row->nama_karyawan }}</td>
    <td>{{ $row->department }}</td>
    <td>{{ $row->location }}</td>
    <td>{{ $row->incident_type }}</td>
    <td>{{ strtoupper($row->severity) }}</td>
    <td>{{ strtoupper($row->status) }}</td>
</tr>
@endforeach
</tbody>
</table>

<br><br>
<table width="100%" border="0">
<tr>
<td width="70%"></td>
<td align="center">
Mengetahui,<br><br><br><br>
( __________________ )
</td>
</tr>
</table>

</body>
</html>
