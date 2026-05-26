@extends('frontend.layout.app')

@section('title', $page->meta_title ?: ('About Us | '.config('app.name')))

@section('content')
    @include('frontend.component.page-breadcrumb')

    @include('frontend.component.about.who')
@endsection
