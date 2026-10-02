<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;
use App\Models\Partner;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            ['label' => 'Blogs',      'count' => Blog::where('status', 'Active')->count(),     'icon' => 'bi-journal-text', 'route' => 'blogs.index'],
            ['label' => 'Categories', 'count' => Category::where('status', 'Active')->count(), 'icon' => 'bi-tags',         'route' => 'categories.index'],
            ['label' => 'Products',   'count' => Product::where('status', 'Active')->count(),  'icon' => 'bi-box-seam',     'route' => 'products.index'],
            ['label' => 'Partners',   'count' => Partner::where('status', 'Active')->count(),  'icon' => 'bi-people',       'route' => 'partners.index'],
        ];

        return view('admin.dashboard', compact('stats'));
    }
}