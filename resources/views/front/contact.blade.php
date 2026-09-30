@extends('front.app')

@section('title', 'Pratham Filter Industries | contact')

@section('content')


    <section class="page_hero" style="background-image: url('{{ asset('front/img/figma/about/page-hero-bg.jpg') }}');">
        <div class="page_hero_overlay"></div>
        <div class="container position-relative">
            <div class="page_hero_content">
                <div class="breadcrumb_row">
                    <a href="{{ url('/') }}">Home</a>
                    <i class="fa-solid fa-chevron-right"></i>
                    <span>Contact us</span>
                </div>
                <h1 class="page_hero_title">Contact Us</h1>
            </div>
        </div>
    </section>

    <section class="section_padding">
        <div class="container">
            <h2 class="title mb-3">Get in touch with us</h2>
            <p class="sub_text_p16 mb-5">Please complete the form below. If you have any questions, feel free to get in
                touch with us.</p>

            <div class="contact_grid">
                <span class="vmp_border_line vmp_border_top"></span>
                <span class="vmp_border_line vmp_border_bottom"></span>
                <span class="vmp_border_side vmp_border_left"></span>
                <span class="vmp_border_side vmp_border_right"></span>
                <span class="contact_grid_divider"></span>

                <form class="contact_form" id="contactForm" action="{{ route('contact.submit') }}" method="post"
                    novalidate>
                    @csrf
                    <div class="contact_input_group">
                        <div class="contact_field">
                            <input type="text" name="name" placeholder="Name" value="{{ old('name') }}"
                                minlength="2" maxlength="120" required>
                        </div>
                        @error('name')
                            <small class="contact_error">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="contact_input_group">
                        <div class="contact_field">
                            <input type="email" name="email" placeholder="Email ID" value="{{ old('email') }}"
                                maxlength="255" required>
                        </div>
                        @error('email')
                            <small class="contact_error">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="contact_input_group">
                        <div class="contact_field">
                            <input type="tel" name="phone" placeholder="Phone Number" value="{{ old('phone') }}"
                                maxlength="30">
                        </div>
                        @error('phone')
                            <small class="contact_error">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="contact_input_group">
                        <div class="contact_field">
                            <textarea name="message" placeholder="Message" rows="4" minlength="10" maxlength="5000" required>{{ old('message') }}</textarea>
                        </div>
                        @error('message')
                            <small class="contact_error">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="contact_field border-0"><button class="purple-btn" type="submit">Contact us</button></div>
                </form>

                
                <div class="contact_info">
    @if ($siteSetting->address)
        <div class="contact_info_block">
            <div class="contact_info_label">
                <img src="{{ asset('front/img/figma/contact/icon-headquarters.svg') }}"
                    alt=""><span>Headquarters</span>
            </div>
            <p class="contact_info_value">{{ $siteSetting->address }}</p>
        </div>
    @endif

    @if ($siteSetting->phone || $siteSetting->email)
        <div class="contact_info_row">
            @if ($siteSetting->phone)
                <div class="contact_info_block">
                    <div class="contact_info_label">
                        <img src="{{ asset('front/img/figma/contact/icon-branch-phone.svg') }}"
                            alt=""><span>Contact Us</span>
                    </div>
                    <p class="contact_info_value">
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSetting->phone) }}">{{ $siteSetting->phone }}</a>
                    </p>
                </div>
            @endif

            @if ($siteSetting->email)
                <div class="contact_info_block">
                    <div class="contact_info_label">
                        <img src="{{ asset('front/img/figma/contact/icon-email.svg') }}" alt=""><span>Email Us</span>
                    </div>
                    <p class="contact_info_value">
                        <a href="mailto:{{ $siteSetting->email }}">{{ $siteSetting->email }}</a>
                    </p>
                </div>
            @endif
        </div>
    @endif

    @php
        $officeNumbers = array_filter(array_map('trim', explode(',', $siteSetting->office_number ?? '')));
    @endphp
    @if (count($officeNumbers))
        <div class="contact_info_block">
            <div class="contact_info_label">
                <img src="{{ asset('front/img/figma/contact/icon-office-lines.svg') }}"
                    alt=""><span>Office Lines</span>
            </div>
            <p class="contact_info_value">
                @foreach ($officeNumbers as $number)
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $number) }}">{{ $number }}</a>
                    @if (!$loop->last)
                        &nbsp;|&nbsp;
                    @endif
                @endforeach
            </p>
        </div>
    @endif
