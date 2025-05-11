<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Cadangan Bahan Baku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            /* Ukuran font lebih kecil */
            margin: 10px;
            /* background: url("{{ asset('images/logoSIG.png') }}") no-repeat center center; */

        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h2 {
            color: #800000;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .filter-info {
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
            font-size: 9px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            table-layout: fixed;
            /* Fixed layout untuk kontrol lebar kolom */
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 3px;
            word-wrap: break-word;
            /* Memastikan teks panjang akan dipotong */
        }

        th {
            background-color: #800000;
            color: white;
            text-align: center;
            font-weight: bold;
            font-size: 9px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 10px;
            text-align: right;
            font-size: 8px;
            color: #666;
        }
    </style>
    </style>
</head>

<body>
    <div class="header">
        <h2>Laporan Data Cadangan Bahan Baku</h2>
        <p>Sistem Informasi Monitoring Cadangan Bahan Baku - Department Raw Material Expansion PT Semen Indonesia
            (Persero). Tbk</p>
    </div>

    <div class="filter-info">
        Dicetak pada
        {{ \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('dddd, D MMMM YYYY HH:mm:ss') }}
        <p><strong>Tahun:</strong> {{ $tahun }} | <strong>Periode:</strong> {{ $periode }}</p>
        <p><strong>Jumlah Data:</strong> {{ count($data) }} record</p>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Nama Opco</th>
                <th style="width: 10%">Komoditi</th>
                <th style="width: 15%">Lokasi/IUP</th>
                <th style="width: 10%">SD/Cadangan (ton)</th>
                <th style="width: 10%">Status</th>
                <th style="width: 30%">Catatan</th>
                <th style="width: 8%">Luas (Ha)</th>
                <th style="width: 12%">Masa Berlaku IUP</th>
                <th style="width: 10%">Umur Cadangan</th>
                <th style="width: 10%">Umur Masa Berlaku Izin</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->nama_opco }}</td>
                    <td>{{ $item->komoditi }}</td>
                    <td>{{ $item->lokasi_iup }}</td>
                    <td class="text-right">{{ number_format($item->sd_cadangan_ton, 0, ',', '.') }}</td>
                    <td>{{ $item->status_penyelidikan }}</td>
                    <td>{{ $item->catatan }}</td>
                    <td class="text-right">{{ number_format($item->luas_ha, 2, ',', '.') }}</td>
                    <td>{{ $item->masa_berlaku_iup }}</td>
                    <td class="text-right">{{ number_format($item->umur_cadangan_thn) }} thn</td>
                    <td>{{ $item->umur_masa_berlaku_izin }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis oleh sistem pada
            {{ \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('dddd, D MMMM YYYY HH:mm:ss') }}
        </p>
    </div>
</body>

</html>
