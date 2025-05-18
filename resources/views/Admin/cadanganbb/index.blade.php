@extends('layoutAdmin.template')

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

        /* Custom styles for DataTables controls */
        .dataTables_wrapper .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .dataTables_length {
            display: flex;
            align-items: center;
            margin-right: 10px;
        }

        .dataTables_filter {
            margin-left: auto;
        }

        .export-btn-container {
            margin-left: 15px;
        }

        .dt-buttons {
            display: flex;
            align-items: center;
        }
    </style>
@endsection

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn-gradient" href="{{ url('admincadanganbb/create') }}">Tambah Cadangan Bahan Baku</a>
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
            <table class="table-bordered table-striped table-hover table-sm table" id="table_m_cadangan_bb">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Opco ID</th>
                        <th>Komoditi</th>
                        <th>Lokasi/IUP</th>
                        <th>SD/Cadangan(ton)</th>
                        <th>Status Penyelidikan</th>
                        <th>Catatan</th>
                        <th>Luas(Ha)</th>
                        <th>Masa Berlaku IUP</th>
                        <th>Masa Berlaku PPKH</th>
                        <th>Umur Cadangan (thn)</th>
                        <th>Umur Masa Berlaku Izin </th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Pilih Tahun dan Periode</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="exportForm" method="GET" action="{{ route('admincadanganbb.exportPDF') }}" target="_blank">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <select class="form-control" id="tahun" name="tahun" required>
                                @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="periode">Periode</label>
                            <select class="form-control" id="periode" name="periode" required>
                                <option value="Quarter 1">Quarter 1</option>
                                <option value="Quarter 2">Quarter 2</option>
                                <option value="Quarter 3">Quarter 3</option>
                                <option value="Quarter 4">Quarter 4</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Export PDF</button>
                    </div>
                </form>
            </div>
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
            var dataTable = $('#table_m_cadangan_bb').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('admincadanganbb/list') }}",
                    "type": "POST",
                    "data": function(d) {
                        d._token = '{{ csrf_token() }}';
                        d.opco_id = $('#opco_id').val(); // Use the correct filter value
                    }
                },
                dom: '<"top"lf>rt<"bottom"ip>',
                initComplete: function() {
                    // Add export button next to the length menu
                    $('.dataTables_length').after(
                        '<div class="export-btn-container"><button type="button" class="btn-gradient" id="exportPdfBtn" data-toggle="modal" data-target="#exportModal">Export PDF</button></div>'
                    );
                    // Handle export button click - show modal only
                    $('#exportPdfBtn').on('click', function(e) {
                        e.preventDefault();
                        $('#exportModal').modal('show');
                    });
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
                        data: "komoditi",
                        orderable: true,
                        searchable: true,
                        width: "50px"
                    },
                    {
                        data: "lokasi_iup",
                        orderable: true,
                        searchable: true,
                        width: "50px"
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
                        width: "40px"
                    },
                    {
                        data: "catatan",
                        orderable: true,
                        searchable: true,
                        width: "70px"
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
                        width: "70px"
                    },
                    {
                        data: "masa_berlaku_ppkh",
                        orderable: true,
                        searchable: true,
                        width: "70px"
                    },
                    {
                        data: "umur_cadangan_thn",
                        orderable: true,
                        searchable: true,
                        width: "70px"
                    },
                    {
                        data: "umur_masa_berlaku_izin",
                        orderable: true,
                        searchable: true,
                        width: "70px"
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
            // Handle form submission for PDF export
            $('#exportForm').on('submit', function(e) {
                e.preventDefault();

                var form = $(this);
                var opcoId = $('#opco_id').val();

                // Add opco_id to the form if it exists
                if (opcoId) {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'opco_id',
                        value: opcoId
                    }).appendTo(form);
                }

                // Submit the form
                form.off('submit').submit();

                // Close the modal after submission
                $('#exportModal').modal('hide');
            });
        });
    </script>
@endpush
