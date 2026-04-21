<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Detail Karyawan - {{ $employee->full_name }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #000;
        }

        .header-table,
        .header-table tr,
        .header-table td {
            border: none !important;
        }

        .header-title {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
            padding: 0;
            line-height: 1;
            display: block;
        }


        hr {
            margin-top: 4px;
            margin-bottom: 12px;
        }

        .section {
            margin-bottom: 15px;
        }

        .section-title {
            font-weight: bold;
            background: #f2f2f2;
            padding: 6px;
            border: 1px solid #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td, th {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        th {
            width: 30%;
            background: #fafafa;
            text-align: left;
        }

        .photo-box {
            width: 110px;
            height: 140px;
            border: 1px solid #000;
            text-align: center;
            line-height: 140px;
            font-size: 10px;
        }
    </style>
</head>
<body>

@php
    $photoPath = $employee->photo
        ? storage_path('app/public/'.$employee->photo)
        : null;
@endphp

{{-- ================= HEADER ================= --}}
<table class="header-table">
    <tr>
        <td width="60%" style="vertical-align: bottom;">
            <img src="{{ $logo }}"
                 height="95"
                 style="display:block; margin-bottom:4px;">
            <span class="header-title">DATA KARYAWAN</span>
        </td>

        <td width="40%" align="right" style="vertical-align: bottom;">
            @if($photoPath && file_exists($photoPath))
                <img src="{{ $photoPath }}"
                     style="width:110px; height:140px; object-fit:cover; border:1px solid #000;">
            @else
                <div class="photo-box">No Photo</div>
            @endif
        </td>
    </tr>
</table>

<hr>


{{-- ================= IDENTITAS ================= --}}
<div class="section">
    <table>
        <tr>
            <th>ID Karyawan</th>
            <td>{{ $employee->id_karyawan }}</td>
        </tr>
        <tr>
            <th>Nama Lengkap</th>
            <td>{{ $employee->full_name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $employee->email ?? '-' }}</td>
        </tr>
        <tr>
            <th>No HP</th>
            <td>{{ $employee->phone ?? '-' }}</td>
        </tr>
    </table>
</div>

{{-- ================= INFORMASI PRIBADI ================= --}}
<div class="section">
    <div class="section-title">A. Informasi Pribadi</div>
    <table>
        <tr>
            <th>NIK</th>
            <td>{{ $employee->nik ?? '-' }}</td>
        </tr>
        <tr>
            <th>Tempat, Tanggal Lahir</th>
            <td>{{ $employee->birth_place ?? '-' }},
                {{ optional($employee->birth_date)->format('d-m-Y') ?? '-' }}</td>
        </tr>
        <tr>
            <th>Jenis Kelamin</th>
            <td>{{ $employee->gender_text ?? '-' }}</td>
        </tr>
        <tr>
            <th>Agama</th>
            <td>{{ optional($employee->religion)->religion_name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Pendidikan</th>
            <td>{{ optional($employee->education)->education_level ?? '-' }}</td>
        </tr>
        <tr>
            <th>Status Perkawinan</th>
            <td>{{ optional($employee->maritalStatus)->marital_status_name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Status Pajak</th>
            <td>{{ $taxStatus ?? '-' }}</td>
        </tr>
        <tr>
            <th>Golongan Darah</th>
            <td>{{ $employee->blood_type ?? '-' }}</td>
        </tr>
        <tr>
            <th>Nama Ibu Kandung</th>
            <td>{{ $employee->mother_name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Nomor KK</th>
            <td>{{ $employee->kk_number ?? '-' }}</td>
        </tr>
    </table>
</div>

{{-- ================= ALAMAT ================= --}}
<div class="section">
    <div class="section-title">B. Alamat</div>
    <table>
        <tr>
            <th>Alamat KTP</th>
            <td>{{ $employee->address_ktp ?? '-' }}</td>
        </tr>
        <tr>
            <th>Alamat Domisili</th>
            <td>{{ $employee->address_domisili ?? '-' }}</td>
        </tr>
    </table>
</div>

{{-- ================= KEPEGAWAIAN ================= --}}
<div class="section">
    <div class="section-title">C. Informasi Kepegawaian</div>
    <table>
        <tr>
            <th>Department</th>
            <td>{{ optional($employee->company)->company_name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Divisi</th>
            <td>{{ optional($employee->department)->department_name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Posisi</th>
            <td>{{ optional($employee->position)->position_name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Status Kerja</th>
            <td>{{ optional($employee->employmentStatus)->status_name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Tanggal Masuk</th>
            <td>{{ optional($employee->join_date)->format('d-m-Y') ?? '-' }}</td>
        </tr>
        <tr>
            <th>Tanggal Keluar</th>
            <td>{{ optional($employee->exit_date)->format('d-m-Y') ?? '-' }}</td>
        </tr>
    </table>
</div>

{{-- ================= KELUARGA ================= --}}
<div class="section">
    <div class="section-title">D. Data Keluarga</div>

    @if($employee->familyMembers->isNotEmpty())
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Hubungan</th>
                    <th>Tanggal Lahir</th>
                    <th>Tanggungan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employee->familyMembers as $family)
                <tr>
                    <td>{{ $family->name }}</td>
                    <td>{{ ucfirst($family->relationship) }}</td>
                    <td>{{ optional($family->birth_date)->format('d-m-Y') ?? '-' }}</td>
                    <td>{{ $family->is_dependent ? 'Ya' : 'Tidak' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <table>
            <tr>
                <td style="text-align:center;">Tidak ada data keluarga</td>
            </tr>
        </table>
    @endif
</div>

{{-- ================= BANK & EMERGENCY ================= --}}
<div class="section">
    <div class="section-title">E. Bank & Emergency Contact</div>
    <table>
        <tr>
            <th>Bank</th>
            <td>{{ optional($employee->bank)->bank_name ?? '-' }}</td>
        </tr>
        <tr>
            <th>No Rekening</th>
            <td>{{ $employee->bank_account ?? '-' }}</td>
        </tr>
        <tr>
            <th>Nama Emergency</th>
            <td>{{ $employee->emergency_name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Hubungan Emergency</th>
            <td>{{ $employee->emergency_relation ?? '-' }}</td>
        </tr>
        <tr>
            <th>No Emergency</th>
            <td>{{ $employee->emergency_phone ?? '-' }}</td>
        </tr>
    </table>
</div>

</body>
</html>
