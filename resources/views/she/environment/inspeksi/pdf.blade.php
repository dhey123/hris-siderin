<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Inspeksi</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        h2,h3 {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #f0f0f0;
        }

        .center { text-align:center; }
        .right { text-align:right; }
    </style>
</head>
<body>

{{-- HEADER --}}
<div class="center">
    <h2>DETAIL INSPEKSI</h2>
    <h3>PT Quantum Tosan International</h3>
</div>

<hr>

<table style="width:100%; border-collapse: collapse; font-size:12px;">
    <tr>
        <td style="width:50%;"><b>Nomor</b> : {{ $inspection->nomor_inspeksi }}</td>
        <td style="width:50%;"><b>Tanggal</b> : {{ \Carbon\Carbon::parse($inspection->tanggal)->format('d-m-Y') }}</td>
    </tr>
    <tr>
        <td><b>Area</b> : {{ $inspection->area }}</td>
        <td><b>Jenis</b> : {{ $inspection->jenis }}</td>
    </tr>
    <tr>
        <td><b>Status</b> : {{ $inspection->status }}</td>
        <td><b>Inspector</b> : {{ $inspection->user->name ?? '-' }}</td>
    </tr>
</table>

{{-- DETAIL --}}
<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="10%">Kategori</th>
            <th width="10%">Kode</th>
            <th width="35%">Item</th>
            <th width="20%">Standar</th>
            <th width="10%">Hasil</th>
            <th width="10%">Ket</th>
        </tr>
    </thead>
    <tbody>
        @foreach($inspection->details as $i=>$d)
        <tr>
            <td class="center">{{ $i+1 }}</td>
            <td>{{ $d->checklist->kategori }}</td>
            <td>{{ $d->checklist->kode }}</td>
            <td>{{ $d->checklist->item }}</td>
            <td>{{ $d->checklist->standar }}</td>
            <td class="center">
                {{ $d->hasil == 'OK' ? 'OK (Sesuai)' : 'NG (Tidak Sesuai)' }}
            </td>
            <td>{{ $d->keterangan ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@if($inspection->keterangan)
<br>
<b>Catatan:</b><br>
{{ $inspection->keterangan }}
@endif
<br><br>

<table width="100%" style="border:0">
<tr style="border:0">

    <td class="center" style="border:0">
        Dibuat Oleh,<br><br><br><br>
        <u>{{ $inspection->user->name ?? 'Inspector' }}</u><br>
        Inspector
    </td>

    <td class="center" style="border:0">
        Diperiksa Oleh,<br><br><br><br>
        <u>____________________</u><br>
        Supervisor
    </td>

    <td class="center" style="border:0">
        Disetujui Oleh,<br><br><br><br>
        <u>____________________</u><br>
        Manager
    </td>

</tr>
</table>

</body>
</html>
