@extends('front.app')

@section('title', 'Pratham Filter Industries | technical-brochure')

@section('content')

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
        </div>

        <div class="brochure_grid" id="brochureGrid">
            @forelse($sheets as $sheet)
                @if($sheet->brochure)
                    <a href="{{ asset('admin-assets/technical-data-sheets/brochure/' . $sheet->brochure) }}"
                       class="brochure_card" target="_blank" download data-cat="{{ $sheet->category_id }}">
                        <img src="{{ asset('front/img/figma/pdf-icon.svg') }}" alt="PDF" class="brochure_pdf_icon">
                        <span>{{ $sheet->category->title }}</span>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    var items    = document.querySelectorAll('.brochure_filter_item');
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
</script>

@endsection