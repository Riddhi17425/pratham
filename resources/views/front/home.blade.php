@extends('front.app')

@section('title', 'Pratham Filter Industries | Home')

@section('content')
@if ($banners->isNotEmpty())
<section class="hero_area" aria-label="Featured solutions">
    <div class="container hero_decor_wrap" aria-hidden="true">
        <div class="hero_decor">
            <span class="hero_ring"></span>
            <span class="hero_ring hero_ring_2"></span>
            <span class="hero_ring hero_ring_3"></span>
        </div>
    </div>
    <div class="hero_slider">
        @foreach ($banners as $banner)
        @php
            // category_id NULL => All Categories => all products list
            // otherwise => that category's product list
            $hasCategory = $banner->category && $banner->category->category_url;
            $exploreUrl  = $hasCategory
                ? route('category.products', $banner->category->category_url)
                : route('products');
            // Button text: "Explore <Category> Products" or "Explore All Products"
            $exploreText = $hasCategory
                ? 'Explore ' . $banner->category->title . ' Products'
                : 'Explore All Products';
            // The image comes from the admin banner. A wide picture (about 1.6:1 or wider) is
            // used as the slide's background with the text on top; a square product shot
            // keeps the original text-left / photo-right layout.
            $bannerFile = $banner->image ? public_path('admin-assets/banners/image/' . $banner->image) : null;
            $bannerSize = ($bannerFile && is_file($bannerFile)) ? @getimagesize($bannerFile) : null;
            $isWideBanner = $bannerSize && $bannerSize[1] > 0 && ($bannerSize[0] / $bannerSize[1]) >= 1.6;
        @endphp
        <div class="hero_slide{{ $isWideBanner ? ' hero_slide_banner' : '' }}">
            @if ($isWideBanner)
            <div class="hero_slide_bg" style="background-image: url('{{ asset('admin-assets/banners/image/' . $banner->image) }}');" role="img" aria-label="{{ $banner->image_alt ?: $banner->title }}"></div>
            @endif
            <div class="container">
                <div class="hero_grid">
                    <div class="hero_content">
                        <span class="eyebrow hero_eyebrow">{{ $hasCategory ? $banner->category->title : 'Industrial & Water Filtration' }}</span>
                        @if ($loop->first)
                        <h1 class="hero_title">{{ $banner->title }}</h1>
                        @else
                        <h2 class="hero_title">{{ $banner->title }}</h2>
                        @endif
                        <div class="hero_text">{!! strip_tags($banner->description, '<p><br><strong><b><em><i><u><ul><ol><li><a>') !!}</div>
                        <div class="hero_actions">
                            <a class="purple-btn-solid" href="{{ $exploreUrl }}">{{ $exploreText }} <svg class="btn_arrow" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                            <button class="purple-btn js-open-quote" type="button">Request a Quote</button>
                        </div>
                    </div>
                    @unless ($isWideBanner)
                    <div class="hero_img_wrap">
                        @if ($banner->image)
                        <img src="{{ asset('admin-assets/banners/image/' . $banner->image) }}" alt="{{ $banner->image_alt ?: $banner->title }}" @if ($loop->first) fetchpriority="high" @endif>
                        @endif
                    </div>
                    @endunless
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @if ($banners->count() > 1)
    <div class="container hero_controls">
        <div class="hero_dots"></div>
        <p class="hero_counter" aria-hidden="true">
            <span class="hero_counter_current">01</span>
            <span class="hero_counter_sep"></span>
            <span class="hero_counter_total">{{ str_pad($banners->count(), 2, '0', STR_PAD_LEFT) }}</span>
        </p>
    </div>
    @endif
</section>
@endif

