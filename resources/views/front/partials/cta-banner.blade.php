{{--
    Call-to-action panel shown above the footer.
    title, text - copy
    actions     - [['label' => 'Talk to Our Experts', 'url' => route('contact'), 'style' => 'outline' | 'solid']]
    eyebrow     - optional small label above the title
--}}
<section class="product_cta_section">
    <div class="container">
        <div class="product_cta_banner" style="--cta-img: url('{{ asset('front/img/figma/products/product-cta-bg.jpg') }}');">
            <div class="product_cta_copy">
                <span class="eyebrow eyebrow_light">{{ $eyebrow ?? 'Talk to our team' }}</span>
                <h2 class="product_cta_title">{{ $title }}</h2>
                <p class="product_cta_text">{{ $text }}</p>
            </div>
            <div class="product_cta_actions">
                @foreach ($actions as $action)
                    <a href="{{ $action['url'] }}" class="{{ ($action['style'] ?? 'solid') === 'outline' ? 'product_cta_btn_outline' : 'product_cta_btn_solid' }}">{{ $action['label'] }}</a>
                @endforeach
            </div>
        </div>
    </div>
</section>
