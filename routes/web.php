<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BlogsController;
use App\Http\Controllers\Front\FrontController;

Route::get('/', [FrontController::class, 'home'])->name('home');
Route::get('about', [FrontController::class, 'about'])->name('about');
Route::get('blogs', [FrontController::class, 'getBlogs'])->name('blog');
Route::get('blog', [FrontController::class, 'blogDetails'])->name('blog.details');
Route::get('contact', [FrontController::class, 'contact'])->name('contact');
Route::get('news-event', [FrontController::class, 'getNewsEvent'])->name('news.events');
Route::get('technical-brochure', [FrontController::class, 'technicalBrochure'])->name('technical.brochure');
Route::get('products', [FrontController::class, 'productList'])->name('products');
Route::get('product', [FrontController::class, 'productDetails'])->name('product.details');

Route::middleware('guest')->prefix('admin')->group(function () {
    Route::get('login', [LoginController::class, 'login_page'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.store');
});

Route::middleware(['auth', 'role:admin,super_admin'])->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    // ===== Sirf Super Admin =====
    Route::middleware('role:super_admin')->group(function () {
        Route::resource('users', UserController::class)->except('show');
        Route::post('users/{user}/status', [UserController::class, 'updateStatus'])->name('users.status');
        Route::put('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
        Route::delete('users/{id}/force-delete', [UserController::class, 'forceDelete'])->name('users.force-delete');
    });

     // ===== MODULES YAHAN ADD HONGE (banners, products, blog ...) =====
      // ===== Blogs =====
Route::get('blogs', [BlogsController::class, 'index'])->name('blogs');
Route::get('blogs/create', [BlogsController::class, 'createBlogs'])->name('blogs.addBlogs');
Route::post('blogs/store', [BlogsController::class, 'BlogsStore'])->name('blogs.store');
Route::get('blogs/get-data', [BlogsController::class, 'getBlogsData'])->name('getBlogsData');
Route::get('blogs/{id}/edit', [BlogsController::class, 'EditBlogs'])->name('blogs.edit');
Route::put('blogs/{id}', [BlogsController::class, 'UpdateBlogs'])->name('blogs.update');
Route::delete('blogs/{id}', [BlogsController::class, 'DestoryBlogs'])->name('blogs.delete');


     });
