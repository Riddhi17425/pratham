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
                    <h3 class="fw-bold mb-0">Blogs</h3>
                    <div class="col-auto d-flex w-sm-100">
                        <a href="{{ route('blogs.addBlogs') }}">
                            <button type="button" class="btn btn-primary btn-set-task w-sm-100">
                                <i class="icofont-plus-circle me-2 fs-6"></i>Add Blogs
                            </button>
                        </a>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <div class="row clearfix g-3">
            <div class="col-sm-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <table id="blogs_table" class="table table-hover align-middle mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th>Front Image</th>
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
    window.APP_URLS = {
        getBlogsData: "{{ route('getBlogsData') }}",
        deleteblogs: "{{ route('blogs.delete', [':id']) }}",
        csrfToken: "{{ csrf_token() }}",
        image_path: "{{ asset('/admin-assets/blogs/front_image/') }}"
    };
</script>
<script src="{{ asset('admin-assets/js/blogs/blogs.js') }}" defer></script>
@endsection
