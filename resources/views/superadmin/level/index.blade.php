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
        th {
            text-align: center;
            background-color: #800000;
            /* Set header background color to red */
            color: white;
            /* Set font color to white */
        }

    </style>
@endsection

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn-gradient" href="{{ url('level/create') }}">Tambah Level</a>
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
                            <select class="form-control" name="nama_level" id="nama_level">
                                <option value="">-- Semua --</option>
                                <option value="Super Administrator"> Super Administrator </option>
                                <option value="Administrator">Administrator</option>
                            </select>
                            <small class="form-text text-muted">Nama Level</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table-bordered table-striped table-hover table-sm table" id="table_level">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Level Code</th>
                        <th>Nama Level</th>
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
            var dataTable = $('#table_level').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('level/list') }}",
                    "type": "POST",
                    "data": function(d) {
                        d._token = '{{ csrf_token() }}'; // Add CSRF token
                        d.nama_level = $('#nama_level').val();
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "kode_level",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "nama_level",
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
            $('#nama_level').on('change', function() {
                dataTable.ajax.reload();
            });
        });
    </script>
@endpush
