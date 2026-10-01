@extends('front.app')

@section('title', $product->title . ' | Pratham Filter Industries')
@section('meta_description', $metaDescription)

@section('content')

<section class="page_hero" style="background-image: url('{{ asset('front/img/figma/about/page-hero-bg.jpg') }}');">
    <div class="page_hero_overlay"></div>
    <div class="container position-relative">
        <div class="page_hero_content">
            <div class="breadcrumb_row">
                <a href="{{ route('home') }}">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <a href="{{ route('products') }}">Water Filter Products</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>{{ $product->name }}</span>
            </div>
            <h1 class="page_hero_title product_detail_hero_title">{{ $product->name }}</h1>
        </div>
    </div>
</section>

<section class="section_padding">
    <div class="container product_detail_feature">
        <div class="product_detail_visual">
            <img src="{{ $product->image ? asset('admin-assets/products/image/' . $product->image) : asset('front/img/figma/products/prod-spun-cartridge.jpg') }}"
                 alt="{{ $product->image_alt ?: $product->name }}">
        </div>
        <div class="product_detail_content">
            <h2 class="title mb-0">{{ $product->title }}</h2>
            <div class="sub_text_p16">{!! $product->description !!}</div>
            <div class="product_detail_actions">
                @if ($product->catalogue)
                    <a href="{{ asset('admin-assets/products/catalogue/' . $product->catalogue) }}" target="_blank" download class="purple-btn-solid product_download_btn">
                        <i class="fa-solid fa-download"></i> Download Catalogue
                    </a>
                @endif
                <a href="{{ route('contact') }}" class="product_enquire_btn">Enquire Now</a>
            </div>
        </div>
    </div>
</section>

@if (!empty(trim(strip_tags($product->technical_details))))
<hr class="product_detail_divider">
<section class="section_padding_top section_padding_bot">
    <div class="container">
        <p class="products_eyebrow">Technical Data</p>
        <h2 class="product_spec_title">{{ $product->name }} Specifications</h2>
        <span class="products_accent_line mb-4"></span>

        <div class="spec_table_scroll">
            {!! $product->technical_details !!}
        </div>
    </div>
</section>
@endif

<section class="product_cta_banner" style="background-image: linear-gradient(-1deg, rgba(57,49,133,0.92) 0%, rgba(57,50,133,0.92) 38%, rgba(0,160,227,0.92) 100%), url('{{ asset('front/img/figma/products/product-cta-bg.jpg') }}');">
    <div class="container">
        <h2 class="product_cta_title">Need Help Choosing The Right Filter?</h2>
        <p class="product_cta_text">Talk to our team and get a recommendation tailored to your exact filtration requirements.</p>
        <div class="product_cta_actions">
            <a href="{{ route('contact') }}" class="product_cta_btn_outline">Talk to Our Experts</a>
            <a href="{{ route('products') }}" class="product_cta_btn_solid">Explore Water Filter Products</a>
        </div>
    </div>
</section>

@endsection