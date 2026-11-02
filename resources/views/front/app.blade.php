<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Pratham Filter Industries')">
    <title>@yield('title', 'Pratham Filter Industries')</title>

    <link rel="icon" href="{{ asset('front/img/favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('front/img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('front/img/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('front/img/apple-touch-icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css" rel="stylesheet">

    {{-- ?v= is the file's modified time, so browsers always pick up the latest styles --}}
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}?v={{ filemtime(public_path('front/css/style.css')) }}">
    <link rel="stylesheet" href="{{ asset('front/css/responsive.css') }}?v={{ filemtime(public_path('front/css/responsive.css')) }}">
    <link rel="stylesheet" href="{{ asset('front/css/animations.css') }}?v={{ filemtime(public_path('front/css/animations.css')) }}">
    <link rel="stylesheet" href="{{ asset('front/css/search.css') }}?v={{ filemtime(public_path('front/css/search.css')) }}">

    @yield('page_styles')
    @stack('styles')
</head>
@php
    $previewMode = include resource_path('views/front/preview-mode.php');
    $previewOpenPaths = [
        parse_url(route('products'), PHP_URL_PATH),
        rtrim(parse_url(url('/product'), PHP_URL_PATH), '/') . '/',
        rtrim(parse_url(url('/category'), PHP_URL_PATH), '/') . '/',
        parse_url(route('contact.thank-you'), PHP_URL_PATH),
    ];
    $previewAllowed = !$previewMode || request()->routeIs('products', 'category.products', 'product.details', 'contact.thank-you');
@endphp
<body class="@yield('body_class'){{ $previewMode ? ' client-preview' : '' }}"@if ($previewMode) data-open-paths='{{ json_encode($previewOpenPaths) }}'@endif>
    <a class="skip_link" href="#main">Skip to main content</a>

    @include('front.layouts.header')

    <main id="main">
        @if ($previewAllowed)
            @yield('content')
        @else
            @include('front.partials.preview-unavailable')
        @endif
    </main>

    @include('front.layouts.footer')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    <script src="{{ asset('front/js/main.js') }}?v={{ filemtime(public_path('front/js/main.js')) }}"></script>
    <script src="{{ asset('front/js/animations.js') }}?v={{ filemtime(public_path('front/js/animations.js')) }}"></script>
    <script src="{{ asset('front/js/search.js') }}?v={{ filemtime(public_path('front/js/search.js')) }}"></script>

    @yield('page_scripts')
    @stack('scripts')
</body>
</html>
