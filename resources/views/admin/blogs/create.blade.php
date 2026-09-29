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
                    <h3 class="fw-bold mb-0">Add Blogs</h3>
                    <a href="{{ route('blogs.index') }}" class="btn btn-primary btn-set-task">Back</a>
                </div>
            </div>
        </div>

        <div class="row clearfix g-3">
            <div class="col-sm-12">
                <div class="card mb-3">
                    <div class="card-body">

                        <form id="blogForm" novalidate action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            

                            <div class="card mb-4 border">
                                <div class="card-header bg-light"><strong>Blogs Information</strong></div>
                                <div class="card-body row">

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Title <span class="required-star">*</span></label>
                                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title') }}" placeholder="Enter Title">
                                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Url <span class="required-star">*</span></label>
                                        <input type="text" name="url" class="form-control @error('url') is-invalid @enderror"
                                            value="{{ old('url') }}" placeholder="Enter Url">
                                        @error('url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Front Image <span class="required-star">*</span></label>
                                        <input type="file" name="front_image" id="blogs_front_image"
                                            class="form-control @error('front_image') is-invalid @enderror">
                                        @error('front_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <img id="preview_blogs_front_image" src="#" alt="Preview" class="mt-2" style="max-width:100px;display:none;">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Front Image Alt <span class="required-star">*</span></label>
                                        <input type="text" name="front_image_alt" class="form-control @error('front_image_alt') is-invalid @enderror"
                                            value="{{ old('front_image_alt') }}" placeholder="Enter Front Image Alt">
                                        @error('front_image_alt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Detail Image <span class="required-star">*</span></label>
                                        <input type="file" name="detail_image" id="blogs_detail_image"
                                            class="form-control @error('detail_image') is-invalid @enderror">
                                        @error('detail_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <img id="preview_blogs_detail_image" src="#" alt="Preview" class="mt-2" style="max-width:100px;display:none;">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Detail Image Alt <span class="required-star">*</span></label>
                                        <input type="text" name="detail_image_alt" class="form-control @error('detail_image_alt') is-invalid @enderror"
                                            value="{{ old('detail_image_alt') }}" placeholder="Enter Detail Image Alt">
                                        @error('detail_image_alt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">CTA Image</label>
                                        <input type="file" name="cta_image" id="cta_image"
                                            class="form-control @error('cta_image') is-invalid @enderror">
                                        @error('cta_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <img id="preview_cta_image" src="#" alt="Preview" class="mt-2" style="max-width:100px;display:none;">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">CTA Image Alt</label>
                                        <input type="text" name="cta_image_alt" class="form-control @error('cta_image_alt') is-invalid @enderror"
                                            value="{{ old('cta_image_alt') }}" placeholder="Enter CTA Image Alt">
                                        @error('cta_image_alt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">CTA Link URL</label>
                                        <input type="text" name="cta_link_url" class="form-control @error('cta_link_url') is-invalid @enderror"
                                            value="{{ old('cta_link_url') }}" placeholder="Enter CTA Link URL">
                                        @error('cta_link_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Date</label>
                                        <input type="date" name="date" value="{{ old('date') }}" class="form-control @error('date') is-invalid @enderror">
                                        @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Meta Title</label>
                                        <input type="text" name="meta_title" class="form-control @error('meta_title') is-invalid @enderror"
                                            value="{{ old('meta_title') }}" placeholder="Enter Meta Title">
                                        @error('meta_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
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

                            <div class="card mb-4 border">
                                <div class="card-header bg-light"><strong>Meta Description</strong></div>
                                <div class="card-body">
                                    <textarea name="meta_description" id="meta_description" class="js-editor" placeholder="Enter meta description">{{ old('meta_description') }}</textarea>
                                    @error('meta_description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="card mb-4 border">
                                <div class="card-header bg-light"><strong>Short Description <span class="required-star">*</span></strong></div>
                                <div class="card-body">
                                    <textarea name="short_description" id="short_description" class="js-editor @error('short_description') is-invalid @enderror" placeholder="Enter short description">{{ old('short_description') }}</textarea>
                                    @error('short_description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="card mb-4 border">
                                <div class="card-header bg-light"><strong>Detail Description</strong></div>
                                <div class="card-body">
                                    <textarea name="detail_description" id="detail_description" class="js-editor" placeholder="Enter detail description">{{ old('detail_description') }}</textarea>
                                    @error('detail_description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="card mb-4 border">
                                <div class="card-header bg-light"><strong>Conclusion</strong></div>
                                <div class="card-body">
                                    <textarea name="conclusion" id="conclusion" class="js-editor" placeholder="Enter conclusion">{{ old('conclusion') }}</textarea>
                                    @error('conclusion')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="card mb-4 border">
                                <div class="card-header bg-light"><strong>Schema JSON</strong></div>
                                <div class="card-body">
                                    {{-- Plain textarea on purpose: a rich text editor would wrap the JSON in <p> tags and break it --}}
                                    <textarea name="schema_json" id="schema_json" class="form-control font-monospace" rows="6" placeholder='{"@@context": "https://schema.org", ...}'>{{ old('schema_json') }}</textarea>
                                    @error('schema_json')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            {{-- ===== FAQs: each row = FAQ Title + FAQ Description (editor) ===== --}}
                            @php
                                $rows = [];
                                if (old('faq_title') !== null) {
                                    foreach ((array) old('faq_title') as $i => $t) {
                                        $rows[] = ['faq_title' => $t, 'faq_description' => old('faq_description.' . $i)];
                                    }
                                } else {
                                    $rows = [];
                                }
                                if (empty($rows)) {
                                    $rows = [['faq_title' => '', 'faq_description' => '']];
                                }
                            @endphp

                            <div class="card mb-4 border">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <strong>FAQs</strong>
                                    <button type="button" class="btn btn-primary btn-sm" id="addFaq">Add More</button>
                                </div>
                                <div class="card-body">
                                    @error('faq_title') <div class="alert alert-danger py-2">{{ $message }}</div> @enderror

                                    <div id="faq-wrapper">
                                        @foreach ($rows as $faq)
                            <div class="faq-item border p-3 mb-3">
                                <div class="mb-3">
                                    <label class="form-label">FAQ Title</label>
                                    <input type="text" name="faq_title[]" class="form-control" value="{{ $faq['faq_title'] ?? '' }}" placeholder="Enter FAQ Title">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">FAQ Description</label>
                                    <textarea name="faq_description[]" class="js-editor faq_description" placeholder="Enter FAQ Description">{{ $faq['faq_description'] ?? '' }}</textarea>
                                </div>
                                <button type="button" class="btn btn-danger removeFaq">Remove</button>
                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- Blank row used by the "Add More" button --}}
                            <template id="faq-template">
                            <div class="faq-item border p-3 mb-3">
                                <div class="mb-3">
                                    <label class="form-label">FAQ Title</label>
                                    <input type="text" name="faq_title[]" class="form-control" value="" placeholder="Enter FAQ Title">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">FAQ Description</label>
                                    <textarea name="faq_description[]" class="js-editor faq_description" placeholder="Enter FAQ Description"></textarea>
                                </div>
                                <button type="button" class="btn btn-danger removeFaq">Remove</button>
                            </div>
                            </template>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary">Save Blogs</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
<script src="{{ asset('admin-assets/js/blogs/blogs.js') }}"></script>
<script>
    // ----- Rich text editors: every textarea with class .js-editor (incl. FAQ descriptions) -----
    $('.js-editor').summernote(window.blogEditorOptions);

    // Red border on the editor box when its field is invalid
    function markEditor(el, invalid) {
        if ($(el).hasClass('js-editor')) {
            $(el).next('.note-editor').css('border-color', invalid ? '#dc3545' : '');
        }
    }

    // ----- Client-side validation (mirror of BlogsController::rules) -----
    var imageRules = { fileExt: 'jpg|jpeg|png|webp', maxFileSize: 2048 };
    var imageMessages = {
        fileExt: 'Only JPG, PNG or WEBP images are allowed.',
        maxFileSize: 'The image may not be greater than 2 MB.'
    };

    $('#blogForm').validate({
        ignore: ':disabled',
        highlight: function (el) { $(el).addClass('is-invalid'); markEditor(el, true); },
        unhighlight: function (el) { $(el).removeClass('is-invalid'); markEditor(el, false); },
        rules: {
            title: { required: true, maxlength: 255 },
            url: { required: true, maxlength: 255 },
            front_image: $.extend({ required: true }, imageRules),
            front_image_alt: { required: true, maxlength: 255 },
            detail_image: $.extend({ required: true }, imageRules),
            detail_image_alt: { required: true, maxlength: 255 },
            cta_image: imageRules,
            cta_image_alt: { maxlength: 255 },
            cta_link_url: { maxlength: 255 },
            meta_title: { maxlength: 255 },
            status: { required: true },
            short_description: { editorRequired: true }
        },
        messages: {
            title: { required: 'Please enter the blog title.', maxlength: 'The title may not be greater than 255 characters.' },
            url: { required: 'Please enter the URL.', maxlength: 'The URL may not be greater than 255 characters.' },
            front_image: $.extend({ required: 'Please select the front image.' }, imageMessages),
            front_image_alt: { required: 'Please enter the front image alt text.', maxlength: 'The alt text may not be greater than 255 characters.' },
            detail_image: $.extend({ required: 'Please select the detail image.' }, imageMessages),
            detail_image_alt: { required: 'Please enter the detail image alt text.', maxlength: 'The alt text may not be greater than 255 characters.' },
            cta_image: imageMessages,
            cta_image_alt: { maxlength: 'The alt text may not be greater than 255 characters.' },
            cta_link_url: { maxlength: 'The CTA link may not be greater than 255 characters.' },
            meta_title: { maxlength: 'The meta title may not be greater than 255 characters.' },
            status: { required: 'Please select the status.' },
            short_description: { editorRequired: 'Please enter the short description.' }
        }
    });
</script>
@endpush
@endsection
