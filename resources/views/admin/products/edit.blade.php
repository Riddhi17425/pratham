@extends('admin.layouts.master')

@section('content')
    <style>
        .required-star {
            color: red;
        }
    </style>

    <div class="body d-flex py-lg-3 py-md-2">
        <div class="container-xxl">

            <div class="row align-items-center">
                <div class="border-0 mb-4">
                    <div
                        class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                        <h3 class="fw-bold mb-0">Edit Product</h3>
                        <a href="{{ route('products.index') }}" class="btn btn-primary btn-set-task">Back</a>
                    </div>
                </div>
            </div>

            <div class="row clearfix g-3">
                <div class="col-sm-12">
                    <div class="card mb-3">
                        <div class="card-body">

                            <form id="productForm" novalidate action="{{ route('products.update', $product->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="card mb-4 border">
                                    <div class="card-header bg-light"><strong>Product Information</strong></div>
                                    <div class="card-body row">

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Category <span class="required-star">*</span></label>
                                            <select name="category_id"
                                                class="form-control @error('category_id') is-invalid @enderror">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->title }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Status <span class="required-star">*</span></label>
                                            <select name="status"
                                                class="form-control @error('status') is-invalid @enderror">
                                                <option value="Active"
                                                    {{ old('status', $product->status) == 'Active' ? 'selected' : '' }}>
                                                    Active</option>
                                                <option value="In-Active"
                                                    {{ old('status', $product->status) == 'In-Active' ? 'selected' : '' }}>
                                                    Inactive</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Product Title <span
                                                    class="required-star">*</span></label>
                                            <input type="text" name="title"
                                                class="form-control @error('title') is-invalid @enderror"
                                                value="{{ old('title', $product->title) }}"
                                                placeholder="Enter Product Title">
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Product Name <span
                                                    class="required-star">*</span></label>
                                            <input type="text" name="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name', $product->name) }}" placeholder="Enter Product Name">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Product URL</label>
                                            <input type="text" name="product_url"
                                                class="form-control @error('product_url') is-invalid @enderror"
                                                value="{{ old('product_url', $product->product_url) }}"
                                                placeholder="Auto-generated from title (you can edit)">
                                            @error('product_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Image</label>
                                            <input type="file" name="image" id="product_image"
                                                class="form-control @error('image') is-invalid @enderror">
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @if ($product->image)
                                                <img id="preview_product_image"
                                                    src="{{ asset('admin-assets/products/image/' . $product->image) }}"
                                                    alt="Preview" class="mt-2" style="max-width:150px;">
                                            @else
                                                <img id="preview_product_image" src="#" alt="Preview" class="mt-2"
                                                    style="max-width:150px;display:none;">
                                            @endif
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Alt Text <span class="required-star">*</span></label>
                                            <input type="text" name="image_alt"
                                                class="form-control @error('image_alt') is-invalid @enderror"
                                                value="{{ old('image_alt', $product->image_alt) }}"
                                                placeholder="Enter Alt Text">
                                            @error('image_alt')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Description <span
                                                    class="required-star">*</span></label>
                                            <textarea name="description" id="product_description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                                            @error('description')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Catalogue PDF</label>
                                            <input type="file" name="catalogue" id="product_catalogue"
                                                accept="application/pdf"
                                                class="form-control @error('catalogue') is-invalid @enderror">
                                            <small class="text-muted">max 2 GB.</small>
                                            @error('catalogue')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                            {{-- hidden flag: 1 => purani PDF delete karni hai --}}
                                            <input type="hidden" name="remove_catalogue" id="remove_catalogue"
                                                value="0">

                                            {{-- naya select kiya hua PDF (cross ke saath) --}}
                                            <div id="catalogue_new_box" class="d-none mt-2 align-items-center">
                                                <i class="bi bi-file-earmark-pdf me-1"></i>
                                                <span id="catalogue_new_name" class="me-2"></span>
                                                <button type="button" id="remove_new_catalogue" class="btn-close"
                                                    aria-label="Remove"></button>
                                            </div>

                                            {{-- purani saved PDF (cross ke saath) --}}
                                            @if ($product->catalogue)
                                                <div id="catalogue_current_box" class="d-flex align-items-center mt-2">
                                                    <a href="{{ asset('admin-assets/products/catalogue/' . $product->catalogue) }}"
                                                        target="_blank" class="me-2">
                                                        <i class="bi bi-file-earmark-pdf"></i> View current catalogue
                                                    </a>
                                                    <button type="button" id="remove_current_catalogue"
                                                        class="btn-close" aria-label="Remove"></button>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Technical Details</label>
                                            <textarea name="technical_details" id="product_technical_details"
                                                class="form-control @error('technical_details') is-invalid @enderror">{{ old('technical_details', $product->technical_details) }}</textarea>
                                            @error('technical_details')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>

                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-primary">Update Product</button>
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
        <script src="{{ asset('admin-assets/js/products/products.js') }}"></script>
        <script>
            var imageRules = {
                fileExt: 'jpg|jpeg|png|webp',
                maxFileSize: 2048
            };
            var imageMessages = {
                fileExt: 'Only JPG, PNG or WEBP images are allowed.',
                maxFileSize: 'The image may not be greater than 2 MB.'
            };
            var pdfRules = {
                fileExt: 'pdf',
                maxFileSize: 2097152
            };
            var pdfMessages = {
                fileExt: 'Only PDF files are allowed.',
                maxFileSize: 'The catalogue may not be greater than 2 GB.'
            };

            $('#productForm').validate({
                ignore: ':disabled',
                highlight: function(el) {
                    $(el).addClass('is-invalid');
                },
                unhighlight: function(el) {
                    $(el).removeClass('is-invalid');
                },
                errorPlacement: function(error, element) {
                    if (element.attr('name') === 'description') {
                        error.insertAfter(element.siblings('.note-editor'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                rules: {
                    category_id: {
                        required: true
                    },
                    title: {
                        required: true,
                        maxlength: 255
                    },
                    name: {
                        required: true,
                        maxlength: 255
                    },

                    image: imageRules,
                    image_alt: {
                        required: true,
                        maxlength: 255
                    },
                    description: {
                        required: true
                    },
                    catalogue: pdfRules,
                    status: {
                        required: true
                    }
                },
                messages: {
                    category_id: {
                        required: 'Please select the category.'
                    },
                    title: {
                        required: 'Please enter the product title.',
                        maxlength: 'The title may not be greater than 255 characters.'
                    },
                    name: {
                        required: 'Please enter the product name.',
                        maxlength: 'The name may not be greater than 255 characters.'
                    },

                    image: imageMessages,
                    image_alt: {
                        required: 'Please enter the alt text.',
                        maxlength: 'The alt text may not be greater than 255 characters.'
                    },
                    description: {
                        required: 'Please enter the description.'
                    },
                    catalogue: pdfMessages,
                    status: {
                        required: 'Please select the status.'
                    }
                }
            });
        </script>
    @endpush
@endsection
