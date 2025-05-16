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

        .separator {
            border-bottom: 2px solid #ccc;
            margin: 10px 0;
        }

        .table-container {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;

        }

        table {
            width: 100%;
            min-width: auto;
            table-layout: auto;
        }

        th,
        td {
            white-space: nowrap;
            padding: 8px 10px;
            text-align: center;
        }

        .btn-gradient {
            background: linear-gradient(to right, #800000, #c81b1b);
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 8px;
            transition: opacity 0.3s ease;
        }

        .btn-gradientu {
            background: linear-gradient(to right, #a0a0a0, #535353);
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 8px;
            transition: opacity 0.3s ease;
        }

        .btn-gradient:hover {
            opacity: 0.8;
        }

        #rekomendasi_section {
            display: none;
            /* Sembunyikan tabel perangkingan & kesimpulan secara default */
        }
    </style>
@endsection

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-body">
            <h4 class="text-center">Data Umur Cadangan Bahan Baku < 5 Tahun</h4>
            <div class="separator"></div>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="table-container">
                <table class="table table-bordered table-striped table-hover table-sm" id="table_m_cadangan_bb">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 30%;">Lokasi/IUP</th>
                            <th style="width: 15%;">Umur Cadangan (thn)</th>
                            <th style="width: 20%;">Umur Masa Berlaku Izin</th>
                            <th style="width: 20%;">Status Pembebasan</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12 text-left mt-4">
        <button type="button" class="btn-gradient" id="btn_hasil_rekomendasi">Hasil Rekomendasi</button>
    </div>
    <div id="rekomendasi_section">
        <div class="card card-outline card-primary mt-4">
            <div class="card-body">
                <h4 class="text-center">Tabel Hasil Perangkingan</h4>
                <div class="separator"></div>
                <table class="table table-bordered table-striped" id="table_perangkingan">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 30%">Lokasi/IUP (Alternatif)</th>
                            <th style="width: 20%">Total</th>
                            <th style="width: 20%">Rangking</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($detailAlternatif) && count($detailAlternatif) > 0)
                            @foreach ($detailAlternatif as $index => $item)
                                <tr @if ($item->ranking == 1) class="bg-danger text-white" @endif>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->lokasi_iup }}</td>
                                    <td>{{ number_format($item->total_bobot, 2, ',', '.') }}</td>
                                    <td>{{ $item->ranking }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center">Tidak Ada Data</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card card-outline card-primary mt-4">
            <div class="card-body">
                <h4 class="text-center">Kesimpulan</h4>
                <div class="separator"></div>
                <p class="text-center" style="font-size: 20px; ">
                    Berdasarkan perangkingan yang dilakukan , Hasil Rekomendasi Penerbitan Prioritas Perluasan Lahan Bahan
                    Baku adalah
                    <strong>{{ isset($detailAlternatif[0]) ? $detailAlternatif[0]->lokasi_iup : 'N/A' }}</strong>.
                </p>
                <button type="button" class="btn-gradient" id="btn_detail_perhitungan">Detail Perhitungan</button>
                <button type="button" class="btn-gradientu" id="btn_cetak_pdf">
                    <i class="fas fa-print mr-2"></i> Cetak PDF
                </button>
                <button type="button" class="btn-gradient" id="btn_cetak_pdf">
                    <i class="fas fa-print mr-2"></i> Simpan 
                </button>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('css')
    <style>
        body {
            overflow-x: hidden;
        }

        .card-body {
            overflow-x: hidden;
        }

        /* Tambahkan style untuk icon */
        .btn-gradientu i {
            margin-right: 8px;
        }

        /* Style khusus untuk cetak */
        @media print {
            body * {
                visibility: hidden;
            }

            #rekomendasi_section,
            #rekomendasi_section * {
                visibility: visible;
            }

            #rekomendasi_section {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .btn-gradient,
            .btn-gradientu {
                display: none !important;
            }
        }
    </style>
@endpush

@push('js')
    <script>
        document.getElementById("btn_cetak_pdf").addEventListener("click", function(e) {
            e.preventDefault(); // Mencegah perilaku default

            // Menggunakan metode fetch untuk memanggil route cetak PDF
            fetch("{{ route('rekomendasi.cetak') }}")
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.blob();
                })
                .then(blob => {
                    // Membuat URL objek dari blob
                    const url = window.URL.createObjectURL(blob);

                    // Membuat elemen <a> untuk memicu download
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'hasil rekomendasi perluasan lahan';
                    document.body.appendChild(a);
                    a.click();

                    // Membersihkan
                    window.URL.revokeObjectURL(url);
                    document.body.removeChild(a);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal mengunduh PDF. Silakan coba lagi.');
                });
        });

        document.getElementById("btn_detail_perhitungan").addEventListener("click", function() {
            window.location.href = "{{ url('/detailrekomendasi') }}";
        });
        $(document).ready(function() {
            var dataTable = $('#table_m_cadangan_bb').DataTable({
                serverSide: true,
                paging: false,
                searching: false,
                lengthChange: false,
                info: false,
                responsive: true,
                autoWidth: false,
                columnDefs: [{
                        width: '5%',
                        targets: 0
                    },
                    {
                        width: '30%',
                        targets: 1
                    },
                    {
                        width: '15%',
                        targets: 2
                    },
                    {
                        width: '20%',
                        targets: 3
                    },
                    {
                        width: '20%',
                        targets: 4
                    }
                ],
                ajax: {
                    "url": "{{ url('rekomendasi/list') }}",
                    "type": "POST",
                    "data": function(d) {
                        d._token = '{{ csrf_token() }}';
                        d.opco_id = $('#opco_id').val();
                        d.filter_umur_cadangan = "<5";
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "lokasi_iup",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "umur_cadangan_thn",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "umur_masa_berlaku_izin",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "status_pembebasan",
                        orderable: true,
                        searchable: true
                    }
                ]
            });

            $('#opco_id').on('change', function() {
                dataTable.ajax.reload();
            });
            $('#btn_hasil_rekomendasi').on('click', function() {
                $('#rekomendasi_section').fadeIn();
            });
        });
    </script>
@endpush
