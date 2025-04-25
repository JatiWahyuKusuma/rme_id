@extends('layout.template')
@section('css')
    <style>
        .card.card-outline.card-primary {
            margin: auto;
            background-color: rgb(245, 245, 245);
            border-top-color: #800000;
            border-top: 4px solid #800000;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-gradient {
            background: linear-gradient(to right, #800000, #800000);
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 15px;
            font-weight: bold;
            border-radius: 8px;
            transition: opacity 0.3s ease;
            display: inline-block;
            /* Ensure it behaves as a block element */
            margin-top: 20px;
            /* Space above the button */
            width: 200px;
            /* Adjust width automatically */
            text-align: center;
            /* Center text */
        }
    </style>
@endsection
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
            <a href="{{ url('opco') }}" class="btn-gradient">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
