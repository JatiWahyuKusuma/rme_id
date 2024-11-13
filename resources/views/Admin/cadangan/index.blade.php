@extends('layoutAdmin.template')

@section('css')
    <style>
        .card.card-outline.card-primary {
            margin: auto;
            background-color: rgb(245, 245, 245);
            border-top-color: rgb(46, 46, 46);
        }

        .aksi-buttons {
            display: flex;
            gap: 5px;
            /* Adjust spacing between buttons */
            justify-content: center;
        }

        .aksi-buttons a,
        .aksi-buttons button {
            flex: 1;
            /* Make buttons take equal space */
            padding: 5px 0;
            /* Adjust padding for better sizing */
            text-align: center;
            font-size: 0.85em;
            /* Adjust font size for better fit */
            border-radius: 4px;
            /* Optional: Rounded corners for better appearance */
        }

        .aksi-buttons .btn {
            width: auto;
            /* Remove fixed width, allowing buttons to adjust proportionally */
        }
    </style>
@endsection

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('admincadpot/create') }}">Tambah</a>
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
                            <select class="form-control" name="opco_id" id="opco_id">
                                <option value="">-- Semua --</option> <!-- Pastikan ini hanya muncul sekali -->
                                @foreach ($opco as $opco)
                                    <option value="{{ $opco->opco_id }}">{{ $opco->nama_opco }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Opco</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table-bordered table-striped table-hover table-sm table" id="table_m_cadangan_potensi">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Opco ID</th>
                        <th>Jarak(km)</th>
                        <th>Komoditi</th>
                        <th>Lokasi/IUP</th>
                        <th>SD/Cadangan(ton)</th>
                        <th>Status Penyelidikan</th>
                        <th>Acuan</th>
                        <th>Kabupaten</th>
                        <th>Kecamatan</th>
                        <th>Luas(Ha)</th>
                        <th>Masa Berlaku IUP</th>
                        <th>Masa Berlaku PPKH</th>
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
            width: 75px;
            text-align: center;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            var dataTable = $('#table_m_cadangan_potensi').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('admincadpot/list') }}",
                    "type": "POST",
                    "data": function(d) {
                        d._token = '{{ csrf_token() }}';
                        d.opco_id = $('#opco_id').val(); // Use the correct filter value
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false,
                        width: "10px"
                    },
                    {
                        data: "opco_id",
                        orderable: true,
                        searchable: true,
                        width: "10px"
                    },
                    {
                        data: "jarak",
                        orderable: true,
                        searchable: true,
                        width: "10px"
                    },
                    {
                        data: "komoditi",
                        orderable: true,
                        searchable: true,
                        width: "120px"
                    },
                    {
                        data: "lokasi_iup",
                        orderable: true,
                        searchable: true,
                        width: "100px"
                    },
                    {
                        data: "sd_cadangan_ton",
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return new Intl.NumberFormat('id-ID').format(data);
                        },
                        width: "150px"
                    },
                    {
                        data: "status_penyelidikan",
                        orderable: true,
                        searchable: true,
                        width: "70px"
                    },
                    {
                        data: "acuan",
                        orderable: true,
                        searchable: true,
                        width: "150px"
                    },
                    {
                        data: "kabupaten",
                        orderable: true,
                        searchable: true,
                        width: "10px"
                    },
                    {
                        data: "kecamatan",
                        orderable: true,
                        searchable: true,
                        width: "10px"
                    },
                    {
                        data: "luas_ha",
                        orderable: true,
                        searchable: true,
                        width: "10px"
                    },
                    {
                        data: "masa_berlaku_iup",
                        orderable: true,
                        searchable: true,
                        width: "100px"
                    },
                    {
                        data: "masa_berlaku_ppkh",
                        orderable: true,
                        searchable: true,
                        width: "100px"
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
            $('#opco_id').on('change', function() {
                dataTable.ajax.reload(); // Reload data when filter changes
            });
        });
    </script>
@endpush
