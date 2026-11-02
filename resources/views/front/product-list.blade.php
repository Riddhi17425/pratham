@extends('front.app')

@section('title', $category ? $category->title . ' | Pratham Filter Industries' : 'Products | Pratham Filter Industries')
@section('meta_description', $metaDescription)

@section('content')
@include('front.partials.page-hero', [
    'image' => asset('front/img/banners/products-banner.webp'),
    'banner' => true,
    'title' => $category ? $category->title . ' Products' : 'Products',
    'crumbs' => $category
        ? [['label' => 'Products', 'url' => route('products')], ['label' => $category->title]]
        : [['label' => 'All Products']],
    'subtitle' => $category ? null : 'Filtration equipment, cartridges, housings, membranes and components for every stage of water treatment.',
])

@php
    $plainDescription = $category
        ? preg_replace('/[\s\x{00A0}]+/u', '', html_entity_decode(strip_tags($category->description ?? '')))
        : '';
    // Category chips for the all-products page, built from the products already loaded on it
    $filterCategories = $category
        ? collect()
        : $products->pluck('category')->filter()->unique('id')->sortBy('title')->values();
@endphp

<section class="section_padding">
    <div class="container">
        <div class="products_header">
            <div class="products_header_title">
                <p class="products_eyebrow">{{ $category?->title ?? 'Our Products' }}</p>
                <h2 class="title">{{ $category ? 'Explore ' . $category->title : 'Explore Our Range' }}</h2>
            </div>
            @if(isset($products) && $products->count() > 1)
            <div class="products_search">
                <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                <input type="search" placeholder="Search products..." id="productSearch" aria-label="Search products">
            </div>
            @endif
        </div>

        @if ($plainDescription !== '')
        <div class="sub_text_p16 rich_text category_description">{!! $category->description !!}</div>
        @endif

        @if ($filterCategories->count() > 1)
        <div class="product_filters" role="group" aria-label="Filter products by category">
            <button type="button" class="product_filter active" data-filter="all" aria-pressed="true">All <span>{{ $products->count() }}</span></button>
            @foreach ($filterCategories as $filterCategory)
            <button type="button" class="product_filter" data-filter="{{ $filterCategory->id }}" aria-pressed="false">{{ $filterCategory->title }} <span>{{ $products->where('category_id', $filterCategory->id)->count() }}</span></button>
            @endforeach
        </div>
        @endif

        @if ($products->isNotEmpty())
        <p class="products_count" aria-live="polite">Showing <strong id="productCount">{{ $products->count() }}</strong> <span id="productCountLabel">{{ $products->count() === 1 ? 'product' : 'products' }}</span></p>
        @endif

        <div class="product_grid_list" id="productGridList">
            @foreach ($products as $product)
            <article class="product_list_card" data-name="{{ \Illuminate\Support\Str::lower($product->title . ' ' . $product->name . ' ' . html_entity_decode(strip_tags($product->description))) }}" data-category="{{ $product->category_id }}">
                <a href="{{ route('product.details', $product->product_url) }}" class="product_list_img_wrap" tabindex="-1" aria-hidden="true">
                    <img src="{{ $product->image ? asset('admin-assets/products/image/' . $product->image) : asset('front/img/figma/products/prod-spun-cartridge.jpg') }}" alt="{{ $product->image_alt ?: $product->name }}" loading="lazy" decoding="async">
                </a>
                <div class="product_list_info">
                    @if (!$category && $product->category)
                    <span class="product_list_cat">{{ $product->category->title }}</span>
                    @endif
                    <h3 class="product_list_title"><a href="{{ route('product.details', $product->product_url) }}">{{ $product->title }}</a></h3>
                    @if ($product->name !== $product->title)
                    <p class="product_list_name">{{ $product->name }}</p>
                    @endif
                    <p class="product_list_desc">{{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($product->description)), 150) }}</p>
                    <a href="{{ route('product.details', $product->product_url) }}" class="product_know_more">Know More <svg class="btn_arrow" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                </div>
            </article>
            @endforeach
        </div>
        <p class="product_no_results" id="productNoResults" @if ($products->isNotEmpty()) style="display:none;" @endif>
            {{ $products->isEmpty() ? ($category ? 'No products are available in this category yet.' : 'No products are available yet.') : 'No products match your search.' }}
        </p>
    </div>
</section>

@include('front.partials.cta-banner', [
    'title' => "Can't Find What You're Looking For?",
    'text' => 'Our engineering team can design a custom filtration solution built around your exact process requirements.',
    'actions' => [['label' => 'Request for Quote', 'url' => route('contact'), 'style' => 'solid']],
])

<script>
(function () {
    var search = document.getElementById('productSearch');
    var cards = document.querySelectorAll('#productGridList .product_list_card');
    var noResults = document.getElementById('productNoResults');
    var count = document.getElementById('productCount');
    var countLabel = document.getElementById('productCountLabel');
    var filters = document.querySelectorAll('.product_filter');
    var activeFilter = 'all';
    if (!cards.length) return;

    function filterProducts() {
        var query = search ? search.value.trim().toLowerCase() : '';
        var visible = 0;

        cards.forEach(function (card) {
            var matches = card.dataset.name.indexOf(query) !== -1 &&
                (activeFilter === 'all' || card.dataset.category === activeFilter);
            card.style.display = matches ? '' : 'none';
            if (matches) visible++;
        });

        noResults.style.display = visible ? 'none' : 'block';
        if (count) count.textContent = visible;
        if (countLabel) countLabel.textContent = visible === 1 ? 'product' : 'products';
    }

    filters.forEach(function (button) {
        button.addEventListener('click', function () {
            activeFilter = button.getAttribute('data-filter');
            filters.forEach(function (other) {
                other.classList.toggle('active', other === button);
                other.setAttribute('aria-pressed', other === button ? 'true' : 'false');
            });
            filterProducts();
        });
    });

    if (search) {
        search.addEventListener('input', filterProducts);
        var initialQuery = new URLSearchParams(window.location.search).get('q');
        if (initialQuery) {
            search.value = initialQuery;
            filterProducts();
        }
    }
})();
</script>
@endsection
