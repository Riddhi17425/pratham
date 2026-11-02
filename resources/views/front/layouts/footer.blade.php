<footer class="footer">
    <div class="container">
        <div class="footer_top">
            <div class="footer_brand">
                <a href="{{ route('home') }}" class="brand_lockup">
                    <img src="{{ asset('front/img/footer-pratham-logo.png') }}" alt="Pratham Filter Industries" class="logo_img" width="400" height="193" loading="lazy">
                    <img src="{{ asset('front/img/footer-flo-logo.png') }}" alt="FLO" class="brand_flo_logo" width="200" height="148" loading="lazy">
                </a>
                <p class="footer_tagline">A trusted name in water and industrial filtration since 2003.</p>
            </div>
            <div class="footer_social">
                @if(isset($siteSetting->linkedin_url) && $siteSetting->linkedin_url != '')
                <a href="{{ $siteSetting->linkedin_url ?: '#' }}" target="_blank" rel="noopener noreferrer" style="--social: #0a66c2;" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in" aria-hidden="true"></i></a>
                @endif
                @if(isset($siteSetting->twitter_url) && $siteSetting->twitter_url != '')
                <a href="{{ $siteSetting->twitter_url ?: '#' }}" target="_blank" rel="noopener noreferrer" style="--social: #000000;" aria-label="X (Twitter)"><i class="fa-brands fa-x-twitter" aria-hidden="true"></i></a>
                @endif
                @if(isset($siteSetting->whatsapp_url) && $siteSetting->whatsapp_url != '')
                <a href="{{ $siteSetting->whatsapp_url ?: '#' }}" target="_blank" rel="noopener noreferrer" style="--social: #25D366;" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i></a>
                @endif
                @if(isset($siteSetting->facebook_url) && $siteSetting->facebook_url != '')
                <a href="{{ $siteSetting->facebook_url ?: '#' }}" target="_blank" rel="noopener noreferrer" style="--social: #1877F2;" aria-label="Facebook"><i class="fa-brands fa-facebook-f" aria-hidden="true"></i></a>
                @endif
                @if(isset($siteSetting->instagram_url) && $siteSetting->instagram_url != '')
                <a href="{{ $siteSetting->instagram_url ?: '#' }}" target="_blank" rel="noopener noreferrer" style="--social: linear-gradient(45deg, #FEDA75 0%, #FA7E1E 25%, #D62976 50%, #962FBF 75%, #4F5BD5 100%);" aria-label="Instagram"><i class="fa-brands fa-instagram" aria-hidden="true"></i></a>
                @endif
            </div>
        </div>

        <div class="ft_content">
            <div class="ft_main_row">
                <div class="ft_col ft_col_links">
                    <h5 class="footer_heading">Quick Links</h5>
                    <ul class="footer_menu">
                        <li><a href="{{ route('home') }}"><svg class="footer_chevron" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Home</a></li>
                        <li><a href="{{ route('about') }}"><svg class="footer_chevron" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>About Us</a></li>
                        <li><a href="{{ route('technical.brochure') }}"><svg class="footer_chevron" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Technical Brochure</a></li>
                        <li><a href="{{ route('news.events') }}"><svg class="footer_chevron" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Events</a></li>
                        <!-- <li><a href="{{ route('blog') }}"><svg class="footer_chevron" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Blog</a></li> -->
                        <li><a href="{{ route('contact') }}"><svg class="footer_chevron" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Contact Us</a></li>
                    </ul>
                </div>
                <div class="ft_col ft_col_solutions">
                    <h5 class="footer_heading">Our Solutions</h5>
                    <ul class="footer_menu solutions_menu">
                        @forelse ($productCategories as $productCategory)
                            <li>
                                <a href="{{ route('category.products', $productCategory->category_url) }}"><svg class="footer_chevron" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>{{ $productCategory->title }}</a>
                            </li>
                        @empty
                            <li><a href="{{ route('products') }}"><svg class="footer_chevron" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>All Products</a></li>
                        @endforelse
                    </ul>
                </div>
                <div class="ft_col ft_col_contact">
                    <h5 class="footer_heading">Get In Touch</h5>
                    <div class="footer_menu contact_menu">
                        @if ($siteSetting->address)
                            <p><span class="contact_icon"><i class="fa-solid fa-location-dot" aria-hidden="true"></i></span><a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($siteSetting->address) }}" target="_blank" rel="noopener noreferrer">{{ $siteSetting->address }}</a></p>
                        @endif
                        @if ($siteSetting->phone)
                            <p><span class="contact_icon"><i class="fa-solid fa-phone" aria-hidden="true"></i></span><a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSetting->phone) }}">{{ $siteSetting->phone }}</a></p>
                        @endif
                        @if ($siteSetting->email)
                            <p><span class="contact_icon"><i class="fa-solid fa-envelope" aria-hidden="true"></i></span><a href="mailto:{{ $siteSetting->email }}">{{ $siteSetting->email }}</a></p>
                        @endif
                    </div>
                </div>
                <div class="ft_col ft_col_quote">
                    <span class="quote_accent" aria-hidden="true"></span>
                    <h5>Request A Quote</h5>
                    <p>Get in touch with our team for a solution built around your needs.</p>
                    <button class="quote_footer_button js-open-quote" type="button">Request A Quote <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                </div>
            </div>
        </div>
    </div>
    <div class="footer_bottom">
        <div class="container footer_bottom_inner">
            <p>Copyright &copy;{{ date('Y') }} Pratham Filter Industries. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Request A Quote modal drawer -->
