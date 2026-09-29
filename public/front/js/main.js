// Toggle the hamburger menu on click
document.getElementById("hamburgerToggle").addEventListener("click", function () {
    const icon = this.querySelector("i"); // Select the <i> element inside the button
    if (icon.classList.contains("fa-bars")) {
        icon.classList.remove("fa-bars");
        icon.classList.add("fa-times"); // Change to close icon
    } else {
        icon.classList.remove("fa-times");
        icon.classList.add("fa-bars"); // Change back to menu icon
    }
});
//sticky header
document.addEventListener("DOMContentLoaded", function () {
    const header = document.getElementById("header");
    
    window.addEventListener("scroll", function () {
        if (window.scrollY > 50) {
            if (!header.classList.contains("scrolled")) {
                header.classList.add("scrolled");
                header.style.animation = "slideDown 0.5s ease-in-out"; // Add animation
            }
        } else {
            header.classList.remove("scrolled");
            header.style.animation = ""; // Remove animation
        }
    });
});


// Request A Quote modal drawer
$(document).ready(function () {
    var $backdrop = $('#quoteModalBackdrop');
    var $modal = $('#quoteModal');

    function openQuoteModal(e) {
        if (e) e.preventDefault();
        $backdrop.addClass('active');
        $modal.addClass('active');
        $('body').css('overflow', 'hidden');
    }
    function closeQuoteModal() {
        $backdrop.removeClass('active');
        $modal.removeClass('active');
        $('body').css('overflow', '');
    }

    $(document).on('click', '.js-open-quote', openQuoteModal);
    $(document).on('click', '.js-close-quote', closeQuoteModal);
    $backdrop.on('click', closeQuoteModal);
    $(document).on('keydown', function (e) {
        if (e.key === 'Escape') closeQuoteModal();
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

    function showPanel(index) {
        current = index;
        $panels.removeClass('active').eq(current).addClass('active');
        $tabs.removeClass('active').eq(current).addClass('active');
    }

    $('.vmp_next_btn').on('click', function () {
        showPanel((current + 1) % $panels.length);
    });

    $tabs.on('click', function () {
        showPanel($tabs.index(this));
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
    $('.hero_slider').slick({
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
$(document).ready(function () {
    $('.client_slider').slick({
        slidesToShow: 4,
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
            { breakpoint: 992, settings: { slidesToShow: 3 } },
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
