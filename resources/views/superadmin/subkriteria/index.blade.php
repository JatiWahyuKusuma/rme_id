@extends('layout.template')

@section('css')
    <style>
        .card.card-outline.card-primary {
            margin: auto;
            background-color: rgb(245, 245, 245);
            border-top-color:  #800000;
            border-top: 4px solid #800000;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-gradient {
            background: linear-gradient(to right, #800000, #c81b1b);
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
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
                <a class="btn-gradient" href="{{ url('subkriteria/create') }}">Tambah Sub Kriteria</a>
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
                        <label class="col-1 control-label col-form-label">Filter Kriteria: </label>
                        <div class="col-3">
                            <select class="form-control" name="kriteria_id" id="kriteria_id">
                                <option value="">-- Semua --</option>
                                @foreach ($kriteria as $item)
                                    <option value="{{ $item->kriteria_id }}">{{ $item->nama_kriteria }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Pilih kriteria</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table-bordered table-striped table-hover table-sm table" id="table_subkriteria">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kriteria ID</th>
                        <th>Nama Sub Kriteria</th>
                        <th>Bobot Sub Kriteria</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('css')
    <style>
        th {
            text-align: center;
        }

        .aksi-buttons {
            display: flex;
            gap: 2px;
        }

        .aksi-buttons a,
        .aksi-buttons button {
            flex-grow: 1;
            width: 50px;
            text-align: center;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            // var kriteriaID = new URLSearchParams(window.location.search).get('kriteria_id') || '';
            var dataTable = $('#table_subkriteria').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('subkriteria/list') }}",
                    "type": "POST",
                    "data": function(d) {
                        d._token = '{{ csrf_token() }}';
                        d.kriteria_id = $('#kriteria_id').val();
                        // d.kriteria_id = kriteriaID; // Use the correct filter value
                    }
                },
                dom: 't',
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false,
                        width: "10px"
                    },
                    {
                        data: "kriteria_id",
                        orderable: true,
                        searchable: true,
                        width: "10px"
                    },
                    {
                        data: "nama_subkriteria",
                        orderable: true,
                        searchable: true,
                        width: "10px"
                    },
                    {
                        data: "bobot_subkriteria",
                        orderable: true,
                        searchable: true,
                        width: "50px"
                    },
                    {
                        data: "aksi",
                        orderable: false,
                        searchable: false,
                        width: "170px"
                    }
                ]
            });
            // Event listener for filter
            $('#kriteria_id').on('change', function() {
                dataTable.ajax.reload();
            });
        });
    </script>
@endpush
