@extends('layouts.main')

@section('content')
<div class="container-fluid py-2 px-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-semibold mb-0">Daftar Stok</h4>
        <a href="{{ route('stocks.create') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Stok
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3 pt-4 mb-1">
        <div class="card-body">
            <div class="table-responsive">
                <table id="stockTable" class="table align-middle table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama</th>
                            <th>Satuan</th>
                            <th>Jumlah</th>
                            <th class="text-center" style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stocks as $i => $stock)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td class="fw-medium text-dark">{{ $stock->name }}</td>
                            <td>{{ $stock->unit }}</td>
                            <td>{{ $stock->quantity }}</td>
                            <td class="text-center">
                                <a href="{{ route('stocks.edit', $stock->id) }}" class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin hapus stok ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach

                        @if($stocks->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center text-muted py-6">
                                Data stok belum tersedia.
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#stockTable').DataTable({
            responsive: true,
            paging: true,
            info: false
        });
    });
</script>
@endpush
