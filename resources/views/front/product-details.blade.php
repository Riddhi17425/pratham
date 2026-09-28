@extends('front.app')

@section('title', 'Pratham Filter Industries | product-detail')

@section('content')
<?php
require base_path('resources/views/front/products-data.blade.php');

$requested = isset($_GET['p']) ? $_GET['p'] : 'Spun Filter Cartridge';
$product = null;
foreach ($products as $p) {
    if ($p[0] === $requested) { $product = $p; break; }
}
if (!$product) { $product = $products[0]; }
$name = $product[0];
$short_desc = $product[1];
$list_image = $product[2];

$details = isset($product_details[$name]) ? $product_details[$name] : null;
$hero_image = $details ? $details['image'] : $list_image;
$hero_image_path = 'img/figma/products/' . $hero_image;
$paragraphs = $details ? $details['paragraphs'] : [$short_desc];


?>

<section class="page_hero" style="background-image: url('{{ asset('front/img/figma/about/page-hero-bg.jpg') }}');">
    <div class="page_hero_overlay"></div>
    <div class="container position-relative">
        <div class="page_hero_content">
            <div class="breadcrumb_row">
                <a href="{{ url('/') }}">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <a href="/products">Water Filter Products</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span><?php echo htmlspecialchars($name); ?></span>
            </div>
            <h1 class="page_hero_title product_detail_hero_title"><?php echo htmlspecialchars($name); ?></h1>
        </div>
    </div>
</section>

<section class="section_padding">
    <div class="container product_detail_feature">
        <div class="product_detail_visual">
            <img src="<?php echo asset('front/' . $hero_image_path); ?>" alt="<?php echo htmlspecialchars($name); ?>">
        </div>
        <div class="product_detail_content">
            <h2 class="title mb-0"><?php echo htmlspecialchars($name); ?></h2>
            <?php foreach ($paragraphs as $para): ?>
                <p class="sub_text_p16"><?php echo htmlspecialchars($para); ?></p>
            <?php endforeach; ?>
            <div class="product_detail_actions">
                <a href="#" class="purple-btn-solid product_download_btn"><i class="fa-solid fa-download"></i> Download Catalogue</a>
                <a href="/contact" class="product_enquire_btn">Enquire Now</a>
            </div>
        </div>
    </div>
</section>

<?php if ($details): ?>
<hr class="product_detail_divider">
<section class="section_padding_top section_padding_bot">
    <div class="container">
        <p class="products_eyebrow">Technical Data</p>
        <h2 class="product_spec_title"><?php echo htmlspecialchars($name); ?> Specifications</h2>
        <span class="products_accent_line mb-4"></span>
        <p class="product_spec_note"><?php echo htmlspecialchars($details['spec_note']); ?></p>

        <div class="spec_table_scroll">
            <div class="spec_table">
                <div class="spec_table_header">
                    <span>MOC</span>
                    <span>Diameter</span>
                    <span>Length</span>
                    <span>Micron</span>
                    <span>Configuration</span>
                </div>
                <?php foreach ($details['spec_table'] as $i => $row): ?>
                <div class="spec_table_row <?php echo $i % 2 === 1 ? 'spec_row_alt' : ''; ?>">
                    <span><?php echo htmlspecialchars($row[0]); ?></span>
                    <span><?php echo htmlspecialchars($row[1]); ?></span>
                    <span><?php echo htmlspecialchars($row[2]); ?></span>
                    <span><?php echo htmlspecialchars($row[3]); ?></span>
                    <span><?php echo htmlspecialchars($row[4]); ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="product_cta_banner" style="background-image: linear-gradient(-1deg, rgba(57,49,133,0.92) 0%, rgba(57,50,133,0.92) 38%, rgba(0,160,227,0.92) 100%), url('{{ asset('front/img/figma/products/product-cta-bg.jpg') }}');">
    <div class="container">
        <h2 class="product_cta_title">Need Help Choosing The Right Filter?</h2>
        <p class="product_cta_text">Talk to our team and get a recommendation tailored to your exact filtration requirements.</p>
        <div class="product_cta_actions">
            <a href="/contact" class="product_cta_btn_outline">Talk to Our Experts</a>
            <a href="/products" class="product_cta_btn_solid">Explore Water Filter Products</a>
        </div>
    </div>
</section>


@endsection
