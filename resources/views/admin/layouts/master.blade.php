@include('admin.includes.headerUrl')
@include('admin.includes.toast')

@include('admin.includes.sidebar')
<div class="main">
    @include('admin.includes.main-header')
    <div class="p-3 p-lg-4">
        @yield('content')
    </div>
</div>

@include('admin.includes.footer')
