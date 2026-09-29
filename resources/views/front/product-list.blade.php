@extends('front.app')

@section('title', 'Pratham Filter Industries | products')

@section('content')
<?php
require base_path('resources/views/front/products-data.blade.php');

?>

<section class="page_hero" style="background-image: url('{{ asset('front/img/figma/about/page-hero-bg.jpg') }}');">
    <div class="page_hero_overlay"></div>
    <div class="container position-relative">
        <div class="page_hero_content">
            <div class="breadcrumb_row">
                <a href="{{ url('/') }}">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>Water Filter Products</span>
            </div>
            <h1 class="page_hero_title">Water Filter Products</h1>
        </div>
    </div>
</section>

<section class="section_padding">
    <div class="container">
        <div class="products_header">
            <div class="products_header_title">
                <p class="products_eyebrow">Our Products</p>
                <h2 class="title mb-0">Explore Our Range</h2>
                <span class="products_accent_line"></span>
            </div>
            <div class="products_search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" placeholder="Search products..." id="productSearch">
            </div>
        </div>

        <div class="product_grid_list" id="productGridList">
            <?php foreach ($products as $p): ?>
            <div class="product_list_card <?php echo $p[4]==='shadow' ? 'product_card_shadow' : ''; ?>" data-name="<?php echo strtolower($p[0]); ?>">
                <div class="product_list_img_wrap product_img_<?php echo $p[3]; ?>">
                    <img src="{{ asset('front/img/figma/products/' . $p[2]) }}" alt="<?php echo htmlspecialchars($p[0]); ?>">
                </div>
                <div class="product_list_info">
                    <h3 class="product_list_title"><?php echo htmlspecialchars($p[0]); ?></h3>
                    <p class="product_list_desc"><?php echo htmlspecialchars($p[1]); ?></p>
                    <a href="/product-detail?p=<?php echo urlencode($p[0]); ?>" class="dark-btn product_know_more">Know More</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <p class="product_no_results" id="productNoResults" style="display:none;">No products match your search.</p>
    </div>
</section>

<section class="product_cta_banner" style="background-image: linear-gradient(-1deg, rgba(57,49,133,0.92) 0%, rgba(57,50,133,0.92) 38%, rgba(0,160,227,0.92) 100%), url('{{ asset('front/img/figma/products/product-cta-bg.jpg') }}');">
    <div class="container">
        <h2 class="product_cta_title">Can&rsquo;t Find What You&rsquo;re Looking For?</h2>
        <p class="product_cta_text">Our engineering team can design a custom filtration solution built around your exact process requirements.</p>
        <a href="/contact" class="purple-btn-solid product_cta_btn">Request for Quote</a>
    </div>
</section>



<script>
document.getElementById('productSearch').addEventListener('input', function () {
    const q = this.value.trim().toLowerCase();
    let visible = 0;
    document.querySelectorAll('#productGridList .product_list_card').forEach(function (card) {
        const match = card.dataset.name.includes(q);
        card.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    document.getElementById('productNoResults').style.display = visible === 0 ? 'block' : 'none';
});
// arrived from the header search (?q=...)
(function () {
    const q = new URLSearchParams(location.search).get('q');
    if (!q) return;
    const el = document.getElementById('productSearch');
    el.value = q;
    el.dispatchEvent(new Event('input'));
})();
</script>

@endsection
