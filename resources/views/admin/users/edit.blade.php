@extends('admin.layouts.master')
@section('title', 'Edit User')

@section('content')
<form id="userForm" novalidate method="POST" action="{{ route('users.update', $user) }}" class="card border-0 shadow-sm">
    <div class="card-body p-4">@include('admin.users._form')</div>
</form>
@endsection
