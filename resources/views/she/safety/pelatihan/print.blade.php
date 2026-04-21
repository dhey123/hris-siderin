<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pelatihan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #f2f2f2; }
        h2 { text-align: center; margin-bottom: 0; }
        .right { text-align: right; font-size: 11px; }
    </style>
</head>
<body>

<h2>LAPORAN JADWAL PELATIHAN K3</h2>
<div class="right">
    Dicetak: {{ now()->format('d M Y') }}
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pelatihan</th>
            <th>Penyelenggara</th>
            <th>Tanggal Aktif</th>
            <th>Durasi</th>
            <th>Department</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pelatihans as $item)
        @php
            $lastReschedule = $item->reschedules->last();
            $tanggalAktif = $lastReschedule
                ? \Carbon\Carbon::parse($lastReschedule->tanggal_baru)
                : \Carbon\Carbon::parse($item->tanggal);
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nama_pelatihan }}</td>
            <td>{{ $item->penyelenggara ?? '-' }}</td>
            <td>{{ $tanggalAktif->format('d-m-Y') }}</td>
            <td>{{ $item->durasi }}</td>
            <td>{{ $item->department ?? '-' }}</td>
            <td>{{ $item->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<br><br>

<table width="100%" style="border:none;">
    <tr style="border:none;">
        <td style="border:none; width:70%;"></td>
        <td style="border:none; text-align:center;">
            Mengetahui,<br><br><br><br>
            (____________________)
        </td>
    </tr>
</table>

</body>
</html>