@extends('front.app')

@section('title', 'Blog | Pratham Filter Industries')

@section('content')
@include('front.partials.page-hero', [
    'title' => 'Latest Articles',
    'crumbs' => [['label' => 'Blog']],
    'subtitle' => 'Insights and guides on industrial and water filtration.',
])

<section class="section_padding">
    <div class="container">
        @if ($blogs->isNotEmpty())
            @php($featuredBlog = $blogs->first())

            @if ($featuredBlog->front_image)
                <a href="{{ route('blog.details', ['post' => $featuredBlog->url]) }}" class="blog_featured_card">
                    <div class="blog_featured_media">
                        <img src="{{ asset('admin-assets/blogs/front_image/' . $featuredBlog->front_image) }}" alt="{{ $featuredBlog->front_image_alt ?: $featuredBlog->title }}">
                    </div>
                    <div class="blog_featured_content">
                        <span class="blog_featured_tag">Featured</span>
                        <p class="articles_date">{{ $featuredBlog->date ? $featuredBlog->date->format('F j, Y') : $featuredBlog->created_at?->format('F j, Y') }}</p>
                        <h2 class="blog_featured_title">{{ $featuredBlog->title }}</h2>
                        <p class="blog_featured_excerpt">{{ strip_tags($featuredBlog->short_description ?? '') }}</p>
                        <span class="article_card_link">Read article <svg class="btn_arrow" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                    </div>
                </a>
            @endif

            <div class="article_grid">
                @foreach ($blogs->skip($featuredBlog->front_image ? 1 : 0) as $blog)
                    <a href="{{ route('blog.details', ['post' => $blog->url]) }}" class="article_card">
                        <div class="article_card_media">
                            @if ($blog->front_image)
                                <img src="{{ asset('admin-assets/blogs/front_image/' . $blog->front_image) }}"
                                     alt="{{ $blog->front_image_alt ?: $blog->title }}" loading="lazy">
                            @else
                                <span class="article_card_placeholder"><i class="fa-solid fa-droplet" aria-hidden="true"></i></span>
                            @endif
                        </div>
                        <div class="article_card_body">
                            <p class="articles_date">
                                {{ $blog->date ? $blog->date->format('F j, Y') : $blog->created_at?->format('F j, Y') }}
                            </p>
                            <h3 class="articles_title">{{ $blog->title }}</h3>
                            <span class="article_card_link">Read article <svg class="btn_arrow" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty_state">
                <i class="fa-regular fa-newspaper" aria-hidden="true"></i>
                <h3>No articles are available yet.</h3>
                <p>Please check back soon.</p>
            </div>
        @endif
    </div>
</section>
@endsection
