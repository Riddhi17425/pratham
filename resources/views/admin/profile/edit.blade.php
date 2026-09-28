@extends('admin.layouts.master')
@section('title', 'My Profile')

@section('content')
<form id="profileForm" novalidate method="POST" action="{{ route('profile.update') }}" class="card border-0 shadow-sm" style="max-width: 40rem;">
    @csrf @method('PUT')
    <div class="card-body p-4">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-4">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <h6 class="border-top pt-3">Change Password <small class="text-muted">(optional)</small></h6>
        <div class="mb-3">
            <label class="form-label">Current Password</label>
            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
            @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">New Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
        </div>
        <button class="btn btn-primary px-4 mt-4">Update Profile</button>
    </div>
</form>
@endsection

@push('scripts')
<script>
    var hasNewPassword = function () { return $('[name="password"]').val().length > 0; };

    $('#profileForm').validate({
        rules: {
            name: { required: true, maxlength: 255 },
            email: { required: true, email: true, maxlength: 255 },
            current_password: { required: hasNewPassword },
            password: { minlength: 8 },
            password_confirmation: { required: hasNewPassword, equalTo: '[name="password"]' }
        },
        messages: {
            name: { required: 'Please enter your name.', maxlength: 'The name may not be greater than 255 characters.' },
            email: { required: 'Please enter your email address.', email: 'Please enter a valid email address.', maxlength: 'The email may not be greater than 255 characters.' },
            current_password: { required: 'Please enter your current password to set a new one.' },
            password: { minlength: 'The new password must be at least 8 characters.' },
            password_confirmation: { required: 'Please confirm the new password.', equalTo: 'The password confirmation does not match.' }
        }
    });
</script>
@endpush
