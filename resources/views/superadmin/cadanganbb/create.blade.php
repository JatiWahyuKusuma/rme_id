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
        }

        .btn-gradientu {
            background: linear-gradient(to right, #a0a0a0, #535353);
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 15px;
            font-weight: bold;
            border-radius: 8px;
            transition: opacity 0.3s ease;
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
            <form method="POST" action="{{ url('cadanganbb') }}" class="form-horizontal">
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
                        <button type="submit" class="btn-gradient" id="submitBtn">
                            Simpan
                        </button>
                        <a class="btn-gradientu" href="{{ url('cadanganbb') }}">Kembali</a>
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

        // Validasi form sebelum submit
        $('#myForm').on('submit', function(e) {
            let isValid = true;
            $('[required]').each(function() {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Harap isi semua field yang wajib diisi!',
                });
            }
        });

        // Hapus validasi saat user mulai mengisi
        $('[required]').on('input', function() {
            if ($(this).val()) {
                $(this).removeClass('is-invalid');
            }
        });
    </script>
@endpush
