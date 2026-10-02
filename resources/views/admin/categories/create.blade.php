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
                    <h3 class="fw-bold mb-0">Add Category</h3>
                    <a href="{{ route('categories.index') }}" class="btn btn-primary btn-set-task">Back</a>
                </div>
            </div>
        </div>

        <div class="row clearfix g-3">
            <div class="col-sm-12">
                <div class="card mb-3">
                    <div class="card-body">

                        <form id="categoryForm" data-auto-slug="1" novalidate action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="card mb-4 border">
                                <div class="card-header bg-light"><strong>Category Information</strong></div>
                                <div class="card-body row">

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Title <span class="required-star">*</span></label>
                                        <input type="text" name="title" id="category_title" class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title') }}" placeholder="Enter Title">
                                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Category URL <span class="required-star">*</span></label>
                                        <input type="text" name="category_url" id="category_url" class="form-control @error('category_url') is-invalid @enderror"
                                            value="{{ old('category_url') }}" placeholder="e.g. web-design">
                                        @error('category_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Thumbnail Image <span class="required-star">*</span></label>
                                        <input type="file" name="thumbnail" id="category_thumbnail"
                                            class="form-control @error('thumbnail') is-invalid @enderror">
                                        @error('thumbnail')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <img id="preview_category_thumbnail" src="#" alt="Preview" class="mt-2" style="max-width:150px;display:none;">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Alt Text <span class="required-star">*</span></label>
                                        <input type="text" name="thumbnail_alt" class="form-control @error('thumbnail_alt') is-invalid @enderror"
                                            value="{{ old('thumbnail_alt') }}" placeholder="Enter Alt Text">
                                        @error('thumbnail_alt')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                                        <label class="form-label">Description</label>
                                        <textarea name="description" id="category_description"
                                            class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                        @error('description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                    </div>

                                </div>
                            </div>

                            <div class="card mb-4 border">
                                <div class="card-header bg-light"><strong>SEO</strong></div>
                                <div class="card-body row">

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Meta Title <span class="required-star">*</span></label>
                                        <input type="text" name="meta_title" class="form-control @error('meta_title') is-invalid @enderror"
                                            value="{{ old('meta_title') }}" placeholder="Enter Meta Title">
                                        @error('meta_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Meta Description <span class="required-star">*</span></label>
                                        <textarea name="meta_description" rows="3" class="form-control @error('meta_description') is-invalid @enderror"
                                            placeholder="Enter Meta Description">{{ old('meta_description') }}</textarea>
                                        @error('meta_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary">Save Category</button>
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
<script src="{{ asset('admin-assets/js/categories/categories.js') }}"></script>
<script>
    var imageRules = { fileExt: 'jpg|jpeg|png|webp', maxFileSize: 2048 };
    var imageMessages = {
        fileExt: 'Only JPG, PNG or WEBP images are allowed.',
        maxFileSize: 'The image may not be greater than 2 MB.'
    };

    $('#categoryForm').validate({
        ignore: ':disabled',
        highlight: function (el) { $(el).addClass('is-invalid'); },
        unhighlight: function (el) { $(el).removeClass('is-invalid'); },
        rules: {
            title: { required: true, maxlength: 255 },
            category_url: { required: true, maxlength: 255,},
            thumbnail: $.extend({ required: true }, imageRules),
            thumbnail_alt: { required: true, maxlength: 255 },
            meta_title: { required: true, maxlength: 255 },
            meta_description: { required: true, maxlength: 500 },
            status: { required: true }
        },
        messages: {
            title: { required: 'Please enter the title.', maxlength: 'The title may not be greater than 255 characters.' },
            category_url: { required: 'Please enter the category URL.' },
            thumbnail: $.extend({ required: 'Please select the thumbnail image.' }, imageMessages),
            thumbnail_alt: { required: 'Please enter the alt text.', maxlength: 'The alt text may not be greater than 255 characters.' },
            meta_title: { required: 'Please enter the meta title.', maxlength: 'The meta title may not be greater than 255 characters.' },
            meta_description: { required: 'Please enter the meta description.', maxlength: 'The meta description may not be greater than 500 characters.' },
            status: { required: 'Please select the status.' }
        }
    });
</script>
@endpush
@endsection
