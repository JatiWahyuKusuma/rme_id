@extends('layoutAdmin.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('admincadpot') }}" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Opco ID</label>
                    <div class="col-11">
                        <input type="hidden" class="form-control" id="opco_id" name="opco_id" value="{{ $opcoId }}" readonly>
                        <input type="text" class="form-control" value="{{ $opcoId == 1 ? 'GHOPO Tuban' : ($opcoId == 2 ? 'SG Rembang' : '') }}" readonly>
                        @error('opco_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Jarak</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="jarak" name="jarak"
                            value="{{ old('jarak') }}" required>
                        @error('jarak')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Latitude</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="latitude" name="latitude"
                            value="{{ old('latitude') }}" required>
                        @error('latitude')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Longitude</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="longitude" name="longitude"
                            value="{{ old('longitude') }}" required>
                        @error('longitude')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">NO ID</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="no_id" name="no_id"
                            value="{{ old('no_id') }}" >
                        @error('no_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Komoditi</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="komoditi" name="komoditi"
                            value="{{ old('komoditi') }}" required>
                        @error('komoditi')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Lokasi IUP</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="lokasi_iup" name="lokasi_iup"
                            value="{{ old('lokasi_iup') }}" required>
                        @error('lokasi_iup')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Tipe SD/Cadangan</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="tipe_sd_cadangan" name="tipe_sd_cadangan"
                            value="{{ old('tipe_sd_cadangan') }}" required>
                        @error('tipe_sd_cadangan')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">SD/Cadangan(ton)</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="sd_cadangan_ton" name="sd_cadangan_ton"
                            value="{{ old('sd_cadangan_ton') }}" required>
                        @error('sd_cadangan_ton')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Catatan</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="catatan" name="catatan"
                            value="{{ old('catatan') }}" >
                        @error('catatan')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Status Penyelidikan</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="status_penyelidikan" name="status_penyelidikan"
                            value="{{ old('status_penyelidikan') }}" >
                        @error('status_penyelidikan')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Acuan</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="acuan" name="acuan"
                            value="{{ old('acuan') }}" >
                        @error('acuan')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Kabupaten</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="kabupaten" name="kabupaten"
                            value="{{ old('kabupaten') }}" required>
                        @error('kabupaten')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Kecamatan</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="kecamatan" name="kecamatan"
                            value="{{ old('kecamatan') }}" required>
                        @error('kecamatan')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Luas(ha)</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="luas_ha" name="luas_ha"
                            value="{{ old('luas_ha') }}" >
                        @error('luas_ha')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Masa Berlaku IUP</label>
                    <div class="col-11">
                        <input type="date" class="form-control" id="masa_berlaku_iup" name="masa_berlaku_iup"
                            value="{{ old('masa_berlaku_iup') }}" >
                        @error('masa_berlaku_iup')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Masa Berlaku PPKH</label>
                    <div class="col-11">
                        <input type="date" class="form-control" id="masa_berlaku_ppkh" name="masa_berlaku_ppkh"
                            value="{{ old('masa_berlaku_ppkh') }}">
                        @error('masa_berlaku_ppkh')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label"></label>
                    <div class="col-11">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ url('admincadpot') }}">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
@endpush
