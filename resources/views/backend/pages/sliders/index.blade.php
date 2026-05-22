@extends('backend.layout.app')

@section('title', 'Sliders')
@section('page_heading', 'Sliders')

@section('content')
    <div class="dash-card mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h2 class="dash-title mb-1">Sliders</h2>
            <p class="dash-subtitle mb-0">Manage homepage slider content and images</p>
        </div>
        <a href="{{ route('sliders.create') }}" class="btn btn-gold">
            <i class="bi bi-plus-lg me-1"></i> Add Slider
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
                            <th>ID</th>
                            <th>Main</th>
                            <th>Background</th>
                            <th>Mobile</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th width="160">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sliders as $slider)
                            <tr>
                                <td>{{ $slider->id }}</td>
                                <td>
                                    @if($slider->main_image)
                                        <img src="{{ asset('storage/'.$slider->main_image) }}" class="slider-thumb" alt="Main">
                                    @else
                                        <span class="text-muted-small">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($slider->desktop_image)
                                        <img src="{{ asset('storage/'.$slider->desktop_image) }}" class="slider-thumb" alt="Background">
                                    @else
                                        <span class="text-muted-small">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($slider->mobile_image)
                                        <img src="{{ asset('storage/'.$slider->mobile_image) }}" class="slider-thumb" alt="Mobile">
                                    @else
                                        <span class="text-muted-small">—</span>
                                    @endif
                                </td>
                                <td>{{ $slider->title ?? '—' }}</td>
                                <td>
                                    @if($slider->status === 'active')
                                        <span class="badge badge-active">Active</span>
                                    @elseif($slider->status === 'inactive')
                                        <span class="badge badge-inactive">Inactive</span>
                                    @else
                                        <span class="text-muted-small">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('sliders.edit', $slider->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('sliders.destroy', $slider->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this slider?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted-small">No sliders found. <a href="{{ route('sliders.create') }}" class="auth-link">Add your first slider</a></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
