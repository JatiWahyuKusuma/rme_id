@extends('layout.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div> <!-- Change class to 'alert-danger' -->
        @endif
        <div class="row">
            <div class="col-md-12">
            </div>
        </div>
        <table class="table-bordered table-striped table-hover table-sm table" id="table_m_cadangan_potensi">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Opco ID</th>
                    <th>Jarak</th>
                    <th>Komoditi</th>
                    <th>Lokasi/IUP</th>
                    <th>Tipe SD/Cadangan</th>
                    <th>SD/Cadangan(ton)</th>
                    <th>Catatan</th>
                    <th>Status Penyelidikan</th>
                    <th>Acuan</th>
                    <th>Kabupaten</th>
                    <th>Kecamatan</th>
                    <th>Luas(Ha)</th>
                    <th>Masa Berlaku IUP</th>
                    <th>Masa Berlaku PPKH</th>
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

    .aksi-buttons a, .aksi-buttons button {
        flex-grow: 1;
        width: 75px;
        text-align: center;
    }
</style>
@endpush