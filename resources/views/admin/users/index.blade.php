@extends('admin.layouts.master')
@section('title', 'Admin Users')

@section('content')
<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link {{ ! $trashed ? 'active' : '' }}" href="{{ route('users.index') }}">Active List</a></li>
        <li class="nav-item"><a class="nav-link {{ $trashed ? 'active' : '' }}" href="{{ route('users.index', ['trashed' => 1]) }}">Trash</a></li>
    </ul>
    <div class="d-flex gap-2">
        <form method="GET" class="d-flex gap-2">
            @if ($trashed) <input type="hidden" name="trashed" value="1"> @endif
            <input name="q" value="{{ request('q') }}" class="form-control" placeholder="Search name / email">
            <button class="btn btn-dark">Search</button>
        </form>
        <a href="{{ route('users.create') }}" class="btn btn-primary text-nowrap">+ Add User</a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th class="text-end">Action</th></tr>
            </thead>
            <tbody>
            @forelse ($users as $u)
                <tr>
                    <td>{{ $users->firstItem() + $loop->index }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->roleLabel() }}</td>
                    <td>
                        @if ($trashed)
                            <span class="badge text-bg-secondary">Deleted</span>
                        @else
                            <form method="POST" action="{{ route('users.status', $u) }}">@csrf
                                <button class="badge border-0 text-bg-{{ $u->status ? 'success' : 'secondary' }}"
                                        @disabled($u->id === auth()->id())>{{ $u->status ? 'Active' : 'Inactive' }}</button>
                            </form>
                        @endif
                    </td>
                    <td class="text-end">
                        @if ($trashed)
                            <form method="POST" action="{{ route('users.restore', $u->id) }}" class="d-inline">@csrf @method('PUT')
                                <button class="btn btn-sm btn-outline-success">Restore</button>
                            </form>
                            <form method="POST" action="{{ route('users.force-delete', $u->id) }}" class="d-inline"
                                  onsubmit="return confirm('This will permanently delete the user. Continue?')">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete Forever</button>
                            </form>
                        @else
                            <a href="{{ route('users.edit', $u) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            @if ($u->id !== auth()->id())
                                <form method="POST" action="{{ route('users.destroy', $u) }}" class="d-inline"
                                      onsubmit="return confirm('Move this user to trash?')">@csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Trash</button>
                                </form>
                            @endif
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No records found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $users->links() }}</div>
@endsection
