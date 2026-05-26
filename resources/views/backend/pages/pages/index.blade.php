@extends('backend.layout.app')

@section('title', 'Static Pages')
@section('page_heading', 'Static Pages')

@section('content')
    <div class="dash-card mb-4">
        <h2 class="dash-title mb-1">Static Pages</h2>
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
                            <th>BG</th>
                            <th>Page</th>
                            <th>URL</th>
                            <th>Label</th>
                            <th>Blade</th>
                            <th>Status</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pages as $page)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($page->bg_image)
                                        <img src="{{ asset('storage/'.$page->bg_image) }}" class="slider-thumb" alt="">
                                    @else
                                        <span class="text-muted-small">—</span>
                                    @endif
                                </td>
                                <td>{{ $page->name }}</td>
                                <td><code>/{{ $page->slug }}</code></td>
                                <td>{{ $page->label ?? '—' }}</td>
                                <td>
                                    @if(view()->exists('frontend.pages.'.$page->slug))
                                        <span class="badge badge-active">OK</span>
                                    @else
                                        <span class="badge badge-inactive">Missing blade</span>
                                    @endif
                                </td>
                                <td>
                                    @if($page->status === 'active')
                                        <span class="badge badge-active">Active</span>
                                    @else
                                        <span class="badge badge-inactive">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if($page->status === 'active')
                                            <a href="{{ url('/'.$page->slug) }}" class="btn btn-sm btn-outline-dark-auth" target="_blank" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('pages.edit', $page->id) }}" class="btn btn-sm btn-warning" title="Edit breadcrumb">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted-small">No pages in database. Run: <code>php artisan db:seed --class=PageSeeder</code></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
