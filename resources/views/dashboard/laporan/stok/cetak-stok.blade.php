<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Laporan Stok Barang</title>
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

        table,
        th,
        td {
            border: 1px solid #000;
            padding: 6px 8px;
        }

        th {
            background-color: #1a2035;
            color: #fff;
        }

        /* Ukuran font tanggal 13px */
        th.tanggal,
        td.tanggal {
            font-size: 13px;
        }

        h1,
        h3 {
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

        .total-row {
            font-weight: bold;
            background-color: #e0e6fb;
        }

        .empty-row {
            text-align: center;
            color: #777;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="company-header">
        <h1>Saudara Mandiri Group</h1>
        <p>Jl. H. Moh. Bafadhal, Cempaka Putih, Kecamatan Jelutung, Kota Jambi, Provinsi Jambi, 36134.</p>
    </div>
    <hr />

    <h3 style="text-align: center; font-size: 18px; margin-top: 30px;">Laporan Stok Barang</h3>

    {{-- Kamu bisa tambahkan filter info jika ada --}}
    <div class="filter-info" style="font-size: 12px; line-height: 1.4; text-align: center;">
        <div>
            Kategori: {{ $categoryLabel ?? 'Semua' }}
        </div>

        <div>
            Urutkan berdasarkan:
            @php
                // Kalau variabel $sort gak ada, default 'name'
                $sort = $sort ?? 'name';

                $sortLabels = [
                    'name' => 'Nama Produk (A-Z)',
                    'stock_desc' => 'Stok Terbanyak',
                    'stock_asc' => 'Stok Tersedikit',
                ];
            @endphp
            {{ $sortLabels[$sort] ?? 'Nama Produk (A-Z)' }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:5%;">No</th>
                <th>Nama Produk</th>
                <th style="width:20%;">Kategori</th>
                <th style="width:12%;">Stok Tersedia</th>
                <th style="width:15%;">Harga Satuan</th>
            </tr>
        </thead>
        <tbody>
            @if ($products->isEmpty())
                <tr>
                    <td colspan="6" class="empty-row">Tidak ada data produk.</td>
                </tr>
            @else
                @foreach ($products as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->name ?? '-' }}</td>
                        <td>{{ $product->category->name ?? '-' }}</td>
                        <td style="text-align: right;">{{ $product->stock_barang ?? 0 }}</td>
                        <td style="text-align: right;">Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <p class="printed-date">
        Dicetak pada: {{ now()->timezone('Asia/Jakarta')->format('d-m-Y H:i') }} | oleh -
        {{ Auth::user()->name ?? '-' }}
    </p>
</body>

</html>
