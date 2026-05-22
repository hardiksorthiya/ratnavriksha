@extends('backend.layout.app')

@section('title', 'Shapes')
@section('page_heading', 'Shapes')

@section('content')
    <div class="dash-card mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h2 class="dash-title mb-1">Shapes</h2>
            <p class="dash-subtitle mb-0">Manage shapes</p>
        </div>
        <a href="{{ route('shapes.create') }}" class="btn btn-gold">
            <i class="bi bi-plus-lg me-1"></i> Add Shape
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
                            <th>Image</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th width="160">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($shapes as $shape)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    @if($shape->image)
                                        <img src="{{ asset('storage/'.$shape->image) }}" class="slider-thumb" alt="Image">
                                    @else
                                        <span class="text-muted-small">—</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $shape->name ?? '—' }}</td>
                                <td>{{ $shape->slug ?? '—' }}</td>
                                <td>
                                    @if($shape->status === 'active')
                                        <span class="badge badge-active">Active</span>
                                    @elseif($shape->status === 'inactive')
                                        <span class="badge badge-inactive">Inactive</span>
                                    @else
                                        <span class="text-muted-small">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('shapes.edit', $shape->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('shapes.destroy', $shape->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this shape?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted-small">No shapes found. <a href="{{ route('shapes.create') }}" class="auth-link">Add your first shape</a></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
