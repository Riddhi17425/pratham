@extends('admin.layouts.master')
@section('title', 'Dashboard')

@section('content')
    <div class="dashboard-welcome mb-4">
        <div class="position-relative" style="z-index:1">
            <div class="small text-white-50 fw-semibold text-uppercase mb-2">Pratham Filter Industries</div>
            <h1 class="h3 fw-bold mb-1">Welcome back, {{ auth()->user()->name }}</h1>
            <p class="mb-0 text-white-50">Here’s a quick overview of your admin team.</p>
        </div>
    </div>

    <div class="row g-3">
        @foreach ([
            ['Total Admins', $total, 'bi-people'],
            ['Active', $active, 'bi-check-circle'],
            ['Inactive', $inactive, 'bi-slash-circle'],
            ['In Trash', $trashed, 'bi-trash'],
        ] as [$label, $value, $icon])
            <div class="col-6 col-lg-3">
                <div class="card stat-card h-100">
                    <div class="card-body d-flex align-items-center justify-content-between p-4">
                        <div>
                            <div class="text-muted small fw-semibold">{{ $label }}</div>
                            <div class="fs-2 fw-bold mt-1">{{ $value }}</div>
                        </div>
                        <div class="stat-icon"><i class="bi {{ $icon }}"></i></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card border-0 mt-4">
        <div class="card-header bg-white fw-semibold d-flex align-items-center gap-2"><i class="bi bi-person-lines-fill text-primary"></i>Latest Admin Users</div>
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
