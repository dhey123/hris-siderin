<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan APD</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #eee; }
        .text-center { text-align: center; }
        .header { text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>

<div class="header">
    <h2>LAPORAN DATA APD</h2>
    <p>Tanggal Cetak: {{ date('d-m-Y') }}</p>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama APD</th>
            <th>Jenis</th>
            <th>Department</th>
            <th>Stok Awal</th>
            <th>Stok Saat Ini</th>
            <th>Kondisi</th>
            <th>Tanggal Pengadaan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($apds as $index => $apd)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $apd->nama_apd }}</td>
            <td>{{ $apd->jenis_apd }}</td>
            <td>{{ $apd->department }}</td>
            <td>{{ $apd->stok_awal }}</td>
            <td>{{ $apd->stok_saat_ini }}</td>
            <td>{{ $apd->kondisi }}</td>
            <td>{{ \Carbon\Carbon::parse($apd->tanggal_pengadaan)->format('d-m-Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<br><br>

<table>
    <tr>
        <td>Total Stok Awal</td>
        <td>{{ $total_stok_awal }}</td>
    </tr>
    <tr>
        <td>Stok Saat Ini</td>
        <td>{{ $total_stok_saat_ini }}</td>
    </tr>
    <tr>
        <td>Total Terpakai</td>
        <td>{{ $total_terpakai }}</td>
    </tr>
</table>

<br><br><br>

<table width="100%" border="0">
    <tr>
        <td width="70%"></td>
        <td class="text-center">
            Mengetahui,<br><br><br><br>
            _______________________
        </td>
    </tr>
</table>

</body>
</html>