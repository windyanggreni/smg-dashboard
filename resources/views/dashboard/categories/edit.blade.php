@extends('layouts.main')

@section('content')
<div class="container py-3 px-2">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h4 class="fw-semibold">Edit Category</h4>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="card border-0 shadow-sm rounded-3 p-4 mb-1">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input
                type="text"
                id="name"
                name="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $category->name) }}"
                required
                autofocus
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description (optional)</label>
            <textarea
                id="description"
                name="description"
                rows="4"
                class="form-control"
            >{{ old('description', $category->description) }}</textarea>
        </div>

        {{-- <button type="submit" class="btn btn-success">
            <i class="bi bi-pencil-square me-1"></i> Update
        </button> --}}
        <div class="d-flex justify-content-start gap-2">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-pencil-square me-1"></i> Update
            </button>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
