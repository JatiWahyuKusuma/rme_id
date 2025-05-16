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
        }

        th {
            text-align: center;
            background-color: #800000;
            /* Set header background color to red */
            color: white;
            /* Set font color to white */
        }

        /* Custom styles for DataTables controls */
        .dataTables_wrapper .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .dataTables_length {
            display: flex;
            align-items: center;
            margin-right: 10px;
        }

        .dataTables_filter {
            margin-left: auto;
        }

        .export-btn-container {
            margin-left: 15px;
        }

        .dt-buttons {
            display: flex;
            align-items: center;
        }
    </style>
@endsection

@section('content')
    <div class="card card-outline card-primary">

    </div>
    <div class="card card-primary card-outline mt-4">
        <h4 class="m-0">Catatan</h4>
        <div class="d-flex flex-column align-items-start pt-3">
            <div class="d-flex mb-2">
                <span class="ms-4">
                    : Hasil Penilaian penerbitan prioritas perluasan lahan bahan baku ini hanya sebagai rekomendasi.
                    keputusan utama penerbitan perluasan lahan tetap ditangan stakeholder.
                </span>
            </div>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
