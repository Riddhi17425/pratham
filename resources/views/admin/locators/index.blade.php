@extends('admin.layouts.master')

@section('content')
<div class="body d-flex py-lg-3 py-md-2">
    <div class="container-xxl">
        <div class="row align-items-center">
            <div id="message-pop-up" class="alert alert-dismissible fade show" role="alert" style="display:none">
                <span id="success-message"></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <div class="border-0 mb-4">
                <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h3 class="fw-bold mb-0">Locators</h3>
                    <div class="col-auto d-flex w-sm-100">
                        <a href="{{ route('admin.trash.index', 'locators') }}" class="btn btn-outline-secondary me-2">
                            <i class="bi bi-trash me-1"></i>Trash
                        </a>
                        <a href="{{ route('locators.create') }}" class="btn btn-primary btn-set-task w-sm-100">
                            <i class="bi bi-plus-circle me-2"></i>Add Locator
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix g-3">
            <div class="col-sm-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <table id="locators_table" class="table table-hover align-middle mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>City</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.APP_URLS = window.APP_URLS || {};
    window.APP_URLS.getLocatorsData    = "{{ route('getLocatorsData') }}";
    window.APP_URLS.deleteLocators     = "{{ route('locators.destroy', [':id']) }}";
    window.APP_URLS.toggleLocatorStatus = "{{ route('locators.toggle-status', [':id']) }}";
    window.APP_URLS.csrfToken          = "{{ csrf_token() }}";
</script>

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="{{ asset('admin-assets/js/locators/locators.js') }}"></script>
@endpush
@endsection
