@extends('layouts.main')

@section('content')
<div class="container-fluid py-2 px-2">
    <h4 class="fw-semibold mb-0">Detail Pesanan</h4>
    <div class="p-4 bg-light rounded shadow-sm mb-4">
        <div class="row gy-3 align-items-center">
            <div class="col-md-2">
                <small class="text-muted d-block">Pelanggan</small>
                <a href="{{ route('users.show', $order->user->id) }}" class="fw-semibold text-decoration-none">
                    {{ $order->user->name }}
                </a>
            </div>
            <div class="col-md-2">
                <small class="text-muted d-block">Invoice</small>
                <span class="text-break">{{ $order->invoice ?? '-' }}</span>
            </div>
            <div class="col-md-2">
                <small class="text-muted d-block">Status Pesanan</small>
                <span class="badge bg-info text-dark">{{ ucfirst($order->order_status) }}</span>
            </div>
            <div class="col-md-2">
                <small class="text-muted d-block">Pembayaran</small>
                <span class="badge bg-success">{{ ucfirst($order->payment_status) }}</span>
            </div>
            <div class="col-md-2">
                <small class="text-muted d-block">Total</small>
                <strong>Rp{{ number_format($order->total_price, 0, ',', '.') }}</strong>
            </div>
            <div class="col-md-2">
                <small class="text-muted d-block">Catatan</small>
                <span class="text-break">{{ $order->note ?? '-' }}</span>
            </div>
        </div>
    </div>

    <h4 class="mt-4 mb-3">
        <i class="fa-solid fa-cart-shopping me-2"></i> Item dalam Pesanan
    </h4>
    <div class="card border-0 shadow-sm rounded-3 pt-3">
        <div class="card-header bg-white border-bottom">
            <strong>Detail Item Pesanan</strong>
        </div>
        <div class="card-body pt-3">
            <div class="table-responsive">
                <table id="orderItemsTable" class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Qty</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal</th>
                            <th>Desain</th>
                            <th>Upload Revisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp{{ number_format($item->unit_price, 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            <td>
                                @php $revCount = 1; @endphp
                                @forelse ($item->designs as $design)
                                    <div class="mb-1">
                                        {{-- Tampilkan badge + link hanya jika file_path ada --}}
                                        @if (!empty($design->file_path))
                                            @if ($design->type === 'initial')
                                                <span class="badge bg-primary">Desain Awal</span>
                                            @elseif ($design->type === 'revision')
                                                <span class="badge bg-warning text-dark">Revisi {{ $revCount++ }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($design->type) }}</span>
                                            @endif

                                            <a href="{{ asset('storage/' . $design->file_path) }}" target="_blank"
                                               class="text-decoration-none ms-1">Lihat</a>
                                        @endif

                                        {{-- Note tetap tampil walau file kosong --}}
                                        @if ($design->note)
                                            <div class="text-muted small">{{ $design->note }}</div>
                                        @endif
                                    </div>
                                @empty
                                    <span class="text-muted">Belum ada</span>
                                @endforelse
                            </td>
                            <td style="min-width: 220px;">
                                <form action="{{ route('orders.uploadRevision', $item->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-2">
                                        <input type="file" name="design_file" class="form-control form-control-sm" required>
                                    </div>
                                    <div class="mb-2">
                                        <select name="type" class="form-select form-select-sm">
                                            <option value="initial">Desain Awal</option>
                                            <option value="revision">Revisi</option>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <input type="text" name="note" class="form-control form-control-sm" placeholder="Catatan (opsional)">
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-outline-warning w-100">Upload</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <h4 class="mt-4 mb-3">
        <i class="fa-solid fa-clock-rotate-left me-2"></i> Riwayat Status
        {{-- <i class="fa-solid fa-list-check me-2"></i> Riwayat Status --}}
    </h4>
    @if($order->statusLogs->isEmpty())
        <p class="text-muted fst-italic">Belum ada riwayat.</p>
    @endif
    <div class="card border-0 shadow-sm rounded-3 pt-3 pb-4 mb-1">
        <div class="card-header bg-white border-bottom">
            <strong>Riwayat Status Pesanan</strong>
        </div>
        <div class="card-body pt-3">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Status</th>
                            <th>Waktu</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($order->statusLogs as $log)
                            <tr>
                                <td class="text-capitalize">
                                    <span class="badge bg-secondary">{{ $log->status }}</span>
                                </td>
                                <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    @if($log->note)
                                        {{ $log->note }}
                                    @else
                                        <span class="text-muted fst-italic">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-muted fst-italic text-center">Belum ada riwayat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Update Status Form --}}
        <div class="card-footer bg-white border-top pt-3">
            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="row gy-2 align-items-end">
                @csrf
                <div class="col-md-4">
                    <label class="form-label small mb-1">Ubah Status</label>
                    <select name="status" class="form-select form-select-sm">
                        @foreach(['pending','processed','waiting_approval','revision','production','done','canceled'] as $status)
                            <option value="{{ $status }}" {{ $order->order_status === $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label small mb-1">Catatan (opsional)</label>
                    <input type="text" name="note" class="form-control form-control-sm" placeholder="Contoh: silahkan tunggu proses produksi 1-2 hari kedepan.">
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-sm btn-outline-primary mt-3">Update</button>
                </div>
            </form>
        </div>
    </div>

</div>

@push('scripts')
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            title: 'Success!',
            text: "{{ session('success') }}",
            icon: 'success'
        });
    });
</script>
@endif
@endpush

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#orderItemsTable').DataTable({
            responsive: true,
            paging: true,
            info: false
        });
    });
</script>
@endpush