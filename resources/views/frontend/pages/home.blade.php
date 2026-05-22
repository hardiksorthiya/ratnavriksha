@extends('frontend.layout.app')

@section('title', 'Ratnavriksha')

@section('content')
    @include('frontend.component.home.slider')
    @include('frontend.component.home.about')
    @include('frontend.component.home.category-slider')
    @include('frontend.component.home.vision')
    @include('frontend.component.home.services')
    @include('frontend.component.home.why')
    @include('frontend.component.home.contact')
@endsection
