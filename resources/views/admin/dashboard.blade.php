@extends('admin.layouts.master')
@section('title', 'Dashboard')

@section('content')
    <div class="dashboard-welcome mb-4">
        <div class="position-relative" style="z-index:1">
            <div class="small text-white-50 fw-semibold text-uppercase mb-2">Pratham Filter Industries</div>
            <h1 class="h3 fw-bold mb-1">Welcome back, {{ auth()->user()->name }}</h1>
            <p class="mb-0 text-white-50">Here’s a quick overview of your website content.</p>
        </div>
    </div>

    <div class="row g-3">
        @foreach ($stats as $stat)
            <div class="col-6 col-lg-3">
                <a href="{{ route($stat['route']) }}" class="text-decoration-none text-reset">
                    <div class="card stat-card h-100">
                        <div class="card-body d-flex align-items-center justify-content-between p-4">
                            <div>
                                <div class="text-muted small fw-semibold">Active {{ $stat['label'] }}</div>
                                <div class="fs-2 fw-bold mt-1">{{ $stat['count'] }}</div>
                            </div>
                            <div class="stat-icon"><i class="bi {{ $stat['icon'] }}"></i></div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection