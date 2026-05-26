@extends('frontend.layout.app')

@section('title', $page->meta_title ?: ('Contact Us | '.config('app.name')))

@section('content')
    @include('frontend.component.page-breadcrumb')

    {{-- Contact page body — add design here later --}}
    <section class="contact-page py-5">
        <div class="container">
            {{-- Your contact form / map / details go here --}}
        </div>
    </section>
@endsection
