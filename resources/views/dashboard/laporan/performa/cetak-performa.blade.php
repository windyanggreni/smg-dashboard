<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Performa Penjualan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #111;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #000;
            padding: 6px 8px;
        }
        th {
            background-color: #1a2035;
            color: #fff;
        }
        h1, h3 {
            margin: 0;
        }
        .company-header {
            text-align: center;
            margin-bottom: 5px;
            margin-top: 10px;
        }
        .company-header h1 {
            font-size: 20px;
        }
        .company-header p {
            margin: 0;
            font-size: 13px;
        }
        hr {
            border: 1px solid #000;
            margin-top: 8px;
            margin-bottom: 10px;
        }
        .printed-date {
            font-size: 11px;
            color: #555;
            margin-top: 8px;
        }
        .filter-info {
            text-align: center;
            font-size: 13px;
            margin-top: 10px;
            margin-bottom: 6px;
        }
    </style>
</head>
<body>
    <div class="company-header">
        <h1>Saudara Mandiri Group</h1>
        <p>Jl. H. Moh. Bafadhal, Cempaka Putih, Kecamatan Jelutung, Kota Jambi, Provinsi Jambi, 36134.</p>
    </div>
    <hr>
    <h3 style="text-align: center; font-size: 18px; margin-top: 30px;">Laporan Performa Penjualan</h3>

    <div class="filter-info">
        <div>Periode: {{ $startDateLabel }} s/d {{ $endDateLabel }}</div>
        <div>Kategori: {{ $categoryLabel }}</div>
        <div>Urutan: {{ $sortLabel }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:5%;">No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th style="width:15%;">Jumlah Terjual</th>
                <th style="width:20%;">Omzet</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($results as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category_name ?? '-' }}</td>
                    <td style="text-align: center;">{{ $item->total_qty }}</td>
                    <td style="text-align: right;">Rp {{ number_format($item->total_omzet, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center; font-style: italic; color:#777;">Tidak ada data untuk filter ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="printed-date">
        Dicetak pada: {{ now()->timezone('Asia/Jakarta')->format('d-m-Y H:i') }} | oleh - {{ Auth::user()->name ?? '-' }}
    </p>
</body>
</html>
