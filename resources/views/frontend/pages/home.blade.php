@extends('frontend.layout.app')

@section('title', 'Ratnavriksha')

@section('content')
    @include('frontend.component.home.slider')
    @include('frontend.component.home.about')
    @include('frontend.component.home.category-slider')
@endsection
