{{-- Breadcrumb hero — content from admin (Page model). Requires $page variable. --}}
@include('frontend.component.breadcrumb', [
    'label' => $page->label ?: $page->name,
    'heading' => $page->headingHtml(),
    'description' => $page->description,
    'bgImage' => $page->bgImageUrl(),
])
