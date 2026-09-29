@extends('admin.layouts.master')

@section('content')
<style>
.required-star { color: red; }
</style>

<div class="body d-flex py-lg-3 py-md-2">
    <div class="container-xxl">

        <div class="row align-items-center">
            <div class="border-0 mb-4">
                <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h3 class="fw-bold mb-0">Add Locator</h3>
                    <a href="{{ route('locators.index') }}" class="btn btn-primary btn-set-task">Back</a>
                </div>
            </div>
        </div>

        <div class="row clearfix g-3">
            <div class="col-sm-12">
                <div class="card mb-3">
                    <div class="card-body">

                        <form id="locatorForm" novalidate action="{{ route('locators.store') }}" method="POST">
                            @csrf

                            <div class="card mb-4 border">
                                <div class="card-header bg-light"><strong>Locator Information</strong></div>
                                <div class="card-body row">

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">City <span class="required-star">*</span></label>
                                        <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                                            value="{{ old('city') }}" placeholder="Enter City">
                                        @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Phone Number <span class="required-star">*</span></label>
                                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone') }}" placeholder="Enter Phone Number">
                                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email <span class="required-star">*</span></label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}" placeholder="Enter Email">
                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Status <span class="required-star">*</span></label>
                                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                                            <option value="Active" {{ old('status', 'Active') == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="In-Active" {{ old('status', 'Active') == 'In-Active' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Address <span class="required-star">*</span></label>
                                        <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror"
                                            placeholder="Enter Address">{{ old('address') }}</textarea>
                                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary">Save Locator</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('admin-assets/js/locators/locators.js') }}"></script>
<script>
    $('#locatorForm').validate({
        ignore: ':disabled',
        highlight: function (el) { $(el).addClass('is-invalid'); },
        unhighlight: function (el) { $(el).removeClass('is-invalid'); },
        rules: {
            city: { required: true, maxlength: 255 },
            address: { required: true, maxlength: 500 },
            phone: { required: true, phoneNumber: true },
            email: { required: true, email: true, maxlength: 255 },
            status: { required: true }
        },
        messages: {
            city: { required: 'Please enter the city.', maxlength: 'The city may not be greater than 255 characters.' },
            address: { required: 'Please enter the address.', maxlength: 'The address may not be greater than 500 characters.' },
            phone: { required: 'Please enter the phone number.' },
            email: { required: 'Please enter the email.', email: 'Please enter a valid email address.' },
            status: { required: 'Please select the status.' }
        }
    });
</script>
@endpush
@endsection
