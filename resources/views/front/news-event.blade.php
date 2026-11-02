@extends('front.app')

@section('title', 'News & Events | Pratham Filter Industries')

@section('content')
@include('front.partials.page-hero', [
    'title' => 'News & Events',
    'crumbs' => [['label' => 'News & Events']],
    'subtitle' => 'Meet our team at upcoming exhibitions and industry events.',
])

<section class="section_padding">
    <div class="container">
        <div class="products_header">
            <div class="products_header_title">
                <p class="products_eyebrow">Pratham Filter Industries</p>
                <h2 class="title">Upcoming / Current Exhibitions</h2>
            </div>
            @if ($events->isNotEmpty())
            <div class="products_search">
                <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                <input type="search" placeholder="Search events..." id="eventSearch" aria-label="Search events">
            </div>
            @endif
        </div>

        @if ($events->isNotEmpty())
        <div class="event_grid" id="eventGridList">
            @foreach ($events as $event)
            <article class="event_card" data-search="{{ \Illuminate\Support\Str::lower($event->title . ' ' . $event->location . ' ' . strip_tags($event->description ?? '')) }}">
                <div class="event_card_img_wrap">
                    @if ($event->image)
                    <img src="{{ asset('admin-assets/events/image/' . $event->image) }}" alt="{{ $event->image_alt ?: $event->title }}" loading="lazy">
                    @else
                    <span class="event_card_placeholder"><i class="fa-regular fa-calendar" aria-hidden="true"></i></span>
                    @endif
                </div>
                <div class="event_card_body">
                    <h3 class="event_card_title">{{ $event->title }}</h3>
                    @if ($event->description)
                    <p class="event_card_desc">{{ $event->description }}</p>
                    @endif
                    <ul class="event_card_meta">
                        @if ($event->location)
                        <li><i class="fa-solid fa-location-dot" aria-hidden="true"></i><span>{{ $event->location }}</span></li>
                        @endif
                        @if ($event->date_range)
                        <li><i class="fa-regular fa-calendar" aria-hidden="true"></i><span>{{ $event->date_range }}</span></li>
                        @endif
                    </ul>
                </div>
            </article>
            @endforeach
        </div>
        <p class="product_no_results" id="eventNoResults" style="display:none;">No events match your search.</p>
        <nav class="event_pagination" id="eventPagination" aria-label="Event pages"></nav>
        @else
        <div class="empty_state">
            <i class="fa-regular fa-calendar" aria-hidden="true"></i>
            <h3>No upcoming events right now</h3>
            <p>Check back soon, or get in touch to meet our team.</p>
        </div>
        @endif
    </div>
</section>

@include('front.partials.cta-banner', [
    'title' => 'Meet Us At The Next Show',
    'text' => "Want to schedule a meeting with our team at an upcoming exhibition? Get in touch and we'll set it up.",
    'actions' => [['label' => 'Talk to Our Experts', 'url' => route('contact'), 'style' => 'solid']],
])

@push('scripts')
<script src="{{ asset('front/js/events.js') }}?v={{ filemtime(public_path('front/js/events.js')) }}"></script>
@endpush

@endsection
