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
                    <h3 class="fw-bold mb-0">Edit Technical Data Sheet</h3>
                    <a href="{{ route('technical-data-sheets.index') }}" class="btn btn-primary btn-set-task">Back</a>
                </div>
            </div>
        </div>

        <div class="row clearfix g-3">
            <div class="col-sm-12">
                <div class="card mb-3">
                    <div class="card-body">

                        <form id="sheetForm" novalidate action="{{ route('technical-data-sheets.update', $sheet->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="card mb-4 border">
                                <div class="card-header bg-light"><strong>Data Sheet Information</strong></div>
                                <div class="card-body row">

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Category</label>
                                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                            <option value="">Select Category (Optional)</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $sheet->category_id) == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Status <span class="required-star">*</span></label>
                                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                                            <option value="Active" {{ old('status', $sheet->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="In-Active" {{ old('status', $sheet->status) == 'In-Active' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Brochure (PDF)</label>
                                        <div class="input-group">
                                            <input type="file" name="brochure" id="sheet_brochure" accept="application/pdf"
                                                class="form-control @error('brochure') is-invalid @enderror">
                                            <button type="button" id="clearBrochure" class="btn btn-outline-danger d-none" title="Remove selected file">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>
                                        <small class="text-muted d-block">Only PDF, max 2 MB. Leave empty to keep the current file.</small>
                                        @error('brochure')<div class="text-danger small">{{ $message }}</div>@enderror
                                        @if($sheet->brochure)
                                            <input type="hidden" name="remove_brochure" id="remove_brochure" value="{{ old('remove_brochure', '0') }}">

                                            <div id="currentFileBox" class="d-flex align-items-center gap-2 mt-2 {{ old('remove_brochure') == '1' ? 'd-none' : '' }}">
                                                <a href="{{ asset('admin-assets/technical-data-sheets/brochure/' . $sheet->brochure) }}" target="_blank">
                                                    <i class="bi bi-file-earmark-pdf"></i> View current file
                                                </a>
                                                <button type="button" id="removeCurrentFile" class="btn btn-sm btn-outline-danger py-0 px-2" title="Remove current file">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </div>

                                            <div id="removedNotice" class="small text-danger mt-2 {{ old('remove_brochure') == '1' ? '' : 'd-none' }}">
                                                Current file removed. Please upload a new PDF.
                                                <a href="#" id="undoRemoveFile">Undo</a>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary">Update Data Sheet</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('admin-assets/js/technical-data-sheets/technical-data-sheets.js') }}"></script>
<script>
    var pdfRules = { fileExt: 'pdf', maxFileSize: 2048 }; // KB (2 MB)
    var pdfMessages = {
        fileExt: 'Only PDF files are allowed.',
        maxFileSize: 'The file may not be greater than 2 MB.'
    };

    $('#sheetForm').validate({
        ignore: ':disabled',
        errorPlacement: function (error, el) {
            if (el.closest('.input-group').length) {
                error.insertAfter(el.closest('.input-group'));
            } else {
                error.insertAfter(el);
            }
        },
        highlight: function (el) { $(el).addClass('is-invalid'); },
        unhighlight: function (el) { $(el).removeClass('is-invalid'); },
        rules: {
            brochure: $.extend({
                // required only after the current file was removed
                required: function () { return $('#remove_brochure').val() === '1'; }
            }, pdfRules),
            status: { required: true }
        },
        messages: {
            brochure: $.extend({ required: 'Please upload a new PDF, the current file was removed.' }, pdfMessages),
            status: { required: 'Please select the status.' }
        }
    });

    // Remove / undo the current (already saved) file
    $('#removeCurrentFile').on('click', function () {
        $('#remove_brochure').val('1');
        $('#currentFileBox').addClass('d-none');
        $('#removedNotice').removeClass('d-none');
    });

    $('#undoRemoveFile').on('click', function (e) {
        e.preventDefault();
        $('#remove_brochure').val('0');
        $('#removedNotice').addClass('d-none');
        $('#currentFileBox').removeClass('d-none');
        $('#sheet_brochure').removeClass('is-invalid');
        $('#sheetForm').validate().element('#sheet_brochure');
    });
</script>
@endpush
@endsection