<section class="stats_strip" aria-label="Pratham Filter Industries at a glance">
    <div class="container">
        <ul class="stats_grid">
            <li class="stat_item">
                <span class="stat_value"><span data-count="20">20</span>+</span>
                <span class="stat_label">Years of filtration expertise</span>
            </li>
            <li class="stat_item">
                <span class="stat_value"><span data-count="8">8</span></span>
                <span class="stat_label">Branches across India</span>
            </li>
            <li class="stat_item">
                <span class="stat_value">NSF &amp; PED</span>
                <span class="stat_label">Certified FRP pressure vessels</span>
            </li>
            <li class="stat_item">
                <span class="stat_value"><span data-count="100">100</span>%</span>
                <span class="stat_label">Quality-checked before dispatch</span>
            </li>
        </ul>
    </div>
</section>

@if ($partners->isNotEmpty())
<section class="partners_section">
    <div class="container">
        <div class="partners_intro we_represent_title">
            <h2 class="partners_title">We Represent</h2>
            <p>Proud partners with global leaders in filtration and water treatment technology.</p>
        </div>
    </div>
    <div class="client client_slider logo_slider_full">
        @foreach ($partners as $partner)
        @if ($partner->icon)
        <div class="slider_item">
            <img src="{{ asset('admin-assets/partners/icon/' . $partner->icon) }}" alt="{{ $partner->icon_alt }}">
        </div>
        @endif
        @endforeach
    </div>
</section>
@endif

@php
    // The seven range tiles from the client meeting. Each pulls the live product
    // (image + link) by its URL slug, so admin edits show up here too.
    $rangeSpec = [
        ['FRP Pressure Vessel', 'frp-filter-vessel'],
        ['RO Membrane', 'ro-membranes'],
        ['RO Housing', 'frp-pressure-tubes'],
        ['Filter Cartridge', 'spun-filter-cartridge'],
        ['Filter Application', null],
        ['MPV', 'multiport-valves'],
        ['Media', 'filter-media'],
    ];
    $rangeProducts = \App\Models\Product::where('status', 'Active')
        ->whereIn('product_url', array_filter(array_column($rangeSpec, 1)))
        ->get()->keyBy('product_url');
    $rangeItems = [];
    foreach ($rangeSpec as [$label, $slug]) {
        $p = $slug ? $rangeProducts->get($slug) : null;
        $rangeItems[] = [
            'label' => $label,
            'url' => $p ? route('product.details', $p->product_url) : route('category.products', 'water-filters'),
            'img' => $p && $p->image ? asset('admin-assets/products/image/' . $p->image) : asset('front/img/figma/collage-plastic-filter-housing.webp'),
        ];
    }
@endphp
<section class="range_section">
    <div class="container">
        <div class="range_head">
            <div class="range_head_title">
                <span class="range_kicker">Our Range</span>
                <h2 class="range_title">Manufactured for ETP, RO, and&nbsp;beyond</h2>
            </div>
            <div class="range_head_side">
                <p>Filter cartridges, housings, membranes and vessels for industrial and water treatment applications.</p>
                <a class="range_all" href="{{ route('products') }}">Explore Products <span aria-hidden="true">&rarr;</span></a>
            </div>
        </div>
        <ul class="range_grid">
            @foreach ($rangeItems as $item)
            <li>
                <a class="range_card" href="{{ $item['url'] }}">
                    <span class="range_tile">
                        <span class="range_num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <img src="{{ $item['img'] }}" alt="{{ $item['label'] }}" loading="lazy">
                    </span>
                    <span class="range_info">
                        <span class="range_name">{{ $item['label'] }}</span>
                        <span class="range_go" aria-hidden="true">&rarr;</span>
                    </span>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</section>

