@extends('backend.layout.app')

@section('title', 'Colors')
@section('page_heading', 'Colors')

@section('content')
    <div class="dash-card mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h2 class="dash-title mb-1">Colors</h2>
            <p class="dash-subtitle mb-0">Manage diamond color grades (e.g. D, E, F, M, L)</p>
        </div>
        <a href="{{ route('colors.create') }}" class="btn btn-gold">
            <i class="bi bi-plus-lg me-1"></i> Add Color
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="card panel-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Color Name</th>
                            <th width="160">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($colors as $color)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $color->name ?: '—' }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('colors.edit', $color->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('colors.destroy', $color->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this color?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted-small">
                                    No colors found. <a href="{{ route('colors.create') }}" class="auth-link">Add your first color</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
