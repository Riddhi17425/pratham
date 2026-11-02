@extends('front.app')

@section('title', 'Technical Datasheet | Pratham Filter Industries')

@section('content')

@include('front.partials.page-hero', [
    'title' => 'Technical Datasheet',
    'crumbs' => [['label' => 'Technical Brochure']],
    'subtitle' => 'Download technical datasheets for our filtration products.',
])

<section class="section_padding">
    <div class="container">
        <div class="brochure_header">
            <div>
                <p class="products_eyebrow">Downloads</p>
                <h2 class="title">Latest Sheets</h2>
            </div>

            {{-- Category filter dropdown (temporarily hidden)
            <div class="dropdown brochure_filter_dropdown">
                <button class="brochure_filter" type="button" id="brochureFilterBtn" data-bs-toggle="dropdown" aria-expanded="false">
                    <span id="brochureFilterLabel">All Categories</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="brochureFilterBtn" id="brochureFilterMenu">
                    <li><a class="dropdown-item brochure_filter_item active" href="#" data-cat="all">All Categories</a></li>
                    @foreach($categories as $category)
                        <li><a class="dropdown-item brochure_filter_item" href="#" data-cat="{{ $category->id }}">{{ $category->title }}</a></li>
                    @endforeach
                </ul>
            </div>
            --}}
        </div>

        <div class="brochure_grid" id="brochureGrid">
            @forelse($sheets as $sheet)
                @if($sheet->brochure)
                    <a href="{{ asset('admin-assets/technical-data-sheets/brochure/' . $sheet->brochure) }}"
                       class="brochure_card" target="_blank" download="{{ $sheet->brochure }}" data-cat="{{ $sheet->category_id }}">
                        <span class="brochure_card_icon"><img src="{{ asset('front/img/figma/pdf-icon.svg') }}" alt="" class="brochure_pdf_icon"></span>
                        <span class="brochure_card_body">
                            <span class="brochure_card_title">{{ $sheet->category->title ?? 'Technical Datasheet' }}</span>
                            <small class="brochure_card_meta">PDF datasheet</small>
                        </span>
                        <span class="brochure_card_action" aria-hidden="true"><i class="fa-solid fa-download"></i></span>
                    </a>
                @endif
            @empty
                <div class="empty_state brochure_empty_state">
                    <i class="fa-regular fa-file-pdf" aria-hidden="true"></i>
                    <h3>No technical sheets available right now.</h3>
                </div>
            @endforelse
        </div>

        <p id="brochureEmpty" class="product_no_results mt-4" style="display:none;">
            No technical sheets found in this category.
        </p>
    </div>
</section>

