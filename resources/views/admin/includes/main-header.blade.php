<nav class="navbar bg-white shadow-sm px-3 px-lg-4 py-3">
    <button class="btn btn-outline-secondary d-lg-none" type="button" onclick="document.body.classList.toggle('sidebar-open')">
        <i class="bi bi-list"></i>
    </button>
    <div class="fw-semibold d-none d-lg-block">@yield('title', 'Dashboard')</div>

    <div class="dropdown ms-auto">
        <a class="d-flex align-items-center text-decoration-none text-dark dropdown-toggle" href="#" data-bs-toggle="dropdown">
            <div class="text-end me-2">
                <div class="fw-semibold lh-sm">{{ auth()->user()->name }}</div>
                <small class="text-muted">{{ auth()->user()->roleLabel() }}</small>
            </div>
            <i class="bi bi-person-circle fs-2"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
            <li class="px-3 py-1 small text-muted">{{ auth()->user()->email }}</li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>My Profile</a></li>
            <li>
                <form action="{{ route('logout') }}" method="POST">@csrf
                    <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Sign out</button>
                </form>
            </li>
        </ul>
    </div>
</nav>
