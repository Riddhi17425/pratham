@extends('front.app')

@section('title', 'Pratham Filter Industries | blog')

@section('content')
<?php
require base_path('resources/views/front/blog-data.blade.php');

?>

<section class="page_hero" style="background-image: url('{{ asset('front/img/figma/about/page-hero-bg.jpg') }}');">
    <div class="page_hero_overlay"></div>
    <div class="container position-relative">
        <div class="page_hero_content">
            <div class="breadcrumb_row">
                <a href="{{ url('/') }}">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>Blog</span>
            </div>
            <h1 class="page_hero_title">Latest Articles</h1>
        </div>
    </div>
</section>

<section class="section_padding">
    <div class="container">
        <a href="/blog-detail?post=<?php echo urlencode($blog_featured['title']); ?>" class="blog_featured_card" style="background-image: linear-gradient(180deg, rgba(25,25,77,0) 0%, rgba(25,25,77,1) 100%), url('<?php echo asset('front/' . $blog_featured['image']); ?>');">
            <div class="blog_featured_content">
                <span class="blog_featured_tag">Featured</span>
                <h2 class="blog_featured_title"><?php echo htmlspecialchars($blog_featured['title']); ?></h2>
                <p class="blog_featured_excerpt"><?php echo htmlspecialchars($blog_featured['excerpt']); ?></p>
            </div>
            <span class="blog_featured_arrow"><img src="{{ asset('front/img/figma/blog/featured-cta-arrow.svg') }}" alt=""></span>
        </a>

        <div class="articles_grid blog_grid">
            <?php foreach (array_chunk($blog_posts, 4) as $row): ?>
            <div class="articles_row">
                <?php foreach ($row as $post): ?>
                <a href="/blog-detail?post=<?php echo urlencode($post['title']); ?>" class="articles_card">
                    <img src="{{ asset('front/img/figma/article-card-frame.svg') }}" alt="" class="articles_frame">
                    <p class="articles_date"><?php echo $post['date']; ?></p>
                    <h3 class="articles_title"><?php echo htmlspecialchars($post['title']); ?></h3>
                    <img src="<?php echo asset('front/' . $post['image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" class="articles_photo">
                </a>
                <?php endforeach; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


@endsection
