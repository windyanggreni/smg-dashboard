@extends('layouts.main')

@section('content')
<div class="container py-3 px-2">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h4 class="fw-semibold">Input Log Produksi</h4>
        <a href="{{ route('production-logs.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('production-logs.store') }}" method="POST" class="card border-0 shadow-sm rounded-3 p-4 mb-1">
        @csrf

        {{-- Pilih Stok --}}
        <div class="mb-3">
            <label for="stok_id" class="form-label">Bahan yang Digunakan</label>
            <select id="stok_id" name="stok_id" class="form-select @error('stok_id') is-invalid @enderror" required>
                <option value="">-- Pilih --</option>
                @foreach ($stocks as $stock)
                    <option value="{{ $stock->id }}"
                        data-quantity="{{ $stock->quantity }}"
                        data-unit="{{ $stock->unit }}"
                        {{ old('stok_id') == $stock->id ? 'selected' : '' }}>
                        {{ $stock->name }} (Sisa: {{ $stock->quantity }} {{ $stock->unit }})
                    </option>
                @endforeach
            </select>
            @error('stok_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tampilkan Sisa Stok --}}
        <div class="mb-3">
            <label for="stock_quantity" class="form-label">Sisa Stok</label>
            <input type="text" id="stock_quantity" class="form-control" readonly>
        </div>

        {{-- Jumlah Digunakan --}}
        <div class="mb-3">
            <label for="quantity_used" class="form-label">Jumlah yang digunakan</label>
            <input type="number" id="quantity_used" name="quantity_used" min="1"
                value="{{ old('quantity_used') }}"
                class="form-control @error('quantity_used') is-invalid @enderror"
                required>
            @error('quantity_used')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-start gap-2">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save me-1"></i> Save
            </button>
            <a href="{{ route('production-logs.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#stok_id').select2({
            placeholder: "-- Pilih --",
            allowClear: true,
            width: '100%' // biar gak menghilangkan border
        });

        // Event select2 change pakai jQuery
        $('#stok_id').on('change', function () {
            const selected = $(this).find('option:selected');
            const qty = selected.data('quantity');
            const unit = selected.data('unit');
            $('#stock_quantity').val(qty ? `${qty} ${unit}` : '');
        });

        // Trigger di awal jika sudah ada pilihan sebelumnya
        $('#stok_id').trigger('change');
    });
</script>
@endpush
