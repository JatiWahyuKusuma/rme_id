@extends('layout.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($cadpot)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table-bordered table-striped table-hover sm table table">
                    <tr>
                        <th>No</th>
                        <td>{{ $cadpot->cadpot_id }}</td>
                    </tr>
                    <tr>
                        <th>ID Opco</th>
                        <td>{{ $cadpot->opco_id }}</td>
                    </tr>
                    <tr>
                        <th>Jarak</th>
                        <td>{{ $cadpot->jarak }}</td>
                    </tr>
                    <tr>
                        <th>latitude</th>
                        <td>{{ $cadpot->latitude }}</td>
                    </tr>
                    <tr>
                        <th>longitude</th>
                        <td>{{ $cadpot->longitude }}</td>
                    </tr>
                    <tr>
                        <th>No ID</th>
                        <td>{{ number_format($cadpot->no_id, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Komoditi</th>
                        <td>{{ $cadpot->komoditi }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi IUP</th>
                        <td>{{ $cadpot->lokasi_iup }}</td>
                    </tr>
                    <tr>
                        <th>Tipe SD/Cadangan</th>
                        <td>{{ $cadpot->tipe_sd_cadangan }}</td>
                    </tr>
                    <tr>
                        <th>SD/Cadangan(ton)</th>
                        <td>{{ number_format($cadpot->sd_cadangan_ton, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>catatan</th>
                        <td>{{ $cadpot->catatan }}</td>
                    </tr>
                    <tr>
                        <th>Status Penyelidikan</th>
                        <td>{{ $cadpot->status_penyelidikan }}</td>
                    </tr>
                    <tr>
                        <th>Acuan</th>
                        <td>{{ $cadpot->acuan }}</td>
                    </tr>
                    <tr>
                        <th>Kabupaten</th>
                        <td>{{ $cadpot->kabupaten }}</td>
                    </tr>
                    <tr>
                        <th>Kecamatan</th>
                        <td>{{ $cadpot->kecamatan }}</td>
                    </tr>
                    <tr>
                        <th>Luas(ha)</th>
                        <td>{{ $cadpot->luas_ha}}</td>
                    </tr>
                    <tr>
                        <th>Masa Berlaku IUP</th>
                        <td>{{ $cadpot->masa_berlaku_iup }}</td>
                    </tr>
                    <tr>
                        <th>Masa Berlaku PPKH</th>
                        <td>{{ $cadpot->masa_berlaku_ppkh }}</td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('cadpot') }}" class="btn btn-sm btn-primary mt-4 mb-2">Kembali</a>
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
