@extends('front.app')

@section('title', $category ? $category->title . ' | Pratham Filter Industries' : 'Pratham Filter Industries | products')
@section('meta_description', $metaDescription)

@section('content')
<section class="page_hero" style="background-image: url('{{ asset('front/img/figma/about/page-hero-bg.jpg') }}');">
    <div class="page_hero_overlay"></div>
    <div class="container position-relative">
        <div class="page_hero_content">
            <div class="breadcrumb_row">
                <a href="{{ route('home') }}">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                @if ($category)
                <a href="{{ route('products') }}">Water Filter Products</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>{{ $category->title }}</span>
                @else
                <span>Water Filter Products</span>
                @endif
            </div>
            <h1 class="page_hero_title">{{ $category?->title ?? 'Water Filter Products' }}</h1>
        </div>
    </div>
</section>

<section class="section_padding">
    <div class="container">
        <div class="products_header">
            <div class="products_header_title">
                <p class="products_eyebrow">{{ $category?->title ?? 'Our Products' }}</p>
                <h2 class="title mb-0">{{ $category ? 'Explore ' . $category->title : 'Explore Our Range' }}</h2>
                <span class="products_accent_line"></span>
            </div>
            <div class="products_search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" placeholder="Search products..." id="productSearch" aria-label="Search products">
            </div>
        </div>

        @if ($category?->description)
        <p class="sub_text_p16 mb-4">{{ $category->description }}</p>
        @endif

        <div class="product_grid_list" id="productGridList">
            @foreach ($products as $product)
            <div class="product_list_card" data-name="{{ \Illuminate\Support\Str::lower($product->title . ' ' . $product->name . ' ' . $product->description) }}">
                <div class="product_list_img_wrap product_img_stretch">
                    <a href="{{ route('product.details', $product->product_url) }}"><img src="{{ $product->image ? asset('admin-assets/products/image/' . $product->image) : asset('front/img/figma/products/prod-spun-cartridge.jpg') }}" alt="{{ $product->image_alt ?: $product->name }}"></a>
                </div>
                <div class="product_list_info">
                    <a href="{{ route('product.details', $product->product_url) }}"><h3 class="product_list_title">{{ $product->title }}</h3></a>
                    @if ($product->name !== $product->title)
                      <a href="{{ route('product.details', $product->product_url) }}"><p class="product_list_name">{{ $product->name }}</p></a>
                    @endif
                    <p class="product_list_desc">{{ $product->description }}</p>
                    <a href="{{ route('product.details', $product->product_url) }}" class="dark-btn product_know_more">Know More</a>
                </div>
            </div>
            @endforeach
        </div>
        <p class="product_no_results" id="productNoResults" @if ($products->isNotEmpty()) style="display:none;" @endif>
            {{ $products->isEmpty() ? ($category ? 'No products are available in this category yet.' : 'No products are available yet.') : 'No products match your search.' }}
        </p>
    </div>
</section>

<section class="product_cta_banner" style="background-image: linear-gradient(-1deg, rgba(57,49,133,0.92) 0%, rgba(57,50,133,0.92) 38%, rgba(0,160,227,0.92) 100%), url('{{ asset('front/img/figma/products/product-cta-bg.jpg') }}');">
    <div class="container">
        <h2 class="product_cta_title">Can&rsquo;t Find What You&rsquo;re Looking For?</h2>
        <p class="product_cta_text">Our engineering team can design a custom filtration solution built around your exact process requirements.</p>
        <a href="{{ route('contact') }}" class="purple-btn-solid product_cta_btn">Request for Quote</a>
    </div>
</section>

<script>
(function () {
    var search = document.getElementById('productSearch');
    var cards = document.querySelectorAll('#productGridList .product_list_card');
    var noResults = document.getElementById('productNoResults');

    function filterProducts() {
        var query = search.value.trim().toLowerCase();
        var visible = 0;

        cards.forEach(function (card) {
            var matches = card.dataset.name.indexOf(query) !== -1;
            card.style.display = matches ? '' : 'none';
            if (matches) visible++;
        });

        noResults.style.display = visible ? 'none' : 'block';
    }

    search.addEventListener('input', filterProducts);
    var initialQuery = new URLSearchParams(window.location.search).get('q');
    if (initialQuery) {
        search.value = initialQuery;
        filterProducts();
    }
})();
</script>
@endsection
