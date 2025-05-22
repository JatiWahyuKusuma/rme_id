<!DOCTYPE html>
<html>

<head>
    <title>Hasil Rekomendasi Prioritas Perluasan Lahan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 16pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #800000;
            color: white;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-style: italic;
        }

        .kesimpulan {
            margin-top: 20px;
            padding: 15px;
            background-color: #f5f5f5;
            border-left: 4px solid #800000;
        }

        .ranking-1 {
            background-color: #ffe100;
            color: rgb(0, 0, 0);
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Hasil Rekomendasi Prioritas Perluasan Lahan Bahan Baku</h1>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Lokasi/IUP (Alternatif)</th>
                <th>Total Skor</th>
                <th>Ranking</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detailAlternatif as $item)
                <tr @if ($item->ranking == 1) class="ranking-1" @endif>
                    <td>{{ $item->ranking }}</td>
                    <td>{{ $item->lokasi_iup }}</td>
                    <td>{{ number_format($item->total_bobot, 2, ',', '.') }}</td>
                    <td>{{ $item->ranking }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="kesimpulan">
        <p><strong>KESIMPULAN :</strong></p>
        <p>Berdasarkan perhitungan dan perangkingan yang dilakukan menggunakan Sistem Pendukung Keputusan metode SAW
            (Simple Additive Weighting), Hasil Rekomendasi Prioritas Perluasan Lahan Bahan Baku adalah
            <strong>{{ $historyItem['lokasi_iup'] }}</strong>.</p>
        <p><strong>Catatan:</strong> perangkingan ini hanya sebagai rekomendasi lokasi terkait perluasan lahan,
            keputusan perluasan lahan utama tetap ditangan stakeholder.</p>
    </div>

    <div class="footer">
        Dicetak pada: {{ $tanggalCetak }}
    </div>
</body>

</html>
