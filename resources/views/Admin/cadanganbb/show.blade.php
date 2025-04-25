@extends('layoutAdmin.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($admincadanganbb)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table-bordered table-striped table-hover sm table table">
                    <tr>
                        <th>No</th>
                        <td>{{ $admincadanganbb->cadanganbb_id }}</td>
                    </tr>
                    <tr>
                        <th>ID Opco</th>
                        <td>{{ $admincadanganbb->opco_id }}</td>
                    </tr>
                    <tr>
                        <th>latitude</th>
                        <td>{{ $admincadanganbb->latitude }}</td>
                    </tr>
                    <tr>
                        <th>longitude</th>
                        <td>{{ $admincadanganbb->longitude }}</td>
                    </tr>
                    <tr>
                        <th>Jarak</th>
                        <td>{{ $admincadanganbb->jarak }}</td>
                    </tr>
                    <tr>
                        <th>Luas(ha)</th>
                        <td>{{ $admincadanganbb->luas_ha}}</td>
                    </tr>
                    <tr>
                        <th>Kebutuhan pertahun (ton)</th>
                        <td>{{ $admincadanganbb->kebutuhan_pertahun_ton}}</td>
                    </tr>
                    <tr>
                        <th>Komoditi</th>
                        <td>{{ $admincadanganbb->komoditi }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi IUP</th>
                        <td>{{ $admincadanganbb->lokasi_iup }}</td>
                    </tr>
                    <tr>
                        <th>SD/Cadangan(ton)</th>
                        <td>{{ number_format($admincadanganbb->sd_cadangan_ton, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Status Penyelidikan</th>
                        <td>{{ $admincadanganbb->status_penyelidikan }}</td>
                    </tr>
                    <tr>
                        <th>Status Pembebasan</th>
                        <td>{{ $admincadanganbb->status_pembebasan }}</td>
                    </tr>
                    <tr>
                        <th>Catatan</th>
                        <td>{{ $admincadanganbb->catatan }}</td>
                    </tr>
                    <tr>
                        <th>Kabupaten</th>
                        <td>{{ $admincadanganbb->kabupaten }}</td>
                    </tr>
                    <tr>
                        <th>Kecamatan</th>
                        <td>{{ $admincadanganbb->kecamatan }}</td>
                    </tr>
                    <tr>
                        <th>Masa Berlaku IUP</th>
                        <td>{{ $admincadanganbb->masa_berlaku_iup }}</td>
                    </tr>
                    <tr>
                        <th>Masa Berlaku PPKH</th>
                        <td>{{ $admincadanganbb->masa_berlaku_ppkh }}</td>
                    </tr>
                    <tr>
                        <th>Umur Cadangan (thn)</th>
                        <td>{{ $admincadanganbb->umur_cadangan_thn }}</td>
                    </tr>
                    <tr>
                        <th>Umur Masa Berlaku Izin </th>
                        <td>{{ $admincadanganbb->umur_masa_berlaku_izin }}</td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('admincadanganbb') }}" class="btn btn-sm btn-primary mt-4 mb-2">Kembali</a>
        </div>
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
