<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Pelatihan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #f2f2f2; }
        .no-border td { border: none; padding: 3px; }
    </style>
</head>
<body>

<h2>Detail Pelatihan K3</h2>

<table class="no-border">
<tr><td width="150">Nama</td><td>: {{ $pelatihan->nama_pelatihan }}</td></tr>
<tr><td>Penyelenggara</td><td>: {{ $pelatihan->penyelenggara ?? '-' }}</td></tr>
<tr><td>Department</td><td>: {{ $pelatihan->department ?? '-' }}</td></tr>
<tr><td>Tanggal Aktif</td><td>: {{ $tanggalAktif->format('d M Y') }}</td></tr>
<tr><td>Durasi</td><td>: {{ $pelatihan->durasi }}</td></tr>
<tr><td>Status</td><td>: {{ $pelatihan->status }}</td></tr>
</table>

<h3>Riwayat Reschedule</h3>

<table>
<thead>
<tr>
<th>No</th>
<th>Tanggal Lama</th>
<th>Tanggal Baru</th>
<th>Alasan</th>
</tr>
</thead>
<tbody>
@forelse($pelatihan->reschedules as $i => $res)
<tr>
<td>{{ $i+1 }}</td>
<td>{{ \Carbon\Carbon::parse($res->tanggal_lama)->format('d M Y') }}</td>
<td>{{ \Carbon\Carbon::parse($res->tanggal_baru)->format('d M Y') }}</td>
<td>{{ $res->alasan }}</td>
</tr>
@empty
<tr>
<td colspan="4" align="center">Tidak ada reschedule</td>
</tr>
@endforelse
</tbody>
</table>

@if($pelatihan->evaluasi)
<h3>Evaluasi</h3>
<table>
<tr><td width="150">Nilai</td><td>: {{ $pelatihan->evaluasi->nilai }}/100</td></tr>
<tr><td>Catatan</td><td>: {{ $pelatihan->evaluasi->catatan }}</td></tr>
</table>
@endif

</body>
</html>