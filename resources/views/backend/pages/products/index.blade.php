@extends('backend.layout.app')

@section('title', 'Products')
@section('page_heading', 'Products')

@section('content')
    <div class="dash-card mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h2 class="dash-title mb-1">Product List</h2>
            <p class="dash-subtitle mb-0">Manage diamond products</p>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-gold">
            <i class="bi bi-plus-lg me-1"></i> Add Product
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
                            <th>Featured</th>
                            <th>Name</th>
                            <th>Stone ID</th>
                            <th>Shape</th>
                            <th>Status</th>
                            <th width="160">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($product->featured_path)
                                        @if($product->featured_type === 'video')
                                            <span class="badge badge-active">Video</span>
                                        @else
                                            <img src="{{ asset('storage/'.$product->featured_path) }}" class="slider-thumb" alt="">
                                        @endif
                                    @else
                                        <span class="text-muted-small">—</span>
                                    @endif
                                </td>
                                <td>{{ $product->name ?? '—' }}</td>
                                <td>{{ $product->stone_id ?? '—' }}</td>
                                <td>{{ $product->shape?->name ?? '—' }}</td>
                                <td>
                                    @if($product->status === 'active')
                                        <span class="badge badge-active">Active</span>
                                    @elseif($product->status === 'inactive')
                                        <span class="badge badge-inactive">Inactive</span>
                                    @else
                                        <span class="text-muted-small">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if($product->status === 'active' && $product->slug)
                                            <a href="{{ route('product.show', $product->slug) }}" class="btn btn-sm btn-outline-dark-auth" target="_blank" title="View on site">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted-small">No products found. <a href="{{ route('products.create') }}" class="auth-link">Add your first product</a></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
