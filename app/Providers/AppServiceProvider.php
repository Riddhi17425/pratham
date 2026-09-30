<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
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
        $siteSearchItems = null;

        View::composer(['front.layouts.header', 'front.layouts.footer'], function ($view) use (&$productCategories, &$siteSetting, &$siteSearchItems) {
            if ($productCategories === null) {
                $productCategories = Category::where('status', 'Active')->orderBy('title')->get();
            }

            if ($siteSetting === null) {
                $siteSetting = Setting::first() ?? new Setting();
            }

            if ($siteSearchItems === null) {
                $siteSearchItems = Product::with('category')->where('status', 'Active')->orderBy('name')->get()
                    ->map(fn ($product) => [
                        't' => $product->name ?: $product->title,
                        'c' => $product->category?->title ?: 'Uncategorized',
                        'x' => strip_tags($product->description ?? ''),
                        'i' => $product->image
                            ? asset('admin-assets/products/image/' . $product->image)
                            : asset('front/img/figma/products/prod-spun-cartridge.jpg'),
                        'k' => 'Product',
                        'u' => route('products', ['q' => $product->name ?: $product->title]),
                    ])
                    ->values();
            }

            $view->with('productCategories', $productCategories)
                 ->with('siteSetting', $siteSetting)
                 ->with('siteSearchItems', $siteSearchItems);
        });
    }
}
