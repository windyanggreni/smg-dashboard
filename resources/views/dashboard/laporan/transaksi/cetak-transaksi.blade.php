<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
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

        .nested-table th {
            background-color: #e9ecef;
            /* abu-abu terang */
            color: #333;
            /* teks gelap */
            border: 1px solid #000;
            padding: 4px 6px;
            font-weight: 600;
        }

        .nested-table {
            margin-top: 0;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <div class="company-header">
        <h1>Saudara Mandiri Group</h1>
        <p>Jl. H. Moh. Bafadhal, Cempaka Putih, Kecamatan Jelutung, Kota Jambi, Provinsi Jambi, 36134.</p>
    </div>
    <hr>

    <h3 style="text-align: center; font-size: 18px; margin-top: 30px;">Laporan Transaksi</h3>

    {{-- Informasi filter (center) --}}
    <div class="filter-info" style="font-size: 12px; line-height: 1.4; text-align: center;">
        @php
            $hasFilter =
                !empty($startDateLabel) ||
                !empty($endDateLabel) ||
                !empty($statusLabel) ||
                !empty($paymentStatusLabel) ||
                !empty($sortLabel);
        @endphp

        @if ($hasFilter)
            {{-- Periode & Urutan --}}
            @if (!empty($startDateLabel) && !empty($endDateLabel))
                <div>
                    Periode: {{ $startDateLabel }} s/d {{ $endDateLabel }}
                    @if (!empty($sortLabel))
                        | Urutan: {{ $sortLabel }}
                    @endif
                </div>
            @elseif(!empty($sortLabel))
                <div>Urutan: {{ $sortLabel }}</div>
            @endif

            {{-- Status Order --}}
            @if (!empty($statusLabel))
                <div>Status Order: {{ $statusLabel }}</div>
            @endif

            {{-- Status Pembayaran --}}
            @if (!empty($paymentStatusLabel))
                <div>Status Pembayaran: {{ $paymentStatusLabel }}</div>
            @endif
        @else
            <span style="color:#666;">(Tidak ada filter, menampilkan semua data)</span>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:5%;">No</th>
                <th class="tanggal" style="width:14%;">Tanggal</th>
                <th>Pelanggan</th>
                <th>Invoice</th>
                <th style="width:14%;">Status Order</th>
                <th style="width:14%;">Status Pembayaran</th>
                <th style="width:14%;">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @if ($orders->isEmpty())
                <tr>
                    <td colspan="7" class="empty-row">Tidak ada data untuk filter ini.</td>
                </tr>
                <tr class="total-row">
                    <td colspan="6" style="text-align: right;">Jumlah Order:</td>
                    <td>0</td>
                </tr>
                <tr class="total-row">
                    <td colspan="6" style="text-align: right;">Total Transaksi:</td>
                    <td>Rp 0</td>
                </tr>
            @else
                @php
                    $i = 0;
                @endphp
                @foreach ($orders as $order)
                    @php $i++; @endphp
                    <tr>
                        <td>{{ $i }}</td>
                        <td class="tanggal">{{ $order->created_at->timezone('Asia/Jakarta')->format('d-m-Y') }}</td>
                        <td>{{ $order->user->name ?? '-' }}</td>
                        <td>{{ $order->invoice ?? '-' }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $order->order_status)) }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}</td>
                        <td style="text-align:right;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                    {{-- jika include_items dipilih --}}
                    @if (request('include_items'))
                        <tr>
                            <td colspan="7" style="padding: 0;">
                                <table class="nested-table"
                                    style="width:100%; border-collapse: collapse; font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th style="width:5%;">No</th>
                                            <th>Produk</th>
                                            <th style="width:10%;">Qty</th>
                                            <th style="width:14%;">Harga Satuan</th>
                                            <th style="width:14%;">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderItems as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->product->name ?? '-' }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td style="text-align:right;">Rp
                                                    {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                                <td style="text-align:right;">Rp
                                                    {{ number_format($item->subtotal, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    @endif
                @endforeach

                <tr class="total-row">
                    <td colspan="6" style="text-align: right;">Jumlah Order:</td>
                    <td style="text-align:right;">{{ number_format($jumlahOrder, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="6" style="text-align: right;">Total Transaksi:</td>
                    <td style="text-align:right;">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                </tr>
            @endif
        </tbody>
    </table>

    <p class="printed-date">
        Dicetak pada: {{ now()->timezone('Asia/Jakarta')->format('d-m-Y H:i') }} | oleh -
        {{ Auth::user()->name ?? '-' }}
    </p>
</body>
</html>
