<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pengadaan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #d9d9d9; font-weight: bold; }
        tbody tr:nth-child(even) { background-color: #f2f2f2; }
        h2 { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>

<p>Riwayat Pengadaan</p>

<table>
    <thead>
        <tr>
            <th>Kode Pengadaan</th>
            <th>Pengaju</th>
            <th>Status</th>
            <th>Total Harga</th>
            <th>Tanggal Pengajuan</th>
            <th>Tanggal Disetujui</th>
            <th>Tanggal Selesai</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $pengadaan)
            @foreach($pengadaan->items as $item)
            <tr>
                <td>{{ $pengadaan->kode_pengadaan }}</td>
                <td>{{ $pengadaan->pengaju->name ?? '-' }}</td>
                <td>{{ ucfirst($pengadaan->status) }}</td>
                <td>="{{ number_format($pengadaan->total_harga, 0, ',', '.') }}"</td>
                <td>{{ $pengadaan->tanggal_pengajuan ?? '-' }}</td>
                <td>{{ $pengadaan->tanggal_disetujui ?? '-' }}</td>
                <td>{{ $pengadaan->tanggal_selesai ?? '-' }}</td>
                <td>{{ $item->barang->nama ?? '-' }}</td>
                <td>{{ $item->barang->category->nama ?? '-' }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>="{{ number_format($item->harga_saat_pengajuan, 0, ',', '.') }}"</td>
                <td>="{{ number_format($item->total_harga_item, 0, ',', '.') }}"</td>
            </tr>
            @endforeach
        @endforeach
    </tbody>
</table>

</body>
</html>
