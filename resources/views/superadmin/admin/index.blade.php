@extends('layout.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('admin/create') }}">Tambah</a>
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
                            <select class="form-control" name="nama" id="nama">
                                <option value="">-- Semua --</option>
                                @foreach ($admin as $i)
                                    <option value="{{ $i->nama }}">{{ $i->nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Nama</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table-bordered table-striped table-hover table-sm table" id="table_admin">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Level Id</th>
                        <th>Opco Id</th>
                        <th>Nama</th>
                        <th>Email</th>
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
</style>
@endpush
@push('js')
    <script>
        $(document).ready(function() {
            var dataLevel = $('#table_admin').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('admin/list') }}",
                    "type": "POST",
                    "data": function(d) {
                        d._token = '{{ csrf_token() }}'; // Add CSRF token
                        d.nama = $('#nama').val();
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
                        data: "level_id",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "opco_id",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "nama",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "email",
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
            $('#nama').on('change', function() {
                dataLevel.ajax.reload();
            });
        });
    </script>
@endpush
