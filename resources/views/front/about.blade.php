@extends('front.app')

@section('title', 'About Us | Pratham Filter Industries')

@section('content')

@include('front.partials.page-hero', [
    'title' => 'About Us',
    'crumbs' => [['label' => 'About Us']],
    'subtitle' => 'Reliable filtration solutions for industries across India since 2003.',
])

<section class="section_padding">
    <div class="container">
        <div class="about_intro_grid">
            <div>
                <span class="eyebrow">Who We Are</span>
                <h2 class="title">From a Mumbai trading business to a trusted name across India</h2>
            </div>
            <p class="sub_text_p16 about_intro_text">Since 2003, Pratham Filter Industries has been helping industries meet their water filtration needs with reliable solutions. What started as a small water filter trading business in Mumbai has grown into a trusted name across India, with branches in Chennai, Kolkata, Pune, Delhi, Ahmedabad, Guwahati, Surat and Hyderabad. Today, we manufacture, wholesale, export and import a wide range of filtration products, from simple cartridges to complete RO systems built for demanding industrial use. Our customers span many industries, including food, pharma, chemicals and water treatment plants, and every product goes through careful quality checks before it reaches you.</p>
        </div>

        <div class="about_video_wrap">
            <img src="{{ asset('front/img/figma/about/about-video-bg.webp') }}" alt="Pratham Filter Industries facility" class="about_video_img" loading="lazy">
            <a class="about_video_play" href="{{ asset('front/img/figma/about/aboutvideo.mp4') }}" data-fancybox="company-video" data-width="1280" data-height="720" aria-label="Play company video">
                <img src="{{ asset('front/img/figma/about/video-play-icon.png') }}" alt="">
            </a>
            <span class="about_video_caption" aria-hidden="true"><i class="fa-solid fa-circle-play"></i> Inside our facility</span>
        </div>

        <div class="about_quality">
            <h3>Quality checked at every stage, from raw material to dispatch</h3>
            <p class="sub_text_p16 about_intro_text">Every product that leaves our facility passes through careful checks. Our teams test each batch for strength, fit and performance, so what you install works the way it should, right from day one. This focus on quality is not a one-time step; it runs through every single stage, from raw material selection to final packing and dispatch. Two decades of doing this consistently is what lets industries trust Pratham with their filtration needs, project after project, and year after year, without fail, every time.</p>
        </div>
    </div>
</section>

<section class="section_padding section_tinted">
    <div class="container">
        <div class="section_head">
            <span class="eyebrow">Our Journey</span>
            <h2 class="title">Two decades of steady growth</h2>
        </div>
        <ol class="journey_list">
            <li class="journey_item"><span class="journey_year">2003</span><p class="journey_text">Founded in Mumbai as a water filter trading business</p></li>
            <li class="journey_item"><span class="journey_year">2005</span><p class="journey_text">Began manufacturing water filters</p></li>
            <li class="journey_item"><span class="journey_year">2013</span><p class="journey_text">Partnership with Pentair</p></li>
            <li class="journey_item"><span class="journey_year">2019</span><p class="journey_text">Partnership with DuPont</p></li>
            <li class="journey_item"><span class="journey_year">2022</span><p class="journey_text">Partnership with Tata</p></li>
            <li class="journey_item"><span class="journey_year">Today</span><p class="journey_text">Branches in eight cities across India</p></li>
        </ol>
    </div>
</section>

