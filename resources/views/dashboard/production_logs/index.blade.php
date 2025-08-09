@extends('layouts.main')

@section('content')
<div class="container py-3 px-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-semibold mb-0">Log Produksi</h4>
        <a href="{{ route('production-logs.create') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Log Produksi
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3 pt-4 mb-1">
        <div class="card-body">
            @if($logs->count() > 0)
            <div class="table-responsive">
                <table id="productionLogTable" class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Bahan</th>
                            <th>Jumlah Digunakan</th>
                            <th>Waktu</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-medium text-dark">{{ $log->stock->name ?? '-' }}</td>
                            <td>{{ $log->quantity_used }} {{ $log->stock->unit ?? '' }}</td>
                            <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                            <td class="text-center">
                                <a href="{{ route('production-logs.edit', $log->id) }}" class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('production-logs.destroy', $log->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus log ini dan kembalikan stok?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <div class="text-center text-muted py-5">
                    Belum ada log produksi yang tercatat.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#productionLogTable').DataTable({
            responsive: true,
            paging: true,
            info: false
        });
    });
</script>
@endpush
