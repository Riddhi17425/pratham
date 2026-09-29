<div class="sidebar">
    <a href="{{ route('dashboard') }}" class="brand"><i class="bi bi-grid-fill me-2"></i>Pratham</a>
    <div class="py-2">
        <a class="m-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="bi bi-house-door"></i> <span>Dashboard</span>
        </a>

        {{-- ===== ADD NEW MODULE LINKS BELOW ===== --}}
        <a class="m-link {{ request()->routeIs('banners.*') ? 'active' : '' }}" href="{{ route('banners.index') }}">
            <i class="bi bi-images"></i> <span>Banners</span>
        </a>

        <a class="m-link {{ request()->routeIs('blogs.*') ? 'active' : '' }}" href="{{ route('blogs.index') }}">
            <i class="bi bi-journal-text"></i> <span>Blogs</span>
        </a>
        <a class="m-link {{ request()->routeIs('events.*') ? 'active' : '' }}" href="{{ route('events.index') }}">
            <i class="bi bi-calendar-event"></i> <span>Events</span>
        </a>
        <a class="m-link {{ request()->routeIs('our-brands.*') ? 'active' : '' }}"
            href="{{ route('our-brands.index') }}">
            <i class="bi bi-award"></i> <span>Our Brand</span>
        </a>

        <a class="m-link {{ request()->routeIs('partners.*') ? 'active' : '' }}" href="{{ route('partners.index') }}">
            <i class="bi bi-people"></i> <span>Partners</span>
        </a>
        <a class="m-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.edit') }}">
            <i class="bi bi-gear"></i> <span>Settings</span>
        </a>
        <a class="m-link {{ request()->routeIs('locators.*') ? 'active' : '' }}" href="{{ route('locators.index') }}">
            <i class="bi bi-geo-alt"></i> <span>Locators</span>
        </a>
        <a class="m-link {{ request()->routeIs('categories.*') ? 'active' : '' }}"
            href="{{ route('categories.index') }}">
            <i class="bi bi-tags"></i> <span>Categories</span>
        </a>
        <a class="m-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
            <i class="bi bi-box-seam"></i> <span>Products</span>
        </a>
        <a class="m-link {{ request()->routeIs('technical-data-sheets.*') ? 'active' : '' }}"
            href="{{ route('technical-data-sheets.index') }}">
            <i class="bi bi-file-earmark-text"></i> <span>Technical Data Sheets</span>
        </a>
    </div>
</div>
