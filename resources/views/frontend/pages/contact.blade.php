@extends('frontend.layout.app')

@section('title', $page->meta_title ?: ('Contact Us | '.config('app.name')))

@section('content')
    @include('frontend.component.page-breadcrumb')
    @include('frontend.component.contact.contact')
    @include('frontend.component.contact.map')
    @include('frontend.component.contact.faq')
@endsection
