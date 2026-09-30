@extends('admin.layouts.master')
@section('title', $label . ' Trash')

@section('content')
@php
    $moduleIndexRoute = [
        'banners' => 'banners.index', 'blogs' => 'blogs.index', 'categories' => 'categories.index',
        'events' => 'events.index', 'locators' => 'locators.index', 'our-brands' => 'our-brands.index',
        'partners' => 'partners.index', 'products' => 'products.index',
        'technical-data-sheets' => 'technical-data-sheets.index',
    ][$module];
@endphp
<div class="body d-flex py-lg-3 py-md-2">
    <div class="container-xxl">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <div>
                <h3 class="fw-bold mb-1">{{ $label }} Trash</h3>
                <p class="text-muted mb-0">Restore removed records or permanently delete them.</p>
            </div>
            <a href="{{ route($moduleIndexRoute) }}" class="btn btn-outline-primary">Back to {{ $label }}</a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light"><tr><th>#</th><th>Record</th><th>Deleted</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                    @forelse ($records as $record)
                        <tr>
                            <td>{{ $records->firstItem() + $loop->index }}</td>
                            <td>{{ $record->title ?? $record->name ?? $record->id }}</td>
                            <td>{{ $record->deleted_at?->format('M j, Y g:i A') }}</td>
                            <td class="text-end">
                                <form method="POST" action="{{ route('admin.trash.restore', [$module, $record->id]) }}" class="d-inline">@csrf @method('PUT')
                                    <button class="btn btn-sm btn-outline-success">Restore</button>
                                </form>
                                <form method="POST" action="{{ route('admin.trash.force-delete', [$module, $record->id]) }}" class="d-inline" onsubmit="return confirm('Permanently delete this record? This cannot be undone.');">@csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete Forever</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Trash is empty.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-3">{{ $records->links() }}</div>
    </div>
</div>
@endsection
