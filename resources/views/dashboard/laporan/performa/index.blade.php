<div class="card border-0 shadow-sm p-3">
    <h5 class="mb-2 mt-3">Laporan Performa Penjualan</h5>
    <hr>

    <form action="{{ route('laporan.performa.pdf') }}" method="GET" target="_blank">
        <div class="row g-3 align-items-end">

            <div class="col-md-4">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" class="form-control" required
                    value="{{ request('start_date') }}">
            </div>

            <div class="col-md-4">
                <label for="end_date" class="form-label">Tanggal Selesai</label>
                <input type="date" name="end_date" id="end_date" class="form-control" required
                    value="{{ request('end_date') }}">
            </div>

            <div class="col-md-4">
                <label for="sort" class="form-label">Urutkan Berdasarkan</label>
                <select name="sort" id="sort" class="form-select">
                    <option value="terlaris" {{ request('sort') == 'terlaris' ? 'selected' : '' }}>Produk Terlaris
                    </option>
                    <option value="omzet" {{ request('sort') == 'omzet' ? 'selected' : '' }}>Omzet Tertinggi</option>
                    <option value="paling_jarang" {{ request('sort') == 'paling_jarang' ? 'selected' : '' }}>Paling
                        Jarang</option>
                </select>
            </div>

            <div class="col-md-12">
                <label for="category_id" class="form-label">
                    Kategori Produk<span style="font-size: 0.85em; color: #888; font-style: italic;">
                        (Leave unselected to show all type)
                    </span>
                </label>
                <select name="category_id[]" id="category_id" class="form-select select2" multiple>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ is_array(request('category_id')) && in_array($cat->id, request('category_id')) ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-12 mt-3">
                <input class="form-check-input" type="checkbox" name="show_all_products" id="show_all_products"
                    value="1" {{ request('show_all_products') ? 'checked' : '' }}>
                <label class="form-check-label" for="show_all_products">
                    Tampilkan semua produk (termasuk yang tidak terjual)
                </label>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf-fill"></i> Cetak Laporan Performa
            </button>
        </div>
    </form>
</div>
