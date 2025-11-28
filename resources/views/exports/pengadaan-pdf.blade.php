<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Export Riwayat Pengadaan</title>

    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        table th, table td {
            border: 1px solid #000;
            padding: 6px;
        }
        th { background: #f2f2f2; }
        .logo { width: 80px; margin-bottom: 10px; }
        .header { text-align: center; margin-bottom: 25px; }
        h3 { margin-bottom: 5px; }
    </style>
</head>
<body>

<div class="header">
    <img src="{{ public_path('images/logo.png') }}" class="logo">
    <h2>Riwayat Pengadaan</h2>
</div>

@foreach ($data as $pengadaan)

    <h3>Kode Pengadaan: {{ $pengadaan->kode_pengadaan }}</h3>
    <p>
        <strong>Pengaju:</strong> {{ $pengadaan->pengaju->name }} <br>
        <strong>Status:</strong> {{ ucfirst($pengadaan->status) }} <br>
        <strong>Total Harga:</strong> Rp {{ number_format($pengadaan->total_harga, 0, ',', '.') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Qty</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>

        <tbody>
    @foreach ($pengadaan->items as $i => $item)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $item->barang->nama }}</td>

            {{-- Kategori --}}
            <td>{{ $item->barang->category->nama ?? '-' }}</td>

            {{-- Qty --}}
            <td>{{ $item->jumlah }}</td>

            {{-- Harga Satuan --}}
            <td>Rp {{ number_format($item->harga_saat_pengajuan, 0, ',', '.') }}</td>

            {{-- Subtotal --}}
            <td>Rp {{ number_format($item->total_harga_item, 0, ',', '.') }}</td>
        </tr>
    @endforeach
</tbody>

    </table>

    <hr style="margin: 30px 0;">

@endforeach

</body>
</html>
