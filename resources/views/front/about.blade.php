@extends('front.app')

@section('title', 'Pratham Filter Industries | about')

@section('content')


<section class="page_hero" style="background-image: url('{{ asset('front/img/figma/about/page-hero-bg.jpg') }}');">
    <div class="page_hero_overlay"></div>
    <div class="container position-relative">
        <div class="page_hero_content">
            <div class="breadcrumb_row">
                <a href="{{ url('/') }}">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>About us</span>
            </div>
            <h1 class="page_hero_title">About Us</h1>
        </div>
    </div>
</section>

<section class="section_padding">
    <div class="container about_intro">
        <p class="sub_text_p16 about_intro_text">Since 2003, Pratham Filter Industries has been helping industries meet their water filtration needs with reliable solutions. What started as a small water filter trading business in Mumbai has grown into a trusted name across India, with branches in Chennai, Kolkata, Pune, Delhi, Ahmedabad, Guwahati, Surat and Hyderabad. Today, we manufacture, wholesale, export and import a wide range of filtration products, from simple cartridges to complete RO systems built for demanding industrial use. Our customers span many industries, including food, pharma, chemicals and water treatment plants, and every product goes through careful quality checks before it reaches you. </p>

        <div class="about_video_wrap">
            <img src="{{ asset('front/img/figma/about/about-video-bg.webp') }}" alt="Pratham Filter Industries facility" class="w-100 about_video_img">
            <a class="about_video_play" href="{{ asset('front/img/figma/about/aboutvideo.mp4') }}" data-fancybox="company-video" data-width="1280" data-height="720" aria-label="Play company video">
                <img src="{{ asset('front/img/figma/about/video-play-icon.png') }}" alt="">
            </a>
           
        </div>

        <p class="sub_text_p16 about_intro_text">Every product that leaves our facility passes through careful checks. Our teams test each batch for strength, fit and performance, so what you install works the way it should, right from day one. This focus on quality is not a one-time step; it runs through every single stage, from raw material selection to final packing and dispatch. Two decades of doing this consistently is what lets industries trust Pratham with their filtration needs, project after project, and year after year, without fail, every time.</p>
    </div>
</section>

<section>
    <div class="container">
        <h2 class="title vmp_title"><span class="vmp_tab active" data-panel="vision">Vision.</span> <span class="vmp_tab" data-panel="mission">Mission.</span> <span class="vmp_tab" data-panel="purpose">Purpose.</span></h2>

        <div class="vmp_card">
            <span class="vmp_border_line vmp_border_top"></span>
            <span class="vmp_border_line vmp_border_bottom"></span>
            <span class="vmp_border_side vmp_border_left"></span>
            <span class="vmp_border_side vmp_border_right"></span>
            <div class="vmp_panel active" data-panel="vision">
                <div class="vmp_panel_body">
                    <div class="vmp_panel_art">
                        <img src="{{ asset('front/img/figma/about/vision-artwork.png') }}" alt="Vision" class="w-100">
                    </div>
                    <div class="vmp_panel_text">
                        <h3 class="vmp_panel_title">Vision</h3>
                        <p class="sub_text_p16">Our vision is simple: to become the most trusted filtration partner for industries across India and beyond. We want every business, big or small, to have access to filtration systems that are reliable, easy to maintain, and built to last, no matter how demanding or unpredictable the application is.</p>
                        <p class="sub_text_p16">We see a future where clean water is never treated as a luxury, but as a standard every industry can count on. To get there, we keep investing in better technology, stronger partnerships with global brands, and a wider product range that covers every stage of water treatment, from the very first filter to the final, clean drop that reaches your process, your plant, or your people.</p>
                    </div>
                </div>
            </div>

            <div class="vmp_panel" data-panel="mission">
                <div class="vmp_panel_body">
                    <div class="vmp_panel_art">
                        <img src="{{ asset('front/img/figma/about/vision-artwork.png') }}" alt="Mission" class="w-100">
                    </div>
                    <div class="vmp_panel_text">
                        <h3 class="vmp_panel_title">Mission</h3>
                        <p class="sub_text_p16">Our mission is to make reliable filtration accessible to every industry that needs it, without exception. We do this by manufacturing, testing, and delivering products that meet real-world demands, not just paper specifications, so our customers can run their daily operations without worry, delay, or downtime.</p>
                        <p class="sub_text_p16">Every day, this means listening closely to what our customers actually need, choosing the right materials and partners, and standing firmly behind our products long after they leave our facility. We keep growing our product range and our reach across India, so that reliable filtration is always within reach, wherever your industry operates.</p>
                    </div>
                </div>
            </div>

            <div class="vmp_panel" data-panel="purpose">
                <div class="vmp_panel_body">
                    <div class="vmp_panel_art">
                        <img src="{{ asset('front/img/figma/about/vision-artwork.png') }}" alt="Purpose" class="w-100">
                    </div>
                    <div class="vmp_panel_text">
                        <h3 class="vmp_panel_title">Purpose</h3>
                        <p class="sub_text_p16">Our purpose is to help industries work better with clean, reliable, and accessible filtration solutions. We focus on protecting equipment, improving processes, and saving resources.</p>
                        <p class="sub_text_p16">By combining practical experience, dependable products, and customer-focused solutions, we make water treatment simpler and more efficient. Whether small or large-scale, our solutions are built to deliver reliable performance and long-term value.</p>
                    </div>
                </div>
            </div>

            <button class="vmp_next_btn" type="button" aria-label="Show next">
                <svg width="18" height="19" viewBox="0 0 30 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.0001 5.5238C15.5919 5.5238 16.0716 6.03548 16.0716 6.66666V22.5742L21.7425 16.5252C22.1609 16.0789 22.8393 16.0789 23.2578 16.5252C23.6762 16.9715 23.6762 17.6951 23.2578 18.1414L15.7578 26.1414C15.5568 26.3558 15.2843 26.4762 15.0001 26.4762C14.716 26.4762 14.4435 26.3558 14.2425 26.1414L6.74252 18.1414C6.32411 17.6951 6.32411 16.9715 6.74253 16.5252C7.16094 16.0789 7.83934 16.0789 8.25775 16.5252L13.9287 22.5742V6.66666C13.9287 6.03548 14.4084 5.5238 15.0001 5.5238Z" fill="currentColor"/>
                </svg>
            </button>
        </div>
    </div>
