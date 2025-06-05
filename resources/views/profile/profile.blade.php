@extends('template.main')
@section('title', 'Profile')
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
            <div class="row justify-content-center">
                <div class="col-12"> <!-- Changed to col-12 for full-width card -->
                    <div class="card shadow-lg">
                        <div class="card-header">
                            <div class="card-tools">
                                <a href="/profile/edit" class="btn btn-sm btn-success">
                                    <i class="fas fa-edit"></i> Edit Profile
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-4 font-weight-bold text-muted">Username:</div>
                                <div class="col-sm-8">{{ $user->name }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 font-weight-bold text-muted">Email:</div>
                                <div class="col-sm-8">{{ $user->email }}</div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <small class="text-muted">Terakhir Diubah: {{ $user->updated_at ? $user->updated_at->format('d M Y, H:i') : 'Belum pernah' }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
