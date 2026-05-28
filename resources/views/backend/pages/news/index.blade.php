@extends('backend.layout.app')

@section('title', 'News & Events')
@section('page_heading', 'News & Events')

@section('content')
    <div class="dash-card mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h2 class="dash-title mb-1">News & Events</h2>
            <p class="dash-subtitle mb-0">Manage news and events posts</p>
        </div>
        <a href="{{ route('news.create') }}" class="btn btn-gold">
            <i class="bi bi-plus-lg me-1"></i> Add News/Event
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
                        @forelse($newsItems as $news)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($news->feature_image)
                                        <img src="{{ asset('storage/'.$news->feature_image) }}" class="slider-thumb" alt="{{ $news->title }}">
                                    @else
                                        <span class="text-muted-small">—</span>
                                    @endif
                                </td>
                                <td>{{ $news->title }}</td>
                                <td>{{ $news->category?->name ?? '—' }}</td>
                                <td>
                                    @if($news->status === 'active')
                                        <span class="badge badge-active">Active</span>
                                    @else
                                        <span class="badge badge-inactive">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ optional($news->published_at)->format('d M Y') ?? '—' }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if($news->status === 'active')
                                            <a href="{{ route('news-events.show', $news->slug) }}" class="btn btn-sm btn-outline-dark-auth" target="_blank" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('news.edit', $news->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('news.destroy', $news->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this item?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted-small">No news/events found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