{{-- Download popup: PDF falls into the basket, then the download starts --}}
<div class="dl_overlay" id="dlOverlay" aria-hidden="true">
    <div class="dl_modal" role="dialog" aria-modal="true" aria-labelledby="dlTitle">
        <button type="button" class="dl_close" id="dlClose" aria-label="Close">&times;</button>

        <div class="dl_stage" id="dlStage">
            <div class="dl_scene" id="dlScene">
                <svg class="dl_bg" viewBox="0 0 340 230" aria-hidden="true">
                    <rect width="340" height="230" fill="#f8f9fa" />
                    <rect y="216" width="340" height="14" fill="#e9ecef" />
                    <rect x="28" y="30" width="8" height="186" rx="2" fill="#adb5bd" />
                    <line x1="36" y1="64" x2="100" y2="50" stroke="#adb5bd" stroke-width="6" stroke-linecap="round" />
                    <line x1="36" y1="108" x2="100" y2="94" stroke="#adb5bd" stroke-width="6" stroke-linecap="round" />
                    <rect x="100" y="18" width="136" height="94" rx="4" fill="#ffffff" stroke="#495057" stroke-width="3" />
                    <rect x="150" y="62" width="40" height="34" rx="1" fill="none" stroke="#e03131" stroke-width="3" />
                    <rect x="164" y="96" width="12" height="14" fill="#c92a2a" />
                    <path d="M144 112 A26 7 0 0 1 196 112" fill="none" stroke="#e03131" stroke-width="4" />
                </svg>
                <div class="dl_ball" id="dlBall">PDF</div>
                <svg class="dl_front" viewBox="0 0 340 230" aria-hidden="true">
                    <g class="dl_net" id="dlNet">
                    <line x1="144" y1="114" x2="154" y2="160" />
                    <line x1="157" y1="117" x2="162" y2="160" />
                    <line x1="170" y1="119" x2="170" y2="160" />
                    <line x1="183" y1="117" x2="178" y2="160" />
                    <line x1="196" y1="114" x2="186" y2="160" />
                    <line x1="144" y1="114" x2="162" y2="160" />
                    <line x1="157" y1="117" x2="154" y2="160" />
                    <line x1="157" y1="117" x2="170" y2="160" />
                    <line x1="170" y1="119" x2="162" y2="160" />
                    <line x1="170" y1="119" x2="178" y2="160" />
                    <line x1="183" y1="117" x2="170" y2="160" />
                    <line x1="183" y1="117" x2="186" y2="160" />
                    <line x1="196" y1="114" x2="178" y2="160" />
                    <line x1="148" y1="134" x2="192" y2="134" /><line x1="152" y1="150" x2="188" y2="150" />
                    </g>
                    <path d="M144 112 A26 7 0 0 0 196 112" fill="none" stroke="#e03131" stroke-width="4.5" />
                </svg>
            </div>
        </div>

        <h3 class="dl_title" id="dlTitle">Downloading your PDF&hellip;</h3>
        <p class="dl_name" id="dlName"></p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var items = document.querySelectorAll('.brochure_filter_item');
    if (!items.length) return;

    var cards    = document.querySelectorAll('#brochureGrid .brochure_card');
    var label    = document.getElementById('brochureFilterLabel');
    var emptyMsg = document.getElementById('brochureEmpty');

    items.forEach(function (item) {
        item.addEventListener('click', function (e) {
            e.preventDefault();

            var cat = this.getAttribute('data-cat');

            // active class
            items.forEach(function (i) { i.classList.remove('active'); });
            this.classList.add('active');

            // button label
            label.textContent = this.textContent.trim();

            // cards show/hide
            var visible = 0;
            cards.forEach(function (card) {
                var show = (cat === 'all' || card.getAttribute('data-cat') === cat);
                card.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            emptyMsg.style.display = visible === 0 ? 'block' : 'none';
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    var overlay = document.getElementById('dlOverlay');
    if (!overlay) return;

    var stage   = document.getElementById('dlStage');
    var scene   = document.getElementById('dlScene');
    var ball    = document.getElementById('dlBall');
    var net     = document.getElementById('dlNet');
    var title   = document.getElementById('dlTitle');
    var nameEl  = document.getElementById('dlName');
    var closeBtn = document.getElementById('dlClose');
    var cards   = document.querySelectorAll('#brochureGrid .brochure_card');

    var BALL_W = 30, BALL_H = 38, RIM_X = 170, RIM_Y = 112, NET_BOTTOM = 160;
    var busy = false, runId = 0, closeTimer = null;
    var reduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function fitScene() {
        var s = Math.min(1, stage.clientWidth / 340);
        scene.style.transform = 'scale(' + s + ')';
        stage.style.height = Math.round(230 * s) + 'px';
    }

    function resetBall() {
        if (ball.getAnimations) {
            ball.getAnimations().forEach(function (a) { a.cancel(); });
        }
        ball.style.display = 'none';
        net.classList.remove('swish');
    }

    function placeBall() {
        ball.style.display = 'flex';
        ball.style.transform = 'translate(' + (RIM_X - BALL_W / 2) + 'px,' + (NET_BOTTOM - BALL_H + 6) + 'px)';
    }

    function throwBall(onLanded) {
        resetBall();

        var sx = 8, sy = 230 - BALL_H - 14;
        var rx = RIM_X - BALL_W / 2, ry = RIM_Y - BALL_H - 6;
        var ey = NET_BOTTOM - BALL_H + 6;
        var peak = 4;
        var cy = 2 * peak - 0.5 * (sy + ry);

        if (!ball.animate || reduced) {
            placeBall();
            net.classList.add('swish');
            onLanded();
            return;
        }

        ball.style.display = 'flex';

        var frames = [], i, t, x, y;
        for (i = 0; i <= 24; i++) {
            t = i / 24;
            x = sx + (rx - sx) * t;
            y = Math.pow(1 - t, 2) * sy + 2 * (1 - t) * t * cy + t * t * ry;
            frames.push({ transform: 'translate(' + x + 'px,' + y + 'px) rotate(' + (t * 360) + 'deg)' });
        }

        var a1 = ball.animate(frames, { duration: 950, easing: 'linear', fill: 'forwards' });
        a1.onfinish = function () {
            var a2 = ball.animate([
                { transform: 'translate(' + rx + 'px,' + ry + 'px) rotate(360deg)' },
                { transform: 'translate(' + rx + 'px,' + ey + 'px) rotate(360deg)' }
            ], { duration: 350, easing: 'cubic-bezier(.4,0,1,1)', fill: 'forwards' });
            a2.onfinish = function () {
                net.classList.add('swish');
                onLanded();
            };
        };
    }

    function triggerDownload(url, filename) {
        var a = document.createElement('a');
        a.href = url;
        a.download = filename || '';
        a.style.display = 'none';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }

    function closeModal() {
        runId++;
        clearTimeout(closeTimer);
        overlay.classList.remove('show');
        overlay.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        resetBall();
        busy = false;
    }

    function startDownload(card) {
        busy = true;
        var run = ++runId;
        var labelEl = card.querySelector('.brochure_card_title') || card.querySelector('span');

        nameEl.textContent = labelEl ? labelEl.textContent.trim() : '';
        title.innerHTML = 'Downloading your PDF&hellip;';
        title.classList.remove('done');

        overlay.classList.add('show');
        overlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        fitScene();
        resetBall();
        closeBtn.focus();

        var fileName = card.getAttribute('download');

        var filePromise = window.fetch
            ? fetch(card.href, { credentials: 'same-origin' }).then(function (res) {
                  if (!res.ok) { throw new Error('Download failed'); }
                  return res.blob();
              })
            : Promise.reject(new Error('fetch not supported'));

        function finish(text) {
            if (run !== runId) return;
            title.textContent = text;
            title.classList.add('done');
            closeTimer = setTimeout(closeModal, 2200);
        }

        setTimeout(function () {
            if (run !== runId) return;

            throwBall(function () {
                if (run !== runId) return;

                filePromise.then(function (blob) {
                    if (run !== runId) return;

                    var blobUrl = URL.createObjectURL(blob);
                    triggerDownload(blobUrl, fileName);
                    setTimeout(function () { URL.revokeObjectURL(blobUrl); }, 15000);
                    finish('✓ Download complete');
                }).catch(function () {
                    if (run !== runId) return;

                    triggerDownload(card.href, fileName);
                    finish('✓ Download started');
                });
            });
        }, 300);
    }

    cards.forEach(function (card) {
        card.addEventListener('click', function (e) {
            if (e.defaultPrevented || e.button !== 0 || e.ctrlKey || e.metaKey || e.shiftKey || e.altKey) return;

            e.preventDefault();
            if (busy) return;

            startDownload(card);
        });
    });

    closeBtn.addEventListener('click', closeModal);
    overlay.addEventListener('click', function (e) { if (e.target === overlay) closeModal(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && busy) closeModal(); });
});
</script>

@endsection
