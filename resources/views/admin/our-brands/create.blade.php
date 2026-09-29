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
                    <h3 class="fw-bold mb-0">Add Brand</h3>
                    <a href="{{ route('our-brands.index') }}" class="btn btn-primary btn-set-task">Back</a>
                </div>
            </div>
        </div>

        <div class="row clearfix g-3">
            <div class="col-sm-12">
                <div class="card mb-3">
                    <div class="card-body">

                        <form id="brandForm" novalidate action="{{ route('our-brands.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="card mb-4 border">
                                <div class="card-header bg-light"><strong>Brand Information</strong></div>
                                <div class="card-body row">

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Icon <span class="required-star">*</span></label>
                                        <input type="file" name="icon" id="brand_icon"
                                            class="form-control @error('icon') is-invalid @enderror">
                                        @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <img id="preview_brand_icon" src="#" alt="Preview" class="mt-2" style="max-width:100px;display:none;">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Alt Text <span class="required-star">*</span></label>
                                        <input type="text" name="icon_alt" class="form-control @error('icon_alt') is-invalid @enderror"
                                            value="{{ old('icon_alt') }}" placeholder="Enter Alt Text">
                                        @error('icon_alt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Status <span class="required-star">*</span></label>
                                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                                            <option value="Active" {{ old('status', 'Active') == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="In-Active" {{ old('status', 'Active') == 'In-Active' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary">Save Brand</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('admin-assets/js/our-brands/our-brands.js') }}"></script>
<script>
    var imageRules = { fileExt: 'jpg|jpeg|png|webp', maxFileSize: 2048 };
    var imageMessages = {
        fileExt: 'Only JPG, PNG or WEBP images are allowed.',
        maxFileSize: 'The image may not be greater than 2 MB.'
    };

    $('#brandForm').validate({
        ignore: ':disabled',
        highlight: function (el) { $(el).addClass('is-invalid'); },
        unhighlight: function (el) { $(el).removeClass('is-invalid'); },
        rules: {
            icon: $.extend({ required: true }, imageRules),
            icon_alt: { required: true, maxlength: 255 },
            status: { required: true }
        },
        messages: {
            icon: $.extend({ required: 'Please select the icon.' }, imageMessages),
            icon_alt: { required: 'Please enter the alt text.', maxlength: 'The alt text may not be greater than 255 characters.' },
            status: { required: 'Please select the status.' }
        }
    });
</script>
@endpush
@endsection