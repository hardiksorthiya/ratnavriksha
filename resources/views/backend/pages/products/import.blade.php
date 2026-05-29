@extends('backend.layout.app')

@section('title', 'Bulk Product Import')
@section('page_heading', 'Bulk Product Import')

@section('content')
    <div class="dash-card mb-4">
        <h2 class="dash-title mb-1">Import Products from CSV</h2>
        <p class="dash-subtitle mb-0">Upload a CSV file to create or update products in bulk.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning mb-4">{{ session('warning') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mb-4">{{ session('error') }}</div>
    @endif

    @if(session('import_errors'))
        <div class="alert alert-danger mb-4">
            <strong>Some rows could not be imported:</strong>
            <ul class="mb-0 mt-2">
                @foreach(session('import_errors') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card panel-card">
                <div class="card-body">
                    <form action="{{ route('products.import.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="csv_file" class="form-label">CSV File <span class="text-danger">*</span></label>
                            <input type="file"
                                name="csv_file"
                                id="csv_file"
                                class="form-control @error('csv_file') is-invalid @enderror"
                                accept=".csv,.txt"
                                required>
                            @error('csv_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Max 10 MB. Use the template for correct column order.</div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-gold">
                                <i class="bi bi-upload me-1"></i> Upload &amp; Import
                            </button>
                            <a href="{{ route('products.import.template') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-download me-1"></i> Download Template
                            </a>
                            <a href="{{ route('products.index') }}" class="btn btn-link text-decoration-none">Back to Product List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card panel-card h-100">
                <div class="card-body">
                    <h5 class="mb-3">Instructions</h5>
                    <ul class="small text-muted mb-4 ps-3">
                        <li class="mb-2">First row must be column headers (download template).</li>
                        <li class="mb-2"><strong>name</strong> or <strong>stone_id</strong> is required on each row.</li>
                        <li class="mb-2">If <strong>stone_id</strong> already exists, that product is updated.</li>
                        <li class="mb-2"><strong>shape</strong>, <strong>color</strong>, <strong>clarity</strong>, and <strong>cut</strong> must match names in your admin lists (case-insensitive).</li>
                        <li class="mb-2"><strong>status</strong>: <code>active</code> or <code>inactive</code>.</li>
                        <li class="mb-2"><strong>featured_path</strong>: path under <code>storage/app/public</code> (e.g. <code>products/featured/file.jpg</code>). Set <strong>featured_type</strong> to <code>image</code> or <code>video</code>.</li>
                        <li class="mb-2"><strong>gallery</strong> (new products only): <code>image:path|video:path</code> separated by <code>|</code>.</li>
                        <li class="mb-2"><strong>short_description</strong> and <strong>long_description</strong> support HTML. Wrap the cell in double quotes if it contains commas or line breaks (e.g. <code>"&lt;p&gt;Your text&lt;/p&gt;"</code>).</li>
                    </ul>

                    <h6 class="mb-2">CSV Columns</h6>
                    <p class="small text-muted mb-0">
                        name, stone_id, slug, shape, color, clarity, cut, row_weight, polish_weight,
                        length, width, table_percent, total_depth, ratio, remarks, short_description,
                        long_description, meta_title, meta_description, meta_keywords, status,
                        featured_type, featured_path, gallery
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
