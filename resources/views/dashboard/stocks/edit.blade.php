@extends('layouts.main')

@section('content')
<div class="container py-3 px-2">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h4 class="fw-semibold">Edit Stocks</h4>
        <a href="{{ route('stocks.index') }}" class="btn btn-secondary btn-sm">
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

    <form action="{{ route('stocks.update', $stock->id) }}" method="POST" class="card border-0 shadow-sm rounded-3 p-4">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama Bahan</label>
            <input type="text" id="name" name="name" value="{{ old('name', $stock->name) }}" class="form-control" required placeholder="Contoh: Tinta Hitam">
        </div>

        <div class="mb-3">
            <label for="unit" class="form-label">Satuan</label>
            <input type="text" id="unit" name="unit" value="{{ old('unit', $stock->unit) }}" class="form-control" required placeholder="Contoh: Botol, Dus, Kg">
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Jumlah</label>
            <input type="number" id="quantity" name="quantity" value="{{ old('quantity', $stock->quantity) }}" class="form-control" min="0" required>
        </div>

        {{-- <button type="submit" class="btn btn-warning">
            <i class="bi bi-pencil-square me-1"></i> Update
        </button> --}}
        <div class="d-flex justify-content-start gap-2">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-pencil-square me-1"></i> Update
            </button>
            <a href="{{ route('stocks.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
