@extends('layouts.main')

@section('content')
<div class="container py-3 px-2">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h4 class="fw-semibold">Add New Stock</h4>
        <a href="{{ route('stocks.index') }}" class="btn btn-secondary btn-sm mt-2">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('stocks.store') }}" method="POST" class="card border-0 shadow-sm rounded-3 p-4 mb-1">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Bahan</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" required placeholder="Contoh: Tinta Hitam">
        </div>

        <div class="mb-3">
            <label for="unit" class="form-label">Satuan</label>
            <input type="text" id="unit" name="unit" value="{{ old('unit') }}" class="form-control" required placeholder="Contoh: Botol, Dus, Kg">
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Jumlah Awal</label>
            <input type="number" id="quantity" name="quantity" value="{{ old('quantity', 0) }}" class="form-control" min="0" required>
        </div>

        {{-- <button type="submit" class="btn btn-primary">
            <i class="bi bi-save me-1"></i> Simpan
        </button> --}}
        <div class="d-flex justify-content-start gap-2">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save me-1"></i> Save
            </button>
            <a href="{{ route('stocks.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
