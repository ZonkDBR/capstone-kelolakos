@extends('template.main')
@section('title', 'Kamar Kos')
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
                                <a href="/kamar/create" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah Kamar Kosan</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Nomor Kamar</th>
                                        <th>Tipe Kamar</th>
                                        <th>Fasilitas</th>
                                        <th>Harga Sewa</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($kamar as $kamars)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $kamars->nomor_kamar }}</td>
                                        <td>{{ $kamars->tipe_kamar }}</td>
                                        <td>{{ $kamars->fasilitas ?? "Tidak ada fasilitas" }}</td>
                                        <td>Rp{{ number_format($kamars->harga, 2, ',', '.') }}</td>
                                        <td>
                                            @if ($kamars->status == 'Terisi')
                                            <button class="btn btn-sm btn-success">Terisi</button>
                                            @else
                                            <button class="btn btn-sm btn-info">Kosong</button>
                                            @endif
                                        </td>
                                        <td>
                                            <form class="d-inline" action="/kamar/{{ $kamars->id_kamar }}/edit" method="GET">
                                                <button type="submit" class="btn btn-success btn-sm mr-1">
                                                    <i class="fa-solid fa-pen"></i> Edit
                                                </button>
                                            </form>
                                            <form class="d-inline" action="/kamar/{{ $kamars->id_kamar }}" method="POST">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
