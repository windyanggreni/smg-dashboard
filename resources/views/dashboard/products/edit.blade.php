@extends('layouts.main')

@section('content')
<div class="container py-3 px-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-semibold mb-0">Edit Product</h4>
        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="card border-0 shadow-sm rounded-3 p-4 mb-1">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text"
                   name="name"
                   id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $product->name) }}"
                   required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Image Upload --}}
        <div class="mb-3">
            <label for="image" class="form-label">New Image (optional)</label>
            <input type="file"
                   name="image"
                   id="image"
                   class="form-control @error('image') is-invalid @enderror">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        @if($product->image)
        <div class="mb-3">
            <label class="form-label">Current Image</label><br>
            <img src="{{ asset('storage/' . $product->image) }}"
                 alt="Current Product Image"
                 class="rounded shadow-sm border"
                 style="max-width: 150px;">
        </div>
        @endif

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description"
                      id="description"
                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price (Rp)</label>
            <input type="number"
                   step="0.01"
                   name="price"
                   id="price"
                   class="form-control @error('price') is-invalid @enderror"
                   value="{{ old('price', $product->price) }}"
                   required>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="stock_barang" class="form-label">Stock Barang</label>
            <input type="number"
                   name="stock_barang"
                   id="stock_barang"
                   class="form-control @error('stock_barang') is-invalid @enderror"
                   value="{{ old('stock_barang', $product->stock_barang) }}"
                   min="0"
                   required>
            @error('stock_barang')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id"
                    id="category_id"
                    class="form-select @error('category_id') is-invalid @enderror">
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Hidden input in case checkbox is unchecked --}}
        <input type="hidden" name="is_active" value="0">
        <div class="form-check form-switch mb-3">
            <input type="checkbox"
                   class="form-check-input"
                   name="is_active"
                   id="is_active"
                   value="1"
                   {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
        </div>

        <div class="d-flex justify-content-start gap-2">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-pencil-square me-1"></i> Update
            </button>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#category_id').select2({
            placeholder: "-- Select Category --",
            allowClear: true
        });
    });
</script>
@endpush
