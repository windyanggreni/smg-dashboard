@extends('layouts.main')

@section('content')
<div class="container py-3 px-2">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h4 class="fw-semibold">Edit Log Produksi</h4>
        <a href="{{ route('production-logs.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <form action="{{ route('production-logs.update', $productionLog->id) }}" method="POST" class="card border-0 shadow-sm rounded-3 p-4">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="stok_id" class="form-label">Bahan</label>
            <select
                id="stok_id"
                name="stok_id"
                class="form-select @error('stok_id') is-invalid @enderror"
                required
            >
                <option value="">-- Pilih --</option>
                @foreach($stocks as $stock)
                    <option value="{{ $stock->id }}" {{ old('stok_id', $productionLog->stok_id) == $stock->id ? 'selected' : '' }}>
                        {{ $stock->name }} ({{ $stock->unit }})
                    </option>
                @endforeach
            </select>
            @error('stok_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="quantity_used" class="form-label">Jumlah yang digunakan</label>
            <input
                type="number"
                id="quantity_used"
                name="quantity_used"
                value="{{ old('quantity_used', $productionLog->quantity_used) }}"
                class="form-control @error('quantity_used') is-invalid @enderror"
                min="1"
                required
            >
            @error('quantity_used')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- <button type="submit" class="btn btn-success">
            <i class="bi bi-pencil-square me-1"></i> Update Log
        </button> --}}
        <div class="d-flex justify-content-start gap-2">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-pencil-square me-1"></i> Update
            </button>
            <a href="{{ route('production-logs.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#stok_id').select2({
            placeholder: "-- Select Category --",
            allowClear: true
        });
    });
</script>
@endpush