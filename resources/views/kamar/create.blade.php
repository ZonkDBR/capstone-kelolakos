@extends('template.main')
@section('title', 'Add Kamar Kos')
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
                        <li class="breadcrumb-item"><a href="/kamar">Kamar Kos</a></li>
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
                                <a href="/kamar" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-rotate-left"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <!-- Form Start -->
                        <form action="/kamar" method="POST">
                            @csrf <!-- CSRF Token for Security -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nomor_kamar">Nomor Kamar</label>
                                    <input type="text" class="form-control" id="nomor_kamar" name="nomor_kamar" placeholder="Masukkan Nomor Kamar" required>
                                    @error('nomor_kamar')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tipe_kamar">Tipe Kamar</label>
                                    <input type="text" class="form-control" id="tipe_kamar" name="tipe_kamar" placeholder="Masukkan Tipe Kamar" required>
                                    @error('tipe_kamar')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="fasilitas">Fasilitas</label>
                                    <textarea class="form-control" id="fasilitas" name="fasilitas" placeholder="Masukkan Fasilitas"></textarea>
                                    @error('fasilitas')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="harga">Harga Sewa</label>
                                    <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukkan Harga Sewa" required>
                                    @error('harga')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="Kosong">Kosong</option>
                                        <option value="Terisi">Terisi</option>
                                    </select>
                                    @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-success" type="submit"><i class="fa-solid fa-floppy-disk"></i>
                                    Save</button>
                            </div>
                        </form>
                        <!-- Form End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
