@extends('template.main')
@section('title', 'Edit Transaksi')
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
                        <div class="card-body">
                            <form action="{{ route('transaksi.update', $transaksi->id_transaksi) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="jenis">Jenis Transaksi</label>
                                    <select name="jenis" id="jenis" class="form-control" required>
                                        <option value="Pemasukan" {{ $transaksi->jenis == 'Pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                                        <option value="Pengeluaran" {{ $transaksi->jenis == 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="sumber">Sumber</label>
                                    <input type="text" name="sumber" id="sumber" class="form-control" value="{{ $transaksi->sumber }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="nominal">Nominal</label>
                                    <input type="number" name="nominal" id="nominal" class="form-control" value="{{ $transaksi->nominal }}" step="0.01" required>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $transaksi->tanggal }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control">{{ $transaksi->keterangan }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection