@extends('template.main')

@section('title', 'Form Pembayaran Tagihan')

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
                        <li class="breadcrumb-item"><a href="{{ route('tagihan.index') }}">Tagihan</a></li>
                        <li class="breadcrumb-item active">Form Pembayaran</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Detail Pembayaran</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('tagihan.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_sewa" value="{{ $sewa->id_sewa }}">

                                <!-- Display validation errors -->
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <div class="form-group">
                                    <label for="penghuni">Nama Penghuni</label>
                                    <input type="text" class="form-control" id="penghuni" value="{{ $sewa->penghuni->nama_penghuni }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="kamar">Nomor Kamar</label>
                                    <input type="text" class="form-control" id="kamar" value="{{ $sewa->kamar->nomor_kamar }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="jumlah_tagihan">Jumlah Tagihan</label>
                                    <input type="text" class="form-control" id="jumlah_tagihan" value="{{ number_format($sewa->kamar->harga, 0, ',', '.') }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="nominal">Jumlah Pembayaran</label>
                                    <input type="number" class="form-control" id="nominal" name="nominal" required min="{{ $sewa->kamar->harga }}">
                                </div>

                                <div class="form-group">
                                    <label for="tanggal_bayar">Tanggal Pembayaran</label>
                                    <input type="date" class="form-control" id="tanggal_bayar" name="tanggal_bayar" required>
                                </div>

                                <div class="form-group">
                                    <label for="periode_bayar">Periode Pembayaran</label>
                                    <input type="text" class="form-control" id="periode_bayar" name="periode_bayar" required placeholder="e.g., Januari 2025">
                                </div>

                                <div class="form-group">
                                    <label for="metode_pembayaran">Metode Pembayaran</label>
                                    <select class="form-control" id="metode_pembayaran" name="metode_pembayaran" required>
                                        <option value="Tunai">Tunai</option>
                                        <option value="Transfer">Transfer</option>
                                        <option value="E-Wallet">E-Wallet</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan Pembayaran</button>
                                <a href="{{ route('tagihan.index') }}" class="btn btn-secondary">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection