@extends('layouts.main')

@section('content')
<div class="container-fluid py-2 px-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-semibold mb-0">Users Management</h3>
        <a href="{{ route('users.create') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Create New User
        </a>
    </div>

    {{-- ADMIN LIST --}}
    <div class="card mb-4">
        <div class="card-header pt-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Admin</h5>
        </div>
        <div class="card-body pt-4">
            <div class="table-responsive">
                <table id="adminTable" class="table table-hover table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($admins as $i => $admin)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">{{ ucfirst($admin->role) }}</span>
                                </td>
                                <td>
                                    @if ($admin->photo)
                                        <img src="{{ asset('storage/' . $admin->photo) }}" alt="Photo" class="rounded-circle" width="45" height="45" style="object-fit: cover;">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('users.edit', $admin->id) }}" class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form id="delete-form-{{ $admin->id }}" action="{{ route('users.destroy', $admin->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-id="{{ $admin->id }}" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted">Tidak ada admin</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer py-2">
        </div>
    </div>

    {{-- CUSTOMER LIST --}}
    <div class="card mb-1">
        <div class="card-header pt-4">
            <h5 class="mb-0">Daftar Customer</h5>
        </div>
        <div class="card-body pt-4">
            <div class="table-responsive">
                <table id="customerTable" class="table table-hover table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $i => $customer)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ ucfirst($customer->role) }}</span>
                                </td>
                                <td>
                                    @if ($customer->photo)
                                        <img src="{{ asset('storage/' . $customer->photo) }}" alt="Photo" class="rounded-circle" width="45" height="45" style="object-fit: cover;">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <form id="delete-form-{{ $customer->id }}" action="{{ route('users.destroy', $customer->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-id="{{ $customer->id }}" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted">Tidak ada customer</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer py-2">
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

@push('scripts')
<script>
     $(document).ready(function () {
        $('#adminTable').DataTable();
        $('#customerTable').DataTable();

        $('.btn-delete').click(function() {
            const categoryId = $(this).data('id');
            Swal.fire({
                title: 'Delete this account?',
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