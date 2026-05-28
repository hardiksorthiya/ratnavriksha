@extends('backend.layout.app')

@section('title', 'Post Categories')
@section('page_heading', 'Post Categories')

@section('content')
    <div class="dash-card mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h2 class="dash-title mb-1">Post Categories</h2>
            <p class="dash-subtitle mb-0">Manage blog categories</p>
        </div>
        <a href="{{ route('post-categories.create') }}" class="btn btn-gold">
            <i class="bi bi-plus-lg me-1"></i> Add Category
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
                            <th>Name</th>
                            <th>Slug</th>
                            <th width="160">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('post-categories.edit', $category->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('post-categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted-small">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

