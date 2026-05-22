@extends('backend.layout.app')

@section('title', 'Clarities')
@section('page_heading', 'Clarities')

@section('content')
    <div class="dash-card mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h2 class="dash-title mb-1">Clarities</h2>
            <p class="dash-subtitle mb-0">Manage diamond clarity grades (e.g. FL, VVS1, VS1, SI1)</p>
        </div>
        <a href="{{ route('clarities.create') }}" class="btn btn-gold">
            <i class="bi bi-plus-lg me-1"></i> Add Clarity
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
                            <th>Clarity Name</th>
                            <th width="160">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clarities as $clarity)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $clarity->name ?: '—' }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('clarities.edit', $clarity->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('clarities.destroy', $clarity->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this clarity?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted-small">
                                    No clarities found. <a href="{{ route('clarities.create') }}" class="auth-link">Add your first clarity</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
