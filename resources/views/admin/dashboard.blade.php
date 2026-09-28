@extends('admin.layouts.master')
@section('title', 'Dashboard')

@section('content')
    <h4 class="mb-4">Welcome, {{ auth()->user()->name }} 👋</h4>

    <div class="row g-3">
        @foreach ([
            ['Total Admins', $total, 'bi-people', 'primary'],
            ['Active', $active, 'bi-check-circle', 'success'],
            ['Inactive', $inactive, 'bi-slash-circle', 'warning'],
            ['In Trash', $trashed, 'bi-trash', 'danger'],
        ] as [$label, $value, $icon, $color])
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted small">{{ $label }}</div>
                            <div class="fs-2 fw-bold">{{ $value }}</div>
                        </div>
                        <i class="bi {{ $icon }} fs-1 text-{{ $color }}"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white fw-semibold">Latest Admin Users</div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="table-light"><tr><th>Name</th><th>Email</th><th>Role</th><th>Joined</th></tr></thead>
                <tbody>
                @foreach ($latest as $u)
                    <tr>
                        <td>{{ $u->name }}</td><td>{{ $u->email }}</td>
                        <td>{{ $u->roleLabel() }}</td><td>{{ $u->created_at?->diffForHumans() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
