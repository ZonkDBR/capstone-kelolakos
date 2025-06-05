@extends('template.main')
@section('title', 'Add Penghuni Kos')
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
                    <li class="breadcrumb-item"><a href="/penghuni">Penghuni Kos</a></li>
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
                    <div class="card">
                        <div class="card-header">
                            <div class="text-right">
                            <a href="/penghuni" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-rotate-left"></i>
                                Back
                            </a>
                            </div>
                        </div>
                        <form class="needs-validation" novalidate action="{{ route('penghuni.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <!-- Nama Lengkap -->
                                <div class="form-group">
                                    <label for="nama_penghuni">Nama Lengkap</label>
                                    <input type="text" name="nama_penghuni" id="nama_penghuni" class="form-control" required placeholder="Nama Penghuni">
                                    @error('nama_penghuni')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Nomor KTP -->
                                <div class="form-group">
                                    <label for="no_ktp">Nomor KTP</label>
                                    <input type="text" name="no_ktp" id="no_ktp" class="form-control" required placeholder="Nomor KTP Penghuni">
                                    @error('no_ktp')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Nomor HP -->
                                <div class="form-group">
                                    <label for="no_hp">Nomor HP</label>
                                    <input type="text" name="no_hp" id="no_hp" class="form-control" required placeholder="Nomor HP Penghuni">
                                    @error('no_hp')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Alamat Asli -->
                                <div class="form-group">
                                    <label for="alamat_asal">Alamat Asli</label>
                                    <textarea name="alamat_asal" id="alamat_asal" class="form-control" required placeholder="Alamat Penghuni"></textarea>
                                    @error('alamat_asal')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-success" type="submit"><i class="fa-solid fa-floppy-disk"></i>
                                    Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
