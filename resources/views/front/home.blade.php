@extends('front.app')

@section('title', 'Pratham Filter Industries | Home')

@section('content')
@if ($banners->isNotEmpty())
<section class="hero_area">
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
        @endphp
        <div class="hero_slide" style="background: linear-gradient(135deg, #F6F2F2 0%, #D9D9D9 100%);">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="hero_content">
                            <h1 class="hero_title">{{ $banner->title }}</h1>
                            <p class="sub_text_p16">{{ $banner->description }}</p>
                            <a class="purple-btn" href="{{ $exploreUrl }}">{{ $exploreText }}</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="hero_img_wrap">
                            @if ($banner->image)
                            <img src="{{ asset('admin-assets/banners/image/' . $banner->image) }}" alt="{{ $banner->image_alt ?: $banner->title }}" class="w-100">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="hero_dots"></div>
</section>
@endif

@if ($partners->isNotEmpty())
<section class="section_padding">
    <div class="container container_flush">
        <div class="row align-items-center client_border we_represent_row">
            <div class="col-md-3 we_represent_title">
                <h2 class="client_title">We Represent</h2>
                <p class="sub_text_p16 mt-2">Proud partners with global leaders in filtration and water treatment technology.</p>
            </div>
            <div class="col-md-9 we_represent_logos">
                <div class="client client_slider">
                    @foreach ($partners as $partner)
                    @if ($partner->icon)
                    <div class="slider_item">
                        <img src="{{ asset('admin-assets/partners/icon/' . $partner->icon) }}" alt="{{ $partner->icon_alt }}" class="w-100">
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<section>
    <div class="container container_flush">
        <div class="collage_grid_row1">
            <div class="collage_col collage_col_empty">
                <div class="filter_card h-100">
                    <img src="{{ asset('front/img/figma/collage-bag-filter-assembly.png') }}" alt="Bag Filter Assembly" class="img_pos_bagfilter">
                    <div class="overlay"><p>Bag Filter Assembly</p></div>
                </div>
            </div>
            <div class="collage_col collage_col_cartridge">
                <div class="filter_card h-100">
                    <img src="{{ asset('front/img/figma/collage-ss-filter-cartridge.png') }}" alt="SS Filter Cartridge" class="img_pos_sscartridge">
                    <div class="overlay"><p>SS Filter Cartridge</p></div>
                </div>
            </div>
            <div class="collage_col collage_col_title">
                <div class="collage_title_card">
                    <h2 class="title mb-0">Manufactured for ETP,<br>RO, and Beyond </h2>
                    <!-- <button class="purple-btn" type="submit">Explore Products</button> -->
                </div>
            </div>
        </div>
        <div class="collage_grid_row2">
            <div class="collage_col collage_col_stringwound">
                <div class="filter_card h-100">
                    <img src="{{ asset('front/img/figma/collage-string-wound.png') }}" alt="String Wound Cartridge" class="img_pos_stringwound">
                    <div class="overlay"><p>String Wound Cartridge</p></div>
                </div>
            </div>
            <div class="collage_col collage_col_housing">
                <div class="collage_stack">
                    <div class="filter_card">
                        <img src="{{ asset('front/img/figma/collage-plastic-filter-housing.png') }}" alt="Plastic Filter Housing" class="img_pos_plastichousing">
                        <div class="overlay"><p>Plastic Filter Housing</p></div>
                    </div>
                    <div class="filter_card">
                        <img src="{{ asset('front/img/figma/collage-cartridges.png') }}" alt="Cartridges" class="img_pos_cartridges">
                        <div class="overlay"><p>Cartridges</p></div>
                    </div>
                </div>
            </div>
            <div class="collage_col collage_col_filter">
                <div class="filter_card h-100">
                    <img src="{{ asset('front/img/figma/collage-filter-large.png') }}" alt="Filter" class="img_pos_filterlarge">
                    <div class="overlay"><p>Filter Cartridge</p></div>
                </div>
            </div>
            <div class="collage_col collage_col_pp">
                <div class="collage_stack">
                    <div class="filter_card">
                        <img src="{{ asset('front/img/figma/collage-pp-filter.png') }}" alt="PP Filter" class="img_pos_ppfilter">
                        <div class="overlay"><p>PP Filter</p></div>
                    </div>
                    <div class="filter_card">
                        <img src="{{ asset('front/img/figma/collage-ro-membrane.png') }}" alt="RO Membrane" class="img_pos_romembrane">
                        <div class="overlay"><p>RO Membrane</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section_padding_top">
    <div class="container container_flush about_container">
        <div class="row align-items-center about_row">
            <div class="col-md-6 about_text_col">
                <h2 class="title">About us</h2>
                <p class="sub_text_p16">Since 2003, Pratham Filter Industries has been a trusted name in water and industrial filtration. With a strong presence in manufacturing, wholesaling, exporting, and importing, we serve diverse industries with reliable, innovative filtration technology.</p>
                <p class="sub_text_p16 mt-3">From filter housings to RO membranes, our range meets the demands of ETP, STP, desalination, food and beverage, pharma, and electroplating applications, backed by stringent quality control.</p>
                <p class="sub_text_p16 mt-3">With over two decades of expertise, our customer-centric approach ensures every solution is tailored to the specific needs of the industries we serve. Our FRP pressure vessels are NSF and PED certified, reflecting our commitment to global quality standards.</p>
                <a href="{{route('about')}}" class="purple-btn mt-4" type="submit">Know More </a>
            </div>
            <div class="col-md-6 position-relative about_ring_col">
                <div class="about_item ">
                    <div class="item1">
                        <h6>Innovation </h6>

                        <img src="{{ asset('front/img/about_pointer.svg') }}" alt="">
                    </div>
                    <div class="item2">
                        <h6>Quality First</h6>

                        <img src="{{ asset('front/img/about_pointer.svg') }}" alt="">
                    </div>
                    <div class="item3">
                        <h6>Customer-Centric</h6>

                        <img src="{{ asset('front/img/about_pointer.svg') }}" alt="">
                    </div>
                    <div class="item4">
                        <h6>Our Values</h6>
                    </div>
                    <div class="item5">
                        <h6>Reliability</h6>

                        <img src="{{ asset('front/img/about_pointer.svg') }}" alt="">
                    </div>
                    <div class="item6">
                        <h6>Sustainability</h6>

                        <img src="{{ asset('front/img/about_pointer.svg') }}" alt="">
                    </div>
                    <div class="item7">
                    <img src="{{ asset('front/img/about_pointer.svg') }}" alt="" class="mb-3">

                        <h6>Global Standards</h6>

                    </div>
                </div>
                <div class="ring_wrapper ">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="421.3px" height="500px" viewBox="0 0 421.3 437" style="enable-background:new 0 0 421.3 437;" xml:space="preserve">
                            <defs>
                            </defs>
                            <g>

                                <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="25.1367" y1="238.3458" x2="396.185" y2="238.3458" gradientTransform="matrix(1 0 0 -1 8.410366e-06 456.8455)">
                                    <stop offset="0" style="stop-color:#2F2F2F;stop-opacity:0.3" />
                                    <stop offset="0.4992" style="stop-color:#2F2F2F" />
                                    <stop offset="1" style="stop-color:#2F2F2F;stop-opacity:0.7" />
                                </linearGradient>
                                <path class="st0" d="M189.2,26.8c83.2-3.2,165.4,38.5,193.5,117c30.8,85.9,8.6,186.2-66,238.6c-71.5,50.2-167.3,27.7-235.4-27.1
                                c-58.3-46.9-67.8-127.1-44.5-198.2C60,87,115.4,29.7,189.2,26.8z" />

                                <linearGradient id="SVGID_2_" gradientUnits="userSpaceOnUse" x1="0.5" y1="238.3459" x2="420.822" y2="238.3459" gradientTransform="matrix(1 0 0 -1 8.410366e-06 456.8455)">
                                    <stop offset="0" style="stop-color:#2F2F2F;stop-opacity:0.3" />
                                    <stop offset="0.4992" style="stop-color:#2F2F2F" />
                                    <stop offset="1" style="stop-color:#2F2F2F;stop-opacity:0.7" />
                                </linearGradient>
                                <path class="st1" d="M227.8,17.8c80.6,2.4,152.2,49.8,178.9,125.9c28.8,82.1,14.9,176.9-54.1,229.9c-74.6,57.2-178.3,61.8-255,7.4
                                C18.5,324.8-20.7,223.2,12.1,131.8C42.4,47.1,137.9,15.1,227.8,17.8z" />

                                <linearGradient id="SVGID_3_" gradientUnits="userSpaceOnUse" x1="40.8145" y1="238.3454" x2="381.253" y2="238.3454" gradientTransform="matrix(1 0 0 -1 8.410366e-06 456.8455)">
                                    <stop offset="0" style="stop-color:#2F2F2F;stop-opacity:0.3" />
                                    <stop offset="0.4992" style="stop-color:#2F2F2F" />
                                    <stop offset="1" style="stop-color:#2F2F2F;stop-opacity:0.7" />
                                </linearGradient>
                                <path class="st2" d="M207.1,24.4c79-0.2,133.8,69.1,158.6,144c25.3,76.5,24.9,166.9-39.8,215c-66.4,49.4-158.4,31.7-223.7-19.1
                                C43.4,318.5,28.5,240.1,50.4,169C73.6,94,128.5,24.6,207.1,24.4z" />

                                <linearGradient id="SVGID_4_" gradientUnits="userSpaceOnUse" x1="22.8965" y1="237.9721" x2="398.424" y2="237.9721" gradientTransform="matrix(1 0 0 -1 8.410366e-06 456.8455)">
                                    <stop offset="0" style="stop-color:#2F2F2F;stop-opacity:0.3" />
                                    <stop offset="0.4992" style="stop-color:#2F2F2F" />
                                    <stop offset="1" style="stop-color:#2F2F2F;stop-opacity:0.7" />
                                </linearGradient>
                                <path class="st3" d="M209.3,19.9c79-0.8,150,47.9,176,122.6c28,80.3,11.7,171.8-55.3,223.9c-73.7,57.3-178.7,72.5-252.7,15.5
                                C8,328.4,14.3,228.6,44.4,146.1C70.6,74.1,132.9,20.7,209.3,19.9z" />

                                <linearGradient id="SVGID_5_" gradientUnits="userSpaceOnUse" x1="6.4727" y1="238.3454" x2="414.849" y2="238.3454" gradientTransform="matrix(1 0 0 -1 8.410366e-06 456.8455)">
                                    <stop offset="0" style="stop-color:#2F2F2F;stop-opacity:0.3" />
                                    <stop offset="0.4992" style="stop-color:#2F2F2F" />
                                    <stop offset="1" style="stop-color:#2F2F2F;stop-opacity:0.7" />
                                </linearGradient>
                                <path class="st4" d="M218.4,0.5c88.8,1.7,152.7,75.6,180.5,160.2c28.2,85.8,23.2,186.1-49,240.2C275.1,457,172,442.6,96.9,387
                                C23.8,332.9-11.7,240.4,15.7,153.5C43.8,64.1,124.9-1.2,218.4,0.5z" />
                            </g>
                        </svg>
                    </div>
            </div>
        </div>
    </div>
