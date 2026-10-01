@extends('front.app')

@section('title', 'Pratham Filter Industries | Blog')

@section('content')
<section class="page_hero" style="background-image: url('{{ asset('front/img/figma/about/page-hero-bg.jpg') }}');">
    <div class="page_hero_overlay"></div>
    <div class="container position-relative">
        <div class="page_hero_content">
            <div class="breadcrumb_row">
                <a href="{{ route('home') }}">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>Blog</span>
            </div>
            <h1 class="page_hero_title">Latest Articles</h1>
        </div>
    </div>
</section>

<section class="section_padding">
    <div class="container">
        @if ($blogs->isNotEmpty())
            @php($featuredBlog = $blogs->first())

            @if ($featuredBlog->front_image)
                <a href="{{ route('blog.details', ['post' => $featuredBlog->url]) }}"
                   class="blog_featured_card"
                   style="background-image: linear-gradient(180deg, rgba(25,25,77,0) 0%, rgba(25,25,77,1) 100%), url('{{ asset('admin-assets/blogs/front_image/' . $featuredBlog->front_image) }}');">
                    <div class="blog_featured_content">
                        <span class="blog_featured_tag">Featured</span>
                        <h2 class="blog_featured_title">{{ $featuredBlog->title }}</h2>
                        <p class="blog_featured_excerpt">{{ strip_tags($featuredBlog->short_description ?? '') }}</p>
                    </div>
                    <span class="blog_featured_arrow">
                        <img src="{{ asset('front/img/figma/blog/featured-cta-arrow.svg') }}" alt="">
                    </span>
                </a>
            @endif

            <div class="articles_grid blog_grid">
                <div class="articles_row">
                    @foreach ($blogs->skip($featuredBlog->front_image ? 1 : 0) as $blog)
                        <a href="{{ route('blog.details', ['post' => $blog->url]) }}" class="articles_card">
                            <img src="{{ asset('front/img/figma/article-card-frame.svg') }}" alt="" class="articles_frame">
                            <p class="articles_date">
                                {{ $blog->date ? $blog->date->format('F j, Y') : $blog->created_at?->format('F j, Y') }}
                            </p>
                            <h3 class="articles_title">{{ $blog->title }}</h3>
                            @if ($blog->front_image)
                                <img src="{{ asset('admin-assets/blogs/front_image/' . $blog->front_image) }}"
                                     alt="{{ $blog->front_image_alt ?: $blog->title }}"
                                     class="articles_photo">
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <p class="sub_text_p16">No articles are available yet.</p>
        @endif
    </div>
</section>
@endsection
