<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nomor Kontrak</th>
            <th>Nama Kontrak</th>
            <th>Vendor</th>
            <th>Jenis</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Berakhir</th>
            <th>Sisa Hari</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @foreach($contracts as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nomor_kontrak }}</td>
            <td>{{ $item->nama_kontrak }}</td>
            <td>{{ $item->vendor->nama_vendor ?? '-' }}</td>
            <td>{{ $item->jenis->nama_jenis ?? '-' }}</td>

            <td>
                {{ $item->tanggal_mulai 
                ? \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-m-Y') 
                : '-' }}
            </td>

            <td>
                {{ $item->tanggal_berakhir 
                ? \Carbon\Carbon::parse($item->tanggal_berakhir)->format('d-m-Y') 
                : '-' }}
            </td>

            <td>{{ $item->sisa_hari }}</td>
            <td>{{ $item->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>