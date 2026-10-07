<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- <meta name="theme-color" content="#393185"> -->

    <title>Pratham Filter Industries</title>
    <!-- favicon -->
    <link rel="icon" href="{{ asset('front/img/favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('front/img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('front/img/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('front/img/apple-touch-icon.png') }}">
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap"
        rel="stylesheet">
    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">

    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/search.css') }}">
</head>

<header id="header">
    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
            <a class="navbar-brand brand_lockup" href="{{ route('home') }}">
                <img src="{{ asset('front/img/pratham-logo.png') }}" alt="Pratham Filter Industries" class="logo_img">
                <img src="{{ asset('front/img/flo-logo.png') }}" alt="FLO" class="brand_flo_logo">
            </a>
            <button class="search_toggle search_toggle_mobile js-open-search" type="button" aria-label="Search" aria-expanded="false" aria-controls="searchPanel"><i class="fa-solid fa-magnifying-glass"></i></button>
            <button class="navbar-toggler" id="hamburgerToggle" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                   <i class="fa-solid fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About Us</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle no-caret" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Products
                        <svg class="dropdown_arrow" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.92 8.95L13.4 15.47C12.63 16.24 11.37 16.24 10.6 15.47L4.08002 8.95" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @forelse ($productCategories as $productCategory)
                            <li><a class="dropdown-item" href="{{ route('category.products', $productCategory->category_url) }}">{{ $productCategory->title }}</a></li>
                            @empty
                            <li><span class="dropdown-item text-muted">No categories available</span></li>
                            @endforelse
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('products') }}">All Products</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('news.events') }}">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('blog') }}">Blogs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
                    </li>
                </ul>
                <div class="header_actions ms-lg-4">
                    <button class="search_toggle search_toggle_desktop js-open-search" type="button" aria-label="Search" aria-expanded="false" aria-controls="searchPanel"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <button class="purple-btn-solid js-open-quote" type="button">Request for Quote</button>
                </div>
            </div>
        </div>
    </nav>
    <div class="search_panel" id="searchPanel" aria-hidden="true">
        <div class="container-fluid">
            <form class="search_form" action="{{ route('products') }}" method="get" role="search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" name="q" id="siteSearchInput" placeholder="Search products..." autocomplete="off" aria-label="Search products">
                <button type="button" class="search_close js-close-search" aria-label="Close search"><i class="fa-solid fa-xmark"></i></button>
            </form>
            <ul class="search_results" id="searchResults" role="listbox"></ul>
        </div>
    </div>
    <script>window.SITE_SEARCH = @json($siteSearchItems ?? []);</script>
   
</header>

<body>
