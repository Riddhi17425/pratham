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
                    <h3 class="fw-bold mb-0">Edit Event</h3>
                    <a href="{{ route('events.index') }}" class="btn btn-primary btn-set-task">Back</a>
                </div>
            </div>
        </div>

        <div class="row clearfix g-3">
            <div class="col-sm-12">
                <div class="card mb-3">
                    <div class="card-body">

                        <form id="eventForm" novalidate action="{{ route('events.update', $events->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="card mb-4 border">
                                <div class="card-header bg-light"><strong>Event Information</strong></div>
                                <div class="card-body row">

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Title <span class="required-star">*</span></label>
                                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title', $events->title) }}" placeholder="Enter Title">
                                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Location <span class="required-star">*</span></label>
                                        <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                                            value="{{ old('location', $events->location) }}" placeholder="Enter Location">
                                        @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">From Date</label>
                                        <input type="text" name="from_date" id="event_from_date" autocomplete="off" maxlength="10" inputmode="numeric"
                                            value="{{ old('from_date', $events->from_date ? $events->from_date->format('d-m-Y') : '') }}" placeholder="dd-mm-yyyy"
                                            class="form-control @error('from_date') is-invalid @enderror">
                                        @error('from_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">To Date</label>
                                        <input type="text" name="to_date" id="event_to_date" autocomplete="off" maxlength="10" inputmode="numeric"
                                            value="{{ old('to_date', $events->to_date ? $events->to_date->format('d-m-Y') : '') }}" placeholder="dd-mm-yyyy"
                                            class="form-control @error('to_date') is-invalid @enderror">
                                      
                                        @error('to_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Status <span class="required-star">*</span></label>
                                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                                            <option value="Active" {{ old('status', $events->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="In-Active" {{ old('status', $events->status) == 'In-Active' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Image</label>
                                        <input type="file" name="image" id="event_image"
                                            class="form-control @error('image') is-invalid @enderror">
                                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        @if($events->image)
                                            <img id="preview_event_image" src="{{ asset('admin-assets/events/image/' . $events->image) }}"
                                                alt="Preview" class="mt-2" style="max-width:100px;">
                                        @else
                                            <img id="preview_event_image" src="#" alt="Preview" class="mt-2" style="max-width:100px;display:none;">
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Image Alt <span class="required-star">*</span></label>
                                        <input type="text" name="image_alt" class="form-control @error('image_alt') is-invalid @enderror"
                                            value="{{ old('image_alt', $events->image_alt) }}" placeholder="Enter Image Alt">
                                        @error('image_alt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                </div>
                            </div>

                            <div class="card mb-4 border">
                                <div class="card-header bg-light"><strong>Description</strong></div>
                                <div class="card-body">
                                    <textarea name="description" id="description" class="js-editor" placeholder="Enter description">{{ old('description', $events->description) }}</textarea>
                                    @error('description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary">Update Event</button>
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
<script src="{{ asset('admin-assets/js/events/events.js') }}"></script>
<script>
    $('.js-editor').summernote(window.blogEditorOptions || { height: 220 });

    // ----- Date fields: typed by hand as dd-mm-yyyy (hyphens are added automatically) -----
    $('#event_from_date, #event_to_date').on('input', function () {
        var d = $(this).val().replace(/\D/g, '').substring(0, 8);
        var out = d;

        if (d.length > 4) {
            out = d.substring(0, 2) + '-' + d.substring(2, 4) + '-' + d.substring(4);
        } else if (d.length > 2) {
            out = d.substring(0, 2) + '-' + d.substring(2);
        }

        $(this).val(out);
    });

    $.validator.addMethod('dateDMY', function (value, element) {
        if (this.optional(element)) { return true; }
        var m = /^(\d{2})-(\d{2})-(\d{4})$/.exec(value);
        if (!m) { return false; }
        var date = new Date(m[3], m[2] - 1, m[1]);
        return date.getFullYear() == m[3] && date.getMonth() == m[2] - 1 && date.getDate() == m[1];
    }, 'Please enter a valid date (dd-mm-yyyy).');

    $.validator.addMethod('notBeforeFrom', function (value, element) {
        var from = $.trim($('#event_from_date').val());
        var re = /^\d{2}-\d{2}-\d{4}$/;
        if (this.optional(element) || !re.test(from) || !re.test(value)) { return true; }
        var key = function (v) { return v.split('-').reverse().join(''); };
        return key(value) >= key(from);
    }, 'To Date cannot be before From Date.');

    function markEditor(el, invalid) {
        if ($(el).hasClass('js-editor')) {
            $(el).next('.note-editor').css('border-color', invalid ? '#dc3545' : '');
        }
    }

    var imageRules = { fileExt: 'jpg|jpeg|png|webp', maxFileSize: 2048 };
    var imageMessages = {
        fileExt: 'Only JPG, PNG or WEBP images are allowed.',
        maxFileSize: 'The image may not be greater than 2 MB.'
    };

    $('#eventForm').validate({
        ignore: ':disabled',
        highlight: function (el) { $(el).addClass('is-invalid'); markEditor(el, true); },
        unhighlight: function (el) { $(el).removeClass('is-invalid'); markEditor(el, false); },
        rules: {
            title: { required: true, maxlength: 255 },
            location: { required: true, maxlength: 255 },
            from_date: { required: function () { return $.trim($('#event_to_date').val()) !== ''; }, dateDMY: true },
            to_date: { dateDMY: true, notBeforeFrom: true },
            image: imageRules,
            image_alt: { required: true, maxlength: 255 },
            status: { required: true }
        },
        messages: {
            title: { required: 'Please enter the event title.', maxlength: 'The title may not be greater than 255 characters.' },
            location: { required: 'Please enter the location.', maxlength: 'The location may not be greater than 255 characters.' },
            from_date: { required: 'Please select the From Date.' },
            image: imageMessages,
            image_alt: { required: 'Please enter the image alt text.', maxlength: 'The alt text may not be greater than 255 characters.' },
            status: { required: 'Please select the status.' }
        }
    });
</script>
@endpush
@endsection
