@extends('layouts.main')

@section('content')
<div class="container-fluid py-2 px-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-semibold mb-0">Product List</h3>
        <a href="{{ route('products.create') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Add Product
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-3 pt-4 mb-1">
        <div class="card-body">
            <div class="table-responsive">
                <table id="productTable" class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 40px;">No</th>
                            <th>Name</th>
                            <th style="width: 70px;">Image</th>
                            <th>Price</th>
                            <th>Stock Product</th>
                            <th style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $i => $product)
                        <tr id="product-{{ $product->id }}">
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $product->name }}</td>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Image" class="rounded" width="50" height="50" style="object-fit: cover;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td><strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong></td>
                            <td><span class="text-dark">{{ $product->stock_barang ?? 0 }}</span></td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center gap-1">
                                    <button class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailModal"
                                        data-name="{{ $product->name }}"
                                        data-image="{{ $product->image ? asset('storage/' . $product->image) : '' }}"
                                        data-description="{{ $product->description }}"
                                        data-price="Rp {{ number_format($product->price, 0, ',', '.') }}"
                                        data-stock="{{ $product->stock_barang ?? 0 }}"
                                        data-category="{{ $product->category->name ?? '-' }}"
                                        data-status="{{ $product->is_active ? 'Active' : 'Inactive' }}">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST"
                                        class="d-inline-block m-0 p-0">
                                      @csrf
                                      @method('DELETE')
                                      <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-id="{{ $product->id }}" title="Delete">
                                          <i class="bi bi-trash"></i>
                                      </button>
                                  </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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

@include('dashboard/products/modal-detail')

@push('scripts')
<script>
    $(document).ready(function() {
        $('#productTable').DataTable({
            responsive: true
        });

        $('.btn-delete').click(function() {
            const categoryId = $(this).data('id');
            Swal.fire({
                title: 'Delete this product?',
                text: "You can't undo this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#31CE36',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete-form-' + categoryId).submit();
                }
            });
        });
    });
</script>
@endpush
