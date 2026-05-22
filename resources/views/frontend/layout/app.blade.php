<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Ratnavriksha')</title>

    {{-- favicon --}}
    <link rel="icon" href="{{ asset('images/logo.png') }}">

    {{-- css --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/media_query.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/keyframe.css') }}">

    {{-- slider slick --}}
    <link rel="stylesheet" href="{{ asset('css/frontend/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/slick-theme.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    @stack('styles')

</head>
<body>
    @include('frontend.layout.header')

    @yield('content')

    @include('frontend.layout.footer')

    <script src="{{ asset('js/frontend/jquery.min.js') }}"></script>
    <script src="{{ asset('js/frontend/slick.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/frontend/script.js') }}"></script>
    @stack('scripts')
</body>
</html>