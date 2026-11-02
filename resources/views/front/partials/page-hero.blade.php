{{--
    Inner page banner.
    title    - page heading (h1)
    crumbs   - [['label' => 'Products', 'url' => route('products')], ['label' => 'Current page']]
    subtitle - optional one-line intro under the heading
    image    - optional background image URL (defaults to the water ripple photo)
    compact  - breadcrumb bar only, for pages that render their own h1
    banner   - true when `image` is a light wide banner: the text sits straight on it with only a soft fade
--}}
@php
    $heroImage = $image ?? asset('front/img/figma/about/page-hero-bg.jpg');
    $heroCrumbs = $crumbs ?? [];
    $heroCompact = $compact ?? false;
    $heroBanner = $banner ?? false;
@endphp
<section class="page_hero{{ $heroCompact ? ' page_hero_compact' : '' }}{{ $heroBanner ? ' page_hero_banner' : '' }}" style="--page-hero-img: url('{{ $heroImage }}');">
    <div class="container page_hero_inner">
        <nav class="breadcrumb_row" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            @foreach ($heroCrumbs as $crumb)
                <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                @if (!empty($crumb['url']) && !$loop->last)
                    <a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a>
                @else
                    <span aria-current="page">{{ $crumb['label'] }}</span>
                @endif
            @endforeach
        </nav>
        @unless ($heroCompact)
            <h1 class="page_hero_title">{{ $title }}</h1>
            @if (!empty($subtitle))
                <p class="page_hero_text">{{ $subtitle }}</p>
            @endif
        @endunless
    </div>
</section>
