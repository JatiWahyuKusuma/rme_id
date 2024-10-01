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
                <a href="{{ url('cadpot') }}" class="btn btn-sm btn-default mt 2">Kembali</a>
            @else
                <form method="POST" action="{{ url('/cadpot/' . $cadpot->cadpot_id) }}" class="form-horizontal">
                    @csrf
                    {!! method_field('PUT') !!}
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">OPCO ID</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="opco_id" name="opco_id"
                                value="{{ old('opco_id', $cadpot->opco_id) }}" required>
                            @error('opco_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Jarak</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="jarak" name="jarak"
                                value="{{ old('jarak', $cadpot->jarak) }}" required>
                            @error('jarak')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">latitude</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="latitude" name="latitude"
                                value="{{ old('latitude', $cadpot->latitude) }}" required>
                            @error('latitude')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Longitude</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="longitude" name="longitude"
                                value="{{ old('longitude', $cadpot->longitude) }}" required>
                            @error('longitude')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">No ID</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="no_id" name="no_id"
                                value="{{ old('no_id', $cadpot->no_id) }}" required>
                            @error('no_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Komoditi</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="komoditi" name="komoditi"
                                value="{{ old('komoditi', $cadpot->komoditi) }}" required>
                            @error('komoditi')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Lokasi IUP</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="lokasi_iup" name="lokasi_iup"
                                value="{{ old('lokasi_iup', $cadpot->lokasi_iup) }}" required>
                            @error('lokasi_iup')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Tipe SD/Cadangan</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="tipe_sd_cadangan" name="tipe_sd_cadangan"
                                value="{{ old('tipe_sd_cadangan', $cadpot->tipe_sd_cadangan) }}" required>
                            @error('tipe_sd_cadangan')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">SD/Cadangan(ton)</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="sd_cadangan_ton" name="sd_cadangan_ton"
                                value="{{ old('sd_cadangan_ton', $cadpot->sd_cadangan_ton) }}" required>
                            @error('sd_cadangan_ton')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Catatan</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="catatan" name="catatan"
                                value="{{ old('catatan', $cadpot->catatan) }}" required>
                            @error('catatan')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Status Penyelidikan</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="status_penyelidikan" name="status_penyelidikan"
                                value="{{ old('status_penyelidikan', $cadpot->status_penyelidikan) }}" required>
                            @error('status_penyelidikan')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Acuan</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="acuan" name="acuan"
                                value="{{ old('acuan', $cadpot->acuan) }}" required>
                            @error('acuan')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Kabupaten</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="kabupaten" name="kabupaten"
                                value="{{ old('kabupaten', $cadpot->kabupaten) }}" required>
                            @error('kabupaten')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Kecamatan</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="kecamatan" name="kecamatan"
                                value="{{ old('kecamatan', $cadpot->kecamatan) }}" required>
                            @error('kecamatan')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Luas(Ha)</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="luas_ha" name="luas_ha"
                                value="{{ old('luas_ha', $cadpot->luas_ha) }}">
                            @error('luas_ha')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Masa Berlaku IUP</label>
                        <div class="col-11">
                            <input type="date" class="form-control" id="masa_berlaku_iup" name="masa_berlaku_iup"
                                value="{{ old('masa_berlaku_iup', $cadpot->masa_berlaku_iup) }}" >
                            @error('masa_berlaku_iup')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Masa Berlaku PPKH</label>
                        <div class="col-11">
                            <input type="date" class="form-control" id="masa_berlaku_ppkh" name="masa_berlaku_ppkh"
                                value="{{ old('masa_berlaku_ppkh', $cadpot->masa_berlaku_ppkh) }}" >
                            @error('masa_berlaku_ppkh')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label"></label>
                        <div class="col-11">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            <a class="btn btn-sm btn-default ml-1" href="{{ url('cadpot') }}">Kembali</a>
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
