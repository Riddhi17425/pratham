<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Pratham Filter Industries')">
    <title>@yield('title', 'Pratham Filter Industries')</title>

    <link rel="icon" href="{{ asset('front/img/favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('front/img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('front/img/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('front/img/apple-touch-icon.png') }}">

    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}?v={{ filemtime(public_path('front/css/style.css')) }}">
    <link rel="stylesheet" href="{{ asset('front/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/search.css') }}">

    @yield('page_styles')
    @stack('styles')
</head>
<body class="@yield('body_class')">
    @include('front.layouts.header')

    <main>
        @yield('content')
    </main>

    @include('front.layouts.footer')
   
    <div class="quote_modal_backdrop" id="quoteModalBackdrop"></div>
    <div class="quote_modal" id="quoteModal" role="dialog" aria-modal="true" aria-labelledby="quoteModalTitle">
        <button class="quote_modal_close js-close-quote" type="button" aria-label="Close">
            <svg width="24" height="24" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.7882 10.7878C11.4577 10.1183 12.5431 10.1183 13.2126 10.7878L24.0004 21.5756L34.7882 10.7878C35.4577 10.1183 36.5431 10.1183 37.2126 10.7878C37.8821 11.4573 37.8821 12.5427 37.2126 13.2122L26.4248 24L37.2126 34.7878C37.8821 35.4573 37.8821 36.5427 37.2126 37.2122C36.5431 37.8817 35.4577 37.8817 34.7882 37.2122L24.0004 26.4244L13.2126 37.2122C12.5431 37.8817 11.4577 37.8817 10.7882 37.2122C10.1188 36.5427 10.1188 35.4573 10.7882 34.7878L21.5761 24L10.7882 13.2122C10.1188 12.5427 10.1188 11.4573 10.7882 10.7878Z" fill="currentColor"/>
            </svg>
        </button>
        <div class="quote_modal_header">
            <h2 class="title quote_modal_title" id="quoteModalTitle">Request A Quote</h2>
            <span class="quote_modal_underline"></span>
        </div>
        <form class="quote_modal_form">
            <div class="contact_field"><input type="text" placeholder="Name" required></div>
            <div class="contact_field"><input type="email" placeholder="Email ID" required></div>
            <div class="contact_field"><input type="tel" placeholder="Phone Number"></div>
            <div class="contact_field quote_modal_select">
                <select required>
                    <option value="" disabled selected>Products</option>
                    <option>Spun Filter Cartridge</option>
                    <option>Filter Bags</option>
                    <option>Pleated PP High Efficiency</option>
                    <option>Activated Carbon Cartridge</option>
                    <option>Washable Cartridge</option>
                    <option>SS Filter Cartridge</option>
                    <option>Other</option>
                </select>
            </div>
            <div class="contact_field"><textarea placeholder="Message" rows="4"></textarea></div>
            <button class="purple-btn quote_modal_submit" type="submit">Get A Quote</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    <script src="{{ asset('front/js/main.js') }}"></script>
    <script src="{{ asset('front/js/animations.js') }}"></script>
    <script src="{{ asset('front/js/search.js') }}"></script>

    @yield('page_scripts')
    @stack('scripts')
</body>
</html>
