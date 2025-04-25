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
            <form method="POST" action="{{ url('kriteria') }}" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Nama Kriteria</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="nama_kriteria" name="nama_kriteria"
                            value="{{ old('nama_kriteria') }}">
                        @error('nama_kriteria')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Jenis Kriteria</label>
                    <div class="col-11">
                        <select class="form-control" id="jenis_kriteria" name="jenis_kriteria">
                            <option value="Benefit" {{ old('jenis_kriteria') == 'Benefit' ? 'selected' : '' }}>Benefit
                            </option>
                            <option value="Cost" {{ old('jenis_kriteria') == 'Cost' ? 'selected' : '' }}>Cost</option>
                        </select>
                        @error('jenis_kriteria')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Bobot Kriteria</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="bobot_kriteria" name="bobot_kriteria"
                            value="{{ old('bobot_kriteria') }}">
                        @error('bobot_kriteria')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label"></label>
                    <div class="col-11">
                        <button type="submit" class="btn-gradient">Simpan</button>
                        <a class="btn-gradientu" href="{{ url('kriteria') }}">Kembali</a>
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
