@extends('front.app')

@section('title', 'Pratham Filter Industries | news-events')

@section('content')
<?php
$events = [
    [
        "title" => "Exhibition IFAT",
        "desc" => "Join Pratham Filter Industries at IFAT, one of the world's leading trade fairs for water, sewage, waste, and raw materials management. Visit our booth to see our latest filtration innovations.",
        "location" => "Munich, Germany",
        "date" => "Sept 9 - Sept 11, 2026",
        "image" => "img/figma/events/event-ifat.jpg",
        "status" => "Upcoming",
    ],
    [
        "title" => "Watertech India",
        "desc" => "Pratham will showcase our full range of RO membranes, filter housings, and industrial filtration systems at Watertech India, the country's premier water technology exhibition.",
        "location" => "Mumbai, India",
        "date" => "Nov 18 - Nov 20, 2026",
        "image" => "img/figma/about/about-video-bg.jpg",
        "status" => "Upcoming",
    ],
    [
        "title" => "Aquatech Amsterdam",
        "desc" => "Our export and engineering teams will be attending Aquatech Amsterdam to connect with global partners in water treatment and industrial filtration.",
        "location" => "Amsterdam, Netherlands",
        "date" => "Mar 3 - Mar 6, 2026",
        "image" => "img/figma/blog/blog-bagfilter-steel.jpg",
        "status" => "Upcoming",
    ],
    [
        "title" => "IFAT India",
        "desc" => "The regional edition of IFAT brings together India's water, sewage, and waste management industry. Pratham exhibited its ETP and STP filtration range at this year's show.",
        "location" => "New Delhi, India",
        "date" => "Oct 8 - Oct 10, 2025",
        "image" => "img/figma/article1.jpg",
        "status" => "Past",
    ],
];

?>

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
            <?php foreach ($events as $ev): ?>
            <div class="event_card" data-name="<?php echo strtolower($ev['title']); ?>">
                <div class="event_card_img_wrap">
                    <img src="<?php echo asset('front/' . $ev['image']); ?>" alt="<?php echo htmlspecialchars($ev['title']); ?>" class="w-100">
                </div>
                <div class="event_card_body">
                    <div class="event_card_title_row">
                        <h3 class="event_card_title"><?php echo htmlspecialchars($ev['title']); ?></h3>
                    </div>
                    <p class="event_card_desc"><?php echo htmlspecialchars($ev['desc']); ?></p>
                    <ul class="event_card_meta">
                        <li><img src="{{ asset('front/img/figma/events/icon-event-location.svg') }}" alt=""> <?php echo htmlspecialchars($ev['location']); ?></li>
                        <li><img src="{{ asset('front/img/figma/events/icon-event-calendar.svg') }}" alt=""> <?php echo htmlspecialchars($ev['date']); ?></li>
                    </ul>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <p class="product_no_results" id="eventNoResults" style="display:none;">No events match your search.</p>
    </div>
</section>

<section class="product_cta_banner" style="background-image: linear-gradient(-1deg, rgba(57,49,133,0.92) 0%, rgba(57,50,133,0.92) 38%, rgba(0,160,227,0.92) 100%), url('{{ asset('front/img/figma/products/product-cta-bg.jpg') }}');">
    <div class="container">
        <h2 class="product_cta_title">Meet Us At The Next Show</h2>
        <p class="product_cta_text">Want to schedule a meeting with our team at an upcoming exhibition? Get in touch and we'll set it up.</p>
        <div class="product_cta_actions">
            <a href="/contact" class="product_cta_btn_outline">Talk to Our Experts</a>
            <a href="/products" class="product_cta_btn_solid">Explore Water Filter Products</a>
        </div>
    </div>
</section>



<script>
document.getElementById('eventSearch').addEventListener('input', function () {
    const q = this.value.trim().toLowerCase();
    let visible = 0;
    document.querySelectorAll('#eventGridList .event_card').forEach(function (card) {
        const match = card.dataset.name.includes(q);
        card.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    document.getElementById('eventNoResults').style.display = visible === 0 ? 'block' : 'none';
});
</script>

@endsection
