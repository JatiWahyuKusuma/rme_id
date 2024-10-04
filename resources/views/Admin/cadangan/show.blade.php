@extends('layoutAdmin.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($admincadpot)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table-bordered table-striped table-hover sm table table">
                    <tr>
                        <th>No</th>
                        <td>{{ $admincadpot->cadpot_id }}</td>
                    </tr>
                    <tr>
                        <th>Jarak</th>
                        <td>{{ $admincadpot->jarak }}</td>
                    </tr>
                    <tr>
                        <th>latitude</th>
                        <td>{{ $admincadpot->latitude }}</td>
                    </tr>
                    <tr>
                        <th>longitude</th>
                        <td>{{ $admincadpot->longitude }}</td>
                    </tr>
                    <tr>
                        <th>No ID</th>
                        <td>{{ number_format($admincadpot->no_id, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Komoditi</th>
                        <td>{{ $admincadpot->komoditi }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi IUP</th>
                        <td>{{ $admincadpot->lokasi_iup }}</td>
                    </tr>
                    <tr>
                        <th>Tipe SD/Cadangan</th>
                        <td>{{ $admincadpot->tipe_sd_cadangan }}</td>
                    </tr>
                    <tr>
                        <th>SD/Cadangan(ton)</th>
                        <td>{{ number_format($admincadpot->sd_cadangan_ton, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>catatan</th>
                        <td>{{ $admincadpot->catatan }}</td>
                    </tr>
                    <tr>
                        <th>Status Penyelidikan</th>
                        <td>{{ $admincadpot->status_penyelidikan }}</td>
                    </tr>
                    <tr>
                        <th>Acuan</th>
                        <td>{{ $admincadpot->acuan }}</td>
                    </tr>
                    <tr>
                        <th>Kabupaten</th>
                        <td>{{ $admincadpot->kabupaten }}</td>
                    </tr>
                    <tr>
                        <th>Kecamatan</th>
                        <td>{{ $admincadpot->kecamatan }}</td>
                    </tr>
                    <tr>
                        <th>Luas(ha)</th>
                        <td>{{ $admincadpot->luas_ha}}</td>
                    </tr>
                    <tr>
                        <th>Masa Berlaku IUP</th>
                        <td>{{ $admincadpot->masa_berlaku_iup }}</td>
                    </tr>
                    <tr>
                        <th>Masa Berlaku PPKH</th>
                        <td>{{ $admincadpot->masa_berlaku_ppkh }}</td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('admincadpot') }}" class="btn btn-sm btn-primary mt-4 mb-2">Kembali</a>
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
