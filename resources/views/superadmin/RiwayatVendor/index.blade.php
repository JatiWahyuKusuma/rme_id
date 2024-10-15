@extends('layout.template')

@section('content')
    <div class="card card-outline card-primary">

        <div class="card-body">
            {{-- <button id="exportButton" class="btn btn-primary mb-3">Export to Excel</button> --}}
            <table class="table-bordered table-striped table-hover table-sm table" id="table_m_vendor">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cadpot ID</th>
                        <th>Opco ID</th>
                        <th>Jarak (km)</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Vendor</th>
                        <th>Komoditi</th>
                        <th>Desa</th>
                        <th>Kecamatan</th>
                        <th>Kabupaten</th>
                        <th>Kap (ton/thn)</th>
                        <th>Konsumsi (ton/thn)</th>
                        <th>Last Update</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>
@endsection

@push('css')
    <style>
        th {
            text-align: center;
        }

        .aksi-buttons {
            display: flex;
            gap: 2px;
        }

        .aksi-buttons a,
        .aksi-buttons button {
            flex-grow: 1;
            width: 75px;
            text-align: center;
        }
    </style>
@endpush
