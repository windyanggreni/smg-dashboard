@extends('layouts.main')

@section('content')
    <div class="container-fluid py-2 px-2">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-semibold mb-0">Manajemen Laporan</h3>
        </div>

        <ul class="nav nav-tabs" id="laporanTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="transaksi-tab" data-bs-toggle="tab" data-bs-target="#transaksi"
                    type="button" role="tab" aria-controls="transaksi" aria-selected="true">Laporan Transaksi</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="stok-tab" data-bs-toggle="tab" data-bs-target="#stok" type="button"
                    role="tab" aria-controls="stok" aria-selected="false">Laporan Stok Barang</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="penjualan-tab" data-bs-toggle="tab" data-bs-target="#penjualan" type="button"
                    role="tab" aria-controls="penjualan" aria-selected="false">Laporan Performa Penjualan</button>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="transaksi" role="tabpanel" aria-labelledby="transaksi-tab">
                @include('dashboard.laporan.transaksi.index')
            </div>

            <div class="tab-pane fade" id="stok" role="tabpanel" aria-labelledby="stok-tab">
                @include('dashboard.laporan.stok.index')
            </div>

            <div class="tab-pane fade" id="penjualan" role="tabpanel" aria-labelledby="penjualan-tab">
                @include('dashboard.laporan.performa.index')
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Semua",
                allowClear: true,
                width: '100%'
            });

            // Saat tab aktif berganti
            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                var target = $(e.target).data('bsTarget');
                $(target).find('select.select2').each(function() {
                    if (!$(this).hasClass("select2-hidden-accessible")) {
                        // Belum diinisialisasi, jadi init
                        $(this).select2({
                            placeholder: "Semua",
                            allowClear: true,
                            width: '100%'
                        });
                    }
                });
            });
        });
    </script>
@endpush
