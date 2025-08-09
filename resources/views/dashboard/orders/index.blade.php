@extends('layouts.main')

@section('content')
<div class="container-fluid py-2 px-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-semibold mb-0">Order List</h3>
        {{-- Form Filter Status --}}
        <form id="filterForm" method="GET" action="{{ route('orders.index') }}" class="d-flex align-items-center gap-2">
            {{-- <label for="filter_status" class="mb-0">Filter by Status:</label> --}}
            <select name="status" id="filter_status" class="form-select" style="width: 200px;">
                <option value="">Select a status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processed" {{ request('status') == 'processed' ? 'selected' : '' }}>Processed</option>
                <option value="waiting_approval" {{ request('status') == 'waiting_approval' ? 'selected' : '' }}>Waiting Approval</option>
                <option value="revision" {{ request('status') == 'revision' ? 'selected' : '' }}>Revision</option>
                <option value="production" {{ request('status') == 'production' ? 'selected' : '' }}>Production</option>
                <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Done</option>
                <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Canceled</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            @if(request('status'))
                <a href="{{ route('orders.index') }}" class="btn btn-secondary btn-sm">Reset</a>
            @endif
        </form>
    </div>

        <div class="card border-0 shadow-sm rounded-3 pt-4 mb-1">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="orderTable" class="table align-middle table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Pelanggan</th>
                                <th>Invoice</th>
                                <th>Status</th>
                                <th>Pembayaran</th>
                                <th>Total</th>
                                {{-- <th>Waktu</th> --}}
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->invoice }}</td>
                                    <td><span class="badge bg-info text-dark">{{ ucfirst($order->order_status) }}</span></td>
                                    <td><span class="badge bg-secondary">{{ ucfirst($order->payment_status) }}</span></td>
                                    <td>Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    {{-- <td>{{ $order->created_at->format('d M Y H:i') }}</td> --}}
                                    <td>
                                        <a href="{{ route('orders.show', $order->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted fst-italic">Belum ada order.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#orderTable').DataTable({
                responsive: true,
                paging: true,
                info: false
            });
        });
    </script>
@endpush
