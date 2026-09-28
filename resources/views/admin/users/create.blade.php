@extends('admin.layouts.master')
@section('title', 'Add User')

@section('content')
<form id="userForm" novalidate method="POST" action="{{ route('users.store') }}" class="card border-0 shadow-sm">
    <div class="card-body p-4">@include('admin.users._form')</div>
</form>
@endsection
