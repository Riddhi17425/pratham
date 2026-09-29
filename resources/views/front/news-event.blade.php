@extends('front.app')

@section('title', 'Pratham Filter Industries | news-events')

@section('content')
<section class="page_hero" style="background-image: url('{{ asset('front/img/figma/about/page-hero-bg.jpg') }}');">
    <div class="page_hero_overlay"></div>
    <div class="container position-relative">
        <div class="page_hero_content">
            <div class="breadcrumb_row">
                <a href="{{ url('/') }}">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>News &amp; Events</span>
            </div>
            <h1 class="page_hero_title">News &amp; Events</h1>
        </div>
    </div>
</section>

<section class="section_padding">
    <div class="container">
        <div class="products_header">
            <div class="products_header_title">
                <p class="products_eyebrow">Our Products</p>
                <h2 class="title mb-0">Upcoming / Current Exhibitions</h2>
                <span class="products_accent_line"></span>
            </div>
            <div class="products_search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" placeholder="Search events..." id="eventSearch">
            </div>
        </div>

        <div class="event_grid" id="eventGridList">
            @foreach ($events as $event)
            <div class="event_card" data-search="{{ \Illuminate\Support\Str::lower($event->title . ' ' . $event->location) }}">
                <div class="event_card_img_wrap">
                    @if ($event->image)
                    <img src="{{ asset('admin-assets/events/image/' . $event->image) }}" alt="{{ $event->image_alt ?: $event->title }}" class="w-100">
                    @endif
                </div>
                <div class="event_card_body">
                    <div class="event_card_title_row">
                        <h3 class="event_card_title">{{ $event->title }}</h3>
                    </div>
                    <p class="event_card_desc">{{ $event->description }}</p>
                    <ul class="event_card_meta">
                        <li><img src="{{ asset('front/img/figma/events/icon-event-location.svg') }}" alt=""> {{ $event->location }}</li>
                        <li><img src="{{ asset('front/img/figma/events/icon-event-calendar.svg') }}" alt=""> {{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M j, Y') : '' }}</li>
                    </ul>
                </div>
            </div>
            @endforeach
        </div>
        <p class="product_no_results" id="eventNoResults" style="display:none;">No events match your search.</p>
        <nav class="event_pagination" id="eventPagination" aria-label="Event pages"></nav>
    </div>
</section>

<section class="product_cta_banner" style="background-image: linear-gradient(-1deg, rgba(57,49,133,0.92) 0%, rgba(57,50,133,0.92) 38%, rgba(0,160,227,0.92) 100%), url('{{ asset('front/img/figma/products/product-cta-bg.jpg') }}');">
    <div class="container">
        <h2 class="product_cta_title">Meet Us At The Next Show</h2>
        <p class="product_cta_text">Want to schedule a meeting with our team at an upcoming exhibition? Get in touch and we'll set it up.</p>
        <div class="product_cta_actions">
            <a href="{{route('contact')}}" class="product_cta_btn_outline">Talk to Our Experts</a>
            <!-- <a href="/products" class="product_cta_btn_solid">Explore Water Filter Products</a> -->
        </div>
    </div>
</section>



@push('scripts')
<script src="{{ asset('front/js/events.js') }}?v={{ filemtime(public_path('front/js/events.js')) }}"></script>
@endpush

@endsection
