@extends('front.app')

@section('title', $metaTitle)
@section('meta_description', $metaDescription)

@section('content')
<section class="page_hero" style="background-image: url('{{ asset('front/img/figma/about/page-hero-bg.jpg') }}');">
    <div class="page_hero_overlay"></div>
    <div class="container position-relative">
        <div class="page_hero_content">
            <div class="breadcrumb_row">
                <a href="{{ route('home') }}">Home</a>
                <!-- <i class="fa-solid fa-chevron-right"></i> -->
                <!-- <a href="{{ route('products') }}">Water Filter Products</a> -->
                @if ($product->category)
                    <i class="fa-solid fa-chevron-right"></i>
                    <a href="{{ route('category.products', $product->category->category_url) }}">{{ $product->category->title }}</a>
                @endif
                <i class="fa-solid fa-chevron-right"></i>
                <span>{{ $product->title }}</span>
            </div>
            <h1 class="page_hero_title product_detail_hero_title">{{ $product->title }}</h1>
        </div>
    </div>
</section>

<section class="section_padding">
    <div class="container product_detail_feature">
        <div class="product_detail_visual">
            <img src="{{ $product->image ? asset('admin-assets/products/image/' . $product->image) : asset('front/img/figma/products/prod-spun-cartridge.jpg') }}"
                 alt="{{ $product->image_alt ?: $product->name }}">
        </div>
        <div class="product_detail_content">
            @if ($product->category)
                <p class="products_eyebrow">{{ $product->category->title }}</p>
            @endif
            <h2 class="title mb-0">{{ $product->name ?: $product->title }}</h2>
            @if ($product->description)
                <div class="sub_text_p16 product_description">{!! $product->description !!}</div>
            @endif
            <div class="product_detail_actions">
                @if ($product->catalogue)
                    <a href="{{ asset('admin-assets/products/catalogue/' . $product->catalogue) }}"
                       class="purple-btn-solid product_download_btn" download>
                        <i class="fa-solid fa-download"></i> Download Catalogue
                    </a>
                @endif
                <a href="#productInquiryModal" class="product_enquire_btn js-open-product-inquiry" aria-haspopup="dialog">
                    Enquire Now
                </a>
            </div>
        </div>
    </div>
</section>

<div class="quote_modal_backdrop @if ($errors->productInquiry->any()) active @endif" id="productInquiryBackdrop"></div>
<div class="quote_modal @if ($errors->productInquiry->any()) active @endif" id="productInquiryModal" role="dialog" aria-modal="true" aria-labelledby="productInquiryTitle">
    <button class="quote_modal_close js-close-product-inquiry" type="button" aria-label="Close product inquiry">
        <svg width="24" height="24" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M12 12L36 36M36 12L12 36" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
        </svg>
    </button>
    <div class="quote_modal_header">
        <h2 class="title quote_modal_title" id="productInquiryTitle">Product Inquiry</h2>
        <span class="quote_modal_underline"></span>
    </div>

    <form class="quote_modal_form" id="productInquiryForm" action="{{ route('product-inquiry.submit') }}" method="post" novalidate>
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div class="contact_field">
            <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" minlength="2" maxlength="120" required>
        </div>
        @error('name', 'productInquiry')<small class="contact_error">{{ $message }}</small>@enderror
        <div class="contact_field">
            <input type="email" name="email" placeholder="Email ID" value="{{ old('email') }}" maxlength="255" required>
        </div>
        @error('email', 'productInquiry')<small class="contact_error">{{ $message }}</small>@enderror
        <div class="contact_field">
            <input type="tel" name="phone" placeholder="Phone Number" value="{{ old('phone') }}" maxlength="15" inputmode="numeric">
        </div>
        @error('phone', 'productInquiry')<small class="contact_error">{{ $message }}</small>@enderror
        <div class="contact_field">
            <input type="text" name="product" value="{{ $product->name ?: $product->title }}" readonly required aria-label="Selected product">
        </div>
        @error('product', 'productInquiry')<small class="contact_error">{{ $message }}</small>@enderror
        <div class="contact_field">
            <textarea name="message" placeholder="Message" rows="4" maxlength="5000">{{ old('message') }}</textarea>
        </div>
        @error('message', 'productInquiry')<small class="contact_error">{{ $message }}</small>@enderror
        @error('product_id', 'productInquiry')<small class="contact_error">{{ $message }}</small>@enderror
        <button class="purple-btn quote_modal_submit" type="submit">Send Inquiry</button>
    </form>