<section class="section_padding">
    <div class="container">
        <div class="vmp_head">
            <span class="eyebrow">What Drives Us</span>
            <div class="vmp_title" role="tablist" aria-label="Vision, mission and purpose">
                <button class="vmp_tab active" type="button" role="tab" id="vmpTabVision" aria-selected="true" aria-controls="vmpPanelVision" data-panel="vision">Vision.</button>
                <button class="vmp_tab" type="button" role="tab" id="vmpTabMission" aria-selected="false" aria-controls="vmpPanelMission" tabindex="-1" data-panel="mission">Mission.</button>
                <button class="vmp_tab" type="button" role="tab" id="vmpTabPurpose" aria-selected="false" aria-controls="vmpPanelPurpose" tabindex="-1" data-panel="purpose">Purpose.</button>
            </div>
        </div>

        <div class="vmp_card">
            <div class="vmp_panel active" data-panel="vision" id="vmpPanelVision" role="tabpanel" aria-labelledby="vmpTabVision">
                <div class="vmp_panel_body">
                    <div class="vmp_panel_art">
                        <img src="{{ asset('front/img/figma/about/vision-artwork.png') }}" alt="Vision" loading="lazy">
                    </div>
                    <div class="vmp_panel_text">
                        <h3 class="vmp_panel_title">Vision</h3>
                        <p class="sub_text_p16">Our vision is simple: to become the most trusted filtration partner for industries across India and beyond. We want every business, big or small, to have access to filtration systems that are reliable, easy to maintain, and built to last, no matter how demanding or unpredictable the application is.</p>
                        <p class="sub_text_p16">We see a future where clean water is never treated as a luxury, but as a standard every industry can count on. To get there, we keep investing in better technology, stronger partnerships with global brands, and a wider product range that covers every stage of water treatment, from the very first filter to the final, clean drop that reaches your process, your plant, or your people.</p>
                    </div>
                </div>
            </div>

            <div class="vmp_panel" data-panel="mission" id="vmpPanelMission" role="tabpanel" aria-labelledby="vmpTabMission">
                <div class="vmp_panel_body">
                    <div class="vmp_panel_art">
                        <img src="{{ asset('front/img/figma/about/vision-artwork.png') }}" alt="Mission" loading="lazy">
                    </div>
                    <div class="vmp_panel_text">
                        <h3 class="vmp_panel_title">Mission</h3>
                        <p class="sub_text_p16">Our mission is to make reliable filtration accessible to every industry that needs it, without exception. We do this by manufacturing, testing, and delivering products that meet real-world demands, not just paper specifications, so our customers can run their daily operations without worry, delay, or downtime.</p>
                        <p class="sub_text_p16">Every day, this means listening closely to what our customers actually need, choosing the right materials and partners, and standing firmly behind our products long after they leave our facility. We keep growing our product range and our reach across India, so that reliable filtration is always within reach, wherever your industry operates.</p>
                    </div>
                </div>
            </div>

            <div class="vmp_panel" data-panel="purpose" id="vmpPanelPurpose" role="tabpanel" aria-labelledby="vmpTabPurpose">
                <div class="vmp_panel_body">
                    <div class="vmp_panel_art">
                        <img src="{{ asset('front/img/figma/about/vision-artwork.png') }}" alt="Purpose" loading="lazy">
                    </div>
                    <div class="vmp_panel_text">
                        <h3 class="vmp_panel_title">Purpose</h3>
                        <p class="sub_text_p16">Our purpose is to help industries work better with clean, reliable, and accessible filtration solutions. We focus on protecting equipment, improving processes, and saving resources.</p>
                        <p class="sub_text_p16">By combining practical experience, dependable products, and customer-focused solutions, we make water treatment simpler and more efficient. Whether small or large-scale, our solutions are built to deliver reliable performance and long-term value.</p>
                    </div>
                </div>
            </div>

            <button class="vmp_next_btn" type="button" aria-label="Show next">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
        </div>
    </div>
</section>

<section class="section_padding_bot">
    <div class="container">
        <div class="founder_row">
            <div class="founder_details">
                <span class="eyebrow">Our Founder</span>
                <h2 class="title">The Man Behind Pratham</h2>
                <p class="sub_text_p16">Ajay Kumar Shroff started Pratham Filter Industries in 2003 with a single small office in Mumbai. What began as a modest water filter trading business grew steadily, driven by hard work and a clear focus on quality. Over the next 15 years, he expanded into Chennai, Kolkata, Pune, Delhi, Ahmedabad, Guwahati, Surat and Hyderabad, building a strong, trusted presence across India, one city at a time.</p>
                <p class="sub_text_p16">Alongside this growth, Ajay began manufacturing water filters in 2005 and went on to build partnerships with respected global brands, including Pentair in 2013, DuPont in 2019 and Tata in 2022. With a background in commerce, technology and finance, he continues to attend major water industry expos, staying close to new ideas and changing customer needs. His approach has stayed simple: build products people can rely on, and grow the business the right way.</p>
                <p class="founder_signoff">Ajay Shroff <small>Founder</small></p>
            </div>
            <div class="founder_visual">
                <img src="{{ asset('front/img/figma/about/founder-wordmark.svg') }}" alt="" class="founder_wordmark">
                <img src="{{ asset('front/img/figma/about/founder-visual-photo.png') }}" alt="Pratham Filter Industries team" class="founder_photo" loading="lazy">
                <div class="founder_photo_fade"></div>
                <div class="founder_visual_label">
                    <span class="founder_label">Founder</span>
                    <img src="{{ asset('front/img/figma/about/founder-signature.png') }}" alt="Signature" class="founder_signature" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>

@if ($brands->isNotEmpty())
<section class="section_padding_bot">
    <div class="container">
        <div class="partners_bar">
            <div class="partners_intro">
                <h2 class="partners_title">Our Brands</h2>
                <p>Trusted product lines from Pratham Filter Industries.</p>
            </div>
            <div class="client client_slider about_brands_logos">
                @foreach ($brands as $brand)
                @if ($brand->icon)
                <div class="slider_item"><img src="{{ asset('admin-assets/our-brands/icon/' . $brand->icon) }}" alt="{{ $brand->icon_alt }}"></div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.1/dist/fancybox/fancybox.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.1/dist/fancybox/fancybox.umd.js"></script>
<script>
    Fancybox.bind('[data-fancybox="company-video"]', {
        Carousel: {
            Video: {
                autoplay: true
            }
        }
    });
</script>
@endpush

@endsection
