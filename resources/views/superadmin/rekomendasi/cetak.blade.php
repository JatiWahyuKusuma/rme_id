<!DOCTYPE html>
<html>

<head>
    <title>Laporan Hasil Rekomendasi Prioritas Perluasan Lahan Bahan Baku</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins';
            position: relative;
        }

        .watermark {
            position: absolute;
            opacity: 0.1;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            /* background-image: url("{{ asset('images/logoSIG.png') }}"); */
            background-repeat: no-repeat;
            background-position: center;
            background-size: 50%;
        }


        .header {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }

        .header h1 {
            font-size: 18px;
            color: #800000;
            margin-top: 30px;
            font-family: 'Poppins';
            font-weight: 600;
        }

        .date {
            position: absolute;
            top: 0;
            right: 0;
            font-size: 14px;
            /* font-weight: 500; */
            font-family: 'Poppins';
            color: #2e2e2e;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-family: 'Poppins', sans-serif;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-family: 'Poppins', sans-serif;
        }

        th {
            background-color: #800000;
            color: white;
            font-weight: 500;
        }

        .kesimpulan-box {
            margin-top: 30px;
            font-size: 16px;
            font-family: 'Poppins';
            max-width: 100%;
            background-color: #d7d7d7;
            border: 2px solid #800000;
            border-radius: 5px;
            padding: 15px;
            box-sizing: border-box;
        }

        .kesimpulan-title {
            text-align: center;
            font-weight: 600;
            margin-bottom: 15px;
            color: #800000;
        }

        .kesimpulan-content {
            text-align: justify;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .kesimpulan-note {
            text-align: justify;
            line-height: 1.5;
        }

        .kesimpulan p {
            margin: 5px 0;
        }

        .ranking-1 {
            background-color: #ffcccc;
        }

        strong {
            font-family: 'Poppins';
            font-weight: 600;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="watermark"></div>
    <div class="container-wrapper " style="width: 100%; max-width: 1000px; margin: 0 auto;">
        <div class="date">
            Dicetak pada
            {{ \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('dddd, D MMMM YYYY HH:mm:ss') }}
        </div>
        <div class="header">
            <h1>Laporan Hasil Rekomendasi Prioritas Perluasan Lahan Bahan Baku</h1>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Lokasi/IUP (Alternatif)</th>
                    <th>Total</th>
                    <th>Rangking</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detailAlternatif as $index => $item)
                    <tr class="{{ $item->ranking == 1 ? 'ranking-1' : '' }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->lokasi_iup }}</td>
                        <td>{{ number_format($item->total_bobot, 2, ',', '.') }}</td>
                        <td>{{ $item->ranking }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="kesimpulan-box">
            <div class="kesimpulan-title">KESIMPULAN :</div>
            <div class="kesimpulan-content">
                Berdasarkan perhitungan dan perangkingan yang dilakukan menggunakan Sistem Pendukung Keputusan metode
                SAW(Simple Additive Weighting), Hasil Rekomendasi Penerbitan Prioritas Perluasan Lahan Bahan Baku
                adalah <strong>{{ isset($detailAlternatif[0]) ? $detailAlternatif[0]->lokasi_iup : 'N/A' }}</strong>.
            </div>
            <div class="kesimpulan-note">
                <strong>Catatan: </strong> perangkingan ini hanya sebagai rekomendasi lokasi terkiat perluasan lahan.
                terkait keputusan perluasan lahan utama
                tetap
                ditangan stakeholder.
            </div>
        </div>
    </div>
</body>

</html>