<div class="quote_modal_backdrop" id="quoteModalBackdrop"></div>
<div class="quote_modal" id="quoteModal" role="dialog" aria-modal="true" aria-labelledby="quoteModalTitle">
    <button class="quote_modal_close js-close-quote" type="button" aria-label="Close">
        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.7882 10.7878C11.4577 10.1183 12.5431 10.1183 13.2126 10.7878L24.0004 21.5756L34.7882 10.7878C35.4577 10.1183 36.5431 10.1183 37.2126 10.7878C37.8821 11.4573 37.8821 12.5427 37.2126 13.2122L26.4248 24L37.2126 34.7878C37.8821 35.4573 37.8821 36.5427 37.2126 37.2122C36.5431 37.8817 35.4577 37.8817 34.7882 37.2122L24.0004 26.4244L13.2126 37.2122C12.5431 37.8817 11.4577 37.8817 10.7882 37.2122C10.1188 36.5427 10.1188 35.4573 10.7882 34.7878L21.5761 24L10.7882 13.2122C10.1188 12.5427 10.1188 11.4573 10.7882 10.7878Z" fill="currentColor"/>
        </svg>
    </button>
    <div class="quote_modal_header">
        <span class="eyebrow">Get a quote</span>
        <h2 class="title quote_modal_title" id="quoteModalTitle">Request A Quote</h2>
        <p class="quote_modal_text">Get in touch with our team for a solution built around your needs.</p>
    </div>

    <form class="quote_modal_form" id="quoteForm" action="{{ route('quote.submit') }}" method="post" novalidate>
        @csrf
        <div class="contact_input_group">
            <div class="contact_field">
                <label for="quoteName">Name <span class="req">*</span></label>
                <input type="text" name="name" id="quoteName" placeholder="Your full name" minlength="2" maxlength="120" autocomplete="name" required>
            </div>
        </div>
        <div class="contact_input_group">
            <div class="contact_field">
                <label for="quoteEmail">Email ID <span class="req">*</span></label>
                <input type="email" name="email" id="quoteEmail" placeholder="you@company.com" maxlength="255" autocomplete="email" required>
            </div>
        </div>
        <div class="contact_input_group">
            <div class="contact_field">
                <label for="quotePhone">Phone Number</label>
                <input type="tel" name="phone" id="quotePhone" placeholder="Phone number" maxlength="30" autocomplete="tel">
            </div>
        </div>
        <div class="contact_input_group">
            <div class="contact_field quote_modal_select">
                <label for="quoteProduct">Product <span class="req">*</span></label>
                <select name="product" id="quoteProduct" required>
                    <option value="" disabled selected>Select a product</option>
                    @forelse ($activeProducts as $quoteProduct)
                        <option value="{{ $quoteProduct->name ?: $quoteProduct->title }}">{{ $quoteProduct->name ?: $quoteProduct->title }}</option>
                    @empty
                        <option value="" disabled>No active products available</option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="contact_input_group contact_input_group_full">
            <div class="contact_field">
                <label for="quoteMessage">Message</label>
                <textarea name="message" id="quoteMessage" placeholder="Tell us about your requirement" rows="4"></textarea>
            </div>
        </div>
        <button class="quote_modal_submit" type="submit">Get A Quote <svg class="btn_arrow" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
    </form>
</div>

<!-- Back to top + WhatsApp -->
<button class="back_to_top" id="backToTop" type="button" aria-label="Back to top"><i class="fa-solid fa-arrow-up" aria-hidden="true"></i></button>

<div class="wa-container">
    <a
        href="https://wa.me/919820246044?text=Hello, I'm interested in Pratham's products. Could you please assist me?" target="_blank" rel="noopener noreferrer"
        class="wa-button"
        target="_blank"
        rel="noopener noreferrer"
        aria-label="Chat with us on WhatsApp"
    >
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M12 0C5.37 0 0 5.37 0 12c0 2.12.55 4.11 1.52 5.84L0 24l6.32-1.48A11.94 11.94 0 0 0 12 24c6.63 0 12-5.37 12-12S18.63 0 12 0Zm0 21.8c-1.86 0-3.69-.5-5.3-1.44l-.38-.22-3.9.92.94-3.8-.25-.4A9.77 9.77 0 0 1 2.2 12C2.2 6.6 6.6 2.2 12 2.2S21.8 6.6 21.8 12 17.4 21.8 12 21.8Zm5.37-7.32c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.95 1.17-.18.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.46-.89-.79-1.49-1.77-1.67-2.07-.18-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.18.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.48-.5-.67-.51h-.57c-.2 0-.52.07-.8.37-.27.3-1.04 1.02-1.04 2.49s1.07 2.89 1.22 3.09c.15.2 2.1 3.21 5.1 4.5.71.31 1.27.49 1.7.63.71.23 1.36.2 1.87.12.57-.09 1.76-.72 2.01-1.42.25-.7.25-1.3.18-1.42-.08-.13-.28-.2-.58-.35Z" fill="white"/>
        </svg>
    </a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('quoteForm');
        if (!form) return;

        const nameRegex = /^[\p{L}\p{M}][\p{L}\p{M}0-9\s.'’-]{1,119}$/u;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

        const rules = {
            name(v) {
                if (!v) return 'Please enter your name.';
                if (v.length < 2) return 'Name must be at least 2 characters.';
                if (!nameRegex.test(v)) return 'Name contains invalid characters.';
                return '';
            },
            email(v) {
                if (!v) return 'Please enter your email address.';
                if (!emailRegex.test(v)) return 'Please enter a valid email address.';
                return '';
            },
            phone(v) {
                if (!v) return ''; // optional
                if (!/^[0-9]+$/.test(v)) return 'Please enter numbers only.';
                if (v.length < 7 || v.length > 15) return 'Phone number must be 7 to 15 digits.';
                return '';
            },
            product(v) {
                if (!v) return 'Please select a product.';
                return '';
            },
            message(v) {
                if (v.length > 5000) return 'Message must not exceed 5000 characters.';
                return '';
            }
        };

        form.setAttribute('novalidate', 'novalidate');

        function getErrorEl(field) {
            const wrapper = field.closest('.contact_field');
            const next = wrapper.nextElementSibling;
            return (next && next.classList.contains('js-error')) ? next : null;
        }

        const phoneField = form.elements['phone'];
        phoneField.setAttribute('inputmode', 'numeric');
        phoneField.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        function showError(field, msg) {
            const wrapper = field.closest('.contact_field');
            let err = getErrorEl(field);
            if (!err) {
                err = document.createElement('small');
                err.className = 'js-error';
                err.setAttribute('role', 'alert');
                wrapper.insertAdjacentElement('afterend', err);
            }
            err.textContent = msg;
            err.style.display = msg ? 'block' : 'none';
            field.classList.toggle('is-invalid-field', !!msg);
            field.setAttribute('aria-invalid', msg ? 'true' : 'false');
        }

        function validateField(name) {
            const field = form.elements[name];
            const msg = rules[name]((field.value || '').trim());
            showError(field, msg);
            return !msg;
        }

        Object.keys(rules).forEach(function(name) {
            const field = form.elements[name];
            field.addEventListener('blur', function() {
                validateField(name);
            });
            field.addEventListener(field.tagName === 'SELECT' ? 'change' : 'input', function() {
                const err = getErrorEl(field);
                if (field.tagName === 'SELECT' || (err && err.textContent)) validateField(name);
            });
        });

        form.addEventListener('submit', function(e) {
            let firstInvalid = null;
            Object.keys(rules).forEach(function(name) {
                if (!validateField(name) && !firstInvalid) firstInvalid = form.elements[name];
            });
            if (firstInvalid) {
                e.preventDefault();
                firstInvalid.focus();
            }
        });

        document.querySelectorAll('.js-close-quote').forEach(function(btn) {
            btn.addEventListener('click', function() {
                form.reset();
                form.querySelectorAll('.js-error').forEach(function(el) {
                    el.textContent = '';
                    el.style.display = 'none';
                });
                form.querySelectorAll('.is-invalid-field').forEach(function(el) {
                    el.classList.remove('is-invalid-field');
                    el.removeAttribute('aria-invalid');
                });
            });
        });
    });
</script>
