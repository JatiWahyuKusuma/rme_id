<!DOCTYPE html>
<html>

<head>
    <title>Laporan Hasil Rekomendasi Prioritas Perluasan Lahan Bahan Baku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 18px;
            color: #800000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #800000;
            color: white;
        }

        .kesimpulan {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .ranking-1 {
            background-color: #ffcccc;
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

    <div class="kesimpulan">
        <p>Berdasarkan perangkingan yang dilakukan, Hasil Rekomendasi Penerbitan Prioritas Perluasan Lahan Bahan Baku
            adalah <strong>{{ isset($detailAlternatif[0]) ? $detailAlternatif[0]->lokasi_iup : 'N/A' }}</strong>.</p>
    </div>
</body>

</html>
