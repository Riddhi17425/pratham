<?php

use App\Http\Controllers\Admin\{BlogsController, DashboardController, LoginController,EventsController,OurBrandsController,BannersController,PartnersController,SettingsController,LocatorsController,CategoriesController};
use Illuminate\Support\Facades\Route;
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

// ===== Login (guests only) =====
Route::middleware('guest')->prefix('admin')->group(function () {
    Route::get('login', [LoginController::class, 'login_page'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.store');
});

// ===== Admin area (Admin + Super Admin) =====
Route::middleware(['auth', 'role:admin,super_admin'])->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // ===== ADD NEW MODULE ROUTES BELOW =====

    // Blogs
    Route::get('blogs/get-data', [BlogsController::class, 'getBlogsData'])->name('getBlogsData');
    Route::resource('blogs', BlogsController::class)->except('show');
    // Events
Route::get('events/get-data', [EventsController::class, 'getEventsData'])->name('getEventsData');
Route::resource('events', EventsController::class)->except('show');
// Our Brands
Route::get('our-brands/get-data', [OurBrandsController::class, 'getOurBrandsData'])->name('getOurBrandsData');
Route::resource('our-brands', OurBrandsController::class)->except('show');
// Banners
    // Banners
    Route::get('banners/get-data', [BannersController::class, 'getBannersData'])->name('getBannersData');
    Route::post('banners/{id}/toggle-status', [BannersController::class, 'toggleStatus'])->name('banners.toggle-status');
    Route::resource('banners', BannersController::class)->except('show');

    // Partners
    Route::get('partners/get-data', [PartnersController::class, 'getPartnersData'])->name('getPartnersData');
    Route::resource('partners', PartnersController::class)->except('show');
    // Settings
    Route::get('settings/get-data', [SettingsController::class, 'getSettingsData'])->name('getSettingsData');
    Route::resource('settings', SettingsController::class)->except('show');
    // Locators
    Route::get('locators/get-data', [LocatorsController::class, 'getLocatorsData'])->name('getLocatorsData');
    Route::post('locators/{id}/toggle-status', [LocatorsController::class, 'toggleStatus'])->name('locators.toggle-status');
    Route::resource('locators', LocatorsController::class)->except('show');
    // Categories
    Route::get('categories/get-data', [CategoriesController::class, 'getCategoriesData'])->name('getCategoriesData');
    Route::post('categories/{id}/toggle-status', [CategoriesController::class, 'toggleStatus'])->name('categories.toggle-status');
    Route::resource('categories', CategoriesController::class)->except('show');

});
