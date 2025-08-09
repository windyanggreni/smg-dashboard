{{-- filepath: /e:/COOLYEAH/LAST_SEMESTER/TA/smg-dashboard/resources/views/index.blade.php --}}
@extends('layouts.main')

@section('content')
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Saudara Mandiri Group Dashboard</h3>
            <h6 class="op-7 mb-2">Welcome to Saudara Mandiri Group Dashboard - Smart control for modern advertising.</h6>
        </div>
    </div>
    <div class="row">
        <!-- Total Pelanggan -->
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Total Pelanggan</p>
                                <h4 class="card-title" style="font-size: 15px;">{{ $totalCustomers }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pesanan Aktif -->
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-info bubble-shadow-small">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Pesanan Aktif</p>
                                <h4 class="card-title" style="font-size: 15px;">{{ $activeOrders }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pesanan Selesai Bulan Ini -->
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Pesanan Selesai</p>
                                <h4 class="card-title" style="font-size: 15px;">{{ $completedOrdersThisMonth }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pendapatan Bulan Ini -->
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-warning bubble-shadow-small">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Pendapatan </p>
                                <h4 class="card-title" style="font-size: 15px;">Rp {{ number_format($totalRevenueThisMonth, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <!-- Produk Terlaris -->
        <div class="col-md-4">
            <div class="card card-round">
                <div class="card-body">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title fs-5">Produk Terlaris Bulan Ini</div>
                        <div class="card-tools">
                            <div class="dropdown">
                                <button class="btn btn-icon btn-clean me-0" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item"  href="{{ route('products.index') }}">Lihat Detail Produk</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-list py-4">
                        @foreach($topProducts as $item)
                            <div class="item-list">
                                <div class="avatar">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                             alt="{{ $item->product->name }}"
                                             class="avatar-img rounded-circle" />
                                    @else
                                        <span class="avatar-title rounded-circle border border-white bg-secondary">
                                            {{ strtoupper(substr($item->product->name, 0, 1)) }}
                                        </span>
                                    @endif
                                </div>
                                <div class="info-user ms-3">
                                    <div class="username" style="white-space: normal; word-break: break-word; max-width: 200px; line-height: 1.2em;">
                                        {{ $item->product->name }}
                                    </div>
                                    <div class="status">Terjual {{ $item->total_sold }} pcs</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaksi Pembayaran -->
        <div class="col-md-8">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Transaksi Pembayaran</div>
                        <div class="card-tools">
                            <div class="dropdown">
                                <button class="btn btn-icon btn-clean me-0" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('orders.index') }}">Lihat Detail Orders</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Payment Number</th>
                                    <th scope="col" class="text-end">Date & Time</th>
                                    <th scope="col" class="text-end">Amount</th>
                                    <th scope="col" class="text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <th scope="row" style="vertical-align: middle;">
                                            <div style="display: flex; align-items: center;">
                                              <button class="btn btn-icon btn-round btn-success btn-sm me-2" style="flex-shrink: 0;">
                                                <i class="fa fa-check"></i>
                                              </button>
                                              <div style="line-height: 1.2;">
                                                Payment #{{ $order->invoice }}
                                              </div>
                                            </div>
                                          </th>
                                          <td>{{ $order->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}</td>
                                        <td class="text-end">
                                            Rp{{ number_format($order->total_price, 0, ',', '.') }}
                                        </td>
                                        <td class="text-end">
                                            @php
                                                $statusClass = match($order->payment_status) {
                                                    'paid', 'paid_full' => 'badge-success',
                                                    'paid_dp' => 'badge-warning',
                                                    default => 'badge-secondary'
                                                };
                                            @endphp
                                            <span class="badge {{ $statusClass }}">
                                                {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
