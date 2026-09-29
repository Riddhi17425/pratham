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
                    <h3 class="fw-bold mb-0">Edit Setting</h3>
                    <a href="{{ route('settings.index') }}" class="btn btn-primary btn-set-task">Back</a>
                </div>
            </div>
        </div>

        <div class="row clearfix g-3">
            <div class="col-sm-12">
                <div class="card mb-3">
                    <div class="card-body">

                        <form id="settingForm" novalidate action="{{ route('settings.update', $setting->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="card mb-4 border">
                                <div class="card-header bg-light"><strong>Contact Information</strong></div>
                                <div class="card-body row">

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Address <span class="required-star">*</span></label>
                                        <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror"
                                            placeholder="Enter Address">{{ old('address', $setting->address) }}</textarea>
                                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Phone Number <span class="required-star">*</span></label>
                                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone', $setting->phone) }}" placeholder="Enter Phone Number">
                                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email <span class="required-star">*</span></label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $setting->email) }}" placeholder="Enter Email">
                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                </div>
                            </div>

                            <div class="card mb-4 border">
                                <div class="card-header bg-light"><strong>Social Links</strong></div>
                                <div class="card-body row">

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">LinkedIn URL</label>
                                        <input type="text" name="linkedin_url" class="form-control @error('linkedin_url') is-invalid @enderror"
                                            value="{{ old('linkedin_url', $setting->linkedin_url) }}" placeholder="https://linkedin.com/...">
                                        @error('linkedin_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Instagram URL</label>
                                        <input type="text" name="instagram_url" class="form-control @error('instagram_url') is-invalid @enderror"
                                            value="{{ old('instagram_url', $setting->instagram_url) }}" placeholder="https://instagram.com/...">
                                        @error('instagram_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Twitter URL</label>
                                        <input type="text" name="twitter_url" class="form-control @error('twitter_url') is-invalid @enderror"
                                            value="{{ old('twitter_url', $setting->twitter_url) }}" placeholder="https://twitter.com/...">
                                        @error('twitter_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">WhatsApp URL</label>
                                        <input type="text" name="whatsapp_url" class="form-control @error('whatsapp_url') is-invalid @enderror"
                                            value="{{ old('whatsapp_url', $setting->whatsapp_url) }}" placeholder="https://wa.me/91XXXXXXXXXX">
                                        @error('whatsapp_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Facebook URL</label>
                                        <input type="text" name="facebook_url" class="form-control @error('facebook_url') is-invalid @enderror"
                                            value="{{ old('facebook_url', $setting->facebook_url) }}" placeholder="https://facebook.com/...">
                                        @error('facebook_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Status <span class="required-star">*</span></label>
                                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                                            <option value="Active" {{ old('status', $setting->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="In-Active" {{ old('status', $setting->status) == 'In-Active' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary">Update Setting</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('admin-assets/js/settings/settings.js') }}"></script>
<script>
    var urlMsg = 'Please enter a valid URL (starting with http:// or https://).';

    $('#settingForm').validate({
        ignore: ':disabled',
        highlight: function (el) { $(el).addClass('is-invalid'); },
        unhighlight: function (el) { $(el).removeClass('is-invalid'); },
        rules: {
            address: { required: true, maxlength: 500 },
            phone: { required: true, phoneNumber: true },
            email: { required: true, email: true, maxlength: 255 },
            linkedin_url: { url: true, maxlength: 255 },
            instagram_url: { url: true, maxlength: 255 },
            twitter_url: { url: true, maxlength: 255 },
            whatsapp_url: { url: true, maxlength: 255 },
            facebook_url: { url: true, maxlength: 255 },
            status: { required: true }
        },
        messages: {
            address: { required: 'Please enter the address.', maxlength: 'The address may not be greater than 500 characters.' },
            phone: { required: 'Please enter the phone number.' },
            email: { required: 'Please enter the email.', email: 'Please enter a valid email address.' },
            linkedin_url: { url: urlMsg },
            instagram_url: { url: urlMsg },
            twitter_url: { url: urlMsg },
            whatsapp_url: { url: urlMsg },
            facebook_url: { url: urlMsg },
            status: { required: 'Please select the status.' }
        }
    });
</script>
@endpush
@endsection
