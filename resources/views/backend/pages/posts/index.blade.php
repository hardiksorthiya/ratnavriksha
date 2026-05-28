@extends('backend.layout.app')

@section('title', 'Posts')
@section('page_heading', 'Posts')

@section('content')
    <div class="dash-card mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h2 class="dash-title mb-1">Post List</h2>
            <p class="dash-subtitle mb-0">Manage blog posts</p>
        </div>
        <a href="{{ route('posts.create') }}" class="btn btn-gold">
            <i class="bi bi-plus-lg me-1"></i> Add Post
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
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Published</th>
                            <th width="190">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($post->feature_image)
                                        <img src="{{ asset('storage/'.$post->feature_image) }}" class="slider-thumb" alt="{{ $post->title }}">
                                    @else
                                        <span class="text-muted-small">—</span>
                                    @endif
                                </td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->category?->name ?? '—' }}</td>
                                <td>
                                    @if($post->status === 'active')
                                        <span class="badge badge-active">Active</span>
                                    @else
                                        <span class="badge badge-inactive">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ optional($post->published_at)->format('d M Y') ?? '—' }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if($post->status === 'active')
                                            <a href="{{ route('blogs.show', $post->slug) }}" class="btn btn-sm btn-outline-dark-auth" target="_blank" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this post?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted-small">No posts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

