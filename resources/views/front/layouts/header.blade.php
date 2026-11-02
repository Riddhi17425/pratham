@php
    $productsActive = request()->routeIs('products', 'category.products', 'product.details');
@endphp
<header id="header">
    <nav class="navbar navbar-expand-lg" aria-label="Main navigation">
        <div class="container">
            <a class="navbar-brand brand_lockup" href="{{ route('home') }}">
                <img src="{{ asset('front/img/pratham-logo.png') }}" alt="Pratham Filter Industries" class="logo_img" width="400" height="193">
                <img src="{{ asset('front/img/flo-logo.png') }}" alt="FLO" class="brand_flo_logo" width="200" height="148">
            </a>
            <button class="search_toggle search_toggle_mobile js-open-search" type="button" aria-label="Search" aria-expanded="false" aria-controls="searchPanel"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i></button>
            <button class="navbar-toggler" id="hamburgerToggle" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars" aria-hidden="true"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}" @if (request()->routeIs('about')) aria-current="page" @endif>About Us</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link {{ $productsActive ? 'active' : '' }}" href="{{ route('products') }}" id="navbarDropdown" @if (request()->routeIs('products')) aria-current="page" @endif>
                            Products
                            <svg class="dropdown_arrow" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M19.92 8.95L13.4 15.47C12.63 16.24 11.37 16.24 10.6 15.47L4.08002 8.95" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                        <button class="dropdown_toggle_btn" id="productsDropdownBtn" type="button" aria-label="Show product categories" aria-expanded="false" aria-controls="productsDropdownMenu">
                            <svg class="dropdown_arrow_btn" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M19.92 8.95L13.4 15.47C12.63 16.24 11.37 16.24 10.6 15.47L4.08002 8.95" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <ul class="dropdown-menu" id="productsDropdownMenu" aria-labelledby="navbarDropdown">
                            @forelse ($productCategories as $productCategory)
                            <li><a class="dropdown-item {{ request()->routeIs('category.products') && request()->route('categoryUrl') === $productCategory->category_url ? 'active' : '' }}" href="{{ route('category.products', $productCategory->category_url) }}">{{ $productCategory->title }} <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a></li>
                            @empty
                            <li><span class="dropdown-item text-muted">No categories available</span></li>
                            @endforelse
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item dropdown_all" href="{{ route('products') }}">View all products <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('news.events') ? 'active' : '' }}" href="{{ route('news.events') }}" @if (request()->routeIs('news.events')) aria-current="page" @endif>Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('technical.brochure') ? 'active' : '' }}" href="{{ route('technical.brochure') }}" @if (request()->routeIs('technical.brochure')) aria-current="page" @endif>Technical Datasheet</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('blog') }}">Blogs</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}" @if (request()->routeIs('contact')) aria-current="page" @endif>Contact Us</a>
                    </li>
                </ul>
                <div class="header_actions">
                    <button class="search_toggle search_toggle_desktop js-open-search" type="button" aria-label="Search" aria-expanded="false" aria-controls="searchPanel"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i></button>
                    <button class="purple-btn-solid js-open-quote" type="button">Request for Quote</button>
                </div>
            </div>
        </div>
    </nav>
    <div class="search_panel" id="searchPanel" aria-hidden="true">
        <div class="container">
            <form class="search_form" action="{{ route('products') }}" method="get" role="search">
                <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                <input type="search" name="q" id="siteSearchInput" placeholder="Search products..." autocomplete="off" aria-label="Search products">
                <button type="button" class="search_close js-close-search" aria-label="Close search"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
            </form>
            <ul class="search_results" id="searchResults" role="listbox"></ul>
        </div>
    </div>
    <script>window.SITE_SEARCH = @json($siteSearchItems ?? []);</script>
</header>
