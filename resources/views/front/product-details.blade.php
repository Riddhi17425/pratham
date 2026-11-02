@extends('front.app')

@section('title', $metaTitle)
@section('meta_description', $metaDescription)

@section('content')
@php
    $productCrumbs = [['label' => 'Products', 'url' => route('products')]];
    if ($product->category) {
        $productCrumbs[] = ['label' => $product->category->title, 'url' => route('category.products', $product->category->category_url)];
    }
    $productCrumbs[] = ['label' => $product->title];
@endphp

@include('front.partials.page-hero', [
    'title' => $product->title,
    'subtitle' => ($product->name && $product->name !== $product->title) ? $product->name : optional($product->category)->title,
    'crumbs' => $productCrumbs,
    'image' => asset('front/img/banners/products-banner.webp'),
    'banner' => true,
])

<section class="section_padding">
    <div class="container product_detail_feature">
        <div class="product_detail_visual">
            <div class="product_detail_frame">
                <img src="{{ $product->image ? asset('admin-assets/products/image/' . $product->image) : asset('front/img/figma/products/prod-spun-cartridge.jpg') }}"
                     alt="{{ $product->image_alt ?: $product->name }}">
            </div>
        </div>
        <div class="product_detail_content">
            <span class="eyebrow">Product Overview</span>
            @if ($product->description)
                <div class="sub_text_p16 rich_text product_description">{!! $product->description !!}</div>
            @endif
            <div class="product_detail_actions">
                <a href="#productInquiryModal" class="product_enquire_btn js-open-product-inquiry" aria-haspopup="dialog">
                    Enquire Now <svg class="btn_arrow" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
                @if (isset($product->catalogue) && $product->catalogue != '')
                    <a href="{{ asset('admin-assets/products/catalogue/' . $product->catalogue) }}"
                       class="product_download_btn" download>
                        <i class="fa-solid fa-download" aria-hidden="true"></i> Download Catalogue
                    </a>
                @endif
            </div>
            <ul class="product_assurance">
                <li><i class="fa-solid fa-circle-check" aria-hidden="true"></i> Quality-checked before dispatch</li>
                <li><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Branches across India</li>
                <li><i class="fa-solid fa-headset" aria-hidden="true"></i> Expert technical guidance</li>
            </ul>
        </div>
    </div>
</section>

<div class="quote_modal_backdrop @if ($errors->productInquiry->any()) active @endif" id="productInquiryBackdrop"></div>
<div class="quote_modal @if ($errors->productInquiry->any()) active @endif" id="productInquiryModal" role="dialog" aria-modal="true" aria-labelledby="productInquiryTitle">
    <button class="quote_modal_close js-close-product-inquiry" type="button" aria-label="Close product inquiry">
        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M12 12L36 36M36 12L12 36" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
        </svg>
    </button>
    <div class="quote_modal_header">
        <span class="eyebrow">Enquire Now</span>
        <h2 class="title quote_modal_title" id="productInquiryTitle">Product Inquiry</h2>
        <p class="quote_modal_text">Share your requirement and our team will get back to you about {{ $product->name ?: $product->title }}.</p>
    </div>

    <form class="quote_modal_form" id="productInquiryForm" action="{{ route('product-inquiry.submit') }}" method="post" novalidate>
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div class="contact_input_group">
            <div class="contact_field">
                <label for="inquiryName">Name <span class="req">*</span></label>
                <input type="text" name="name" id="inquiryName" placeholder="Your full name" value="{{ old('name') }}" minlength="2" maxlength="120" autocomplete="name" required @class(['contact_error' => $errors->productInquiry->has('name')])>
            </div>
            @error('name', 'productInquiry')<small class="contact_error">{{ $message }}</small>@enderror
        </div>
        <div class="contact_input_group">
            <div class="contact_field">
                <label for="inquiryEmail">Email ID <span class="req">*</span></label>
                <input type="email" name="email" id="inquiryEmail" placeholder="you@company.com" value="{{ old('email') }}" maxlength="255" autocomplete="email" required @class(['contact_error' => $errors->productInquiry->has('email')])>
            </div>
            @error('email', 'productInquiry')<small class="contact_error">{{ $message }}</small>@enderror
        </div>
        <div class="contact_input_group">
            <div class="contact_field">
                <label for="inquiryPhone">Phone Number</label>
                <input type="tel" name="phone" id="inquiryPhone" placeholder="Phone number" value="{{ old('phone') }}" maxlength="15" inputmode="numeric" autocomplete="tel" @class(['contact_error' => $errors->productInquiry->has('phone')])>
            </div>
            @error('phone', 'productInquiry')<small class="contact_error">{{ $message }}</small>@enderror
        </div>
        <div class="contact_input_group">
            <div class="contact_field">
                <label for="inquiryProduct">Product <span class="req">*</span></label>
                <input type="text" name="product" id="inquiryProduct" value="{{ $product->name ?: $product->title }}" readonly required aria-label="Selected product">
            </div>
            @error('product', 'productInquiry')<small class="contact_error">{{ $message }}</small>@enderror
        </div>
        <div class="contact_input_group contact_input_group_full">
            <div class="contact_field">
                <label for="inquiryMessage">Message</label>
                <textarea name="message" id="inquiryMessage" placeholder="Tell us about your requirement" rows="4" maxlength="5000" @class(['contact_error' => $errors->productInquiry->has('message')])>{{ old('message') }}</textarea>
            </div>
            @error('message', 'productInquiry')<small class="contact_error">{{ $message }}</small>@enderror
        </div>
        @error('product_id', 'productInquiry')<small class="contact_error">{{ $message }}</small>@enderror
        <button class="quote_modal_submit" type="submit">Send Inquiry</button>
    </form>
</div>

@if ($product->technical_details)
    <section class="section_padding section_tinted">
        <div class="container">
            <div class="section_head">
                <p class="products_eyebrow">Technical Data</p>
                <h2 class="product_spec_title">{{ $product->title }} Specifications</h2>
            </div>
            <div class="product_technical_details">{!! $product->technical_details !!}</div>
        </div>
    </section>
@endif

@include('front.partials.cta-banner', [
    'title' => 'Need Help Choosing The Right Filter?',
    'text' => 'Talk to our team and get a recommendation tailored to your exact filtration requirements.',
    'actions' => [
        ['label' => 'Talk to Our Experts', 'url' => route('contact'), 'style' => 'outline'],
        ['label' => 'Explore Our Products', 'url' => route('products'), 'style' => 'solid'],
    ],
])
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.22.1/dist/jquery.validate.min.js"></script>
    <script>
        $.validator.addMethod('inquiryNamePattern', function(value, element) {
            return this.optional(element) || /^[\p{L}\p{M}][\p{L}\p{M}0-9\s.'’-]{1,119}$/u.test(value.trim());
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
