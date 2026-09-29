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
                                        <label class="form-label">Category <span class="required-star">*</span></label>
                                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                            <option value="">Select Category</option>
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
                                        <input type="file" name="brochure" id="sheet_brochure" accept="application/pdf"
                                            class="form-control @error('brochure') is-invalid @enderror">
                                        <small class="text-muted">Sirf PDF, max 10 MB.</small>
                                        @error('brochure')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        @if($sheet->brochure)
                                            <a href="{{ asset('admin-assets/technical-data-sheets/brochure/' . $sheet->brochure) }}" target="_blank" class="d-inline-block mt-2">
                                                <i class="bi bi-file-earmark-pdf"></i> View current file
                                            </a>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">PDF</label>
                                        <input type="file" name="pdf" id="sheet_pdf" accept="application/pdf"
                                            class="form-control @error('pdf') is-invalid @enderror">
                                        <small class="text-muted">Sirf PDF, max 10 MB.</small>
                                        @error('pdf')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        @if($sheet->pdf)
                                            <a href="{{ asset('admin-assets/technical-data-sheets/pdf/' . $sheet->pdf) }}" target="_blank" class="d-inline-block mt-2">
                                                <i class="bi bi-file-earmark-pdf"></i> View current file
                                            </a>
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
    var pdfRules = { fileExt: 'pdf', maxFileSize: 10240 };
    var pdfMessages = {
        fileExt: 'Only PDF files are allowed.',
        maxFileSize: 'The file may not be greater than 10 MB.'
    };

    $('#sheetForm').validate({
        ignore: ':disabled',
        highlight: function (el) { $(el).addClass('is-invalid'); },
        unhighlight: function (el) { $(el).removeClass('is-invalid'); },
        rules: {
            category_id: { required: true },
            brochure: pdfRules,
            pdf: pdfRules,
            status: { required: true }
        },
        messages: {
            category_id: { required: 'Please select the category.' },
            brochure: pdfMessages,
            pdf: pdfMessages,
            status: { required: 'Please select the status.' }
        }
    });
</script>
@endpush
@endsection
