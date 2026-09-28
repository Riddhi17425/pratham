@extends('front.app')

@section('title', 'Pratham Filter Industries | technical-brochure')

@section('content')
<?php
$sheets = [
    ["Spun Filter Cartridge", "Filter Cartridges"],
    ["Filter Bags", "Filter Bags"],
    ["Pleated PP High Efficiency", "Filter Cartridges"],
    ["Activated Carbon Cartridge", "Filter Cartridges"],
    ["Washable Cartridge", "Filter Cartridges"],
    ["SS Filter Cartridge", "Filter Cartridges"],
    ["SS Basket Strainers", "Filter Housings & Assemblies"],
    ["Nominal Pleated Cartridge", "Filter Cartridges"],
    ["Std PP Filter Housings", "Filter Housings & Assemblies"],
    ["Jumbo Filter Housings", "Filter Housings & Assemblies"],
    ["PP Bag Filter Assembly", "Filter Housings & Assemblies"],
    ["SS Multi Filter Cartridge Housing", "Filter Housings & Assemblies"],
];
$categories = [];
foreach ($sheets as $s) {
    if (!in_array($s[1], $categories)) $categories[] = $s[1];
}

?>

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
                    <?php foreach ($categories as $cat): ?>
                    <li><a class="dropdown-item brochure_filter_item" href="#" data-cat="<?php echo htmlspecialchars($cat); ?>"><?php echo htmlspecialchars($cat); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="brochure_grid" id="brochureGrid">
            <?php foreach ($sheets as $sheet): ?>
            <a href="#" class="brochure_card" download data-cat="<?php echo htmlspecialchars($sheet[1]); ?>">
                <img src="{{ asset('front/img/figma/pdf-icon.svg') }}" alt="PDF" class="brochure_pdf_icon">
                <span><?php echo htmlspecialchars($sheet[0]); ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>


@endsection