</section>

<section class="section_padding_top">
    <div class="container">
        <h2 class="title mb-4">The Man Behind Pratham</h2>
        <div class="founder_row">
            <div class="founder_details">
                <p class="sub_text_p16">Ajay Kumar Shroff started Pratham Filter Industries in 2003 with a single small office in Mumbai. What began as a modest water filter trading business grew steadily, driven by hard work and a clear focus on quality. Over the next 15 years, he expanded into Chennai, Kolkata, Pune, Delhi, Ahmedabad, Guwahati, Surat and Hyderabad, building a strong, trusted presence across India, one city at a time.</p>
                <p class="sub_text_p16">Alongside this growth, Ajay began manufacturing water filters in 2005 and went on to build partnerships with respected global brands, including Pentair in 2013, DuPont in 2019 and Tata in 2022. With a background in commerce, technology and finance, he continues to attend major water industry expos, staying close to new ideas and changing customer needs. His approach has stayed simple: build products people can rely on, and grow the business the right way.</p>
                <p class="founder_signoff mt-3">- Ajay Shroff</p>
            </div>
            <div class="founder_visual">
                <img src="{{ asset('front/img/figma/about/founder-wordmark.svg') }}" alt="" class="founder_wordmark">
                <img src="{{ asset('front/img/figma/about/founder-visual-photo.png') }}" alt="Pratham Filter Industries team" class="founder_photo">
                <div class="founder_photo_fade"></div>
                <div class="founder_visual_label">
                    <span class="founder_label">Founder</span>
                    <img src="{{ asset('front/img/figma/about/founder-signature.png') }}" alt="Signature" class="founder_signature">
                </div>
            </div>
        </div>
    </div>
</section>

@if ($brands->isNotEmpty())
<section class="section_padding">
    <div class="container">
        <div class="row align-items-center client_border">
            <div class="col-md-2">
                <h2 class="client_title">Our <br>Brands</h2>
            </div>
            <div class="col-md-10 about_brands_logos">
                <div class="client client_slider">
                    @foreach ($brands as $brand)
                    @if ($brand->icon)
                    <div class="slider_item"><img src="{{ asset('admin-assets/our-brands/icon/' . $brand->icon) }}" alt="{{ $brand->icon_alt }}" class="w-100"></div>
                    @endif
                    @endforeach
                </div>
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
