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
        <p class="sub_text_p16 about_intro_text">Since 2003, Pratham Filter Industries has grown from a small manufacturing unit into a trusted name in water and industrial filtration. What started as a focused effort to solve local filtration challenges has evolved into a full-scale operation serving industries across ETP, RO, desalination, food and beverage, pharma, and electroplating sectors.</p>

        <div class="about_video_wrap">
            <img src="{{ asset('front/img/figma/about/about-video-bg.webp') }}" alt="Pratham Filter Industries facility" class="w-100">
            <a class="about_video_play" href="{{ asset('front/img/figma/about/aboutvideo.mp4') }}" data-fancybox="company-video" data-width="1280" data-height="720" aria-label="Play company video">
                <img src="{{ asset('front/img/figma/about/video-play-icon.png') }}" alt="">
            </a>
           
        </div>

        <p class="sub_text_p16 about_intro_text">Today, we manufacture, wholesale, export, and import a complete range of filtration equipment &mdash; from filter housings and RO membranes to FRP pressure vessels certified to NSF and PED standards. Every product we ship reflects two decades of engineering discipline and an unwavering commitment to quality.</p>
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
                        <p class="sub_text_p16">To be the most trusted name in water and industrial filtration across India and beyond, recognized for engineering excellence, reliability, and a genuine commitment to sustainable water management.</p>
                        <p class="sub_text_p16">We envision a future where clean water access is never a barrier to industrial growth &mdash; where every filtration system we manufacture plays a small part in that larger mission.</p>
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
                        <p class="sub_text_p16">To design, manufacture, and deliver filtration solutions that meet the exact demands of our customers &mdash; with stringent quality control, responsive service, and continuous innovation in every product line we offer.</p>
                        <p class="sub_text_p16">We are committed to building long-term partnerships with the industries we serve, backed by technical expertise and dependable after-sales support.</p>
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
                        <p class="sub_text_p16">We exist to make water treatment simpler, safer, and more accessible for the industries that depend on it &mdash; from small workshops to large-scale manufacturing plants.</p>
                        <p class="sub_text_p16">Every filter housing, membrane, and pressure vessel we build carries forward our founding belief: that quality filtration should never be out of reach.</p>
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
        <h2 class="title mb-4">Built On Two Decades Of Trust</h2>
        <div class="founder_row">
            <div class="founder_details">
                <p class="sub_text_p16">Pratham Filter Industries was founded in 2003 with a simple goal &mdash; to bring reliable, high-quality filtration equipment to industries that couldn&rsquo;t compromise on water treatment. What began as a small manufacturing setup has since grown into a name trusted across ETP, RO, and industrial filtration sectors nationwide.</p>
                <p class="sub_text_p16">Two decades on, that founding philosophy hasn&rsquo;t changed. Every product we manufacture is still held to the same standard: built to perform, built to last, and backed by a team that genuinely cares about getting it right.</p>
                <p class="founder_signoff mt-3">- Ajay Shah</p>
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
