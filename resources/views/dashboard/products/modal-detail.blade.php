<!-- Modal Detail Produk -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered"> <!-- modal-md biar gak terlalu lebar -->
        <div class="modal-content border-0 shadow-lg rounded-3 overflow-hidden">

            <!-- Header -->
            <div class="modal-header border-0 text-white p-3" style="background: #1a2035;">
                <h6 class="modal-title fw-semibold mb-0" id="detailModalLabel">
                    <i class="bi bi-info-circle me-2"></i> Detail Produk
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body p-4 text-center">

                <!-- Gambar Produk -->
                <img id="detailImage" src="" class="img-fluid rounded-0 shadow-sm mb-3"
                    style="max-height: 100px; object-fit: cover;">

                <!-- Info Produk -->
                <h5 id="detailName" class="fw-bold text-dark mb-1"></h5>
                <p id="detailDescription" class="text-secondary small mb-3"></p>

                <hr class="my-4">

                <!-- Tabel Detail -->
                <div class="table-responsive">
                    <table class="table table-borderless align-middle mb-0">
                        <tbody>
                            <tr>
                                <th class="text-muted" style="width: 120px;">Harga</th>
                                <td id="detailPrice" class="fw-semibold text-success"></td>
                            </tr>
                            <tr>
                                <th class="text-muted">Stok</th>
                                <td id="detailStock"></td>
                            </tr>
                            <tr>
                                <th class="text-muted">Kategori</th>
                                <td id="detailCategory"></td>
                            </tr>
                            <tr>
                                <th class="text-muted">Status</th>
                                <td>
                                    <span id="detailStatus" class="badge rounded-pill px-3 py-2 shadow-sm"></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#detailModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);

                $('#detailName').text(button.data('name'));
                $('#detailImage').attr('src', button.data('image') ||
                    'https://via.placeholder.com/300x250?text=No+Image');
                $('#detailDescription').text(button.data('description'));
                $('#detailPrice').text(button.data('price'));
                $('#detailStock').text(button.data('stock'));
                $('#detailCategory').text(button.data('category'));

                let status = button.data('status');
                let badge = $('#detailStatus');
                badge.text(status);
                badge.removeClass('bg-success bg-secondary')
                    .addClass(status === 'Active' ? 'bg-success' : 'bg-secondary');
            });
        });
    </script>
@endpush
