<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan APK</title>

<style>
body{
    font-family: Arial, sans-serif;
    font-size:12px;
}

h2{
    text-align:center;
    margin-bottom:5px;
}

.summary{
    margin-bottom:15px;
}

.summary span{
    margin-right:20px;
    font-weight:bold;
}

table{
    width:100%;
    border-collapse: collapse;
}

th, td{
    border:1px solid #000;
    padding:6px;
}

th{
    background:#f2f2f2;
}

.text-center{
    text-align:center;
}
</style>
</head>
<body>

<h2>LAPORAN APK (ALAT PELINDUNG KESELAMATAN)</h2>

<div class="summary">
    <span>Total: {{ $total }}</span>
    <span>Baik: {{ $baik }}</span>
    <span>Maintenance: {{ $maintenance }}</span>
    <span>Rusak: {{ $rusak }}</span>
    <span>Expired: {{ $expired }}</span>
</div>

<table>
<thead>
<tr>
    <th>No</th>
    <th>Nama Alat</th>
    <th>Lokasi</th>
    <th>Jumlah</th>
    <th>Kondisi</th>
    <th>Penanggung Jawab</th>
    <th>Tanggal Update</th>
    <th>Kadaluarsa</th>
</tr>
</thead>

<tbody>
@foreach($apks as $apk)
<tr>
    <td class="text-center">{{ $loop->iteration }}</td>
    <td>{{ $apk->nama_alat }}</td>
    <td>{{ $apk->lokasi }}</td>
    <td class="text-center">{{ $apk->jumlah }}</td>
    <td>{{ $apk->kondisi }}</td>
    <td>{{ $apk->owner }}</td>
    <td>{{ $apk->tanggal_update ? date('d M Y', strtotime($apk->tanggal_update)) : '-' }}</td>
    <td>
        {{ $apk->expired_date ? date('d M Y', strtotime($apk->expired_date)) : '-' }}
    </td>
</tr>
@endforeach
</tbody>
</table>

<br><br>

<table width="100%" style="border:none;">
<tr>
    <td width="70%"></td>
    <td class="text-center" style="border:none;">
        Mengetahui,<br><br><br><br>
        ____________________<br>
        HSE / Safety Officer
    </td>
</tr>
</table>

</body>
</html>
