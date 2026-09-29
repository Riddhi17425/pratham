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
                    <h3 class="fw-bold mb-0">Add Banner</h3>
                    <a href="{{ route('banners.index') }}" class="btn btn-primary btn-set-task">Back</a>
                </div>
            </div>
        </div>

        <div class="row clearfix g-3">
            <div class="col-sm-12">
                <div class="card mb-3">
                    <div class="card-body">

                        <form id="bannerForm" novalidate action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="card mb-4 border">
                                <div class="card-header bg-light"><strong>Banner Information</strong></div>
                                <div class="card-body row">

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Title <span class="required-star">*</span></label>
                                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title') }}" placeholder="Enter Title">
                                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Description <span class="required-star">*</span></label>
                                        <textarea name="description" id="banner_description"
                                            class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                        @error('description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Image <span class="required-star">*</span></label>
                                        <input type="file" name="image" id="banner_image"
                                            class="form-control @error('image') is-invalid @enderror">
                                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <img id="preview_banner_image" src="#" alt="Preview" class="mt-2" style="max-width:200px;display:none;">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Alt Text <span class="required-star">*</span></label>
                                        <input type="text" name="image_alt" class="form-control @error('image_alt') is-invalid @enderror"
                                            value="{{ old('image_alt') }}" placeholder="Enter Alt Text">
                                        @error('image_alt')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                                <button type="submit" class="btn btn-primary">Save Banner</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="{{ asset('admin-assets/js/banners/banners.js') }}"></script>
<script>
    var imageRules = { fileExt: 'jpg|jpeg|png|webp', maxFileSize: 2048 };
    var imageMessages = {
        fileExt: 'Only JPG, PNG or WEBP images are allowed.',
        maxFileSize: 'The image may not be greater than 2 MB.'
    };

    $('#bannerForm').validate({
        ignore: ':disabled',
        highlight: function (el) { $(el).addClass('is-invalid'); },
        unhighlight: function (el) { $(el).removeClass('is-invalid'); },
        errorPlacement: function (error, element) {
            if (element.attr('name') === 'description') {
                error.insertAfter(element.next('.note-editor'));
            } else {
                error.insertAfter(element);
            }
        },
        rules: {
            title: { required: true, maxlength: 255 },
            description: { required: true },
            image: $.extend({ required: true }, imageRules),
            image_alt: { required: true, maxlength: 255 },
            status: { required: true }
        },
        messages: {
            title: { required: 'Please enter the title.', maxlength: 'The title may not be greater than 255 characters.' },
            description: { required: 'Please enter the description.' },
            image: $.extend({ required: 'Please select the image.' }, imageMessages),
            image_alt: { required: 'Please enter the alt text.', maxlength: 'The alt text may not be greater than 255 characters.' },
            status: { required: 'Please select the status.' }
        }
    });
</script>
@endpush
@endsection
