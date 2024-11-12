@extends('layout.template')
@section('css')
    <style>
        .card.card-outline.card-primary {
            margin: auto;
            background-color: rgb(245, 245, 245);
            border-top-color: rgb(46, 46, 46);
        }
    </style>
@endsection
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('opco/create') }}">Tambah</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div> <!-- Change class to 'alert-danger' -->
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter: </label>
                        <div class="col-3">
                            <select class="form-control" name="nama_opco" id="nama_opco">
                                <option value="">-- Semua --</option>
                                <option value="GHOPO Tuban" > GHOPO Tuban </option>
                                <option value="SG Rembang">SG Rembang</option>
                            </select>
                            <small class="form-text text-muted">Nama opco</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table-bordered table-striped table-hover table-sm table" id="table_opco">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Opco</th>
                        <th>Nama Opco</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('css')
<style>
    /* Center-align table headers */
    th {
        text-align: center;
    }

     /* Control the width of the action buttons */
</style>
@endpush
@push('js')
    <script>
        $(document).ready(function() {
            var dataTable = $('#table_opco').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('opco/list') }}",
                    "type": "POST",
                    "data": function(d) {
                        d._token = '{{ csrf_token() }}'; // Add CSRF token
                        d.nama_opco = $('#nama_opco').val();
                    }
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "kode_opco",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "nama_opco",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        className: "",
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            $('#nama_opco').on('change', function() {
                dataTable.ajax.reload();
            });
        });
    </script>
@endpush
