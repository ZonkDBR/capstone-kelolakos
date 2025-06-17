@extends('template.main')
@section('title', 'Laporan Transaksi')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">@yield('title')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">@yield('title')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="text-right">
                                <form action="{{ route('transaksi.laporan') }}" method="GET" class="form-inline">
                                    <div class="form-group mr-2">
                                        <label for="from">Dari:</label>
                                        <input type="month" name="from" id="from" class="form-control" value="{{ request('from', $from) }}">
                                    </div>
                                    <div class="form-group mr-2">
                                        <label for="to">Sampai:</label>
                                        <input type="month" name="to" id="to" class="form-control" value="{{ request('to', $to) }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </form>
                                <a href="{{ route('transaksi.exportExcel', ['from' => request('from'), 'to' => request('to')]) }}" class="btn btn-success">
                                    <i class="fa-solid fa-file-excel"></i> Export Excel
                                </a>
                                <a href="{{ route('transaksi.exportPdf', ['from' => request('from'), 'to' => request('to')]) }}" class="btn btn-danger">
                                    <i class="fa-solid fa-file-pdf"></i> Export PDF
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
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
                                        <td>
                                            @if ($item->jenis == 'Pemasukan')
                                            <span class="badge bg-success">{{ $item->jenis }}</span>
                                            @else
                                            <span class="badge bg-danger">{{ $item->jenis }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->sumber }}</td>
                                        <td>Rp{{ number_format($item->nominal, 2, ',', '.') }}</td>
                                        <td>{{ $item->tanggal }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="card bg-success text-white">
                                        <div class="card-body">
                                            <h5 class="card-title">Total Pemasukan</h5>
                                            <p class="card-text">Rp{{ number_format($totalPemasukan, 2, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-danger text-white">
                                        <div class="card-body">
                                            <h5 class="card-title">Total Pengeluaran</h5>
                                            <p class="card-text">Rp{{ number_format($totalPengeluaran, 2, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body">
                                            <h5 class="card-title">Total Saldo</h5>
                                            <p class="card-text">Rp{{ number_format($totalSaldo, 2, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection