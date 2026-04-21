<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Kecelakaan Kerja</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12pt; line-height: 1.4; }
        .header { text-align: center; margin-bottom: 20px; }
        .card { border: 1px solid #ddd; padding: 20px; border-radius: 8px; }
        .field { margin-bottom: 8px; }
        .label { font-weight: bold; }
        .status { display: inline-block; padding: 2px 6px; border-radius: 4px; font-size: 10pt; }
        .fatal { background-color: #fee2e2; color: #b91c1c; }
        .berat { background-color: #ffedd5; color: #c2410c; }
        .sedang { background-color: #fef3c7; color: #b45309; }
        .ringan { background-color: #d1fae5; color: #065f46; }
        .terkirim { background-color: #e5e7eb; color: #374151; }
        .ditangani { background-color: #fef3c7; color: #b45309; }
        .selesai { background-color: #d1fae5; color: #065f46; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Detail Kecelakaan Kerja</h1>
        <p>Informasi lengkap Kecelakaan keselamatan kerja</p>
    </div>

    <div class="card">
        @if($incident->employee->photo)
            <div style="margin-bottom:10px;">
                <img src="{{ public_path('storage/employees/'.$incident->employee->photo) }}" 
                     style="width:80px; height:80px; border-radius:50%;">
            </div>
        @endif

        <div class="field"><span class="label">Nama Karyawan:</span> {{ $incident->nama_karyawan ?? $incident->employee->full_name ?? '-' }}</div>
        <div class="field"><span class="label">Department / Bagian:</span> {{ $incident->department ?? $incident->employee->department->department_name ?? '-' }}/{{ $incident->bagian ?? $incident->employee->position->position_name ?? '-' }}</div>
        <div class="field"><span class="label">Tanggal Insiden:</span> {{ \Carbon\Carbon::parse($incident->incident_date)->format('d-m-Y') }}</div>
        <div class="field"><span class="label">Lokasi:</span> {{ $incident->location ?? '-' }}</div>
        <div class="field"><span class="label">Jenis Insiden:</span> {{ $incident->incident_type ?? '-' }}</div>
        <div class="field"><span class="label">Keparahan:</span> 
            <span class="status {{ strtolower($incident->severity) }}">
                {{ ucfirst($incident->severity) }}
            </span>
        </div>
        <div class="field"><span class="label">Deskripsi:</span> {{ $incident->description ?? '-' }}</div>
        <div class="field"><span class="label">Tindakan Awal:</span> {{ $incident->action_taken ?? '-' }}</div>
        @if($incident->attachment)
            <div class="field"><span class="label">Lampiran:</span> {{ $incident->attachment }}</div>
        @endif

        <div class="field"><span class="label">Status & Keterangan:</span> 
            <span class="status {{ strtolower($incident->status) }}">{{ ucfirst($incident->status) }}</span>
            @if($incident->status_note)
                <div style="margin-top:4px; font-style:italic;">{{ $incident->status_note }}</div>
            @endif
        </div>
    </div>
</body>
</html>
