@extends('front.app')

@section('title', $metaTitle . ' | Pratham Filter Industries')
@section('meta_description', $metaDescription)

@section('content')
<section class="page_hero" style="background-image: url('{{ asset('front/img/figma/blog/blog-detail-hero-bg.jpg') }}');">
    <div class="page_hero_overlay"></div>
    <div class="container position-relative">
        <div class="page_hero_content">
            <div class="breadcrumb_row">
                <a href="{{ route('home') }}">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <a href="{{ route('blog') }}">Blogs</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>{{ $blog->title }}</span>
            </div>
            <h1 class="page_hero_title">{{ $blog->title }}</h1>
        </div>
    </div>
</section>

<section class="section_padding">
    <article class="container">
        @if ($blog->date)
            <p class="articles_date mb-3">{{ $blog->date->format('F j, Y') }}</p>
        @endif

        @if ($blog->short_description)
            <div class="blog_detail_body"><p class="sub_text_p16">{{ strip_tags($blog->short_description) }}</p></div>
        @endif

        @if ($blog->detail_image || $blog->front_image)
            <img src="{{ $blog->detail_image ? asset('admin-assets/blogs/detail_image/' . $blog->detail_image) : asset('admin-assets/blogs/front_image/' . $blog->front_image) }}"
                 alt="{{ $blog->detail_image_alt ?: ($blog->front_image_alt ?: $blog->title) }}"
                 class="w-100 blog_detail_hero_img">
        @endif

        @if ($blog->detail_description)
            <div class="blog_detail_body">{!! $blog->detail_description !!}</div>
        @endif

        @if ($blog->conclusion)
            <div class="blog_detail_body">{!! $blog->conclusion !!}</div>
        @endif

        @if (!empty($blog->faqs))
            <section class="blog_detail_body mt-5" aria-labelledby="blogFaqTitle">
                <h2 class="blog_detail_heading" id="blogFaqTitle">Frequently Asked Questions</h2>
                @foreach ($blog->faqs as $faq)
                    <h3 class="h5 mt-4">{{ $faq['faq_title'] ?? '' }}</h3>
                    <div class="sub_text_p16">{!! $faq['faq_description'] ?? '' !!}</div>
                @endforeach
            </section>
        @endif
    </article>
</section>
@endsection
