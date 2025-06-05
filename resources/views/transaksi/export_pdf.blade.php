<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .total {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Laporan Transaksi</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Lokasi Kos</th>
                <th>Jenis</th>
                <th>Sumber</th>
                <th>Nominal</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->lokasiKos->nama_kos }}</td>
                <td>{{ $item->jenis }}</td>
                <td>{{ $item->sumber }}</td>
                <td>Rp{{ number_format($item->nominal, 2, ',', '.') }}</td>
                <td>{{ $item->tanggal }}</td>
                <td>{{ $item->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Display the sum of pemasukan, pengeluaran, and total saldo -->
    <div class="total">
        <p>Total Pemasukan: Rp{{ number_format($totalPemasukan, 2, ',', '.') }}</p>
        <p>Total Pengeluaran: Rp{{ number_format($totalPengeluaran, 2, ',', '.') }}</p>
        <p>Total Saldo: Rp{{ number_format($totalSaldo, 2, ',', '.') }}</p>
    </div>
</body>
</html>