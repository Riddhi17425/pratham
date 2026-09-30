<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $productCategories = null;
        $siteSetting = null;

        View::composer(['front.layouts.header', 'front.layouts.footer'], function ($view) use (&$productCategories, &$siteSetting) {
            if ($productCategories === null) {
                $productCategories = Category::where('status', 'Active')->orderBy('title')->get();
            }

            if ($siteSetting === null) {
                $siteSetting = Setting::first() ?? new Setting();
            }

            $view->with('productCategories', $productCategories)
                 ->with('siteSetting', $siteSetting);
        });
    }
}