@extends('front.app')

@section('title', 'Pratham Filter Industries | blog-detail')

@section('content')
<?php
require base_path('resources/views/front/blog-data.blade.php');

$requested = isset($_GET['post']) ? $_GET['post'] : $blog_featured['title'];
$all_posts = array_merge([$blog_featured], $blog_posts);
$post = null;
foreach ($all_posts as $p) {
    if ($p['title'] === $requested) { $post = $p; break; }
}
if (!$post) { $post = $blog_featured; }
$body = isset($blog_body[$post['title']]) ? $blog_body[$post['title']] : [
    ["p", isset($post['excerpt']) ? $post['excerpt'] : ""],
    ["p", "Our engineering team continues to expand this article with deeper technical detail. In the meantime, feel free to reach out to our team directly with any questions about this topic."],
];


?>

<section class="page_hero" style="background-image: url('{{ asset('front/img/figma/blog/blog-detail-hero-bg.jpg') }}');">
    <div class="page_hero_overlay"></div>
    <div class="container position-relative">
        <div class="page_hero_content">
            <div class="breadcrumb_row">
                <a href="{{ url('/') }}">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span><?php echo htmlspecialchars($post['title']); ?></span>
            </div>
            <h1 class="page_hero_title"><?php echo htmlspecialchars($post['title']); ?></h1>
        </div>
    </div>
</section>

<section class="section_padding">
    <div class="container">
        <div class="blog_detail_body">
            <?php $firstBlock = array_shift($body); ?>
            <p class="sub_text_p16"><?php echo htmlspecialchars($firstBlock[1]); ?></p>
        </div>

        <img src="<?php echo asset('front/' . $post['image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" class="w-100 blog_detail_hero_img">

        <div class="blog_detail_body">
            <?php foreach ($body as $block): ?>
                <?php if ($block[0] === 'h'): ?>
                    <h2 class="blog_detail_heading"><?php echo htmlspecialchars($block[1]); ?></h2>
                <?php else: ?>
                    <p class="sub_text_p16"><?php echo htmlspecialchars($block[1]); ?></p>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>


@endsection
