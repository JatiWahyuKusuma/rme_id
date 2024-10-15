@extends('layout.template')

@section('content')

    <div class="card card-outline card-primary">

        <div class="card-header">

            <h3 class="card-title">{{ $page->title }}</h3>

            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('vendorbb/create') }}">Tambah</a>
            </div>

        </div>

        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter: </label>
                        <div class="col-3">
                            <select class="form-control" name="opco_id" id="opco_id">
                                <option value="">-- Semua --</option> <!-- Pastikan ini hanya muncul sekali -->
                                @foreach ($opco as $opco)
                                    <option value="{{$opco->opco_id }}">{{$opco->nama_opco }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Opco</small>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table-bordered table-striped table-hover table-sm table" id="table_m_vendor">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Opco ID</th>
                        <th>Jarak (km)</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Vendor</th>
                        <th>Komoditi</th>
                        <th>Desa</th>
                        <th>Kecamatan</th>
                        <th>Kabupaten</th>
                        <th>Kap (ton/thn)</th>
                        <th>Konsumsi (ton/thn)</th>
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
            justify-content: center;
            gap: 5px;
        }
        .aksi-buttons a,
        .aksi-buttons button {
            flex-grow: 1;
            text-align: center;
        }
        table th {
            text-align: center;
            vertical-align: middle;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {

            // Initialize DataTable
            var dataLevel = $('#table_m_vendor').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('vendorbb/list') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = '{{ csrf_token() }}'; // Add CSRF token
                        d.opco_id = $('#opco_id').val(); // Get the selected filter value
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
                        data: "opco_id",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "jarak",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "latitude",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "longitude",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "vendor",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "komoditi",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "desa",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "kecamatan",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "kabupaten",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "kap_ton_thn",
                        orderable: true,
                        searchable: true,
                        render: function(data) {
                            return new Intl.NumberFormat('id-ID').format(data);
                        }
                    },
                    {
                        data: "konsumsi_ton_thn",
                        orderable: true,
                        searchable: true
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
                dataLevel.ajax.reload(); // Reload DataTable with the selected filter
            });

        });
    </script>
@endpush
