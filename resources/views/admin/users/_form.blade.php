@php $isEdit = $user->exists; @endphp
@csrf
@if ($isEdit) @method('PUT') @endif

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Name</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror">
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror">
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Role</label>
        <select name="role" class="form-select @error('role') is-invalid @enderror" @disabled($isEdit && $user->id === auth()->id())>
            <option value="2" @selected(old('role', $user->role) == 2)>Admin</option>
            <option value="1" @selected(old('role', $user->role) == 1)>Super Admin</option>
        </select>
        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 d-flex align-items-end">
        <div class="form-check form-switch">
            <input type="hidden" name="status" value="0">
            <input class="form-check-input" type="checkbox" name="status" value="1" id="status"
                   @checked(old('status', $user->status)) @disabled($isEdit && $user->id === auth()->id())>
            <label class="form-check-label" for="status">Active</label>
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label">Password {{ $isEdit ? '(leave blank to keep current)' : '' }}</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control">
    </div>
</div>

<div class="mt-4 d-flex gap-2">
    <button class="btn btn-primary px-4">Save</button>
    <a href="{{ route('users.index') }}" class="btn btn-light">Cancel</a>
</div>

@push('scripts')
<script>
    $('#userForm').validate({
        rules: {
            name: { required: true, maxlength: 255 },
            email: { required: true, email: true, maxlength: 255 },
            role: { required: true },
            password: { @if (! $isEdit) required: true, @endif minlength: 8 },
            password_confirmation: {
                required: function () { return $('[name="password"]').val().length > 0; },
                equalTo: '[name="password"]'
            }
        },
        messages: {
            name: { required: 'Please enter the name.', maxlength: 'The name may not be greater than 255 characters.' },
            email: { required: 'Please enter the email address.', email: 'Please enter a valid email address.', maxlength: 'The email may not be greater than 255 characters.' },
            role: { required: 'Please select a role.' },
            password: { required: 'Please enter a password.', minlength: 'The password must be at least 8 characters.' },
            password_confirmation: { required: 'Please confirm the password.', equalTo: 'The password confirmation does not match.' }
        }
    });
</script>
@endpush
