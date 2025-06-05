@extends('template.user')
@section('title', 'Edit Profile')
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
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">@yield('title')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <div class="card-header">
                            <div class="text-right">
                                <a href="{{ route('profile.show') }}" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-rotate-left"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Nama Lengkap -->
                                <div class="form-group">
                                    <label for="nama_penghuni">Nama Lengkap</label>
                                    <input type="text" name="nama_penghuni" id="nama_penghuni" class="form-control" value="{{ $penghuni->nama_penghuni }}" required placeholder="Masukkan nama lengkap Anda">
                                    @error('nama_penghuni')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Nomor KTP -->
                                <div class="form-group">
                                    <label for="no_ktp">Nomor KTP</label>
                                    <input type="text" name="no_ktp" id="no_ktp" class="form-control" value="{{ $penghuni->no_ktp }}" required placeholder="Masukkan nomor KTP">
                                    @error('no_ktp')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Nomor HP -->
                                <div class="form-group">
                                    <label for="no_hp">Nomor HP</label>
                                    <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ $penghuni->no_hp }}" required placeholder="Masukkan nomor HP">
                                    @error('no_hp')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Alamat Asli -->
                                <div class="form-group">
                                    <label for="alamat_asal">Alamat Asli</label>
                                    <textarea name="alamat_asal" id="alamat_asal" class="form-control" required placeholder="Masukkan alamat asli Anda">{{ $penghuni->alamat_asal }}</textarea>
                                    @error('alamat_asal')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Username -->
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" id="username" class="form-control" value="{{ $penghuni->user->name }}" required placeholder="Masukkan username Anda">
                                    @error('username')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ $penghuni->user->email }}" required placeholder="Masukkan email Anda">
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Konfirmasi Password -->
                                <div class="form-group">
                                    <label for="password_confirmation">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
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
