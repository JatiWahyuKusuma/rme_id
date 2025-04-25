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

        .btn-gradient:hover {
            opacity: 0.8;
        }
    </style>
@endsection

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-body">
            <h4 class="text-center">Detail Alternatif</h4>
            <div class="separator"></div>
            <div class="table-container">
                <table class="table table-bordered table-striped" id="table_detail_alternatif">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 30%">Lokasi/IUP(Alternatif)</th>
                            <th style="width: 15%">Umur Cadangan (C1)</th>
                            <th style="width: 20%">Umur Izin (C2)</th>
                            <th style="width: 20%">Status Pembebasan(C3)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($detailAlternatif as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->lokasi_iup }}</td>
                                <td class="text-center">{{ $item->umur_cadangan_bobot }}</td>
                                <td class="text-center">{{ $item->umur_masa_berlaku_izin_bobot }}</td>
                                <td class="text-center">{{ $item->status_pembebasan_bobot }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak Ada Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card card-outline card-primary mt-4">
        <div class="card-body">
            <h4 class="text-center">Tahap Normalisasi</h4>
            <div class="separator"></div>
            <div class="table-container">
                <table class="table table-bordered table-striped" id="table_normalisasi">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 30%">Lokasi/IUP (Alternatif)</th>
                            <th style="width: 15%">Umur Cadangan (C1)</th>
                            <th style="width: 20%">Umur Izin (C2)</th>
                            <th style="width: 20%">Status Pembebasan(C3)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($detailAlternatif as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->lokasi_iup }}</td>
                                <td>{{ fmod($item->normalisasi_c1, 1) == 0 ? number_format($item->normalisasi_c1, 0) : number_format($item->normalisasi_c1, 4, ',', '') }}
                                </td>
                                <td>{{ fmod($item->normalisasi_c2, 1) == 0 ? number_format($item->normalisasi_c2, 0) : number_format($item->normalisasi_c2, 4, ',', '') }}
                                </td>
                                <td>{{ fmod($item->normalisasi_c3, 1) == 0 ? number_format($item->normalisasi_c3, 0) : number_format($item->normalisasi_c3, 4, ',', '') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak Ada Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card card-outline card-primary mt-4">
        <div class="card-body">
            <h4 class="text-center mt-4">Tabel Kriteria dengan Bobot</h4>
            <div class="separator"></div>
            <div class="table-container">
                <table class="table table-bordered table-striped" id="table_kriteria">
                    <thead>
                        <tr>
                            <th style="width: 10%;">No</th>
                            <th style="width: 60%;">Kriteria</th>
                            <th style="width: 30%;">Bobot</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kriteria as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $item->nama_kriteria }}</td>
                                <td class="text-center">{{ $item->bobot_kriteria }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card card-outline card-primary mt-4">
        <div class="card-body">
            <h4 class="text-center">Tahap Perhitungan Nilai Prefrensi</h4>
            <div class="separator"></div>
            <div class="table-container">
                <table class="table table-bordered table-striped" id="table_perangkingan">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 30%">Lokasi/IUP (Alternatif)</th>
                            <th style="width: 15%">Umur Cadangan (C1)</th>
                            <th style="width: 20%">Umur Izin (C2)</th>
                            <th style="width: 20%">Status Pembebasan(C3)</th>
                            <th style="width: 20%">Total</th>
                            <th style="width: 20%">Rangking</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($detailAlternatif as $index => $item)
                            <tr @if ($item->ranking == 1) class="bg-danger text-white" @endif>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->lokasi_iup }}</td>
                                <td>{{ fmod($item->normalisasi_c1, 1) == 0 ? number_format($item->normalisasi_c1, 0) : number_format($item->normalisasi_c1, 4, ',', '') }}
                                </td>
                                <td>{{ fmod($item->normalisasi_c2, 1) == 0 ? number_format($item->normalisasi_c2, 0) : number_format($item->normalisasi_c2, 4, ',', '') }}
                                </td>
                                <td>{{ fmod($item->normalisasi_c3, 1) == 0 ? number_format($item->normalisasi_c3, 0) : number_format($item->normalisasi_c3, 4, ',', '') }}
                                </td>
                                <td>{{ number_format($item->total_bobot, 2, ',', '.') }}</td>
                                <td>{{ $item->ranking }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak Ada Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card card-outline card-primary mt-4">
        <div class="card-body">
            <h4 class="text-center">Tahap Perangkingan dan Kesimpulan</h4>
            <div class="separator"></div>
            <div class="table-container">
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
                        @forelse ($detailAlternatif as $index => $item)
                            <tr @if ($item->ranking == 1) class="bg-danger text-white" @endif>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->lokasi_iup }}</td>
                                <td>{{ number_format($item->total_bobot, 2, ',', '.') }}</td>
                                <td>{{ $item->ranking }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak Ada Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="col-12 text-left mt-4">
                    <button type="button" class="btn-gradient" id="btn_kembali">Kembali</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        document.getElementById("btn_kembali").addEventListener("click", function() {
            window.location.href = "{{ url('/rekomendasi') }}";
        });
    </script>
@endpush
