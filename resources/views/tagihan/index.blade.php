@extends('template.main')

@section('title', 'Tagihan Sewa')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">@yield('title') - Bulan {{ \Carbon\Carbon::now()->format('F Y') }}</h1>
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
                            <h3 class="card-title">List Tagihan Bulanan</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Penghuni</th>
                                        <th>Kamar</th>
                                        <th>Jumlah Tagihan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tagihans as $tagihan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $tagihan->penghuni->nama_penghuni }}</td>
                                        <td>{{ $tagihan->kamar->nomor_kamar }}</td>
                                        <td>Rp{{ number_format($tagihan->kamar->harga, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($tagihan->dibayar == 'Sudah')
                                            <span class="badge bg-success">Sudah Bayar</span>
                                            @else
                                            <span class="badge bg-warning">Belum Bayar</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($tagihan->dibayar == 'Belum')
                                            <a href="{{ route('tagihan.create', ['id_sewa' => $tagihan->id_sewa]) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-money-bill-wave"></i> Bayar Tagihan
                                            </a>
                                            @else
                                            <span class="text-muted">Sudah Lunas</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection