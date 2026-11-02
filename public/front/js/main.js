// Toggle the hamburger menu icon on click
var hamburgerToggle = document.getElementById("hamburgerToggle");
if (hamburgerToggle) {
    hamburgerToggle.addEventListener("click", function () {
        const icon = this.querySelector("i"); // Select the <i> element inside the button
        if (icon.classList.contains("fa-bars")) {
            icon.classList.remove("fa-bars");
            icon.classList.add("fa-times"); // Change to close icon
        } else {
            icon.classList.remove("fa-times");
            icon.classList.add("fa-bars"); // Change back to menu icon
        }
    });
}

// Mobile: tapping the "Products" text opens the products page (normal link),
// tapping the down arrow toggles the category dropdown instead.
document.addEventListener("DOMContentLoaded", function () {
    const btn = document.getElementById("productsDropdownBtn");
    const menu = document.getElementById("productsDropdownMenu");
    if (!btn || !menu) return;

    btn.addEventListener("click", function () {
        const open = menu.classList.toggle("show");
        btn.setAttribute("aria-expanded", open ? "true" : "false");
    });
});

// Sticky header: compact style + hairline once the page is scrolled
document.addEventListener("DOMContentLoaded", function () {
    const header = document.getElementById("header");
    if (!header) return;

    function updateScrolled() {
        header.classList.toggle("scrolled", window.scrollY > 50);
    }
    updateScrolled();
    window.addEventListener("scroll", updateScrolled, { passive: true });
});

// Shared drawer behaviour: remember what opened it, move focus inside,
// keep Tab inside while it is open and hand focus back on close.
function drawerFocusables(modal) {
    return modal.querySelectorAll('a[href], button:not([disabled]), input:not([type="hidden"]):not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])');
}
function trapDrawerFocus(modal, e) {
    if (e.key !== 'Tab') return;
    var items = drawerFocusables(modal);
    if (!items.length) return;
    var first = items[0];
    var last = items[items.length - 1];
    if (e.shiftKey && (document.activeElement === first || document.activeElement === modal)) {
        e.preventDefault();
        last.focus();
    } else if (!e.shiftKey && document.activeElement === last) {
        e.preventDefault();
        first.focus();
    }
}

// Request A Quote modal drawer
$(document).ready(function () {
    var $backdrop = $('#quoteModalBackdrop');
    var $modal = $('#quoteModal');
    var lastFocus = null;
    if (!$modal.length) return;
    $modal.attr('tabindex', '-1');

    function openQuoteModal(e) {
        if (e) e.preventDefault();
        lastFocus = document.activeElement;
        $backdrop.addClass('active');
        $modal.addClass('active');
        $('body').css('overflow', 'hidden');
        setTimeout(function () { $modal.trigger('focus'); }, 60);
    }
    function closeQuoteModal() {
        if (!$modal.hasClass('active')) return;
        $backdrop.removeClass('active');
        $modal.removeClass('active');
        $('body').css('overflow', '');
        if (lastFocus && lastFocus.focus) lastFocus.focus();
    }

    $(document).on('click', '.js-open-quote', openQuoteModal);
    $(document).on('click', '.js-close-quote', closeQuoteModal);
    $backdrop.on('click', closeQuoteModal);
    $(document).on('keydown', function (e) {
        if (e.key === 'Escape') closeQuoteModal();
        if ($modal.hasClass('active')) trapDrawerFocus($modal[0], e);
    });
});

// Product detail inquiry modal uses the same drawer presentation as Request A Quote.
$(document).ready(function () {
    var $backdrop = $('#productInquiryBackdrop');
    var $modal = $('#productInquiryModal');
    var lastFocus = null;
    if (!$backdrop.length || !$modal.length) return;
    $modal.attr('tabindex', '-1');
    if ($modal.hasClass('active')) $('body').css('overflow', 'hidden');

    function closeProductInquiry() {
        $backdrop.removeClass('active');
        $modal.removeClass('active');
        $('body').css('overflow', '');
        if (lastFocus && lastFocus.focus) lastFocus.focus();
    }

    $(document).on('click', '.js-open-product-inquiry', function (e) {
        e.preventDefault();
        lastFocus = this;
        $backdrop.addClass('active');
        $modal.addClass('active');
        $('body').css('overflow', 'hidden');
        setTimeout(function () { $modal.trigger('focus'); }, 60);
    });
    $(document).on('click', '.js-close-product-inquiry', closeProductInquiry);
    $backdrop.on('click', closeProductInquiry);
    $(document).on('keydown', function (e) {
        if (e.key === 'Escape' && $modal.hasClass('active')) closeProductInquiry();
        if ($modal.hasClass('active')) trapDrawerFocus($modal[0], e);
    });
});

// Technical Brochure page: category filter dropdown
$(document).ready(function () {
    var $items = $('.brochure_filter_item');
    var $cards = $('#brochureGrid .brochure_card');
    if (!$items.length) return;

    $items.on('click', function (e) {
        e.preventDefault();
        var cat = $(this).data('cat');

        $items.removeClass('active');
        $(this).addClass('active');
        $('#brochureFilterLabel').text($(this).text());

        if (cat === 'all') {
            $cards.show();
        } else {
            $cards.each(function () {
                $(this).toggle($(this).data('cat') === cat);
            });
        }
    });
});

// About page: Vision / Mission / Purpose panel switcher (tabs + next button)
$(document).ready(function () {
    var $panels = $('.vmp_panel');
    var $tabs = $('.vmp_tab');
    if (!$panels.length) return;
    var current = 0;

    function showPanel(index, focusTab) {
        current = index;
        $panels.removeClass('active').eq(current).addClass('active');
        $tabs.removeClass('active').attr({ 'aria-selected': 'false', tabindex: '-1' });
        $tabs.eq(current).addClass('active').attr({ 'aria-selected': 'true', tabindex: '0' });
        if (focusTab) $tabs.eq(current).trigger('focus');
    }

    $('.vmp_next_btn').on('click', function () {
        showPanel((current + 1) % $panels.length);
    });

    $tabs.on('click', function () {
        showPanel($tabs.index(this));
    });

    // Arrow keys move between tabs, as expected for a tab list
    $tabs.on('keydown', function (e) {
        if (e.key === 'ArrowRight' || e.key === 'ArrowLeft') {
            e.preventDefault();
            var step = e.key === 'ArrowRight' ? 1 : -1;
            showPanel((current + step + $panels.length) % $panels.length, true);
        }
    });
});

// Keep the hero exactly one screen tall below the sticky header
function setHeaderHeight() {
    var h = document.getElementById('header');
    if (h) document.documentElement.style.setProperty('--header-h', h.offsetHeight + 'px');
}
setHeaderHeight();
$(window).on('load resize orientationchange', setHeaderHeight);

// Hero auto-sliding carousel
$(document).ready(function () {
    var $hero = $('.hero_slider');
    if (!$hero.length) return;

    // "01 / 04" counter next to the dots - updated as the slide starts
    // changing, so it stays in step with the active dot
    var $current = $('.hero_counter_current');
    function setCounter(index) {
        index += 1;
        $current.text(index < 10 ? '0' + index : index);
    }
    $hero.on('init', function (event, slick) { setCounter(slick.currentSlide); });
    $hero.on('beforeChange', function (event, slick, currentSlide, nextSlide) { setCounter(nextSlide); });

    $hero.slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        arrows: false,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 5000,
        speed: 600,
        fade: true,
        cssEase: 'ease-in-out',
        pauseOnHover: true,
        appendDots: '.hero_dots'
    });
});

// "We Represent" client logos auto-sliding carousel
// Slick only scrolls when there are more slides than visible ones, so a short
// list of logos is repeated until it can loop smoothly.
function fillLogoSlider($el, itemSelector, minSlides) {
    var $items = $el.children(itemSelector);
    if (!$items.length) return;
    var originals = $items.clone();
    while ($el.children(itemSelector).length < minSlides) {
        $el.append(originals.clone());
    }
}

$(document).ready(function () {
    fillLogoSlider($('.client_slider'), '.slider_item', 10);
    fillLogoSlider($('.brands_slider'), '.brand_item', 12);
    $('.client_slider').slick({
        slidesToShow: $('.client_slider').hasClass('logo_slider_full') ? 6 : 4,
        slidesToScroll: 1,
        dots: false,
        arrows: false,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 0,
        speed: 5000,
        cssEase: 'linear',
        pauseOnHover: false,
        pauseOnFocus: false,
        waitForAnimate: false,
        responsive: [
            { breakpoint: 1200, settings: { slidesToShow: $('.client_slider').hasClass('logo_slider_full') ? 5 : 4 } },
            { breakpoint: 992, settings: { slidesToShow: $('.client_slider').hasClass('logo_slider_full') ? 4 : 3 } },
            { breakpoint: 600, settings: { slidesToShow: 2 } }
        ]
    });
});

// "Our Brands" auto-sliding logo carousel
$(document).ready(function () {
    $('.brands_slider').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        dots: false,
        arrows: false,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 0,
        speed: 5000,
        cssEase: 'linear',
        pauseOnHover: false,
        pauseOnFocus: false,
        waitForAnimate: false,
        responsive: [
            { breakpoint: 1200, settings: { slidesToShow: 4 } },
            { breakpoint: 992, settings: { slidesToShow: 3 } }
        ]
    });
});


// Smart header: slides away when scrolling down, comes straight back on the
// slightest scroll up (and stays put while the menu or search is open).
(function () {
    var header = document.getElementById('header');
    if (!header) return;
    var lastY = window.pageYOffset;
    var ticking = false;

    function menuOpen() {
        var nav = document.getElementById('navbarSupportedContent');
        var search = document.getElementById('searchPanel');
        return (nav && nav.classList.contains('show')) || (search && search.classList.contains('open'));
    }

    function update() {
        var y = window.pageYOffset;
        var delta = y - lastY;
        if (menuOpen() || y < 120) {
            header.classList.remove('header_hidden');
        } else if (delta > 6) {
            header.classList.add('header_hidden');
        } else if (delta < -4) {
            header.classList.remove('header_hidden');
        }
        lastY = y;
        ticking = false;
    }

    window.addEventListener('scroll', function () {
        if (!ticking) { window.requestAnimationFrame(update); ticking = true; }
    }, { passive: true });
})();

// Back to top button: appears after the first screen, scrolls up smoothly
(function () {
    var button = document.getElementById('backToTop');
    if (!button) return;

    function toggle() {
        button.classList.toggle('visible', window.pageYOffset > window.innerHeight * 0.8);
    }
    toggle();
    window.addEventListener('scroll', toggle, { passive: true });
    button.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
})();

// Client preview mode: every menu / footer link stays visible, but only the pages listed in
// <body data-open-paths> (All Products, Product Detail, thank-you) can be opened. Clicking any
// other internal link does nothing except show a short notice. See views/front/preview-mode.php.
(function () {
    var body = document.body;
    var raw = body && body.getAttribute('data-open-paths');
    if (!raw) return;
    var open;
    try { open = JSON.parse(raw); } catch (e) { return; }

    var toast = null, timer = null;
    function notice() {
        if (!toast) {
            toast = document.createElement('div');
            toast.className = 'preview_toast';
            toast.setAttribute('role', 'status');
            toast.textContent = 'This page will be available soon.';
            document.body.appendChild(toast);
        }
        toast.classList.add('is-visible');
        clearTimeout(timer);
        timer = setTimeout(function () { toast.classList.remove('is-visible'); }, 2200);
    }

    function canOpen(path) {
        return open.some(function (p) {
            return p.charAt(p.length - 1) === '/' ? path.indexOf(p) === 0 : (path === p || path === p + '/');
        });
    }

    function guard(e) {
        var a = e.target.closest && e.target.closest('a[href]');
        if (!a) return;
        var href = a.getAttribute('href');
        if (!href || href.charAt(0) === '#' || /^(mailto:|tel:|javascript:)/i.test(href)) return;
        var url;
        try { url = new URL(a.href, window.location.href); } catch (err) { return; }
        if (url.origin !== window.location.origin) return;      // WhatsApp, social profiles, maps
        if (url.pathname.indexOf('/admin-assets/') !== -1) return; // catalogue / datasheet downloads
        if (canOpen(url.pathname)) return;
        e.preventDefault();
        e.stopPropagation();
        notice();
    }
    document.addEventListener('click', guard, true);
    document.addEventListener('auxclick', guard, true);
})();

// Tables written in the admin editor (product technical data, blog articles): each table is wrapped in its
// own scroll box, so several tables on one page scroll independently. While a table has more columns than
// fit, a "swipe" hint shows above it and its right edge fades; both disappear at the end of the scroll.
(function () {
    var tables = document.querySelectorAll('.product_technical_details table, .blog_detail_body table, .faq_item .rich_text table');
    Array.prototype.forEach.call(tables, function (table) {
        if (table.parentNode.classList.contains('table_scroll')) return;
        var wrap = document.createElement('div');
        wrap.className = 'table_scroll';
        table.parentNode.insertBefore(wrap, table);
        wrap.appendChild(table);

        var hint = document.createElement('p');
        hint.className = 'table_hint';
        hint.innerHTML = 'Swipe sideways to see the full table <span aria-hidden="true">&rarr;</span>';
        wrap.parentNode.insertBefore(hint, wrap);

        function update() {
            var scrollable = wrap.scrollWidth > wrap.clientWidth + 2;
            var atEnd = wrap.scrollLeft + wrap.clientWidth >= wrap.scrollWidth - 2;
            wrap.classList.toggle('is-scrollable', scrollable);
            wrap.classList.toggle('is-at-end', atEnd);
            hint.classList.toggle('is-visible', scrollable && !atEnd);
        }
        wrap.addEventListener('scroll', update, { passive: true });
        window.addEventListener('resize', update);
        window.addEventListener('load', update);
        update();
    });
})();
