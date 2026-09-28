@extends('admin.layouts.master')

@section('content')
<style>
.required-star { color: red; }
</style>

<div class="body d-flex py-lg-3 py-md-2">
    <div class="container-xxl">

        <div class="row align-items-center">
            <div id="message-pop-up" class="alert alert-dismissible fade show" role="alert" style="display:none">
                <span id="success-message"></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <div class="border-0 mb-4">
                <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h3 class="fw-bold mb-0">Edit Blogs</h3>
                    <a href="{{ route('blogs') }}" class="btn btn-primary btn-set-task">Back</a>
                </div>
            </div>
        </div>

        <div class="row clearfix g-3">
            <div class="col-sm-12">
                <div class="card mb-3">
                    <div class="card-body">

                        <form action="{{ route('blogs.update', $blogs->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="card mb-4 border">
                                <div class="card-header bg-light"><strong>Blogs Information</strong></div>
                                <div class="card-body row">

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Title <span class="required-star">*</span></label>
                                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title', $blogs->title) }}" placeholder="Enter Title">
                                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Url <span class="required-star">*</span></label>
                                        <input type="text" name="url" class="form-control @error('url') is-invalid @enderror"
                                            value="{{ old('url', $blogs->url) }}" placeholder="Enter Url">
                                        @error('url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Front Image</label>
                                        <input type="file" name="front_image" id="blogs_front_image"
                                            class="form-control @error('front_image') is-invalid @enderror">
                                        @error('front_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        @if($blogs->front_image)
                                            <img id="preview_blogs_front_image"
                                                src="{{ asset('/admin-assets/blogs/front_image/' . $blogs->front_image) }}"
                                                alt="Preview" class="mt-2" style="max-width:100px;">
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Front Image Alt <span class="required-star">*</span></label>
                                        <input type="text" name="front_image_alt" class="form-control @error('front_image_alt') is-invalid @enderror"
                                            value="{{ old('front_image_alt', $blogs->front_image_alt) }}" placeholder="Enter Front Image Alt">
                                        @error('front_image_alt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Detail Image</label>
                                        <input type="file" name="detail_image" id="blogs_detail_image"
                                            class="form-control @error('detail_image') is-invalid @enderror">
                                        @error('detail_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        @if($blogs->detail_image)
                                            <img id="preview_blogs_detail_image"
                                                src="{{ asset('public/admin-assets/blogs/detail_image/' . $blogs->detail_image) }}"
                                                alt="Preview" class="mt-2" style="max-width:100px;">
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Detail Image Alt <span class="required-star">*</span></label>
                                        <input type="text" name="detail_image_alt" class="form-control @error('detail_image_alt') is-invalid @enderror"
                                            value="{{ old('detail_image_alt', $blogs->detail_image_alt) }}" placeholder="Enter Detail Image Alt">
                                        @error('detail_image_alt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">CTA Image</label>
                                        <input type="file" name="cta_image" id="cta_image" class="form-control @error('cta_image') is-invalid @enderror">
                                        @error('cta_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        @if($blogs->cta_image)
                                            <img id="preview_cta_image"
                                                src="{{ asset('public/admin-assets/blogs/cta_image/' . $blogs->cta_image) }}"
                                                alt="Preview" class="mt-2" style="max-width:100px;">
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">CTA Image Alt</label>
                                        <input type="text" name="cta_image_alt" class="form-control"
                                            value="{{ old('cta_image_alt', $blogs->cta_image_alt) }}" placeholder="Enter CTA Image Alt">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">CTA Link URL</label>
                                        <input type="text" name="cta_link_url" class="form-control"
                                            value="{{ old('cta_link_url', $blogs->cta_link_url) }}" placeholder="Enter CTA Link URL">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Date</label>
                                        <input type="date" name="date" value="{{ old('date', $blogs->date) }}" class="form-control">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Meta Title</label>
                                        <input type="text" name="meta_title" class="form-control"
                                            value="{{ old('meta_title', $blogs->meta_title) }}" placeholder="Enter Meta Title">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Status <span class="required-star">*</span></label>
                                        <select name="status" class="form-control">
                                            <option value="Active" {{ old('status', $blogs->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="In-Active" {{ old('status', $blogs->status) == 'In-Active' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>

                                </div>
                            </div>

                            <div class="card mb-4 border">
                                <div class="card-header bg-light"><strong>Meta Description</strong></div>
                                <div class="card-body">
                                    <textarea name="meta_description" id="meta_description" class="form-control" rows="4">{{ old('meta_description', $blogs->meta_description) }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Short Description <span class="required-star">*</span></label>
                                <textarea name="short_description" id="short_description" class="form-control @error('short_description') is-invalid @enderror">{{ old('short_description', $blogs->short_description) }}</textarea>
                                @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="card mb-4 border">
                                <div class="card-header bg-light"><strong>Detail Description</strong></div>
                                <div class="card-body">
                                    <textarea name="detail_description" id="detail_description" class="form-control" rows="4">{{ old('detail_description', $blogs->detail_description) }}</textarea>
                                </div>
                            </div>

                            <div class="card mb-4 border">
                                <div class="card-header bg-light"><strong>Conclusion</strong></div>
                                <div class="card-body">
                                    <textarea name="conclusion" id="conclusion" class="form-control" rows="4">{{ old('conclusion', $blogs->conclusion) }}</textarea>
                                </div>
                            </div>

                            <div class="card mb-4 border">
                                <div class="card-header bg-light"><strong>Schema JSON</strong></div>
                                <div class="card-body">
                                    <textarea name="schema_json" id="schema_json" class="form-control" rows="4">{{ old('schema_json', $blogs->schema_json) }}</textarea>
                                </div>
                            </div>

                            <div class="card mb-4 border">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <strong>FAQs</strong>
                                    <button type="button" class="btn btn-primary btn-sm" id="addFaq">Add More</button>
                                </div>
                                <div class="card-body">
                                    <div id="faq-wrapper">
                                        @if(isset($blogs->faqs) && is_countable($blogs->faqs) && count($blogs->faqs) > 0)
                                            @foreach($blogs->faqs as $faq)
                                                <div class="faq-item border p-3 mb-3">
                                                    <div class="mb-3">
                                                        <label class="form-label">FAQ Title</label>
                                                        <input type="text" name="faq_title[]" class="form-control"
                                                            value="{{ $faq['faq_title'] ?? '' }}" placeholder="Enter FAQ Title">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Question</label>
                                                        <input type="text" name="question[]" class="form-control"
                                                            value="{{ $faq['question'] ?? '' }}" placeholder="Enter Question">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Answer</label>
                                                        <textarea name="answer[]" class="form-control faq_answer" rows="4">{{ $faq['answer'] ?? '' }}</textarea>
                                                    </div>
                                                    <button type="button" class="btn btn-danger removeFaq">Remove</button>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="faq-item border p-3 mb-3">
                                                <div class="mb-3">
                                                    <label class="form-label">FAQ Title</label>
                                                    <input type="text" name="faq_title[]" class="form-control" placeholder="Enter FAQ Title">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Question</label>
                                                    <input type="text" name="question[]" class="form-control" placeholder="Enter Question">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Answer</label>
                                                    <textarea name="answer[]" class="form-control faq_answer" rows="4"></textarea>
                                                </div>
                                                <button type="button" class="btn btn-danger removeFaq">Remove</button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary">Update Blogs</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('admin-assets/js/blogs/blogs.js') }}" defer></script>
<script>
$(document).ready(function() {
    $('#detail_description, #meta_description, #conclusion, #schema_json, #short_description').summernote({
        placeholder: 'Enter Content Here...',
        height: 300
    });
});
</script>
@endsection
