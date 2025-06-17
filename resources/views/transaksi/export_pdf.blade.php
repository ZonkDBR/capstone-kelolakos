<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #333;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            margin-top: 0;
        }
        .container {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th {
            background-color: #4472C4;
            color: white;
            font-weight: bold;
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
        }
        table td {
            padding: 10px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table tr:hover {
            background-color: #e9e9e9;
        }
        .total {
            font-weight: bold;
        }
        .summary {
            background-color: #f2f2f2;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .summary h3 {
            margin-top: 0;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .summary p {
            margin: 10px 0;
            font-size: 16px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Transaksi</h1>
        <p>Periode: @if(isset($from) && isset($to)) {{ $from }} - {{ $to }} @else Semua Data @endif</p>
    </div>
    
    <div class="container">
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
                    <td>{{ $item->lokasiKos ? $item->lokasiKos->nama_kos : 'N/A' }}</td>
                    <td>{{ $item->jenis }}</td>
                    <td>{{ $item->sumber }}</td>
                    <td>Rp{{ number_format($item->nominal, 2, ',', '.') }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="summary">
            <h3>Ringkasan</h3>
            <p>Total Pemasukan: Rp{{ number_format($totalPemasukan, 2, ',', '.') }}</p>
            <p>Total Pengeluaran: Rp{{ number_format($totalPengeluaran, 2, ',', '.') }}</p>
            <p>Total Saldo: Rp{{ number_format($totalSaldo, 2, ',', '.') }}</p>
        </div>
    </div>
    
    <div class="footer">
        <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>
</body>
</html>