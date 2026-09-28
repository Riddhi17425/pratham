<div class="sidebar">
    <a href="{{ route('dashboard') }}" class="brand"><i class="bi bi-grid-fill me-2"></i>Pratham</a>
    <div class="py-2">
        <a class="m-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="bi bi-house-door"></i> <span>Dashboard</span>
        </a>
         <a class="m-link {{ request()->routeIs('blogs') || request()->routeIs('blogs.*') ? 'active' : '' }}"
            href="{{ route('blogs') }}">
            <i class="bi bi-journal-text"></i> <span>Blogs</span>
        </a>
        {{-- ===== MODULES YAHAN ADD HONGE ===== --}}

        @if (auth()->user()->isSuperAdmin())
            <div class="menu-title">Management</div>
            <a class="m-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                <i class="bi bi-people"></i> <span>Admin Users</span>
            </a>
        @endif

        

        <div class="menu-title">Account</div>
        <a class="m-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
            <i class="bi bi-person-circle"></i> <span>My Profile</span>
        </a>
    </div>
</div>
