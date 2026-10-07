@extends('front.app')

@section('title', 'Thank You | Pratham Filter Industries')
@section('body_class', 'thank-you-page')

@section('content')
<section class="thank_you_section">
    <div class="container">
        <div class="thank_you_card">
            <div class="thank_you_art" aria-hidden="true">
                <span class="thank_you_orbit thank_you_orbit_outer"></span>
                <span class="thank_you_orbit thank_you_orbit_inner"></span>
                <span class="thank_you_spark thank_you_spark_one"></span>
                <span class="thank_you_spark thank_you_spark_two"></span>
                <svg class="thank_you_drop" viewBox="0 0 160 190" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="thankYouDropGradient" x1="30" y1="20" x2="130" y2="170" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#00A0E3"/>
                            <stop offset="1" stop-color="#393185"/>
                        </linearGradient>
                    </defs>
                    <path d="M80 8C80 8 20 81 20 119C20 152.137 46.8629 179 80 179C113.137 179 140 152.137 140 119C140 81 80 8 80 8Z" fill="url(#thankYouDropGradient)"/>
                    <path d="M51 118C51 101 62 81 75 63" stroke="white" stroke-opacity=".55" stroke-width="8" stroke-linecap="round"/>
                    <circle cx="80" cy="120" r="24" fill="white" fill-opacity=".96"/>
                    <path d="M69 120L77 128L93 111" stroke="#393185" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <span class="thank_you_eyebrow">MESSAGE RECEIVED</span>
            <h1 class="thank_you_title">Thank you for reaching out</h1>
            <p class="thank_you_text">{{ session('contact_status', 'Your inquiry has been received. Our team will get back to you soon.') }}</p>
            <div class="thank_you_actions">
                <a href="{{ route('home') }}" class="purple-btn">Back to Home</a>
                <a href="{{ route('products') }}" class="purple-btn-solid">Explore Products <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
</section>
@endsection
