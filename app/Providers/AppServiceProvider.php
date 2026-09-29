<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $productCategories = null;

        View::composer(['front.layouts.header', 'front.layouts.footer'], function ($view) use (&$productCategories) {
            if ($productCategories === null) {
                $productCategories = Category::where('status', 'Active')->orderBy('title')->get();
            }

            $view->with('productCategories', $productCategories);
        });
    }
}
