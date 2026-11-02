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
                    <div
                        class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                        <h3 class="fw-bold mb-0">Products</h3>
                        <div class="col-auto d-flex w-sm-100">
                            <a href="{{ route('admin.trash.index', 'products') }}" class="btn btn-outline-secondary me-2">
                                <i class="bi bi-trash me-1"></i>Trash
                            </a>
                            <a href="{{ route('products.create') }}" class="btn btn-primary btn-set-task w-sm-100">
                                <i class="bi bi-plus-circle me-2"></i>Add Product
                            </a>
                        </div>
                        <div class="mb-3 d-flex align-items-center">
                            <label class="me-2 mb-0">Sort By:</label>
                            <select id="sortFilter" class="form-select form-select-sm w-auto">
                                <option value="">All (Default)</option>
                                <option value="asc">Sort Order: Low → High (ASC)</option>
                                <option value="desc">Sort Order: High → Low (DESC)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row clearfix g-3">
                <div class="col-sm-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <table id="products_table" class="table table-hover align-middle mb-0" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Image</th>
                                        <th>Category</th>
                                        <th>Title</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                        <th>Sort Order</th>
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
        window.APP_URLS.getProductsData = "{{ route('getProductsData') }}";
        window.APP_URLS.deleteProducts = "{{ route('products.destroy', [':id']) }}";
        window.APP_URLS.toggleProductStatus = "{{ route('products.toggle-status', [':id']) }}";
        window.APP_URLS.csrfToken = "{{ csrf_token() }}";
        window.APP_URLS.updateProductSort = "{{ route('products.update-sort', [':id']) }}";
    </script>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    @endpush

    @push('scripts')
        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
        <script src="{{ asset('admin-assets/js/products/products.js') }}"></script>
        <script>
$('#sortFilter').on('change', function () {
    $('#products_table').DataTable().ajax.reload();
});

$(document).on('change', '.sort-input', function () {
    var $input = $(this);
    var value = parseInt($input.val(), 10);

    if (isNaN(value) || value < 0) {
        $input.val($input.data('old'));
        return;
    }

    $.ajax({
        url: window.APP_URLS.updateProductSort.replace(':id', $input.data('id')),
        type: 'POST',
        data: { _token: window.APP_URLS.csrfToken, sort_order: value },
        success: function () {
            $input.data('old', value);
            $('#products_table').DataTable().ajax.reload(null, false);
        },
        error: function () {
            $input.val($input.data('old'));
            alert('Could not update sort order.');
        }
    });
});
</script>
    @endpush
@endsection