<section class="section_padding section_tinted industries_section">
    <div class="container">
        <div class="section_head section_head_split">
            <div>
                <span class="eyebrow">Industries We Serve</span>
                <h2 class="title">Filtration built for demanding applications</h2>
            </div>
            <p class="section_lead">From ETP and STP to desalination, food and beverage, pharma and electroplating, every product is backed by stringent quality control.</p>
        </div>
        <ul class="industry_grid">
            <li class="industry_card">
                <span class="industry_icon"><i class="fa-solid fa-industry" aria-hidden="true"></i></span>
                <div><h3>ETP &amp; STP</h3><p>Effluent and sewage treatment plants</p></div>
            </li>
            <li class="industry_card">
                <span class="industry_icon"><i class="fa-solid fa-water" aria-hidden="true"></i></span>
                <div><h3>Desalination</h3><p>RO and seawater treatment systems</p></div>
            </li>
            <li class="industry_card">
                <span class="industry_icon"><i class="fa-solid fa-bottle-water" aria-hidden="true"></i></span>
                <div><h3>Food &amp; Beverage</h3><p>Process water and liquid filtration</p></div>
            </li>
            <li class="industry_card">
                <span class="industry_icon"><i class="fa-solid fa-capsules" aria-hidden="true"></i></span>
                <div><h3>Pharmaceuticals</h3><p>Filtration for critical process water</p></div>
            </li>
            <li class="industry_card">
                <span class="industry_icon"><i class="fa-solid fa-flask" aria-hidden="true"></i></span>
                <div><h3>Chemicals</h3><p>Chemically resistant housings and media</p></div>
            </li>
            <li class="industry_card">
                <span class="industry_icon"><i class="fa-solid fa-bolt" aria-hidden="true"></i></span>
                <div><h3>Electroplating</h3><p>Plating and rinse water filtration</p></div>
            </li>
        </ul>
    </div>
</section>

<section class="section_padding">
    <div class="container">
        <div class="about_row">
            <div class="about_text_col">
                <span class="eyebrow">About Us</span>
                <h2 class="title">A trusted name in filtration since 2003</h2>
                <p class="sub_text_p16">Since 2003, Pratham Filter Industries has been a trusted name in water and industrial filtration. With a strong presence in manufacturing, wholesaling, exporting, and importing, we serve diverse industries with reliable, innovative filtration technology.</p>
                <p class="sub_text_p16">From filter housings to RO membranes, our range meets the demands of ETP, STP, desalination, food and beverage, pharma, and electroplating applications, backed by stringent quality control.</p>
                <p class="sub_text_p16">With over two decades of expertise, our customer-centric approach ensures every solution is tailored to the specific needs of the industries we serve. Our FRP pressure vessels are NSF and PED certified, reflecting our commitment to global quality standards.</p>
                <a href="{{ route('about') }}" class="purple-btn-solid">Know More <svg class="btn_arrow" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
            </div>
            <div class="about_ring_col">
                <div class="values_orbit">
                    <span class="values_ring" aria-hidden="true"></span>
                    <span class="values_ring values_ring_inner" aria-hidden="true"></span>
                    <div class="values_core">
                        <span>What we stand for</span>
                        <h3>Our Values</h3>
                    </div>
                    <ul class="values_list">
                        <li class="value_item value_1"><span class="value_icon"><i class="fa-solid fa-lightbulb" aria-hidden="true"></i></span><span class="value_label">Innovation</span></li>
                        <li class="value_item value_2"><span class="value_icon"><i class="fa-solid fa-handshake" aria-hidden="true"></i></span><span class="value_label">Customer-Centric</span></li>
                        <li class="value_item value_3"><span class="value_icon"><i class="fa-solid fa-leaf" aria-hidden="true"></i></span><span class="value_label">Sustainability</span></li>
                        <li class="value_item value_4"><span class="value_icon"><i class="fa-solid fa-earth-asia" aria-hidden="true"></i></span><span class="value_label">Global Standards</span></li>
                        <li class="value_item value_5"><span class="value_icon"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i></span><span class="value_label">Reliability</span></li>
                        <li class="value_item value_6"><span class="value_icon"><i class="fa-solid fa-award" aria-hidden="true"></i></span><span class="value_label">Quality First</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

@if ($brands->isNotEmpty())
<section class="section_padding_bot brands_section">
    <div class="container">
        <div class="section_head text-center">
            <span class="eyebrow">Trusted Product Lines</span>
            <h2 class="title">Our Brands</h2>
        </div>
    </div>
    <div class="brands_row brands_slider">
        @foreach ($brands as $brand)
        @if ($brand->icon)
        <div class="brand_item"><img src="{{ asset('admin-assets/our-brands/icon/' . $brand->icon) }}" alt="{{ $brand->icon_alt }}"></div>
        @endif
        @endforeach
    </div>
