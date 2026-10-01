<?php

use App\Http\Controllers\Admin\{BlogsController, DashboardController, LoginController,EventsController,OurBrandsController,BannersController,PartnersController,SettingsController,LocatorsController,CategoriesController,ProductsController,TechnicalDataSheetsController,TrashController,UserController};
use App\Http\Controllers\Front\FrontController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'home'])->name('home');
Route::get('about', [FrontController::class, 'about'])->name('about');
Route::get('blogs', [FrontController::class, 'getBlogs'])->name('blog');
Route::get('blog', [FrontController::class, 'blogDetails'])->name('blog.details');
Route::get('contact', [FrontController::class, 'contact'])->name('contact');
Route::post('contact', [FrontController::class, 'submitContact'])->name('contact.submit');
Route::get('thank-you', [FrontController::class, 'thankYou'])->name('contact.thank-you');
Route::post('request-quote', [FrontController::class, 'submitQuote'])->name('quote.submit');
Route::post('product-inquiry', [FrontController::class, 'submitProductInquiry'])->name('product-inquiry.submit');
Route::get('news-event', [FrontController::class, 'getNewsEvent'])->name('news.events');
Route::get('technical-brochure', [FrontController::class, 'technicalBrochure'])->name('technical.brochure');
Route::get('category/{categoryUrl}', [FrontController::class, 'categoryProducts'])->name('category.products');
Route::get('products', [FrontController::class, 'productList'])->name('products');
Route::get('product/{productUrl}', [FrontController::class, 'productDetails'])->name('product.details');

// ===== Login (guests only) =====
Route::middleware('guest')->prefix('admin')->group(function () {
    Route::get('login', [LoginController::class, 'login_page'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.store');
});

// ===== Admin Routes (Admin + Super Admin) =====
Route::middleware(['auth', 'role:admin,super_admin'])->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('trash/{module}', [TrashController::class, 'index'])->name('admin.trash.index');
    Route::put('trash/{module}/{id}/restore', [TrashController::class, 'restore'])->name('admin.trash.restore');
    Route::delete('trash/{module}/{id}', [TrashController::class, 'forceDelete'])->name('admin.trash.force-delete');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::put('users/{user}/status', [UserController::class, 'updateStatus'])->name('users.status');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::put('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('users/{id}/force-delete', [UserController::class, 'forceDelete'])->name('users.force-delete');

    // Blogs
    Route::get('blogs/get-data', [BlogsController::class, 'getBlogsData'])->name('getBlogsData');
    Route::post('blogs/{id}/toggle-status', [BlogsController::class, 'toggleStatus'])->name('blogs.toggle-status');
    Route::resource('blogs', BlogsController::class)->except('show');
        
    // Events
    Route::get('events/get-data', [EventsController::class, 'getEventsData'])->name('getEventsData');
    Route::post('events/{id}/toggle-status', [EventsController::class, 'toggleStatus'])->name('events.toggle-status');
    Route::resource('events', EventsController::class)->except('show');

    // Our Brands
    Route::get('our-brands/get-data', [OurBrandsController::class, 'getOurBrandsData'])->name('getOurBrandsData');
    Route::post('our-brands/{id}/toggle-status', [OurBrandsController::class, 'toggleStatus'])->name('our-brands.toggle-status');
    Route::resource('our-brands', OurBrandsController::class)->except('show');

    // Banners
    Route::get('banners/get-data', [BannersController::class, 'getBannersData'])->name('getBannersData');
    Route::post('banners/{id}/toggle-status', [BannersController::class, 'toggleStatus'])->name('banners.toggle-status');
    Route::resource('banners', BannersController::class)->except('show');
    
    // Partners
    Route::get('partners/get-data', [PartnersController::class, 'getPartnersData'])->name('getPartnersData');
    Route::post('partners/{id}/toggle-status', [PartnersController::class, 'toggleStatus'])->name('partners.toggle-status');
    Route::resource('partners', PartnersController::class)->except('show');
        
    // Settings
    Route::get('settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
    
    // Locators
    Route::get('locators/get-data', [LocatorsController::class, 'getLocatorsData'])->name('getLocatorsData');
    Route::post('locators/{id}/toggle-status', [LocatorsController::class, 'toggleStatus'])->name('locators.toggle-status');
    Route::resource('locators', LocatorsController::class)->except('show');
    
    // Categories
    Route::get('categories/get-data', [CategoriesController::class, 'getCategoriesData'])->name('getCategoriesData');
    Route::post('categories/{id}/toggle-status', [CategoriesController::class, 'toggleStatus'])->name('categories.toggle-status');
    Route::resource('categories', CategoriesController::class)->except('show');
    
    // Products
    Route::get('products/get-data', [ProductsController::class, 'getProductsData'])->name('getProductsData');
    Route::post('products/{id}/toggle-status', [ProductsController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::resource('products', ProductsController::class)->except('show');
    
    // Technical Data Sheets
    Route::get('technical-data-sheets/get-data', [TechnicalDataSheetsController::class, 'getTechnicalDataSheetsData'])->name('getTechnicalDataSheetsData');
    Route::post('technical-data-sheets/{id}/toggle-status', [TechnicalDataSheetsController::class, 'toggleStatus'])->name('technical-data-sheets.toggle-status');
    Route::resource('technical-data-sheets', TechnicalDataSheetsController::class)->except('show');

});
