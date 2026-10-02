@extends('admin.layouts.master')
@section('title', 'Dashboard')

@section('content')
    <div class="dashboard-welcome mb-4">
        <div class="position-relative" style="z-index:1">
            <div class="small text-white-50 fw-semibold text-uppercase mb-2">Pratham Filter Industries</div>
            <h1 class="h3 fw-bold mb-1">Welcome back, {{ auth()->user()->name }}</h1>
        </div>
    </div>
@endsection