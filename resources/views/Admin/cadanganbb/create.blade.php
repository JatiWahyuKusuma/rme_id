@extends('layoutAdmin.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('admincadanganbb') }}" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Nama Opco</label>
                    <div class="col-11">
                        <input type="hidden" class="form-control" id="opco_id" name="opco_id" value="{{ $opcoId }}"
                            readonly>
                        <input type="text" class="form-control"
                            value="{{ $opcoId == 1 ? 'GHOPO Tuban' : ($opcoId == 2 ? 'SG Rembang' : ($opcoId == 3 ? 'SBI Tuban' : ($opcoId == 4 ? 'Semen Tonasa' : ($opcoId == 5 ? 'SBI Narogong' : ($opcoId == 6 ? 'SBI Cilacap' : ($opcoId == 7 ? 'SBI Lhoknga' : ($opcoId == 8 ? 'Semen Padang' : ($opcoId == 9 ? 'Semen Baturaja' : '')))))))) }}"
                            readonly>
                        @error('opco_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Latitude</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="latitude" name="latitude"
                            value="{{ old('latitude') }}">
                        @error('latitude')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Longitude</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="longitude" name="longitude"
                            value="{{ old('longitude') }}">
                        @error('longitude')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Jarak</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="jarak" name="jarak"
                            value="{{ old('jarak') }}">
                        @error('jarak')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Luas(ha)</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="luas_ha" name="luas_ha"
                            value="{{ old('luas_ha') }}">
                        @error('luas_ha')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Kebutuhan Pertahun (ton)</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="kebutuhan_pertahun_ton" name="kebutuhan_pertahun_ton"
                            value="{{ old('kebutuhan_pertahun_ton') }}" required>
                        @error('kebutuhan_pertahun_ton')
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
                    <label class="col-1 control-label col-form-label">Status Penyelidikan</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="status_penyelidikan" name="status_penyelidikan"
                            value="{{ old('status_penyelidikan') }}">
                        @error('status_penyelidikan')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Status Pembebasan</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="status_pembebasan" name="status_pembebasan"
                            value="{{ old('status_pembebasan') }}">
                        @error('status_pembebasan')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Catatan</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="catatan" name="catatan"
                            value="{{ old('catatan') }}">
                        @error('catatan')
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
                    <label class="col-1 control-label col-form-label">Masa Berlaku IUP</label>
                    <div class="col-11">
                        <input type="date" class="form-control" id="masa_berlaku_iup" name="masa_berlaku_iup"
                            value="{{ old('masa_berlaku_iup') }}">
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
                    <label class="col-1 control-label col-form-label">Umur Cadangan (thn)</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="umur_cadangan_thn" name="umur_cadangan_thn"
                            value="{{ old('umur_cadangan_thn') }}"readonly>
                        @error('umur_cadangan_thn')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label"> Umur Masa Berlaku Izin</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="umur_masa_berlaku_izin"
                            name="umur_masa_berlaku_izin" value="{{ old('umur_masa_berlaku_izin') }}"readonly>
                        @error('umur_masa_berlaku_izin')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label"></label>
                    <div class="col-11">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ url('admincadanganbb') }}">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function calculateUmurCadangan() {
                const kebutuhan = parseFloat(document.getElementById('kebutuhan_pertahun_ton').value) ||
                    0; // Ambil nilai dari input kebutuhan
                const sdCadangan = parseFloat(document.getElementById('sd_cadangan_ton').value) ||
                    0; // Ambil nilai dari input sd_cadangan

                if (kebutuhan > 0) {
                    const umurCadangan = (sdCadangan / kebutuhan).toFixed(2); // Hitung umur cadangan
                    document.getElementById('umur_cadangan_thn').value =
                        umurCadangan; // Set nilai hasil ke input umur cadangan
                } else {
                    document.getElementById('umur_cadangan_thn').value = ''; // Reset jika tidak valid
                }
            }

            document.getElementById('kebutuhan_pertahun_ton').addEventListener('input',
                calculateUmurCadangan); // Event saat input kebutuhan
            document.getElementById('sd_cadangan_ton').addEventListener('input',
                calculateUmurCadangan); // Event saat input sd_cadangan
        });

        document.addEventListener('DOMContentLoaded', function() {
            function calculateUmurMasaBerlakuIzin() {
                const masaBerlakuIUP = new Date(document.getElementById('masa_berlaku_iup')
                    .value); // Ambil tanggal dari input
                const today = new Date(); // Ambil tanggal hari ini

                if (masaBerlakuIUP) {
                    const diffTime = masaBerlakuIUP - today; // Selisih waktu dalam milisecond

                    // Hitung tahun dan bulan berdasarkan selisih waktu
                    const years = Math.floor(Math.abs(diffTime) / (1000 * 60 * 60 * 24 * 365));
                    const months = Math.floor((Math.abs(diffTime) % (1000 * 60 * 60 * 24 * 365)) / (1000 * 60 * 60 *
                        24 * 30));

                    if (diffTime > 0) {
                        document.getElementById('umur_masa_berlaku_izin').value = years + ' tahun ' + months +
                            ' bulan'; // Tampilkan sisa waktu
                    } else {
                        document.getElementById('umur_masa_berlaku_izin').value = 'Terlewat ' + years + ' tahun ' +
                            months + ' bulan'; // Tampilkan waktu terlewat
                    }
                }
            }

            document.getElementById('masa_berlaku_iup').addEventListener('change',
                calculateUmurMasaBerlakuIzin); // Event saat input tanggal berubah
        });
    </script>
@endpush
