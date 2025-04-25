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
            @empty($cadanganbb)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table-bordered table-striped table-hover sm table table">
                    <tr>
                        <th>No</th>
                        <td>{{ $cadanganbb->cadanganbb_id }}</td>
                    </tr>
                    <tr>
                        <th>ID Opco</th>
                        <td>{{ $cadanganbb->opco_id }}</td>
                    </tr>
                    <tr>
                        <th>latitude</th>
                        <td>{{ $cadanganbb->latitude }}</td>
                    </tr>
                    <tr>
                        <th>longitude</th>
                        <td>{{ $cadanganbb->longitude }}</td>
                    </tr>
                    <tr>
                        <th>Jarak</th>
                        <td>{{ $cadanganbb->jarak }}</td>
                    </tr>
                    <tr>
                        <th>Luas(ha)</th>
                        <td>{{ $cadanganbb->luas_ha }}</td>
                    </tr>
                    <tr>
                        <th>Kebutuhan pertahun (ton)</th>
                        <td>{{ $cadanganbb->kebutuhan_pertahun_ton }}</td>
                    </tr>
                    <tr>
                        <th>Komoditi</th>
                        <td>{{ $cadanganbb->komoditi }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi IUP</th>
                        <td>{{ $cadanganbb->lokasi_iup }}</td>
                    </tr>
                    <tr>
                        <th>SD/Cadangan(ton)</th>
                        <td>{{ number_format($cadanganbb->sd_cadangan_ton, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Status Penyelidikan</th>
                        <td>{{ $cadanganbb->status_penyelidikan }}</td>
                    </tr>
                    <tr>
                        <th>Status Pembebasan</th>
                        <td>{{ $cadanganbb->status_pembebasan }}</td>
                    </tr>
                    <tr>
                        <th>Catatan</th>
                        <td>{{ $cadanganbb->catatan }}</td>
                    </tr>
                    <tr>
                        <th>Kabupaten</th>
                        <td>{{ $cadanganbb->kabupaten }}</td>
                    </tr>
                    <tr>
                        <th>Kecamatan</th>
                        <td>{{ $cadanganbb->kecamatan }}</td>
                    </tr>
                    <tr>
                        <th>Masa Berlaku IUP</th>
                        <td>{{ $cadanganbb->masa_berlaku_iup }}</td>
                    </tr>
                    <tr>
                        <th>Masa Berlaku PPKH</th>
                        <td>{{ $cadanganbb->masa_berlaku_ppkh }}</td>
                    </tr>
                    <tr>
                        <th>Umur Cadangan (thn)</th>
                        <td>{{ $cadanganbb->umur_cadangan_thn }}</td>
                    </tr>
                    <tr>
                        <th>Umur Masa Berlaku Izin </th>
                        <td>{{ $cadanganbb->umur_masa_berlaku_izin }}</td>
                    </tr>
                </table>
            @endempty

        </div>
        <a href="{{ url('cadanganbb') }}" class="btn-gradient">Kembali</a>
    </div>
@endsection

@push('css')
    <style>
        /* Add spacing and improve button styling */
        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
        }

        /* Adjust margin and spacing for better layout */
        .mt-4 {
            margin-top: 1.5rem !important;
        }

        .mb-2 {
            margin-bottom: 0.75rem !important;
        }
    </style>
@endpush

@push('js')
@endpush
