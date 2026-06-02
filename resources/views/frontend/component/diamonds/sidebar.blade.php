@php
    $filterRoute = $filterRoute ?? 'diamonds';
    $hideCategoryFilter = $hideCategoryFilter ?? false;
    $activeShapeIds = collect($activeShapeIds ?? [])->map(fn ($id) => (string) $id)->all();
    $activeColorIds = collect($activeColorIds ?? [])->map(fn ($id) => (string) $id)->all();
    $activeCutIds = collect($activeCutIds ?? [])->map(fn ($id) => (string) $id)->all();
    $activeClarityIds = collect($activeClarityIds ?? [])->map(fn ($id) => (string) $id)->all();
    $activeCategoryIds = collect($activeCategoryIds ?? [])->map(fn ($id) => (string) $id)->all();
    $persistedQuery = request()->except([
        'shape_id',
        'shape_ids',
        'color_id',
        'color_ids',
        'cut_id',
        'cut_ids',
        'clarity_id',
        'clarity_ids',
        'category_id',
        'category_ids',
        'page',
    ]);
    $hasActiveFilters = !empty($activeShapeIds) || !empty($activeColorIds) || !empty($activeCutIds) || !empty($activeClarityIds) || !empty($activeCategoryIds);
@endphp

<aside class="diamonds-sidebar">
    <div class="diamonds-sidebar-card">
        <h3 class="diamonds-sidebar-title font-pilo">Filters</h3>
        <p class="diamonds-sidebar-subtitle">Refine diamonds by category, shape, color, cut and clarity.</p>
        <div class="diamonds-filter-actions">
            <button type="submit" form="diamondsFilterForm" class="diamonds-filter-apply">Apply Filters</button>
            <a href="{{ route($filterRoute, $persistedQuery) }}" class="diamonds-filter-reset {{ $hasActiveFilters ? '' : 'is-disabled' }}">Reset</a>
        </div>

        <form id="diamondsFilterForm" method="GET" action="{{ route($filterRoute) }}">
            @foreach ($persistedQuery as $key => $value)
                @if (is_array($value))
                    @foreach ($value as $nestedValue)
                        <input type="hidden" name="{{ $key }}[]" value="{{ $nestedValue }}">
                    @endforeach
                @else
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach

        <div class="diamonds-filter-accordion" id="diamondsFilterAccordion">
            <div class="diamonds-filter-group">
                <button class="diamonds-filter-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#diamondsFilterShape" aria-expanded="true" aria-controls="diamondsFilterShape">
                    <span class="diamonds-filter-group-title">Shape</span>
                    <span class="diamonds-filter-icon" aria-hidden="true"><i class="fa-solid fa-plus"></i></span>
                </button>
                <div id="diamondsFilterShape" class="collapse show diamonds-filter-collapse" data-bs-parent="#diamondsFilterAccordion">
                    <ul class="diamonds-sidebar-list">
                        @foreach ($shapes as $shape)
                            <li>
                                <label class="diamonds-filter-option {{ in_array((string) $shape->id, $activeShapeIds, true) ? 'is-active' : '' }}">
                                    <span class="diamonds-shape-item">
                                        <input type="checkbox" class="diamonds-filter-checkbox" name="shape_ids[]" value="{{ $shape->id }}" {{ in_array((string) $shape->id, $activeShapeIds, true) ? 'checked' : '' }}>
                                        <span class="diamonds-shape-thumb">
                                            <img src="{{ $shape->list_image_src }}" alt="{{ $shape->name }}" loading="lazy">
                                        </span>
                                        <span>{{ $shape->name }}</span>
                                    </span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            @if(!$hideCategoryFilter && isset($categories) && $categories->isNotEmpty())
                <div class="diamonds-filter-group">
                    <button class="diamonds-filter-toggle {{ empty($activeCategoryIds) ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#diamondsFilterCategory" aria-expanded="{{ !empty($activeCategoryIds) ? 'true' : 'false' }}" aria-controls="diamondsFilterCategory">
                        <span class="diamonds-filter-group-title">Category</span>
                        <span class="diamonds-filter-icon" aria-hidden="true"><i class="fa-solid fa-plus"></i></span>
                    </button>
                    <div id="diamondsFilterCategory" class="collapse diamonds-filter-collapse {{ !empty($activeCategoryIds) ? 'show' : '' }}" data-bs-parent="#diamondsFilterAccordion">
                        <ul class="diamonds-sidebar-list diamonds-sidebar-list--simple">
                            @foreach ($categories as $category)
                                <li>
                                    <label class="diamonds-filter-option {{ in_array((string) $category->id, $activeCategoryIds, true) ? 'is-active' : '' }}">
                                        <span class="diamonds-shape-item">
                                            <input type="checkbox" class="diamonds-filter-checkbox" name="category_ids[]" value="{{ $category->id }}" {{ in_array((string) $category->id, $activeCategoryIds, true) ? 'checked' : '' }}>
                                            <span>{{ $category->name }}</span>
                                        </span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="diamonds-filter-group">
                <button class="diamonds-filter-toggle {{ empty($activeColorIds) ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#diamondsFilterColor" aria-expanded="{{ !empty($activeColorIds) ? 'true' : 'false' }}" aria-controls="diamondsFilterColor">
                    <span class="diamonds-filter-group-title">Color</span>
                    <span class="diamonds-filter-icon" aria-hidden="true"><i class="fa-solid fa-plus"></i></span>
                </button>
                <div id="diamondsFilterColor" class="collapse diamonds-filter-collapse {{ !empty($activeColorIds) ? 'show' : '' }}" data-bs-parent="#diamondsFilterAccordion">
                    <ul class="diamonds-sidebar-list diamonds-sidebar-list--simple">
                        @foreach ($colors as $color)
                            <li>
                                <label class="diamonds-filter-option {{ in_array((string) $color->id, $activeColorIds, true) ? 'is-active' : '' }}">
                                    <span class="diamonds-shape-item">
                                        <input type="checkbox" class="diamonds-filter-checkbox" name="color_ids[]" value="{{ $color->id }}" {{ in_array((string) $color->id, $activeColorIds, true) ? 'checked' : '' }}>
                                        <span>{{ $color->name }}</span>
                                    </span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="diamonds-filter-group">
                <button class="diamonds-filter-toggle {{ empty($activeCutIds) ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#diamondsFilterCut" aria-expanded="{{ !empty($activeCutIds) ? 'true' : 'false' }}" aria-controls="diamondsFilterCut">
                    <span class="diamonds-filter-group-title">Cut</span>
                    <span class="diamonds-filter-icon" aria-hidden="true"><i class="fa-solid fa-plus"></i></span>
                </button>
                <div id="diamondsFilterCut" class="collapse diamonds-filter-collapse {{ !empty($activeCutIds) ? 'show' : '' }}" data-bs-parent="#diamondsFilterAccordion">
                    <ul class="diamonds-sidebar-list diamonds-sidebar-list--simple">
                        @foreach ($cuts as $cut)
                            <li>
                                <label class="diamonds-filter-option {{ in_array((string) $cut->id, $activeCutIds, true) ? 'is-active' : '' }}">
                                    <span class="diamonds-shape-item">
                                        <input type="checkbox" class="diamonds-filter-checkbox" name="cut_ids[]" value="{{ $cut->id }}" {{ in_array((string) $cut->id, $activeCutIds, true) ? 'checked' : '' }}>
                                        <span>{{ $cut->name }}</span>
                                    </span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="diamonds-filter-group">
                <button class="diamonds-filter-toggle {{ empty($activeClarityIds) ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#diamondsFilterClarity" aria-expanded="{{ !empty($activeClarityIds) ? 'true' : 'false' }}" aria-controls="diamondsFilterClarity">
                    <span class="diamonds-filter-group-title">Clarity</span>
                    <span class="diamonds-filter-icon" aria-hidden="true"><i class="fa-solid fa-plus"></i></span>
                </button>
                <div id="diamondsFilterClarity" class="collapse diamonds-filter-collapse {{ !empty($activeClarityIds) ? 'show' : '' }}" data-bs-parent="#diamondsFilterAccordion">
                    <ul class="diamonds-sidebar-list diamonds-sidebar-list--simple">
                        @foreach ($clarities as $clarity)
                            <li>
                                <label class="diamonds-filter-option {{ in_array((string) $clarity->id, $activeClarityIds, true) ? 'is-active' : '' }}">
                                    <span class="diamonds-shape-item">
                                        <input type="checkbox" class="diamonds-filter-checkbox" name="clarity_ids[]" value="{{ $clarity->id }}" {{ in_array((string) $clarity->id, $activeClarityIds, true) ? 'checked' : '' }}>
                                        <span>{{ $clarity->name }}</span>
                                    </span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        </form>
    </div>

    <div class="diamonds-sidebar-card diamonds-sidebar-card--hint">
        <h4 class="diamonds-sidebar-hint-title">Need help choosing?</h4>
        <p class="diamonds-sidebar-hint-text">
            Tell us your preference and our team will recommend the best options.
        </p>
        <a class="diamonds-sidebar-hint-link" href="{{ route('contact') }}">
            Contact Us
            <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
        </a>
    </div>
</aside>

