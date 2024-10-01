@extends('layout.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($admin)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table-bordered table-striped table-hover sm table table">
                    <tr>
                        <th>ID</th>
                        <td>{{ $admin->admin_id }}</td>
                    </tr>
                    <tr>
                        <th>Level Id</th>
                        <td>{{ $admin->level_id }}</td>
                    </tr>
                    <tr>
                        <th>Opco Id</th>
                        <td>{{ $admin->opco_id }}</td>
                    </tr>
                    <tr>
                        <th>Nama </th>
                        <td>{{ $admin->nama}}</td>
                    </tr>
                    <tr>
                        <th>Email </th>
                        <td>{{ $admin->email}}</td>
                    </tr>
                    <tr>
                        <th>Opco </th>
                        <td>{{ $admin->opco}}</td>
                    </tr>
                    <tr>
                        <th>Password </th>
                        <td>{{ $admin->password}}</td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('admin') }}" class="btn btn-sm btn-default mt 2">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
