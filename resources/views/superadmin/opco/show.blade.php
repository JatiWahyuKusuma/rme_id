@extends('layout.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($opco)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table-bordered table-striped table-hover sm table table">
                    <tr>
                        <th>ID</th>
                        <td>{{ $opco->opco_id }}</td>
                    </tr>
                    <tr>
                        <th>Kode Opco</th>
                        <td>{{ $opco->kode_opco }}</td>
                    </tr>
                    <tr>
                        <th>Nama Opco</th>
                        <td>{{ $opco->nama_opco }}</td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('opco') }}" class="btn btn-sm btn-default mt 2">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
