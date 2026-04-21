<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Audit - {{ $audit->kode_audit }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .info { width: 100%; margin-bottom: 20px; }
        .info td { padding: 4px 8px; vertical-align: top; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
        .ttd { margin-top: 50px; width: 100%; text-align: left; }
        .ttd div { display: inline-block; width: 30%; text-align: center; }
    </style>
</head>
<body>

    <div class="header" style="text-align:center; margin-bottom:20px;">
    <h2 style="margin:0;">AUDIT INTERNAL</h2>
    <h3 style="margin:0;">PT Quantum Tosan International</h3>
</div>

{{-- ================= INFO AUDIT ================= --}}
<table class="info" width="100%" cellpadding="6" cellspacing="0">
    <tr>
        <td width="33%"><strong>Kode Audit</strong> : {{ $audit->kode_audit }}</td>
        <td width="33%"><strong>Jenis Audit</strong> : {{ $audit->jenis_audit }}</td>
        <td width="33%"><strong>Tanggal</strong> : {{ \Carbon\Carbon::parse($audit->tanggal_audit)->format('d/m/Y') }}</td>
    </tr>
    <tr>
        <td><strong>Area</strong> : {{ $audit->area }}</td>
        <td><strong>Auditor</strong> : {{ $audit->auditor }}</td>
        <td><strong>Status</strong> : {{ ucfirst($audit->status) }}</td>
    </tr>
</table>

    {{-- ================= CHECKLIST ================= --}}
    <h3>Checklist Audit</h3>
    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Item</th>
                <th>Hasil</th>
                <th>Temuan</th>
                <th>Tindak Lanjut</th>
                <th>Target</th>
            </tr>
        </thead>
        <tbody>
            @forelse($audit->details as $detail)
            <tr>
                <td>{{ $detail->checklist->kategori }}</td>
                <td>
                    {{ $detail->checklist->item }}<br>
                    <small>Standar: {{ $detail->checklist->standar }}</small>
                </td>
                <td>{{ ucfirst($detail->hasil) }}</td>
                <td>{{ $detail->temuan ?? '-' }}</td>
                <td>{{ $detail->tindak_lanjut ?? '-' }}</td>
                <td>{{ $detail->target_selesai ? \Carbon\Carbon::parse($detail->target_selesai)->format('d/m/Y') : '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;">Belum ada checklist</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ================= TTD ================= --}}
    <div class="ttd">
        <div>
            Auditor<br><br><br>
            ({{ $audit->auditor }})
        </div>
        <div>
            Mengetahui<br><br><br>
            (___________________)
        </div>
        <div>
            Pihak Terkait<br><br><br>
            (___________________)
        </div>
    </div>

</body>
</html>