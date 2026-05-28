@extends('frontend.layout.app')

@section('title', $page->meta_title ?: ('About Us | '.config('app.name')))

@section('content')
    @include('frontend.component.page-breadcrumb')

    @include('frontend.component.about.who')
    @include('frontend.component.about.stats')
    @include('frontend.component.about.mission')
    @include('frontend.component.about.process')
    @include('frontend.component.about.founder')
    @include('frontend.component.about.commitment')
    @include('frontend.component.about.cta')
@endsection
