@extends('layout.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('vendorbb') }}" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Opco</label>
                    <div class="col-11">
                        <select name="opco_id" id="opco_id" class="form-control" required>
                            <option value="">--Pilih Opco--</option> <!-- Default option -->
                            @foreach ($opco as $op)
                                <option value="{{ $op->opco_id }}">{{ $op->nama_opco }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Jarak</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="jarak" name="jarak" value="{{ old('jarak') }}"
                            required>
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
                    <label class="col-1 control-label col-form-label">Vendor</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="vendor" name="vendor"
                            value="{{ old('vendor') }}" required>
                        @error('vendor')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">komoditi</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="komoditi" name="komoditi"
                            value="{{ old('komoditi') }}" required>
                        @error('komoditi')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Desa</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="desa" name="desa"
                            value="{{ old('desa') }}" required>
                        @error('desa')
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
                    <label class="col-1 control-label col-form-label">Kap(Ton/thn)</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="kap_ton_thn" name="kap_ton_thn"
                            value="{{ old('kap_ton_thn') }}" required>
                        @error('kap_ton_thn')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Konsumsi (ton/thn)</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="konsumsi_ton_thn" name="konsumsi_ton_thn"
                            value="{{ old('konsumsi_ton_thn') }}" required>
                        @error('konsumsi_ton_thn')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label"></label>
                    <div class="col-11">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ url('vendorbb') }}">Kembali</a>
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
