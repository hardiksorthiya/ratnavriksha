<section class="breadcrumb-section" style="--breadcrumb-bg: url('{{ $bgImage }}');">
    <div class="breadcrumb-section-overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-xl-6">
                <div class="breadcrumb-content">
                    <span class="breadcrumb-label">{{ $label }}</span>
                    <h1 class="breadcrumb-heading font-pilo">{!! $heading !!}</h1>
                    <div class="breadcrumb-divider" aria-hidden="true">
                        <span class="breadcrumb-divider-line"></span>
                        <span class="breadcrumb-divider-icon">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L20 12L12 22L4 12L12 2Z" fill="none" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                        </span>
                        <span class="breadcrumb-divider-line"></span>
                    </div>
                    @if($description)
                        <p class="breadcrumb-desc">{{ $description }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
