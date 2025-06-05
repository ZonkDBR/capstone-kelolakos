@extends('template.main')
@section('title', 'Sewa Kamar')
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
                                <a href="/sewa/create" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah Sewa</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Nama Penghuni</th>
                                        <th>Nomor Kamar</th>
                                        <th>Tanggal Sewa</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($sewa as $sewas)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $sewas->penghuni->nama_penghuni }}</td>
                                        <td>{{ $sewas->kamar->nomor_kamar }}</td>
                                        <td>{{ $sewas->tanggal_sewa->format('Y-m-d') }}</td>
                                        <td>{{ $sewas->tanggal_selesai ?? 'Masih Berlangsung' }}</td>
                                        <td>
                                            @if ($sewas->status == 'Aktif')
                                            <button class="btn btn-sm btn-success">Aktif</button>
                                            @else
                                            <button class="btn btn-sm btn-danger">Berakhir</button>
                                            @endif
                                        </td>
                                        <td>
                                            <form class="d-inline" action="/sewa/{{ $sewas->id_sewa }}/edit" method="GET">
                                                <button type="submit" class="btn btn-success btn-sm mr-1">
                                                    <i class="fa-solid fa-pen"></i> Edit
                                                </button>
                                            </form>
                                            <form class="d-inline" action="/sewa/{{ $sewas->id_sewa }}" method="POST">
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