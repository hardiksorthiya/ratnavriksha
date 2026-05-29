@extends('frontend.layout.app')

@section('title', $product->meta_title ?: ($product->name ?: 'Product') . ' | Ratnavriksha')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/frontend/product.css') }}">
@endpush

@section('content')
    <section class="product-page">
        <div class="container">
            <nav class="product-breadcrumb" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->name ?? 'Product' }}</li>
                </ol>
            </nav>

            <div class="row product-main g-4 g-lg-5">
                <div class="col-lg-6">
                    <div class="product-media">
                        <div class="product-gallery-wrap">
                            <div class="product-main-view" id="productMainView">
                                @if($galleryItems->isNotEmpty())
                                    <div class="product-gallery-slider" id="productGallerySlider">
                                        <div class="product-gallery-track" id="productGalleryTrack">
                                            @foreach($galleryItems as $item)
                                                <div class="product-gallery-slide">
                                                    @if($item['type'] === 'video')
                                                        <video src="{{ $item['src'] }}" class="product-main-media" loop muted playsinline preload="metadata"></video>
                                                    @else
                                                        <img src="{{ $item['src'] }}"
                                                            alt="{{ !empty($item['is_placeholder']) ? 'Ratnavriksha' : $product->name }}"
                                                            class="product-main-media {{ !empty($item['is_placeholder']) ? 'product-main-media--logo' : '' }}">
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @if($galleryItems->count() > 1)
                                <button type="button" class="product-gallery-arrow product-gallery-prev hero-arrow" aria-label="Previous image">
                                    &larr;
                                </button>
                                <button type="button" class="product-gallery-arrow product-gallery-next hero-arrow" aria-label="Next image">
                                    &rarr;
                                </button>
                            @endif
                        </div>

                        @if($galleryItems->count() > 1)
                            <div class="product-thumbs" role="list">
                                @foreach($galleryItems as $index => $item)
                                    <button type="button"
                                        class="product-thumb {{ $index === 0 ? 'is-active' : '' }}"
                                        role="listitem"
                                        data-index="{{ $index }}"
                                        data-type="{{ $item['type'] }}"
                                        data-src="{{ $item['src'] }}"
                                        aria-label="View media {{ $index + 1 }}">
                                        @if($item['type'] === 'video')
                                            <video src="{{ $item['src'] }}" muted playsinline preload="metadata"></video>
                                            <span class="product-thumb-badge">Video</span>
                                        @else
                                            <img src="{{ $item['src'] }}"
                                                alt=""
                                                class="{{ !empty($item['is_placeholder']) ? 'product-thumb-logo' : '' }}">
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="product-details">
                        <h1 class="product-title font-pilo">{{ $product->name ?? 'Untitled Product' }}</h1>

                        @if($product->short_description)
                            <div class="product-short-desc product-rich-content">
                                {!! $product->short_description !!}
                            </div>
                        @endif

                        @if(session('enquiry_success'))
                            <div class="alert alert-success product-enquiry-alert">{{ session('enquiry_success') }}</div>
                        @endif

                        @php
                            $specRows = array_filter([
                                'Stone ID' => $product->stone_id,
                                'Shape' => $product->shape?->name,
                                'Color' => $product->color?->name,
                                'Clarity' => $product->clarity?->name,
                                'Cut' => $product->cut?->name,
                                'Row Weight' => $product->row_weight,
                                'Polish Weight' => $product->polish_weight,
                                'Length' => $product->length,
                                'Width' => $product->width,
                                'Table' => $product->table_percent,
                                'TD (Total Depth)' => $product->total_depth,
                                'Ratio' => $product->ratio,
                                'Remarks' => $product->remarks,
                            ], fn ($value) => filled($value));
                        @endphp

                        <div class="product-enquiry-actions">
                            <button type="button"
                                class="btn btn-primary-sorath product-enquiry-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#productEnquiryModal">
                                Send Enquiry
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2.75 4.02">
                                    <path d="M69.3,125.73c.08.07.15.15.22.22l1.79,1.73a.07.07,0,0,1,0,.12l-2,1.9,0,.05h0c-.21-.23-.43-.45-.64-.67a.19.19,0,0,1,0-.07v-2.52a.11.11,0,0,1,0-.08l.17-.18.47-.49Zm1.79,2h0l-1.76-.7v1.42Zm-1.76,1.8L71,127.93h0l-1.61.65s0,0,0,0v.91Zm1.66-2h0l-1.66-1.6v.92s0,0,0,0l1.37.55Zm-1.77-.43-.49.62.49.62Zm0,1.42-.48-.61v1Zm-.48-1,.49-.62-.49-.36Zm.52,2v-.87l-.49.36Zm0-2.72v-.87l-.48.52Z" transform="translate(-68.59 -125.73)" />
                                </svg>
                            </button>
                        </div>

                        @if(count($specRows))
                            <div class="product-spec-card">
                                <h2 class="product-spec-card-title font-pilo">Stone Details</h2>
                                <div class="table-responsive">
                                    <table class="table product-spec-table mb-0">
                                        <tbody>
                                            @foreach($specRows as $label => $value)
                                                <tr>
                                                    <th scope="row">{{ $label }}</th>
                                                    <td>{{ $value }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if($product->long_description)
                <div class="product-long-desc">
                    <h2 class="product-long-desc-title font-pilo">Description</h2>
                    <div class="product-long-desc-body product-rich-content">
                        {!! $product->long_description !!}
                    </div>
                </div>
            @endif
        </div>
    </section>

    <div class="modal fade product-enquiry-modal" id="productEnquiryModal" tabindex="-1" aria-labelledby="productEnquiryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-pilo" id="productEnquiryModalLabel">Product Enquiry</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('product.enquiry.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control" value="{{ $product->name ?? 'Untitled Product' }}" readonly>
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="product_name" value="{{ $product->name }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Your Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Enter your name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="text" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" placeholder="e.g. 1, 2, 5 carat">
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required placeholder="Enter phone number">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Comment</label>
                            <textarea name="comment" class="form-control @error('comment') is-invalid @enderror" rows="4" placeholder="Your message or questions">{{ old('comment') }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn product-enquiry-cancel" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary-sorath">Submit Enquiry</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/frontend/product.js') }}"></script>
    @if($errors->any() && !session('enquiry_success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var modal = document.getElementById('productEnquiryModal');
                if (modal && window.bootstrap) {
                    new bootstrap.Modal(modal).show();
                }
            });
        </script>
    @endif
@endpush
