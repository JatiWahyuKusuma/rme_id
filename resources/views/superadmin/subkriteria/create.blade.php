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
            <form method="POST" action="{{ url('subkriteria') }}" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Kriteria</label>
                    <div class="col-11">
                        <select name="kriteria_id" id="kriteria_id" class="form-control" required>
                            <option value="">--Pilih Kriteria--</option>
                            @foreach ($kriteria as $ktr)
                                <option value="{{ $ktr->kriteria_id }}"
                                    {{ old('kriteria_id') == $ktr->kriteria_id ? 'selected' : '' }}>
                                    {{ $ktr->nama_kriteria }}
                                </option>
                            @endforeach
                        </select>
                        @error('kriteria_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Nama Sub Kriteria</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="nama_subkriteria" name="nama_subkriteria"
                            value="{{ old('nama_subkriteria') }}" required>
                        @error('nama_subkriteria')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Bobot Sub Kriteria</label>
                    <div class="col-11">
                        <input type="number" step="0.01" class="form-control" id="bobot_subkriteria"
                            name="bobot_subkriteria" value="{{ old('bobot_subkriteria') }}" required>
                        @error('bobot_subkriteria')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-1 control-label col-form-label"></label>
                    <div class="col-11">
                        <button type="submit" class="btn-gradient">Simpan</button>
                        <a id="btn-kembali" class="btn-gradientu" href="{{ url('/subkriteria') }}">
                            Kembali
                        </a>
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
        document.addEventListener("DOMContentLoaded", function() {
            var btnKembali = document.getElementById("btn-kembali");
            var selectKriteria = document.getElementById("kriteria_id");

            btnKembali.addEventListener("click", function(event) {
                event.preventDefault();
                var selectedKriteriaId = selectKriteria.value;

                if (selectedKriteriaId) {
                    window.location.href = "{{ url('/subkriteria') }}?kriteria_id=" + selectedKriteriaId;
                } else {
                    window.location.href = "{{ url('/subkriteria') }}";
                }
            });
        });
    </script>
@endpush
