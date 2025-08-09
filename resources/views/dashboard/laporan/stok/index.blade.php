<div class="card border-0 shadow-sm p-3">
    <h5 class="mb-2 mt-3">Laporan Stok Barang</h5>
    <hr>

    <form action="{{ route('laporan.stok.pdf') }}" method="GET" target="_blank">
        <div class="row g-3 align-items-end">

            <div class="col-md-12">
                <label for="sort" class="form-label">Urutkan Berdasarkan</label>
                <select name="sort" id="sort" class="form-select">
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama Produk (A-Z)</option>
                    <option value="stock_desc" {{ request('sort') == 'stock_desc' ? 'selected' : '' }}>Stok Terbanyak
                    </option>
                    <option value="stock_asc" {{ request('sort') == 'stock_asc' ? 'selected' : '' }}>Stok Tersedikit
                    </option>
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
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf-fill"></i> Cetak Laporan Stok
            </button>
        </div>
    </form>
</div>