</section>
@endif

@if(isset($blogs) && is_countable($blogs) && count($blogs) > 0)
<section class="section_padding_bot">
    <div class="container">
        <div class="section_head section_head_split articles_head">
            <div>
                <span class="eyebrow">Insights</span>
                <h2 class="title">Latest Articles</h2>
            </div>
            <a class="purple-btn" href="{{ route('blog') }}">Explore Articles <svg class="btn_arrow" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
        </div>
        <div class="article_grid">
            @foreach ($blogs as $blog)
            <a href="{{ route('blog.details', ['post' => $blog->url]) }}" class="article_card">
                <div class="article_card_media">
                    @if ($blog->front_image)
                    <img src="{{ asset('admin-assets/blogs/front_image/' . $blog->front_image) }}" alt="{{ $blog->front_image_alt ?: $blog->title }}" loading="lazy">
                    @else
                    <span class="article_card_placeholder"><i class="fa-solid fa-droplet" aria-hidden="true"></i></span>
                    @endif
                </div>
                <div class="article_card_body">
                    <p class="articles_date">{{ $blog->date ? \Carbon\Carbon::parse($blog->date)->format('F j, Y') : $blog->created_at->format('F j, Y') }}</p>
                    <h3 class="articles_title">{{ $blog->title }}</h3>
                    <span class="article_card_link">Read article <svg class="btn_arrow" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@php
    // Latest active event, shown once per visit as a pop-up when the home page loads
    $popupEvent = \App\Models\Event::where('status', 'Active')->orderByDesc('from_date')->orderByDesc('id')->first();
@endphp
@if ($popupEvent)
<div class="event_popup" id="eventPopup" role="dialog" aria-modal="true" aria-labelledby="eventPopupTitle" hidden data-event="{{ $popupEvent->id }}">
    <div class="event_popup_backdrop" data-popup-close></div>
    <div class="event_popup_box">
        <button class="event_popup_close" type="button" aria-label="Close" data-popup-close>&times;</button>
        @if ($popupEvent->image)
        <div class="event_popup_media"><img src="{{ asset('admin-assets/events/image/' . $popupEvent->image) }}" alt="{{ $popupEvent->image_alt ?: $popupEvent->title }}"></div>
        @endif
        <div class="event_popup_body">
            <span class="event_popup_kicker">Upcoming Event</span>
            <h2 id="eventPopupTitle">{{ $popupEvent->title }}</h2>
            @if ($popupEvent->date_range)<p class="event_popup_meta"><i class="fa-regular fa-calendar" aria-hidden="true"></i> {{ $popupEvent->date_range }}</p>@endif
            @if ($popupEvent->location)<p class="event_popup_meta"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> {{ $popupEvent->location }}</p>@endif
            <a class="event_popup_btn" href="{{ route('news.events') }}">View all events</a>
        </div>
    </div>
</div>
@push('scripts')
<script>
(function () {
    var popup = document.getElementById('eventPopup');
    if (!popup) return;
    var key = 'pratham_event_popup_' + popup.getAttribute('data-event');
    try { if (sessionStorage.getItem(key)) return; } catch (e) {}
    function close() {
        popup.classList.remove('is-open');
        document.body.style.overflow = '';
        setTimeout(function () { popup.hidden = true; }, 300);
        try { sessionStorage.setItem(key, '1'); } catch (e) {}
    }
    setTimeout(function () {
        popup.hidden = false;
        document.body.style.overflow = 'hidden';
        requestAnimationFrame(function () { popup.classList.add('is-open'); popup.querySelector('.event_popup_close').focus(); });
    }, 900);
    popup.addEventListener('click', function (e) { if (e.target.hasAttribute('data-popup-close')) close(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && !popup.hidden) close(); });
})();
</script>
@endpush
@endif

@endsection