</div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29386.132594725917!2d72.45635881083984!3d22.977222899999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e9a95007cb573%3A0xc4b5bda7e22253c!2spratham%20filter%20industries!5e0!3m2!1sen!2sin!4v1790145958860!5m2!1sen!2sin"
                width="100%" height="550" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="strict-origin-when-cross-origin"></iframe>
        </div>
    </section>

    @if ($locators->count())
        <section class="section_padding">
            <div class="container">
                <h2 class="title mb-5 text-center">Locate us</h2>
                <div class="branch_grid">
                    @foreach ($locators as $locator)
                        <div class="branch_card">
                            <span class="vmp_border_line vmp_border_top"></span>
                            <span class="vmp_border_line vmp_border_bottom"></span>
                            <span class="vmp_border_side vmp_border_left"></span>
                            <span class="vmp_border_side vmp_border_right"></span>
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($locator->address) }}"
                                target="_blank" rel="noopener noreferrer"
                                aria-label="View {{ $locator->city }} office on Google Maps" class="d-block">
                                <img src="{{ asset('front/img/figma/contact/branch-photo.jpg') }}"
                                    alt="{{ strtoupper($locator->city) }} office" class="w-100 branch_card_img">
                            </a>
                            <div class="branch_card_body">
                                <h3 class="branch_card_title">{{ strtoupper($locator->city) }}</h3>
                                <p class="branch_card_address">{{ $locator->address }}</p>
                                <p class="branch_card_phone"><img
                                        src="{{ asset('front/img/figma/contact/icon-branch-phone.svg') }}"
                                        alt=""> <a
                                        href="tel:{{ preg_replace('/[^0-9+]/', '', $locator->phone) }}">{{ $locator->phone }}</a>
                                </p>
                                <p class="branch_card_email"><img
                                        src="{{ asset('front/img/figma/contact/icon-email.svg') }}" alt=""> <a
                                        href="mailto:{{ $locator->email }}">{{ $locator->email }}</a></p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif


    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.22.1/dist/jquery.validate.min.js"></script>
        <script>
            $.validator.addMethod('phonePattern', function(value, element) {
                return this.optional(element) || /^[0-9+().\s-]{7,30}$/.test(value);
            }, 'Enter a valid phone number.');
            $.validator.addMethod('namePattern', function(value, element) {
                return this.optional(element) || /^[\p{L}\p{M}][\p{L}\p{M}0-9\s.'\u2019-]{1,119}$/u.test(value.trim());
            }, 'Enter a valid name.');

            $('#contactForm').validate({
                errorElement: 'small',
                errorClass: 'contact_error',
                rules: {
                    name: {
                        required: true,
                        minlength: 2,
                        maxlength: 120,
                        namePattern: true
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 255
                    },
                    phone: {
                        phonePattern: true
                    },
                    message: {
                        required: true,
                        minlength: 10,
                        maxlength: 5000
                    }
                },
                messages: {
                    name: {
                        required: 'Please enter your name.',
                        minlength: 'Name must be at least 2 characters.',
                        maxlength: 'Name cannot exceed 120 characters.',
                        namePattern: 'Enter a valid name using letters, numbers, spaces, apostrophes, periods, or hyphens.'
                    },
                    email: {
                        required: 'Please enter your email address.',
                        email: 'Please enter a valid email address.',
                        maxlength: 'Email cannot exceed 255 characters.'
                    },
                    message: {
                        required: 'Please enter a message.',
                        minlength: 'Message must be at least 10 characters.',
                        maxlength: 'Message cannot exceed 5000 characters.'
                    }
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element.closest('.contact_field'));
                },
                submitHandler: function(form) {
                    var $submitButton = $(form).find('button[type="submit"]');
                    $submitButton.prop('disabled', true).addClass('is-submitting').text('Submitting...');
                    HTMLFormElement.prototype.submit.call(form);
                    return false;
                }
            });
        </script>
    @endpush

@endsection
