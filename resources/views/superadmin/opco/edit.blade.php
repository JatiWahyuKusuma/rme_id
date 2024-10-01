@extends('layout.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($opco)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('opco') }}" class="btn btn-sm btn-default mt 2">Kembali</a>
            @else
                <form method="POST" action="{{ url('/opco/' . $opco->opco_id) }}" class="form-horizontal">
                    @csrf
                    {!! method_field('PUT') !!}
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Kode Opco</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="kode_opco" name="kode_opco"
                                value="{{ old('kode_opco', $opco->kode_opco) }}" required>
                            @error('kode_opco')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Nama Opco</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="nama_opco" name="nama_opco"
                                value="{{ old('opco_name', $opco->nama_opco) }}" required>
                            @error('nama_opco')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label"></label>
                        <div class="col-11">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            <a class="btn btn-sm btn-default ml-1" href="{{ url('opco') }}">Kembali</a>
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
