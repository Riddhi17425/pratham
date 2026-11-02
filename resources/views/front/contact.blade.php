@extends('front.app')

@section('title', 'Contact Us | Pratham Filter Industries')

@section('content')

    @include('front.partials.page-hero', [
        'title' => 'Contact Us',
        'crumbs' => [['label' => 'Contact Us']],
        'subtitle' => 'Talk to our team about your filtration requirements.',
    ])

    <section class="section_padding">
        <div class="container">
            <div class="contact_grid">
                <div class="contact_form_card">
                    <span class="eyebrow">Send a Message</span>
                    <h2 class="title">Get in touch with us</h2>
                    <p class="sub_text_p16">Please complete the form below. If you have any questions, feel free to get in touch with us.</p>

                    <form class="contact_form" id="contactForm" action="{{ route('contact.submit') }}" method="post" novalidate>
                        @csrf
                        <div class="contact_form_grid">
                            <div class="contact_input_group">
                                <div class="contact_field">
                                    <label for="contactName">Name <span class="req">*</span></label>
                                    <input type="text" name="name" id="contactName" placeholder="Your full name" value="{{ old('name') }}"
                                        minlength="2" maxlength="120" autocomplete="name" required @class(['contact_error' => $errors->has('name')])>
                                </div>
                                @error('name')
                                    <small class="contact_error">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="contact_input_group">
                                <div class="contact_field">
                                    <label for="contactEmail">Email ID <span class="req">*</span></label>
                                    <input type="email" name="email" id="contactEmail" placeholder="you@company.com" value="{{ old('email') }}"
                                        maxlength="255" autocomplete="email" required @class(['contact_error' => $errors->has('email')])>
                                </div>
                                @error('email')
                                    <small class="contact_error">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="contact_input_group contact_input_group_full">
                                <div class="contact_field">
                                    <label for="contactPhone">Phone Number</label>
                                    <input type="tel" name="phone" id="contactPhone" placeholder="Phone number" value="{{ old('phone') }}"
                                        maxlength="30" autocomplete="tel" @class(['contact_error' => $errors->has('phone')])>
                                </div>
                                @error('phone')
                                    <small class="contact_error">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="contact_input_group contact_input_group_full">
                                <div class="contact_field">
                                    <label for="contactMessage">Message <span class="req">*</span></label>
                                    <textarea name="message" id="contactMessage" placeholder="Tell us about your requirement" rows="5" minlength="10" maxlength="5000" required @class(['contact_error' => $errors->has('message')])>{{ old('message') }}</textarea>
                                </div>
                                @error('message')
                                    <small class="contact_error">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="contact_actions">
                            <button class="purple-btn-solid" type="submit">Contact us</button>
                            <span class="contact_actions_note">Fields marked * are required.</span>
                        </div>
                    </form>
                </div>

                <aside class="contact_info" aria-label="Contact information">
                    <h3 class="contact_info_heading">Contact Information</h3>
                    <p class="contact_info_intro">Prefer to reach us directly? Our team is happy to help.</p>

                    <ul class="contact_info_list">
                        @if ($siteSetting->address)
                            <li class="contact_info_block">
                                <span class="contact_info_icon"><i class="fa-solid fa-location-dot" aria-hidden="true"></i></span>
                                <div>
                                    <p class="contact_info_label">Headquarters</p>
                                    <p class="contact_info_value">{{ $siteSetting->address }}</p>
                                </div>
                            </li>
                        @endif

                        @if ($siteSetting->phone)
                            <li class="contact_info_block">
                                <span class="contact_info_icon"><i class="fa-solid fa-phone" aria-hidden="true"></i></span>
                                <div>
                                    <p class="contact_info_label">Contact Us</p>
                                    <p class="contact_info_value">
                                        {{-- The admin can enter two mobile numbers separated by a comma, slash or "|" --}}
                                        @foreach (array_filter(array_map('trim', preg_split('/[,\/|]/', $siteSetting->phone))) as $mobile)
                                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $mobile) }}">{{ $mobile }}</a>@if (!$loop->last)<span class="contact_info_sep">|</span>@endif
                                        @endforeach
                                    </p>
                                </div>
                            </li>
                        @endif

                        @if ($siteSetting->email)
                            <li class="contact_info_block">
                                <span class="contact_info_icon"><i class="fa-solid fa-envelope" aria-hidden="true"></i></span>
                                <div>
                                    <p class="contact_info_label">Email Us</p>
                                    <p class="contact_info_value">
                                        <a href="mailto:{{ $siteSetting->email }}">{{ $siteSetting->email }}</a>
                                    </p>
                                </div>
                            </li>
                        @endif

                        @php
                            $officeNumbers = array_filter(array_map('trim', explode(',', $siteSetting->office_number ?? '')));
                        @endphp
                        @if (count($officeNumbers))
                            <li class="contact_info_block">
                                <span class="contact_info_icon"><i class="fa-solid fa-headset" aria-hidden="true"></i></span>
                                <div>
                                    <p class="contact_info_label">Office Lines</p>
                                    <p class="contact_info_value">
                                        @foreach ($officeNumbers as $number)
                                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $number) }}">{{ $number }}</a>@if (!$loop->last)<span class="contact_info_sep">|</span>@endif
                                        @endforeach
                                    </p>
                                </div>
                            </li>
                        @endif
                    </ul>

                    @if ($siteSetting->linkedin_url || $siteSetting->twitter_url || $siteSetting->whatsapp_url || $siteSetting->facebook_url || $siteSetting->instagram_url)
                        <div class="contact_info_social">
                            @if ($siteSetting->linkedin_url)
                                <a href="{{ $siteSetting->linkedin_url }}" target="_blank" rel="noopener noreferrer" style="--social: #0a66c2;" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in" aria-hidden="true"></i></a>
                            @endif
                            @if ($siteSetting->twitter_url)
                                <a href="{{ $siteSetting->twitter_url }}" target="_blank" rel="noopener noreferrer" style="--social: #000000;" aria-label="X (Twitter)"><i class="fa-brands fa-x-twitter" aria-hidden="true"></i></a>
                            @endif
                            @if ($siteSetting->whatsapp_url)
                                <a href="{{ $siteSetting->whatsapp_url }}" target="_blank" rel="noopener noreferrer" style="--social: #25D366;" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i></a>
                            @endif
                            @if ($siteSetting->facebook_url)
                                <a href="{{ $siteSetting->facebook_url }}" target="_blank" rel="noopener noreferrer" style="--social: #1877F2;" aria-label="Facebook"><i class="fa-brands fa-facebook-f" aria-hidden="true"></i></a>
                            @endif
                            @if ($siteSetting->instagram_url)
                                <a href="{{ $siteSetting->instagram_url }}" target="_blank" rel="noopener noreferrer" style="--social: linear-gradient(45deg, #FEDA75 0%, #FA7E1E 25%, #D62976 50%, #962FBF 75%, #4F5BD5 100%);" aria-label="Instagram"><i class="fa-brands fa-instagram" aria-hidden="true"></i></a>
                            @endif
                        </div>
                    @endif
                </aside>
            </div>
        </div>
    </section>

    <section class="section_padding_bot">
        <div class="container">
            <div class="contact_map">
                <iframe
                    src="https://www.google.com/maps?q={{ urlencode($siteSetting->address ?: 'Pratham Filter Industries, Andheri East, Mumbai') }}&output=embed"
                    title="Pratham Filter Industries on Google Maps" allowfullscreen="" loading="lazy"
                    referrerpolicy="strict-origin-when-cross-origin"></iframe>
            </div>
        </div>
    </section>

    @if ($locators->count())
        <section class="section_padding section_tinted">
            <div class="container">
                <div class="section_head text-center">
                    <span class="eyebrow">Our Network</span>
                    <h2 class="title">Locate us</h2>
                </div>
                <div class="branch_grid">
                    @foreach ($locators as $locator)
                        <article class="branch_card">
                            <div class="branch_card_head">
                                <span class="branch_card_icon"><i class="fa-solid fa-location-dot" aria-hidden="true"></i></span>
                                <h3 class="branch_card_title">{{ strtoupper($locator->city) }}</h3>
                            </div>
                            <p class="branch_card_address">{{ $locator->address }}</p>
                            <ul class="branch_card_meta">
                                @if ($locator->phone)
                                    <li class="branch_card_phone"><i class="fa-solid fa-phone" aria-hidden="true"></i><a href="tel:{{ preg_replace('/[^0-9+]/', '', $locator->phone) }}">{{ $locator->phone }}</a></li>
                                @endif
                                @if ($locator->email)
                                    <li class="branch_card_email"><i class="fa-solid fa-envelope" aria-hidden="true"></i><a href="mailto:{{ $locator->email }}">{{ $locator->email }}</a></li>
                                @endif
                            </ul>
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($locator->address) }}"
                                target="_blank" rel="noopener noreferrer" class="text_link branch_card_map"
                                aria-label="View {{ $locator->city }} office on Google Maps">View on map <svg class="btn_arrow" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                        </article>
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
                return this.optional(element) || /^[\p{L}\p{M}][\p{L}\p{M}0-9\s.'’-]{1,119}$/u.test(value.trim());
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
