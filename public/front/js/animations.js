// Scroll-reveal: tags the targets below, then fades/slides them in as they
// enter the viewport. Elements that arrive together are staggered, and once
// shown the tag is removed so each element goes back to its own styles
// (hover transitions etc. keep working).
(function () {
    if (!('IntersectionObserver' in window)) return;
    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    var SELECTORS = [
        '.section_head', '.products_header', '.brochure_header', '.vmp_head',
        '.stats_grid', '.partners_bar', '.range_head', '.range_card',
        '.ind_head', '.ind_tabs', '.about_text_col > *', '.values_orbit',
        '.about_intro_grid > *', '.about_video_wrap', '.about_quality', '.journey_item',
        '.vmp_card', '.founder_details', '.founder_visual', '.brands_slider',
        '.article_card', '.blog_featured_card', '.product_list_card', '.event_card',
        '.brochure_card', '.branch_card', '.contact_form_card', '.contact_info', '.contact_map',
        '.product_detail_visual', '.product_detail_content', '.product_technical_details',
        '.product_cta_banner', '.ft_main_row', '.empty_state'
    ].join(',');
    var EXCLUDE = '#header, .hero_area, .quote_modal, .dropdown-menu';

    var nodes = document.querySelectorAll(SELECTORS);
    var targets = [];
    Array.prototype.forEach.call(nodes, function (el) {
        if (el.closest(EXCLUDE)) return;
        // skip anything already inside another revealed element
        for (var p = el.parentElement; p; p = p.parentElement) {
            if (p.hasAttribute('data-reveal')) return;
        }
        el.setAttribute('data-reveal', el.classList.contains('values_orbit') ? 'fade' : '');
        targets.push(el);
    });
    if (!targets.length) return;

    document.documentElement.classList.add('js-anim');

    var io = new IntersectionObserver(function (entries) {
        var batch = 0;
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;
            var el = entry.target;
            var delay = Math.min(batch++, 5) * 90;
            io.unobserve(el);
            el.style.setProperty('--reveal-delay', delay + 'ms');
            el.classList.add('in-view');
            setTimeout(function () {
                el.removeAttribute('data-reveal');
                el.classList.remove('in-view');
                el.style.removeProperty('--reveal-delay');
            }, 900 + delay);
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -6% 0px' });

    targets.forEach(function (el) { io.observe(el); });
})();

// Count-up for the numbers in the home stats strip
(function () {
    var counters = document.querySelectorAll('[data-count]');
    if (!counters.length || !('IntersectionObserver' in window)) return;
    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    function run(el) {
        var target = parseInt(el.getAttribute('data-count'), 10) || 0;
        var start = null;
        var duration = 1400;
        function step(ts) {
            if (!start) start = ts;
            var progress = Math.min((ts - start) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.round(target * eased);
            if (progress < 1) window.requestAnimationFrame(step);
        }
        window.requestAnimationFrame(step);
    }

    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;
            io.unobserve(entry.target);
            run(entry.target);
        });
    }, { threshold: 0.6 });

    Array.prototype.forEach.call(counters, function (el) {
        el.textContent = '0';
        io.observe(el);
    });
})();
