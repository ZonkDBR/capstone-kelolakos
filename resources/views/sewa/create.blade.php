@extends('template.main')
@section('title', 'Tambah Sewa')
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
                        <li class="breadcrumb-item"><a href="/sewa">Sewa</a></li>
                        <li class="breadcrumb-item active">@yield('title')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Sewa</h3>
                        </div>
                        <form action="{{ route('sewa.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <!-- Penghuni Dropdown -->
                                <div class="form-group">
                                    <label for="id_penghuni">Penghuni</label>
                                    <select class="form-control" id="id_penghuni" name="id_penghuni" required>
                                        <option value="">Pilih Penghuni</option>
                                        @foreach ($penghuni as $p)
                                            <option value="{{ $p->id_penghuni }}">{{ $p->nama_penghuni }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Kamar Dropdown -->
                                <div class="form-group">
                                    <label for="id_kamar">Kamar</label>
                                    <select class="form-control" id="id_kamar" name="id_kamar" required>
                                        <option value="">Pilih Kamar</option>
                                        @foreach ($kamar as $k)
                                            <option value="{{ $k->id_kamar }}">{{ $k->nomor_kamar }} ({{ $k->tipe_kamar }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Other fields -->
                                <div class="form-group">
                                    <label for="tanggal_sewa">Tanggal Sewa</label>
                                    <input type="date" class="form-control" id="tanggal_sewa" name="tanggal_sewa" required>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Berakhir">Berakhir</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection