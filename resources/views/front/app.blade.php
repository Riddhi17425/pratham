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

    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/search.css') }}">

    @yield('page_styles')
    @stack('styles')
</head>
<body>
    <header id="header">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand brand_lockup" href="{{ url('/') }}">
                    <img src="{{ asset('front/img/pratham-logo.png') }}" alt="Pratham Filter Industries" class="logo_img">
                    <img src="{{ asset('front/img/flo-logo.png') }}" alt="FLO" class="brand_flo_logo">
                </a>

                <button class="search_toggle search_toggle_mobile js-open-search" type="button" aria-label="Search" aria-expanded="false" aria-controls="searchPanel">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>

                <button class="navbar-toggler" id="hamburgerToggle" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                        <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About Us</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle no-caret" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Products
                                <svg class="dropdown_arrow" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19.92 8.95L13.4 15.47C12.63 16.24 11.37 16.24 10.6 15.47L4.08002 8.95" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ url('/product-detail?p=Spun+Filter+Cartridge') }}">Spun Filter Cartridge</a></li>
                                <li><a class="dropdown-item" href="{{ url('/product-detail?p=Filter+Bags') }}">Filter Bags</a></li>
                                <li><a class="dropdown-item" href="{{ url('/product-detail?p=Pleated+PP+High+Efficiency') }}">Pleated PP High Efficiency</a></li>
                                <li><a class="dropdown-item" href="{{ url('/product-detail?p=Activated+Carbon+Cartridge') }}">Activated Carbon Cartridge</a></li>
                                <li><a class="dropdown-item" href="{{ url('/product-detail?p=Washable+Cartridge') }}">Washable Cartridge</a></li>
                                <li><a class="dropdown-item" href="{{ url('/product-detail?p=SS+Filter+Cartridge') }}">SS Filter Cartridge</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ url('/products') }}">All Products</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/news-events') }}">Events</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/blog') }}">Blogs</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">Contact Us</a></li>
                    </ul>

                    <div class="header_actions ms-lg-4">
                        <button class="search_toggle search_toggle_desktop js-open-search" type="button" aria-label="Search" aria-expanded="false" aria-controls="searchPanel">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        <button class="purple-btn-solid js-open-quote" type="button">Request for Quote</button>
                    </div>
                </div>
            </div>
        </nav>

        <div class="search_panel" id="searchPanel" aria-hidden="true">
            <div class="container-fluid">
                <form class="search_form" action="{{ url('/products') }}" method="get" role="search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" name="q" id="siteSearchInput" placeholder="Search products, articles, pages..." autocomplete="off" aria-label="Search the site">
                    <button type="button" class="search_close js-close-search" aria-label="Close search"><i class="fa-solid fa-xmark"></i></button>
                </form>
                <ul class="search_results" id="searchResults" role="listbox"></ul>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <a href="{{ url('/') }}" class="brand_lockup justify-content-center justify-content-md-start">
                        <img src="{{ asset('front/img/footer-pratham-logo.png') }}" alt="Pratham Filter Industries" class="logo_img">
                        <img src="{{ asset('front/img/footer-flo-logo.png') }}" alt="FLO" class="brand_flo_logo">
                    </a>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="footer_social">
                        <a href="#" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 34 34" fill="none"><g clip-path="url(#clip0_41_312)"><path d="M31.4832 0H2.51016C1.12227 0 0 1.0957 0 2.45039V31.543C0 32.8977 1.12227 34 2.51016 34H31.4832C32.8711 34 34 32.8977 34 31.5496V2.45039C34 1.0957 32.8711 0 31.4832 0ZM10.0871 28.973H5.04023V12.7434H10.0871V28.973ZM7.56367 10.532C5.94336 10.532 4.63516 9.22383 4.63516 7.61016C4.63516 5.99648 5.94336 4.68828 7.56367 4.68828C9.17734 4.68828 10.4855 5.99648 10.4855 7.61016C10.4855 9.21719 9.17734 10.532 7.56367 10.532ZM28.973 28.973H23.9328V21.084C23.9328 19.2047 23.8996 16.7809 21.3098 16.7809C18.6867 16.7809 18.2883 18.8328 18.2883 20.9512V28.973H13.2547V12.7434H18.0891V14.9613H18.1555C18.8262 13.6863 20.473 12.3383 22.9234 12.3383C28.0301 12.3383 28.973 15.6984 28.973 20.068V28.973Z" fill="#181818"/></g><defs><clipPath id="clip0_41_312"><rect width="34" height="34" fill="white"/></clipPath></defs></svg></a>
                        <a href="#" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 34 34" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M22.5894 32.5834L14.7277 21.3777L4.88589 32.5834H0.722168L12.8805 18.7441L0.722168 1.41675H11.4123L18.8218 11.978L28.1056 1.41675H32.2693L20.6753 14.6151L33.2795 32.5834H22.5894ZM27.2262 29.4243H24.423L6.68399 4.57591H9.48757L16.5922 14.5254L17.8207 16.2519L27.2262 29.4243Z" fill="#181818"/></svg></a>
                        <a href="#" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M15.6047 0.0927316C13.4128 0.389688 10.8068 1.3043 8.84131 2.46655C4.25749 5.17689 1.05443 9.8848 0.180668 15.1957C-0.146253 17.1833 -0.0173502 20.3176 0.469144 22.2038C1.38659 25.7619 3.09242 28.6856 5.66016 31.1011C9.0772 34.3157 13.3498 36.0127 18.0075 36.0054C21.0598 36.0006 23.4749 35.4231 26.1537 34.0577C30.7916 31.6936 34.1554 27.5172 35.4977 22.4563C35.9182 20.8711 35.94 20.6568 35.9487 18.0342C35.9572 15.4408 35.9339 15.1862 35.5528 13.7233C33.7445 6.78111 28.485 1.75179 21.5043 0.28976C20.1894 0.0142877 16.9757 -0.0929899 15.6047 0.0927316ZM20.9757 8.00526C24.4515 9.09047 27.0178 11.7009 27.9928 15.1431C28.445 16.7394 28.4468 19.0772 27.9972 20.6427C26.7626 24.9417 23.1003 27.9098 18.7142 28.1662C16.9784 28.2675 15.6897 28.066 14.1785 27.4567L13.0492 27.0013L11.5707 27.3888C8.69233 28.1435 7.73687 28.3755 7.70267 28.3288C7.68359 28.3027 7.98394 27.1278 8.36994 25.7178L9.07197 23.154L8.62845 22.0886C7.17561 18.599 7.52995 15.0931 9.64992 11.9803C11.0808 9.87943 13.3376 8.38758 16.0097 7.77628C17.2474 7.49304 19.6971 7.60611 20.9757 8.00526ZM17.1595 9.36594C15.2114 9.66389 13.5112 10.4714 12.1789 11.7317C11.0784 12.7727 10.4386 13.7615 9.91507 15.2307C9.59748 16.1217 9.54589 16.496 9.54744 17.8929C9.54942 19.6731 9.79465 20.66 10.5869 22.077L10.9901 22.7981L10.5792 24.3292C10.3534 25.1715 10.185 25.8769 10.2052 25.8971C10.2253 25.9173 10.9341 25.7482 11.7802 25.5212L13.3184 25.1084L14.3202 25.5951C16.8598 26.8288 19.8096 26.7354 22.3101 25.3421C24.09 24.3502 25.8167 22.0955 26.3427 20.0763C26.6214 19.0062 26.6214 16.7795 26.3427 15.7094C25.6049 12.8768 23.0783 10.3549 20.269 9.64678C19.3122 9.40566 17.7955 9.26856 17.1595 9.36594ZM15.2911 13.0531C15.5964 13.3905 16.3594 15.5089 16.2706 15.7728C16.2313 15.8894 16.0177 16.1937 15.796 16.4491C15.5742 16.7043 15.3927 16.9995 15.3927 17.1049C15.3927 17.4202 16.5832 18.9387 17.2473 19.4702C18.11 20.1608 18.8375 20.5783 19.1782 20.5783C19.344 20.5783 19.7067 20.306 20.0916 19.8075C20.4764 19.309 21.0128 18.406 21.8359 18.406C22.5431 18.406 23.5967 19.1236 24.0595 19.7702C24.3337 20.1467 24.4558 20.4781 24.4558 20.6072C24.4558 20.7519 24.3514 21.1004 24.1024 21.2371C23.2363 21.6949 22.4373 21.8719 21.6177 21.8218C20.0824 21.7351 18.2216 20.5369 16.5928 18.8235C15.4435 17.7255 14.427 16.0585 13.6883 13.7312C13.0774 11.9887 12.9998 11.6424 13.1407 11.3688C13.2411 11.1683 13.4194 11.0979 13.8638 11.0979C14.748 11.0979 15.3386 11.5929 15.2911 13.0531Z" fill="#181818"/></svg></a>
                        <a href="#" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 34 34" fill="none"><g clip-path="url(#clip0_41_315)"><path d="M34 17C34 7.61115 26.3888 0 17 0C7.61115 0 0 7.61115 0 17C0 25.4851 6.21662 32.5181 14.3438 33.7935V21.9141H10.0273V17H14.3438V13.2547C14.3438 8.99406 16.8818 6.64062 20.7649 6.64062C22.6243 6.64062 24.5703 6.97266 24.5703 6.97266V11.1562H22.4267C20.315 11.1562 19.6562 12.4668 19.6562 13.8125V17H24.3711L23.6174 21.9141H19.6562V33.7935C27.7834 32.5181 34 25.4851 34 17Z" fill="#181818"/></g><defs><clipPath id="clip0_41_315"><rect width="34" height="34" fill="white"/></clipPath></defs></svg></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="ft_content">
            <div class="container">
                <div class="ft_main_row">
                    <div class="ft_col">
                        <ul class="footer_menu">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ url('/about') }}">About Us</a></li>
                            <li><a href="{{ url('/products') }}">Products</a></li>
                            <li><a href="{{ url('/technical-brochure') }}">Technical Brochure</a></li>
                        </ul>
                    </div>
                    <span class="ft_divider"></span>
                    <div class="ft_col">
                        <ul class="footer_menu">
                            <li><a href="{{ url('/news-events') }}">Events</a></li>
                            <li><a href="{{ url('/blog') }}">Blog</a></li>
                            <li><a href="#" class="js-open-quote">Get a Quote</a></li>
                            <li><a href="{{ url('/contact') }}">Contact Us</a></li>
                        </ul>
                    </div>
                    <span class="ft_divider"></span>
                    <div class="ft_col ft_col_contact">
                        <div class="footer_menu">
                            <p><span><i class="fa-solid fa-location-dot"></i></span> <a href="#">K 12 A, Ansa Indl Estate, Saki Vihar Road, Andheri (E), Mumbai-400072.</a></p>
                            <p><span><i class="fa-solid fa-phone"></i></span> <a href="tel:+919820246044">+91 98 202 46044</a></p>
                            <p><span><i class="fa-solid fa-envelope"></i></span><a href="mailto:ajay@prathamfilter.com">ajay@prathamfilter.com</a></p>
                        </div>
                    </div>
                    <span class="ft_divider"></span>
                    <div class="ft_col ft_col_quote">
                        <h5 class="f_18">Request A Quote</h5>
                        <p>Get in touch with our team for a solution built around your needs.</p>
                        <button class="dark-btn js-open-quote" type="button">Request A Quote</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row pb-3">
                <div class="ym_copyright text-center">
                    <p class="mb-0">Copyright ©2026 Pratham Filter Industries. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

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
