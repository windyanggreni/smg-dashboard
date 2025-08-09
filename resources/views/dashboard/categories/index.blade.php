@extends('layouts.main')

@section('content')
<div class="container-fluid py-2 px-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-semibold mb-0">Category List</h3>
        <a href="{{ route('categories.create') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Add Category
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-3 pt-4 mb-1">
        <div class="card-body">
            <div class="table-responsive">
                <table id="categoryTable" class="table align-middle table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $i => $category)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td class="fw-medium text-dark">{{ $category->name }}</td>
                            <td class="text-muted">{{ $category->description }}</td>
                            <td class="text-center">
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form id="delete-form-{{ $category->id }}" action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-id="{{ $category->id }}" title="Delete">
                                        <i class="bi bi-trash"></i>
                                      </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @if($categories->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center text-muted py-6">
                                No categories available.
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: 'Good job!',
                text: "{{ session('success') }}",
                icon: 'success'
            });
        });
    </script>
@endif

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#categoryTable').DataTable({
            responsive: true,
            paging: true,
            info: false
        });

        $('.btn-delete').click(function() {
            const categoryId = $(this).data('id');
            Swal.fire({
                title: 'Delete this category?',
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