</div>

@if ($product->technical_details)
    <hr class="product_detail_divider">
    <section class="section_padding_top section_padding_bot">
        <div class="container">
            <p class="products_eyebrow">Technical Data</p>
            <h2 class="product_spec_title">{{ $product->title }} Specifications</h2>
            <span class="products_accent_line mb-4"></span>
            <div class="product_technical_details">{!! $product->technical_details !!}</div>
        </div>
    </section>
@endif

<section class="product_cta_banner" style="background-image: linear-gradient(-1deg, rgba(57,49,133,0.92) 0%, rgba(57,50,133,0.92) 38%, rgba(0,160,227,0.92) 100%), url('{{ asset('front/img/figma/products/product-cta-bg.jpg') }}');">
    <div class="container">
        <h2 class="product_cta_title">Need Help Choosing The Right Filter?</h2>
        <p class="product_cta_text">Talk to our team and get a recommendation tailored to your exact filtration requirements.</p>
        <div class="product_cta_actions">
            <a href="{{ route('contact') }}" class="product_cta_btn_outline">Talk to Our Experts</a>
            <a href="{{ route('products') }}" class="product_cta_btn_solid">Explore Water Filter Products</a>
        </div>
    </div>
</section>
@endsection

@push('styles')
    <style>
        .product_description p { margin-bottom: 1rem; }
        .product_description p:last-child { margin-bottom: 0; }
        .product_description ul,
        .product_description ol { padding-left: 1.25rem; margin-bottom: 1rem; }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.22.1/dist/jquery.validate.min.js"></script>
    <script>
        $.validator.addMethod('inquiryNamePattern', function(value, element) {
            return this.optional(element) || /^[\p{L}\p{M}][\p{L}\p{M}0-9\s.'\u2019-]{1,119}$/u.test(value.trim());
        }, 'Enter a valid name.');
        $.validator.addMethod('inquiryPhonePattern', function(value, element) {
            return this.optional(element) || /^[0-9]{7,15}$/.test(value);
        }, 'Phone number must be 7 to 15 digits.');

        $('#productInquiryForm').validate({
            errorElement: 'small',
            errorClass: 'contact_error',
            rules: {
                name: { required: true, minlength: 2, maxlength: 120, inquiryNamePattern: true },
                email: { required: true, email: true, maxlength: 255 },
                phone: { inquiryPhonePattern: true },
                product: { required: true, maxlength: 255 },
                message: { maxlength: 5000 }
            },
            messages: {
                name: {
                    required: 'Please enter your name.',
                    minlength: 'Name must be at least 2 characters.',
                    maxlength: 'Name cannot exceed 120 characters.'
                },
                email: {
                    required: 'Please enter your email address.',
                    email: 'Please enter a valid email address.',
                    maxlength: 'Email cannot exceed 255 characters.'
                },
                phone: { inquiryPhonePattern: 'Phone number must be 7 to 15 digits.' },
                product: { required: 'The selected product is required.' },
                message: { maxlength: 'Message cannot exceed 5000 characters.' }
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element.closest('.contact_field'));
            },
            submitHandler: function(form) {
                var button = $(form).find('button[type="submit"]');
                button.prop('disabled', true).addClass('is-submitting').text('Submitting...');
                HTMLFormElement.prototype.submit.call(form);
                return false;
            }
        });

        $('#productInquiryForm [name="phone"]').on('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 15);
        });
    </script>
@endpush
