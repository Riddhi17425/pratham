<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $admins = User::whereIn('role', [1, 2]);

        return view('admin.dashboard', [
            'total' => (clone $admins)->count(),
            'active' => (clone $admins)->where('status', true)->count(),
            'inactive' => (clone $admins)->where('status', false)->count(),
            'trashed' => User::onlyTrashed()->count(),
            'latest' => User::whereIn('role', [1, 2])->latest()->take(5)->get(),
        ]);
    }
}