</section>

@if ($brands->isNotEmpty())
<section class="section_padding">
        <h2 class="title_f27 text-center mb-3 mb-lg-5">Our Brands</h2>
        <div class="brands_row brands_slider">
            @foreach ($brands as $brand)
            @if ($brand->icon)
            <div class="brand_item"><img src="{{ asset('admin-assets/our-brands/icon/' . $brand->icon) }}" alt="{{ $brand->icon_alt }}"></div>
            @endif
            @endforeach
        </div>
</section>
@endif

<section class="section_padding_bot">
    <div class="container">
        <div class="justify-content-between d-flex align-items-center articles_head">
            <h2 class="title">Latest Articles</h2>
            <button class="purple-btn" type="submit">Explore Articles</button>
        </div>
        <div class="articles_items">
            <div class="articles_grid">
                <div class="articles_row">
                    @foreach ($blogs as $blog)
                    <a href="{{ route('blog.details', ['post' => $blog->url]) }}" class="articles_card">
                        <img src="{{ asset('front/img/figma/article-card-frame.svg') }}" alt="" class="articles_frame">
                        <p class="articles_date">{{ $blog->date ? \Carbon\Carbon::parse($blog->date)->format('F j, Y') : $blog->created_at->format('F j, Y') }}</p>
                        <h3 class="articles_title">{{ $blog->title }}</h3>
                        @if ($blog->front_image)
                        <img src="{{ asset('admin-assets/blogs/front_image/' . $blog->front_image) }}" alt="{{ $blog->front_image_alt ?: $blog->title }}" class="articles_photo">
                        @endif
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
