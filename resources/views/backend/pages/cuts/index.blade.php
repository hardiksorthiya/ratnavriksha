@extends('backend.layout.app')

@section('title', 'Cuts')
@section('page_heading', 'Cuts')

@section('content')
    <div class="dash-card mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h2 class="dash-title mb-1">Cuts</h2>
            <p class="dash-subtitle mb-0">Manage diamond cut grades (e.g. Excellent, Very Good, Good)</p>
        </div>
        <a href="{{ route('cuts.create') }}" class="btn btn-gold">
            <i class="bi bi-plus-lg me-1"></i> Add Cut
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
                            <th>Cut Name</th>
                            <th width="160">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cuts as $cut)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $cut->name ?: '—' }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('cuts.edit', $cut->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('cuts.destroy', $cut->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this cut?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted-small">
                                    No cuts found. <a href="{{ route('cuts.create') }}" class="auth-link">Add your first cut</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
