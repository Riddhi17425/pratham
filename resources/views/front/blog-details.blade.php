@extends('front.app')

@section('title', $metaTitle . ' | Pratham Filter Industries')
@section('meta_description', $metaDescription)

@section('content')
@include('front.partials.page-hero', [
    'title' => $blog->title,
    'crumbs' => [['label' => 'Blogs', 'url' => route('blog')], ['label' => $blog->title]],
    'image' => asset('front/img/figma/blog/blog-detail-hero-bg.jpg'),
])

<section class="section_padding">
    <article class="container blog_article">
        @if ($blog->date)
            <p class="blog_article_meta"><i class="fa-regular fa-calendar" aria-hidden="true"></i> {{ $blog->date->format('F j, Y') }}</p>
        @endif

        @if ($blog->short_description)
            <p class="blog_article_lead">{{ strip_tags($blog->short_description) }}</p>
        @endif

        @if ($blog->detail_image || $blog->front_image)
            <img src="{{ $blog->detail_image ? asset('admin-assets/blogs/detail_image/' . $blog->detail_image) : asset('admin-assets/blogs/front_image/' . $blog->front_image) }}"
                 alt="{{ $blog->detail_image_alt ?: ($blog->front_image_alt ?: $blog->title) }}"
                 class="blog_detail_hero_img">
        @endif

        @if ($blog->detail_description)
            <div class="rich_text blog_detail_body">{!! $blog->detail_description !!}</div>
        @endif

        @if ($blog->conclusion)
            <div class="rich_text blog_detail_body">{!! $blog->conclusion !!}</div>
        @endif

        @if (!empty($blog->faqs))
            <section class="blog_faq" aria-labelledby="blogFaqTitle">
                <h2 class="blog_detail_heading" id="blogFaqTitle">Frequently Asked Questions</h2>
                @foreach ($blog->faqs as $faq)
                    <details class="faq_item" @if ($loop->first) open @endif>
                        <summary>{{ $faq['faq_title'] ?? '' }}</summary>
                        <div class="rich_text">{!! $faq['faq_description'] ?? '' !!}</div>
                    </details>
                @endforeach
            </section>
        @endif

        <div class="blog_article_footer">
            <a href="{{ route('blog') }}" class="text_link"><svg class="btn_arrow btn_arrow_back" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M19 12H5m6-6-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Back to all articles</a>
        </div>
    </article>
</section>
@endsection
