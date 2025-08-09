{{-- resources/views/dashboard/laporan/laporan-transaksi.blade.php --}}

<div class="card border-0 shadow-sm p-3">
    <h5 class="mb-2 mt-3">Laporan Transaksi</h5>
    <hr>

    <form action="{{ route('laporan.transaksi.pdf') }}" method="GET" target="_blank">
        <div class="row g-3 align-items-end">

            <div class="col-md-4">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label for="end_date" class="form-label">Tanggal Selesai</label>
                <input type="date" name="end_date" id="end_date" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label for="sort" class="form-label">Urutkan Berdasarkan</label>
                <select name="sort" id="sort" class="form-select">
                    <option value="latest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                    <option value="highest_price">Harga Tertinggi</option>
                    <option value="lowest_price">Harga Terendah</option>
                </select>
            </div>

            <div class="col-md-6">
                <label for="status" class="form-label">
                    Status Order <span style="font-size: 0.85em; color: #888; font-style: italic;">
                        (Leave unselected to show all type)
                    </span>
                </label>
                <select name="status[]" id="status" class="form-select select2" multiple>
                    @foreach (['pending', 'processed', 'waiting_approval', 'revision', 'production', 'done', 'canceled'] as $s)
                        <option value="{{ $s }}"
                            {{ collect(request('status'))->contains($s) ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $s)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="payment_status" class="form-label">
                    Status Pembayaran <span style="font-size: 0.85em; color: #888; font-style: italic;">
                        (Leave unselected to show all type)
                    </span>
                </label>
                <select name="payment_status[]" id="payment_status" class="form-select select2" multiple>
                    <option value="paid_dp"
                        {{ collect(request('payment_status'))->contains('paid_dp') ? 'selected' : '' }}>Paid (DP)
                    </option>
                    <option value="paid_full"
                        {{ collect(request('payment_status'))->contains('paid_full') ? 'selected' : '' }}>Paid Full
                    </option>
                    <option value="unpaid"
                        {{ collect(request('payment_status'))->contains('unpaid') ? 'selected' : '' }}>Unpaid</option>
                    <option value="failed"
                        {{ collect(request('payment_status'))->contains('failed') ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
        </div>

        <div class="col-md-12 mt-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="include_items" id="include_items" value="1"
                    {{ request('include_items') ? 'checked' : '' }}>
                <label class="form-check-label" for="include_items">
                    Sertakan detail item pesanan
                </label>
            </div>
        </div>


        <div class="mt-4">
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf-fill"></i> Cetak Laporan Transaksi
            </button>
        </div>
    </form>
</div>

