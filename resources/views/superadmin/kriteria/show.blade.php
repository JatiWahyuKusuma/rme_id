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
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('subkriteria/create') }}">Tambah Sub Kriteria</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div> <!-- Change class to 'alert-danger' -->
            @endif
            <table class="table-bordered table-striped table-hover table-sm table" id="table_subkriteria">
                <thead>
                    <tr>
                        <th>No</th>
                        {{-- <th>Kriteria ID</th> --}}
                        <th>Nama Sub Kriteria</th>
                        <th>Bobot Sub Kriteria</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="card-footer text-left">
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('kriteria') }}" >Kembali</a>
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
            var dataTable = $('#table_subkriteria').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('subkriteria/list') }}",
                    "type": "POST",
                    "data": function(d) {
                        d._token = '{{ csrf_token() }}';
                        d.nama_kriteria = $('#nama_subkriteria').val(); // Use the correct filter value
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
            $('#nama_subkriteria').on('change', function() {
                dataTable.ajax.reload(); // Reload data when filter changes
            });
        });
    </script>
@endpush
