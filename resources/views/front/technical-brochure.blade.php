@extends('front.app')

@section('title', 'Pratham Filter Industries | technical-brochure')

@section('content')

<style>
    /* ---------- Download basket popup ---------- */
    .dl_overlay{position:fixed;top:0;right:0;bottom:0;left:0;background:rgba(15,23,42,.6);display:flex;align-items:center;justify-content:center;
        opacity:0;visibility:hidden;transition:opacity .25s,visibility .25s;z-index:99999;padding:16px}
    .dl_overlay.show{opacity:1;visibility:visible}
    .dl_modal{position:relative;box-sizing:border-box;background:#fff;border-radius:16px;padding:20px 20px 24px;width:100%;max-width:400px;text-align:center;
        transform:translateY(12px) scale(.97);transition:transform .25s;box-shadow:0 20px 50px rgba(0,0,0,.25)}
    .dl_overlay.show .dl_modal{transform:none}
    .dl_close{position:absolute;top:6px;right:12px;border:0;background:none;font-size:28px;line-height:1;color:#6c757d;cursor:pointer;z-index:5}
    .dl_close:hover{color:#212529}
    .dl_stage{position:relative;box-sizing:border-box;width:340px;max-width:100%;height:230px;margin:10px auto 0;overflow:hidden;
        border-radius:12px;border:1px solid #dee2e6;background:#f8f9fa}
    .dl_scene{position:relative;width:340px;height:230px;transform-origin:0 0}
    .dl_bg,.dl_front{position:absolute;left:0;top:0;width:340px;height:230px;pointer-events:none}
    .dl_bg{z-index:0}.dl_front{z-index:2}
    .dl_ball{position:absolute;left:0;top:0;width:30px;height:38px;display:none;align-items:flex-end;justify-content:center;padding-bottom:6px;
        font:700 10px/1 sans-serif;color:#fff;background:linear-gradient(160deg,#ff6b6b,#c92a2a);border-radius:3px;
        clip-path:polygon(0 0,calc(100% - 9px) 0,100% 9px,100% 100%,0 100%);z-index:1;transform:translate(8px,178px)}
    .dl_ball::after{content:"";position:absolute;top:0;right:0;width:9px;height:9px;background:linear-gradient(to top right,#ffc9c9 50%,transparent 50%)}
    .dl_net line{stroke:#868e96;stroke-width:1.4}
    .dl_net{transform-origin:170px 112px}
    .dl_net.swish{animation:dlSwish .6s ease}
    @keyframes dlSwish{0%{transform:scale(1,1)}30%{transform:scale(1.12,.92)}60%{transform:scale(.94,1.06)}100%{transform:scale(1,1)}}
    .dl_title{font-size:20px;font-weight:600;margin:16px 0 4px;color:#212529}
    .dl_title.done{color:#2b8a3e}
    .dl_name{margin:0;color:#6c757d;font-size:14px;word-break:break-word}
</style>

<section class="page_hero" style="background-image: url('{{ asset('front/img/figma/about/page-hero-bg.jpg') }}');">
    <div class="page_hero_overlay"></div>
    <div class="container position-relative">
        <div class="page_hero_content">
            <div class="breadcrumb_row">
                <a href="{{ url('/') }}">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>Technical Brochure</span>
            </div>
            <h1 class="page_hero_title">Technical Datasheet</h1>
        </div>
    </div>
</section>

<section class="section_padding">
    <div class="container">
        <div class="brochure_header">
            <h2 class="title mb-0">Latest Sheets</h2>

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
                        <img src="{{ asset('front/img/figma/pdf-icon.svg') }}" alt="PDF" class="brochure_pdf_icon">
                        <span>{{ $sheet->category->title ?? 'Technical Datasheet' }}</span>
                    </a>
                @endif
            @empty
                <p class="text-center w-100">No technical sheets available right now.</p>
            @endforelse
        </div>

        <p id="brochureEmpty" class="text-center w-100 mt-4" style="display:none;">
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
    if (!items.length) return; // dropdown hidden hai to kuch na karo

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

// ---------------------------------------------------------------
// Download: PDF basket me girti hai, phir download shuru hota hai
// ---------------------------------------------------------------
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

    // chhoti screen par scene ko fit karo
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
        var labelEl = card.querySelector('span');

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

        // file animation ke saath-saath load hoti hai, taaki "complete" sach me complete ho
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
            if (run !== runId) return; // popup band ho chuka hai

            throwBall(function () {
                if (run !== runId) return;

                // PDF basket me aa gayi, file poori load hote hi save karo
                filePromise.then(function (blob) {
                    if (run !== runId) return;

                    var blobUrl = URL.createObjectURL(blob);
                    triggerDownload(blobUrl, fileName);
                    setTimeout(function () { URL.revokeObjectURL(blobUrl); }, 15000);
                    finish('\u2713 Download complete');
                }).catch(function () {
                    if (run !== runId) return;

                    // fallback: browser ka normal download (completion ka pata nahi chalta)
                    triggerDownload(card.href, fileName);
                    finish('\u2713 Download started');
                });
            });
        }, 300);
    }

    cards.forEach(function (card) {
        card.addEventListener('click', function (e) {
            // new tab / shortcut clicks ko browser par chhod do
            if (e.defaultPrevented || e.button !== 0 || e.ctrlKey || e.metaKey || e.shiftKey || e.altKey) return;

            e.preventDefault();
            if (busy) return; // double click par dobara na chale

            startDownload(card);
        });
    });

    closeBtn.addEventListener('click', closeModal);
    overlay.addEventListener('click', function (e) { if (e.target === overlay) closeModal(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && busy) closeModal(); });
});
</script>

@endsection
