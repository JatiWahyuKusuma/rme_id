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
                <a class="btn-gradient" href="{{ url('kriteria/create') }}">Tambah Kriteria</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div> <!-- Change class to 'alert-danger' -->
            @endif
            <table class="table-bordered table-striped table-hover table-sm table" id="table_kriteria">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Kriteria</th>
                        <th>Jenis Kriteria</th>
                        <th>Bobot Kriteria</th>
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
            var dataTable = $('#table_kriteria').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('kriteria/list') }}",
                    "type": "POST",
                    "data": function(d) {
                        d._token = '{{ csrf_token() }}';
                        d.nama_kriteria = $('#nama_kriteria').val(); // Use the correct filter value
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
                        data: "nama_kriteria",
                        orderable: true,
                        searchable: true,
                        width: "10px"
                    },
                    {
                        data: "jenis_kriteria",
                        orderable: true,
                        searchable: true,
                        width: "50px"
                    },
                    {
                        data: "bobot_kriteria",
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
            $('#nama_kriteria').on('change', function() {
                dataTable.ajax.reload(); // Reload data when filter changes
            });
        });
    </script>
@endpush
