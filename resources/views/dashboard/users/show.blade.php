@extends('layouts.main')

@section('content')
<div class="container-fluid px-2 mt-4">
    <div class="card border-0 shadow-sm rounded-3 mx-auto" style="max-width: 600px;">
        <div class="card-header bg-white border-bottom d-flex align-items-center">
            <i class="bi bi-person-circle fs-4 me-2"></i>
            <strong>Detail Pengguna</strong>
        </div>

        <div class="card-body">
            <div class="text-center mb-4">
                @if ($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" class="rounded-circle" alt="Foto Pengguna" width="100" height="100">
                @else
                    <i class="bi bi-person-circle text-secondary" style="font-size: 100px;"></i>
                @endif
                <h5 class="mt-2 mb-0">{{ $user->name }}</h5>
                <div class="text-muted">{{ ucfirst($user->role) }}</div>
            </div>

            <table class="table table-borderless mb-0">
                <tbody>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>{{ $user->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Dibuat</th>
                        <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white text-end">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
