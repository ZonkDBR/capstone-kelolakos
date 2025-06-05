@extends('template.main')
@section('title', 'Add Lokasi Kosan')
@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">@yield('title')</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/lokasi">Lokasi Kos</a></li>
            <li class="breadcrumb-item active">@yield('title')</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <div class="text-right">
                <a href="/lokasi" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-rotate-left"></i>
                  Back
                </a>
              </div>
            </div>
            <form class="needs-validation" novalidate action="/lokasi" method="POST">
              @csrf
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="nama_kos">Nama Kosan</label>
                      <input type="text" name="nama_kos" class="form-control @error('nama_kos') is-invalid @enderror" id="nama_kos" placeholder="Nama Kosan" value="{{old('nama_kos')}}" required>
                      @error('nama_kos')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="kapasitas_total">Kapasitas</label>
                      <input type="number" name="kapasitas_total" class="form-control @error('kapasitas_total') is-invalid @enderror" id="kapasitas_total" placeholder="Kapasitas_total" value="{{old('kapasitas_total')}}" required>
                      @error('kapasitas_total')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="kontak_pengelola">Kontak Pengelola</label>
                      <input type="text" name="kontak_pengelola" class="form-control @error('kontak_pengelola') is-invalid @enderror" id="kontak_pengelola" placeholder="Kontak Pengelola" value="{{old('kontak_pengelola')}}" required>
                      @error('kontak_pengelola')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="alamat">Alamat</label>
                      <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" cols="10" rows="5" placeholder="Alamat">{{old('alamat')}}</textarea>
                      @error('alamat')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer text-right">
                <button class="btn btn-dark mr-1" type="reset"><i class="fa-solid fa-arrows-rotate"></i>
                  Reset</button>
                <button class="btn btn-success" type="submit"><i class="fa-solid fa-floppy-disk"></i>
                  Save</button>
              </div>
            </form>
          </div>
        </div>
        <!-- /.content -->
      </div>
    </div>
  </div>
</div>

@endsection