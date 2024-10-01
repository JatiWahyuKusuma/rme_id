@extends('layout.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('cadpot/create') }}">Tambah</a>
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
                            <select class="form-control" name="komoditi" id="komoditi">
                                <option value="">-- Semua --</option>
                                <option value="Cad Batugamping">Cad Batugamping</option>
                                <option value="Pot Batugamping">Pot Batugamping</option>
                                <option value="Cad Lempung">Cad Lempung</option>
                                <option value="Pot Lempung">Pot Lempung</option>
                                <option value="Pot Pasirkuarsa">Pot Pasirkuarsa</option>
                            </select>
                            <small class="form-text text-muted">Komoditi</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table-bordered table-striped table-hover table-sm table" id="table_m_cadangan_potensi">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Opco ID</th>
                        <th>Jarak</th>
                        <th>Komoditi</th>
                        <th>Lokasi/IUP</th>
                        <th>Tipe SD/Cadangan</th>
                        <th>SD/Cadangan(ton)</th>
                        <th>Catatan</th>
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

        .aksi-buttons a, .aksi-buttons button {
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
                "url": "{{ url('cadpot/list') }}",
                "type": "POST",
                "data": function(d) {
                    d._token = '{{ csrf_token() }}';
                    d.komoditi = $('#komoditi').val(); // Use the correct filter value
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
                    data: "komoditi",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "lokasi_iup",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "tipe_sd_cadangan",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "sd_cadangan_ton",
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row){
                        return new Intl.NumberFormat('id-ID').format(data);
                    },
                    width: "150px"
                },
                {
                    data: "catatan",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "status_penyelidikan",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "acuan",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "kabupaten",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "kecamatan",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "luas_ha",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "masa_berlaku_iup",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "masa_berlaku_ppkh",
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
        $('#komoditi').on('change', function() {
            dataTable.ajax.reload(); // Reload data when filter changes
        });
    });
</script>
@endpush
