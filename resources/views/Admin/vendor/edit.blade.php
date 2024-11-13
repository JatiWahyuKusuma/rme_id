@extends('layoutAdmin.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($adminvendorbb)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('adminvendorbb') }}" class="btn btn-sm btn-default mt 2">Kembali</a>
            @else
                <form method="POST" action="{{ url('/adminvendorbb/' . $adminvendorbb->vendor_id) }}" class="form-horizontal">
                    @csrf
                    {!! method_field('PUT') !!}
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Nama Opco</label>
                        <div class="col-11">
                            <input type="hidden" class="form-control" id="opco_id" name="opco_id" value="{{ $opcoId }}"
                                readonly>
                            <input type="text" class="form-control"
                                value="{{ $opcoId == 1 ? 'GHOPO Tuban' : ($opcoId == 2 ? 'SG Rembang' : ($opcoId == 3 ? 'SBI Tuban' : ($opcoId == 4 ? 'Semen Tonasa' : ($opcoId == 5 ? 'SBI Narogong' : ($opcoId == 6 ? 'SBI Cilacap' :  ($opcoId == 7 ? 'SBI Lhoknga' :'')))))) }}"
                                readonly>
                            @error('opco_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Jarak</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="jarak" name="jarak"
                                value="{{ old('jarak', $adminvendorbb->jarak) }}" required>
                            @error('jarak')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">latitude</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="latitude" name="latitude"
                                value="{{ old('latitude', $adminvendorbb->latitude) }}" required>
                            @error('latitude')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Longitude</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="longitude" name="longitude"
                                value="{{ old('longitude', $adminvendorbb->longitude) }}" required>
                            @error('longitude')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Vendor</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="vendor" name="vendor"
                                value="{{ old('vendor', $adminvendorbb->vendor) }}" required>
                            @error('vendor')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Komoditi</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="komoditi" name="komoditi"
                                value="{{ old('komoditi', $adminvendorbb->komoditi) }}" required>
                            @error('komoditi')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Desa</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="desa" name="desa"
                                value="{{ old('desa', $adminvendorbb->desa) }}" required>
                            @error('desa')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Kecamatan</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="kecamatan" name="kecamatan"
                                value="{{ old('kecamatan', $adminvendorbb->kecamatan) }}" required>
                            @error('kecamatan')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Kabupaten</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="kabupaten" name="kabupaten"
                                value="{{ old('kabupaten', $adminvendorbb->kabupaten) }}" required>
                            @error('kabupaten')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Kap(ton/thn)</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="kap_ton_thn" name="kap_ton_thn"
                                value="{{ old('kap_ton_thn', $adminvendorbb->kap_ton_thn) }}" required>
                            @error('kap_ton_thn')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Konsumsi (ton/thn)</label> <!-- Tambahkan spasi di antara Konsumsi dan tanda kurung -->
                        <div class="col-11">
                            <input type="text" class="form-control" id="konsumsi_ton_thn" name="konsumsi_ton_thn"
                                value="{{ old('konsumsi_ton_thn', $adminvendorbb->konsumsi_ton_thn) }}" required>
                            @error('konsumsi_ton_thn')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label"></label>
                        <div class="col-11">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            <a class="btn btn-sm btn-default ml-1" href="{{ url('adminvendorbb') }}">Kembali</a>
                        </div>
                    </div>
                </form>
            @endempty
        </div>
    </div>
@endsection

@push('css')
@endpush
@push('js')
@endpush
