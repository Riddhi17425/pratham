// Site search: toggle panel, live suggestions, keyboard support.
(function () {
    var panel = document.getElementById('searchPanel');
    var input = document.getElementById('siteSearchInput');
    var list = document.getElementById('searchResults');
    if (!panel || !input || !list) return;

    var data = window.SITE_SEARCH || [];
    var form = input.form;
    var toggles = document.querySelectorAll('.js-open-search');
    var active = -1;

    function esc(s) {
        return String(s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    function open() {
        panel.classList.add('open');
        panel.setAttribute('aria-hidden', 'false');
        toggles.forEach(function (t) { t.setAttribute('aria-expanded', 'true'); });
        setTimeout(function () { input.focus(); }, 60);
        render();
    }

    function close() {
        panel.classList.remove('open');
        panel.setAttribute('aria-hidden', 'true');
        toggles.forEach(function (t) { t.setAttribute('aria-expanded', 'false'); });
    }

    function matches(q) {
        q = q.toLowerCase();
        return data
            .map(function (it) {
                var t = it.t.toLowerCase();
                var hay = t + ' ' + (it.x || '').toLowerCase();
                var score = t.indexOf(q) === 0 ? 0 : t.indexOf(q) > -1 ? 1 : hay.indexOf(q) > -1 ? 2 : -1;
                return { it: it, score: score };
            })
            .filter(function (r) { return r.score > -1; })
            .sort(function (a, b) { return a.score - b.score; })
            .slice(0, 8)
            .map(function (r) { return r.it; });
    }

    function highlight(text, q) {
        var i = text.toLowerCase().indexOf(q.toLowerCase());
        if (i < 0 || !q) return esc(text);
        return esc(text.slice(0, i)) + '<mark>' + esc(text.slice(i, i + q.length)) + '</mark>' + esc(text.slice(i + q.length));
    }

    function render() {
        var q = input.value.trim();
        active = -1;
        if (!q) { list.innerHTML = ''; return; }
        var res = matches(q);
        if (!res.length) {
            list.innerHTML = '<li class="search_empty">No results for &ldquo;' + esc(q) +
                '&rdquo;. <a href="./products.php?q=' + encodeURIComponent(q) + '">Search all products</a></li>';
            return;
        }
        list.innerHTML = res.map(function (it) {
            return '<li role="option"><a href="' + esc(it.u) + '"><span>' + highlight(it.t, q) +
                '</span><span class="search_badge">' + esc(it.k) + '</span></a></li>';
        }).join('');
    }

    function move(dir) {
        var links = list.querySelectorAll('a');
        if (!links.length) return;
        if (active > -1) links[active].classList.remove('active');
        active = (active + dir + links.length) % links.length;
        links[active].classList.add('active');
        links[active].scrollIntoView({ block: 'nearest' });
    }

    toggles.forEach(function (t) {
        t.addEventListener('click', function () {
            panel.classList.contains('open') ? close() : open();
        });
    });
    document.querySelectorAll('.js-close-search').forEach(function (b) { b.addEventListener('click', close); });
    input.addEventListener('input', render);

    input.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowDown') { e.preventDefault(); move(1); }
        else if (e.key === 'ArrowUp') { e.preventDefault(); move(-1); }
    });

    // Enter: open the highlighted / first suggestion, else search all products
    form.addEventListener('submit', function (e) {
        var links = list.querySelectorAll('a[href]');
        var pick = active > -1 ? links[active] : links[0];
        if (pick && !pick.closest('.search_empty')) {
            e.preventDefault();
            window.location.href = pick.getAttribute('href');
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && panel.classList.contains('open')) close();
    });
    document.addEventListener('click', function (e) {
        if (!panel.classList.contains('open')) return;
        if (panel.contains(e.target) || e.target.closest('.js-open-search')) return;
        close();
    });
})();
