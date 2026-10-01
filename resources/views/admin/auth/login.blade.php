@include('admin.includes.headerUrl')
@include('admin.includes.toast')

<div class="login-page min-vh-100 d-flex align-items-center justify-content-center p-3">
    <form id="loginForm" novalidate method="POST" action="{{ route('login.store') }}" class="card login-card border-0 w-100" style="max-width: 27rem;">
        @csrf
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="stat-icon mx-auto" style="width:3.5rem;height:3.5rem;font-size:1.5rem"><i class="bi bi-droplet-half"></i></div>
                <h1 class="h3 mt-2 mb-0">Pratham Admin</h1>
                <small class="text-muted">Sign in to continue</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="name@example.com">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" required class="form-control form-control-lg">
            </div>
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>
            <button class="btn btn-primary btn-lg w-100">Sign in</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    $('#loginForm').validate({
        rules: {
            email: { required: true, email: true },
            password: { required: true }
        },
        messages: {
            email: { required: 'Please enter your email address.', email: 'Please enter a valid email address.' },
            password: { required: 'Please enter your password.' }
        }
    });
</script>
@endpush

@include('admin.includes.footer')
