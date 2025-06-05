@extends('template.main')
@section('title', 'Pemasukan')
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
                                <form action="{{ route('transaksi.pemasukan') }}" method="GET" class="form-inline">
                                    <div class="form-group mr-2">
                                        <label for="from">Dari:</label>
                                        <input type="month" name="from" id="from" class="form-control" value="{{ request('from') }}">
                                    </div>
                                    <div class="form-group mr-2">
                                        <label for="to">Sampai:</label>
                                        <input type="month" name="to" id="to" class="form-control" value="{{ request('to') }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </form>
                                <a href="/transaksi/create" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah Pemasukan </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Sumber</th>
                                        <th>Nominal</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($pemasukan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->sumber }}</td>
                                        <td>Rp{{ number_format($item->nominal, 2, ',', '.') }}</td>
                                        <td>{{ $item->tanggal }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td>
                                            <form class="d-inline" action="{{ route('transaksi.edit', $item->id_transaksi) }}" method="GET">
                                                <button type="submit" class="btn btn-success btn-sm mr-1">
                                                    <i class="fa-solid fa-pen"></i> Edit
                                                </button>
                                            </form>
                                            <form class="d-inline" action="{{ route('transaksi.destroy', $item->id_transaksi) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    id="btn-delete"><i class="fa-solid fa-trash-can"></i> Delete
                                                </button>
                                            </form>
                                        </td>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection