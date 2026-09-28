// Scroll-reveal: tags the targets below, then fades/slides them in as they
// enter the viewport. Once shown, the tag is removed so the element goes back
// to its own normal styles (hover transitions etc. keep working).
(function () {
    if (!('IntersectionObserver' in window)) return;
    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    var SELECTORS = [
        '.title', '.products_header', '.client_title',
        '.we_represent_row', '.filter_card', '.collage_title_card', '.about_text_col > *',
        '.about_ring_col', '.about_intro_text', '.about_video_wrap', '.articles_card',
        '.event_card', '.product_list_card', '.branch_card', '.brochure_card',
        '.blog_featured_card', '.vmp_card', '.founder_row', '.product_cta_banner',
        '.contact_form', '.contact_info', '.spec_table', '.product_detail_content',
        '.product_detail_visual', '.brands_row', '.brands_slider', '.ft_content'
    ].join(',');
    var EXCLUDE = '#header, .hero_area, .quote_modal, .video_modal, .dropdown-menu';

    var nodes = document.querySelectorAll(SELECTORS);
    var targets = [];
    Array.prototype.forEach.call(nodes, function (el) {
        if (el.closest(EXCLUDE)) return;
        // skip anything already inside another revealed element
        for (var p = el.parentElement; p; p = p.parentElement) {
            if (p.hasAttribute('data-reveal')) return;
        }
        targets.push(el);
    });
    if (!targets.length) return;

    document.documentElement.classList.add('js-anim');

    // Stagger siblings that share a parent (cards in a row, list items...)
    var seen = new Map();
    targets.forEach(function (el) {
        var i = seen.get(el.parentElement) || 0;
        seen.set(el.parentElement, i + 1);
        el.setAttribute('data-reveal', el.classList.contains('about_ring_col') ? 'fade' : '');
        el.style.setProperty('--reveal-delay', Math.min(i, 5) * 90 + 'ms');
    });

    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;
            var el = entry.target;
            io.unobserve(el);
            el.classList.add('in-view');
            var wait = 900 + (parseInt(el.style.getPropertyValue('--reveal-delay'), 10) || 0);
            setTimeout(function () {
                el.removeAttribute('data-reveal');
                el.classList.remove('in-view');
                el.style.removeProperty('--reveal-delay');
            }, wait);
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -6% 0px' });

    targets.forEach(function (el) { io.observe(el); });
})();
