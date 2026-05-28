@php
    $baseFilters = request()->query();
@endphp

<aside class="diamonds-sidebar">
    <div class="diamonds-sidebar-card">
        <h3 class="diamonds-sidebar-title font-pilo">Categories</h3>
        <p class="diamonds-sidebar-subtitle">Filter diamonds by shape.</p>

        <div class="diamonds-filter-accordion" id="diamondsFilterAccordion">
            <div class="diamonds-filter-group">
                <button class="diamonds-filter-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#diamondsFilterShape" aria-expanded="true" aria-controls="diamondsFilterShape">
                    <span class="diamonds-filter-group-title">Shape</span>
                    <span class="diamonds-filter-icon" aria-hidden="true"><i class="fa-solid fa-plus"></i></span>
                </button>
                <div id="diamondsFilterShape" class="collapse show diamonds-filter-collapse" data-bs-parent="#diamondsFilterAccordion">
                    <ul class="diamonds-sidebar-list">
                        <li>
                            <a href="{{ route('diamonds', array_merge($baseFilters, ['shape_id' => null])) }}" class="{{ empty($activeShapeId) ? 'is-active' : '' }}">
                                <span class="diamonds-shape-item">
                                    <span class="diamonds-shape-thumb diamonds-shape-thumb--all">
                                        <i class="fa-solid fa-gem" aria-hidden="true"></i>
                                    </span>
                                    <span>All Shapes</span>
                                </span>
                            </a>
                        </li>
                        @foreach ($shapes as $shape)
                            <li>
                                <a href="{{ route('diamonds', array_merge($baseFilters, ['shape_id' => $shape->id])) }}" class="{{ (string) $activeShapeId === (string) $shape->id ? 'is-active' : '' }}">
                                    <span class="diamonds-shape-item">
                                        <span class="diamonds-shape-thumb">
                                            <img src="{{ $shape->list_image_src }}" alt="{{ $shape->name }}" loading="lazy">
                                        </span>
                                        <span>{{ $shape->name }}</span>
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="diamonds-filter-group">
                <button class="diamonds-filter-toggle collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#diamondsFilterColor" aria-expanded="false" aria-controls="diamondsFilterColor">
                    <span class="diamonds-filter-group-title">Color</span>
                    <span class="diamonds-filter-icon" aria-hidden="true"><i class="fa-solid fa-plus"></i></span>
                </button>
                <div id="diamondsFilterColor" class="collapse diamonds-filter-collapse" data-bs-parent="#diamondsFilterAccordion">
                    <ul class="diamonds-sidebar-list diamonds-sidebar-list--simple">
                        <li><a href="{{ route('diamonds', array_merge($baseFilters, ['color_id' => null])) }}" class="{{ empty($activeColorId) ? 'is-active' : '' }}"><span>All Colors</span></a></li>
                        @foreach ($colors as $color)
                            <li><a href="{{ route('diamonds', array_merge($baseFilters, ['color_id' => $color->id])) }}" class="{{ (string) $activeColorId === (string) $color->id ? 'is-active' : '' }}"><span>{{ $color->name }}</span></a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="diamonds-filter-group">
                <button class="diamonds-filter-toggle collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#diamondsFilterCut" aria-expanded="false" aria-controls="diamondsFilterCut">
                    <span class="diamonds-filter-group-title">Cut</span>
                    <span class="diamonds-filter-icon" aria-hidden="true"><i class="fa-solid fa-plus"></i></span>
                </button>
                <div id="diamondsFilterCut" class="collapse diamonds-filter-collapse" data-bs-parent="#diamondsFilterAccordion">
                    <ul class="diamonds-sidebar-list diamonds-sidebar-list--simple">
                        <li><a href="{{ route('diamonds', array_merge($baseFilters, ['cut_id' => null])) }}" class="{{ empty($activeCutId) ? 'is-active' : '' }}"><span>All Cuts</span></a></li>
                        @foreach ($cuts as $cut)
                            <li><a href="{{ route('diamonds', array_merge($baseFilters, ['cut_id' => $cut->id])) }}" class="{{ (string) $activeCutId === (string) $cut->id ? 'is-active' : '' }}"><span>{{ $cut->name }}</span></a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="diamonds-filter-group">
                <button class="diamonds-filter-toggle collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#diamondsFilterClarity" aria-expanded="false" aria-controls="diamondsFilterClarity">
                    <span class="diamonds-filter-group-title">Clarity</span>
                    <span class="diamonds-filter-icon" aria-hidden="true"><i class="fa-solid fa-plus"></i></span>
                </button>
                <div id="diamondsFilterClarity" class="collapse diamonds-filter-collapse" data-bs-parent="#diamondsFilterAccordion">
                    <ul class="diamonds-sidebar-list diamonds-sidebar-list--simple">
                        <li><a href="{{ route('diamonds', array_merge($baseFilters, ['clarity_id' => null])) }}" class="{{ empty($activeClarityId) ? 'is-active' : '' }}"><span>All Clarity</span></a></li>
                        @foreach ($clarities as $clarity)
                            <li><a href="{{ route('diamonds', array_merge($baseFilters, ['clarity_id' => $clarity->id])) }}" class="{{ (string) $activeClarityId === (string) $clarity->id ? 'is-active' : '' }}"><span>{{ $clarity->name }}</span></a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
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

